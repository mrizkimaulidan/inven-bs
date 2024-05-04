<div id="accordion">
	<div class="accordion mb-3">
		<div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="true">
			<h4>Menu filter (klik atau sentuh untuk membuka atau menutup menu filter)</h4>
		</div>
		<div class="accordion-body collapse show" id="panel-body-1" data-parent="#accordion">
			<form action="" method="GET">
				{{ $slot }}
				<div class="d-flex">
					<button type="submit" class="btn btn-primary mr-1 flex-fill">Cari</button>
					<a href="{{ $resetFilterURL }}" class="btn btn-warning" role="button">Reset Filter</a>
				</div>
			</form>
		</div>
	</div>
</div>
