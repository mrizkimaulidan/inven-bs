<script>
	$(document).ready(function () {
		new TomSelect("#user_create_modal form #role_id");
		const userRoleInput = new TomSelect("#user_edit_modal form #role_id");

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

		$(".edit-modal").on("click", function () {
			const id = $(this).data("id");
			let url = "{{ route('api.pengguna.show', ':paramID') }}".replace(
				":paramID",
				id
			);

			let updateURL = "{{ route('pengguna.update', ':paramID') }}".replace(
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
					$("#user_edit_modal form #name").val(res.data.name);
					$("#user_edit_modal form #email").val(res.data.email);

					if(res.data.role !== null) {
						userRoleInput.setValue(res.data.role.id);
					}

					$("#user_edit_modal form").attr("action", updateURL);
				},
				error: (err) => {
					alert("error occured, check console");
					console.log(err);
				},
			});
		});
	});
</script>
