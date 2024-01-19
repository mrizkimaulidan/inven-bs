<script>
	$(document).ready(function () {
		$(".show-modal").click(function () {
			const id = $(this).data("id");
			let url = "{{ route('api.bantuan-dana-operasional.show', ':paramID') }}".replace(
				":paramID",
				id
			);

			$.ajax({
				url: url,
				header: {
					"Content-Type": "application/json",
				},
				success: (res) => {
					$("#show_school_operational_assistance #name").val(res.data.name);
					$("#show_school_operational_assistance #description").val(res.data.description);
				},
				error: (err) => {
					alert("error occured, check console");
					console.log(err);
				},
			});
		});

		$(".edit-modal").on("click", function () {
			const id = $(this).data("id");
			let url = "{{ route('api.bantuan-dana-operasional.show', ':paramID') }}".replace(
				":paramID",
				id
			);

			let updateURL = "{{ route('bantuan-dana-operasional.update', ':paramID') }}".replace(
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
					console.log(res)
					$("#school_operational_assistance_edit_modal form #name").val(res.data.name);
					$("#school_operational_assistance_edit_modal form #description").val(
						res.data.description
					);
					$("#school_operational_assistance_edit_modal form").attr("action", updateURL);
				},
				error: (err) => {
					alert("error occured, check console");
					console.log(err);
				},
			});
		});
	});
</script>
