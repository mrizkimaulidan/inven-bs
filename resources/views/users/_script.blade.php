<script>
	$(document).ready(function () {
		new TomSelect("#user_create_modal form #role_id");

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
					$("#show_user #role_id").val(res.data.role.name);
				},
				error: (err) => {
					alert("error occured, check console");
					console.log(err);
				},
			});
		});
	});
</script>
