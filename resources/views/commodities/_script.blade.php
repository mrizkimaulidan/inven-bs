<script>
	$(document).ready(function () {
		new TomSelect("#commodity_create_modal form #commodity_location_id");
		new TomSelect("#filter-accordion form #commodity_location_id");
		new TomSelect("#filter-accordion form #year_of_purchase");
		new TomSelect("#filter-accordion form #material");
		new TomSelect("#filter-accordion form #brand");

		const commodityLocationInput = new TomSelect(
			"#commodity_edit_modal form #commodity_location_id"
		);

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
					$("#show_commodity #price_per_item").val(
						res.data.price_per_item_formatted
					);
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
					$("#commodity_edit_modal form #item_code").val(res.data.item_code);
					$("#commodity_edit_modal form #name").val(res.data.name);
					$("#commodity_edit_modal form #material").val(res.data.material);
					$("#commodity_edit_modal form #brand").val(res.data.brand);
					$("#commodity_edit_modal form #year_of_purchase").val(
						res.data.year_of_purchase
					);
					$("#commodity_edit_modal form #condition").val(res.data.condition);
					$("#commodity_edit_modal form #commodity_acquisition_id").val(
						res.data.commodity_acquisition.id
					);
					$("#commodity_edit_modal form #note").val(res.data.note);
					$("#commodity_edit_modal form #quantity").val(res.data.quantity);
					$("#commodity_edit_modal form #price").val(res.data.price);
					$("#commodity_edit_modal form #price_per_item").val(
						res.data.price_per_item
					);

					if (res.data.role !== null) {
						commodityLocationInput.setValue(res.data.commodity_location.id);
					}

					$("#commodity_edit_modal form").attr("action", updateURL);
				},
				error: (err) => {
					alert("error occured, check console");
					console.log(err);
				},
			});
		});

		$(".qr-modal-button").on("click", function () {
			const id = $(this).data("id");

			$("#qr_code_container").html(
				'<span class="text-muted">Memuat QR Code...</span>'
			);
			$("#qr_code_modal .modal-title").html("Memuat QR Code");
			$("#download_qr_link").addClass("disabled").attr("href", "#");

			let url = "{{ route('api.barang.generate-qrcode', ':paramID') }}".replace(
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
					$("#qr_code_modal .modal-title").text(
						"QR Code untuk " + res.data.name
					);

					$("#download_qr_link")
						.removeClass("disabled")
						.attr("href", res.data.qr_code_uri)
						.attr("download", res.data.filename);

					$("#qr_code_container").html(
						'<img src="' +
							res.data.qr_code_uri +
							'" alt="QR Code" class="d-inline-block">'
					);
				},
				error: (err) => {
					$("#qr_code_container").html(
						'<span class="text-danger">Gagal memuat QR Code.</span>'
					);
					console.log(err);
				},
			});
		});
	});
</script>
