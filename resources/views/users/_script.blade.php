<script>
	$(document).ready(function () {
		$(".show-modal").click(function () {
			const id = $(this).data("id");
			let url = "{{ route('api.pengguna.show', ':paramID') }}".replace(
				":paramID",
				id
			);

			$.ajax({
				url: url,
				header: {
					"Content-Type": "application/json",
				},
				success: (res) => {
					$("#show_user #name").val(res.data.name);
					$("#show_user #email").val(res.data.email);
				},
				error: (err) => {
					alert("error occured, check console");
					console.log(err);
				},
			});
		});
	});
</script>
