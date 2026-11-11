(function () {
  const instances = new Map();
  const paletteNames = ["primary", "success", "warning", "danger", "info"];

  function themeColor(className, property) {
    const element = document.createElement("span");
    element.className = className;
    element.style.display = "none";
    document.body.appendChild(element);
    const color = window.getComputedStyle(element)[property];
    element.remove();

    return color;
  }

  function themeColors() {
    return {
      primary: themeColor("text-primary", "color"),
      success: themeColor("bg-success", "backgroundColor"),
      warning: themeColor("bg-warning", "backgroundColor"),
      danger: themeColor("bg-danger", "backgroundColor"),
      info: themeColor("bg-info", "backgroundColor"),
      grid: themeColor("border-bottom", "borderBottomColor"),
      text: themeColor("text-muted", "color"),
      surface: themeColor("card", "backgroundColor"),
      font: window.getComputedStyle(document.body).fontFamily,
    };
  }

  function formatValue(value, format) {
    const digits = format === "decimal" ? 1 : 0;
    const formatted = Number(value).toLocaleString("id-ID", {
      maximumFractionDigits: digits,
      minimumFractionDigits: digits,
    });

    return format === "currency" ? `Rp ${formatted}` : formatted;
  }

  function destroyCharts() {
    instances.forEach((chart) => chart.destroy());
    instances.clear();
  }

  function renderCharts(charts) {
    if (typeof Chart === "undefined") {
      throw new Error("Chart.js diperlukan untuk menampilkan grafik inventaris.");
    }

    destroyCharts();
    const colors = themeColors();
    const palette = paletteNames.map((name) => colors[name]);

    charts.forEach((chart) => {
      const canvas = document.getElementById(chart.canvasId);

      if (!canvas) {
        throw new Error(`Canvas grafik "${chart.canvasId}" tidak ditemukan.`);
      }

      const isRadial = ["doughnut", "pie", "polarArea"].includes(chart.type);
      const isLine = chart.type === "line";
      const isHorizontal = chart.type === "horizontalBar";
      const color = chart.color === "palette" ? palette : colors[chart.color];
      const dataset = {
        label: chart.datasetLabel,
        data: chart.values,
        backgroundColor: isLine
          ? color.replace("rgb(", "rgba(").replace(")", ", 0.12)")
          : color,
        borderColor: isLine ? color : color,
        borderWidth: isRadial ? 0 : 1,
        unitLabel: chart.unitLabel,
      };

      if (isLine) {
        dataset.pointBackgroundColor = color;
        dataset.pointBorderColor = colors.surface;
        dataset.pointBorderWidth = 2;
        dataset.pointRadius = 3;
        dataset.lineTension = 0.3;
        dataset.fill = true;
      }

      const options = {
        responsive: true,
        legend: {
          display: isRadial,
          labels: { fontColor: colors.text, fontFamily: colors.font },
        },
        tooltips: {
          titleFontColor: colors.text,
          bodyFontColor: colors.text,
          titleFontFamily: colors.font,
          bodyFontFamily: colors.font,
          backgroundColor: colors.surface,
          borderColor: colors.grid,
          borderWidth: 1,
          callbacks: {
            label: (tooltipItem, data) => {
              const activeDataset = data.datasets[tooltipItem.datasetIndex];
              const label = activeDataset.label || data.labels[tooltipItem.index];
              const value = activeDataset.data[tooltipItem.index];
              const formatted = formatValue(value, chart.valueFormat);
              const unit = chart.unitLabel ? ` ${chart.unitLabel}` : "";

              return `${label}: ${formatted}${chart.valueFormat === "currency" ? "" : unit}`;
            },
          },
        },
      };

      if (chart.type === "doughnut") {
        options.cutoutPercentage = 62;
      }

      if (!isRadial) {
        const valueAxis = isHorizontal ? "xAxes" : "yAxes";
        const categoryAxis = isHorizontal ? "yAxes" : "xAxes";

        options.scales = {
          [valueAxis]: [
            {
              scaleLabel: {
                display: Boolean(chart.unitLabel) || chart.valueFormat === "currency",
                labelString: chart.datasetLabel,
                fontColor: colors.text,
                fontFamily: colors.font,
              },
              ticks: {
                beginAtZero: true,
                fontColor: colors.text,
                fontFamily: colors.font,
                callback: (value) => formatValue(value, chart.valueFormat),
              },
              gridLines: { color: colors.grid },
            },
          ],
          [categoryAxis]: [
            {
              ticks: { fontColor: colors.text, fontFamily: colors.font },
              gridLines: { display: false },
            },
          ],
        };
      }

      instances.set(
        chart.canvasId,
        new Chart(canvas.getContext("2d"), {
          type: chart.type,
          data: {
            labels: chart.labels,
            datasets: [dataset],
          },
          options,
        }),
      );
    });
  }

  window.InventoryDashboardCharts = {
    mount($wire, initialCharts) {
      let charts = initialCharts;
      let waitingForChartJs = false;
      let renderFrame = null;
      let stopListening = function () {};

      const renderWhenReady = () => {
        if (charts.length === 0) {
          return;
        }

        if (typeof Chart !== "undefined") {
          renderCharts(charts);
          return;
        }

        if (document.readyState === "complete") {
          throw new Error("Chart.js tidak tersedia saat grafik inventaris dimuat.");
        }

        if (!waitingForChartJs) {
          waitingForChartJs = true;
          window.addEventListener(
            "load",
            () => {
              waitingForChartJs = false;
              renderWhenReady();
            },
            { once: true },
          );
        }
      };

      const scheduleRender = () => {
        if (renderFrame !== null) {
          cancelAnimationFrame(renderFrame);
        }

        renderFrame = requestAnimationFrame(() => {
          renderFrame = requestAnimationFrame(() => {
            renderFrame = null;
            renderWhenReady();

            instances.forEach((chart) => chart.resize());
          });
        });
      };

      if (charts.length > 0) {
        scheduleRender();
      }

      stopListening = $wire.on("inventory-dashboard-updated", (event) => {
        charts = event.charts;
        scheduleRender();
      });

      document.addEventListener("livewire:navigated", scheduleRender);

      document.addEventListener(
        "livewire:navigating",
        () => {
          document.removeEventListener("livewire:navigated", scheduleRender);
          if (renderFrame !== null) {
            cancelAnimationFrame(renderFrame);
          }
          stopListening();
          destroyCharts();
        },
        { once: true },
      );
    },
  };
})();
