<script>
	$(document).ready(function () {
		$(".show-modal").click(function () {
			const id = $(this).data("id");
			let url = "{{ route('api.barang.show', ':paramID') }}".replace(
				":paramID",
				id
			);

			$.ajax({
				url: url,
				header: {
					"Content-Type": "application/json",
				},
				success: (res) => {
					$("#show_commodity #item_code").val(res.data.item_code);
					$("#show_commodity #name").val(res.data.name);
					$("#show_commodity #commodity_location_id").val(
						res.data.commodity_location.name
					);
					$("#show_commodity #material").val(res.data.material);
					$("#show_commodity #brand").val(res.data.brand);
					$("#show_commodity #year_of_purchase").val(res.data.year_of_purchase);
					$("#show_commodity #condition").val(res.data.condition_name);
					$("#show_commodity #commodity_acquisition_id").val(
						res.data.commodity_acquisition.name
					);
					$("#show_commodity #note").val(res.data.note);
					$("#show_commodity #quantity").val(res.data.quantity);
					$("#show_commodity #price").val(res.data.price_formatted);
					$("#show_commodity #price_per_item").val(res.data.price_per_item_formatted);
				},
				error: (err) => {
					alert("error occured, check console");
					console.log(err);
				},
			});
		});

		$(".edit-modal").on("click", function () {
			const id = $(this).data("id");
			let url = "{{ route('api.barang.show', ':paramID') }}".replace(
				":paramID",
				id
			);

			let updateURL = "{{ route('barang.update', ':paramID') }}".replace(
				":paramID",
				id
			);

			$.ajax({
				url: url,
				method: "GET",
				header: {
					"Content-Type": "application/json",
				},
				success: (res) => {
					$("#edit_commodity form #item_code").val(res.data.item_code);
					$("#edit_commodity form #name").val(res.data.name);
					$("#edit_commodity form #commodity_location_id").val(
						res.data.commodity_location.id
					);
					$("#edit_commodity form #material").val(res.data.material);
					$("#edit_commodity form #brand").val(res.data.brand);
					$("#edit_commodity form #year_of_purchase").val(
						res.data.year_of_purchase
					);
					$("#edit_commodity form #condition").val(res.data.condition);
					$("#edit_commodity form #commodity_acquisition_id").val(
						res.data.commodity_acquisition.id
					);
					$("#edit_commodity form #note").val(res.data.note);
					$("#edit_commodity form #quantity").val(res.data.quantity);
					$("#edit_commodity form #price").val(res.data.price);
					$("#edit_commodity form #price_per_item").val(
						res.data.price_per_item
					);
					$("#edit_commodity form").attr("action", updateURL);
				},
				error: (err) => {
					alert("error occured, check console");
					console.log(err);
				},
			});
		});

    $(".qr-modal-button").on("click", function () {
      const id = $(this).data("id");
      const name = $(this).data("name");

      $("#qr_code_container").html('<span class="text-muted">Memuat QR Code...</span>');
      $("#qr_code_modal .modal-title").text('QR Code untuk ' + name);
      $("#download_qr_link").addClass('disabled').attr('href', '#');

      let url = "{{ route('api.barang.generate-qrcode', ':paramID') }}".replace(":paramID", id);

      $.ajax({
        url: url,
        method: "GET",
        header: {
          "Content-Type": "application/json",
        },
        success: (res) => {
          if (res.success) {
            const dataUri = res.svg;

            $("#download_qr_link")
              .removeClass('disabled')
              .attr('href', dataUri)
              .attr('download', res.filename);

            $("#qr_code_container").html('<img src="' + dataUri + '" alt="QR Code" class="d-inline-block">');
          }
        },
        error: (err) => {
          $("#qr_code_container").html('<span class="text-danger">Gagal memuat QR Code.</span>');
          console.log(err);
        },
      });
    });
	});
</script>
