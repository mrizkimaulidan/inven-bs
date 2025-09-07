<div class="card">
	<div class="card-header">
		<h4>{{ $chartTitle }}</h4>
	</div>
	<div class="card-body">
		<div id="{{ $chartID }}"></div>
	</div>
</div>

@push('js')
<script>
	$(function() {
		const chartID = "#{{ $chartID }}";
		const series = @json($series);
		const colors = @json($colors);
		const categories = @json($categories);

		var options = {
			series: series,
			chart: {
				type: 'bar',
				height: 500
			},
			plotOptions: {
				bar: {
					horizontal: false,
					columnWidth: '55%',
					borderRadius: 1,
					borderRadiusApplication: 'end'
				}
			},
			colors: colors,
			dataLabels: {
				enabled: false
			},
			stroke: {
				show: true,
				width: 2,
				colors: ['transparent']
			},
			xaxis: {
				categories: categories
			},
			fill: {
				opacity: 1
			}
		};

		var chart = new ApexCharts(document.querySelector(chartID), options);
		chart.render();
	});
</script>
@endpush
