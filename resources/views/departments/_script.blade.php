<script>
	$(document).ready(function () {
		$(".show-modal").click(function () {
			const id = $(this).data("id");
			let url = "{{ route('api.prodi.show', ':paramID') }}".replace(
				":paramID",
				id
			);
			$.ajax({
				url: url,
				header: {
					"Content-Type": "application/json",
				},
				success: (res) => {
					$("#show_department #name").val(res.data.name);
					$("#show_department #description").val(res.data.description);
				},
				error: (err) => {
					alert("error occured, check console");
					console.log(err);
				},
			});
		});

		$(".edit-modal").on("click", function () {
			const id = $(this).data("id");
			let url = "{{ route('api.prodi.show', ':paramID') }}".replace(
				":paramID",
				id
			);

			let updateURL = "{{ route('prodi.update', ':paramID') }}".replace(
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
					$("#department_edit_modal form #name").val(res.data.name);
					$("#department_edit_modal form #description").val(
						res.data.description
					);
					$("#department_edit_modal form").attr("action", updateURL);
				},
				error: (err) => {
					alert("error occured, check console");
					console.log(err);
				},
			});
		});
	});
</script>
