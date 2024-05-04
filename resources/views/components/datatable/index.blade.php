<div class="table-responsive">
	<table class="table table-bordered table-hover" id="datatable">
		{{ $slot }}
	</table>
</div>

@push('js')
<script>
	$(document).ready(function() {
		$("#datatable").DataTable({
			lengthMenu: [5, 10, 15],
			language: {
				url: "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json",
			},
		});
	});
</script>
@endpush
