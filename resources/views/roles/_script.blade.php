<script>
	$(document).ready(function () {
		new TomSelect("#role_create_modal form #permissions", {
			plugins: {
				remove_button: {
					title: "Hapus item",
				},
			},
		});

		const permissionSelectInput = new TomSelect(
			"#role_edit_modal form #permissions",
			{
				plugins: {
					remove_button: {
						title: "Hapus item",
					},
				},
			}
		);

		// Handle click event for editing a role
		$(".edit-modal").on("click", function () {
			const id = $(this).data("id");
			const url =
				"{{ route('api.peran-dan-hak-akses.show', ':paramID') }}".replace(
					":paramID",
					id
				);
			const updateURL =
				"{{ route('peran-dan-hak-akses.update', ':paramID') }}".replace(
					":paramID",
					id
				);

			$.ajax({
				url: url,
				method: "GET",
				success: function (res) {
					$("#role_edit_modal form #name").val(res.data.name);

					const permissionIds = res.data.permissions.map(
						(permission) => permission.id
					);
					permissionSelectInput.setValue(permissionIds);

					$("#role_edit_modal form").attr("action", updateURL);
				},
				error: function (err) {
					alert("Error occurred. Please check the console.");
					console.log(err);
				},
			});
		});
	});
</script>
