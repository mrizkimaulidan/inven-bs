<div id="filter-accordion">
	<div class="accordion mb-3">
		<div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="true">
			<h4>Menu filter (klik atau sentuh untuk membuka atau menutup menu filter)</h4>
		</div>
		<div class="accordion-body collapse show" id="panel-body-1" data-parent="#filter-accordion">
			<form action="" method="GET">
				{{ $slot }}
				<div class="d-flex">
					<button type="submit" class="btn btn-primary mr-1 flex-fill">
						<i class="fas fa-magnifying-glass mr-1"></i> Cari
					</button>
					<a href="{{ $resetFilterURL }}" class="btn btn-warning" role="button">
						<i class="fas fa-filter mr-1"></i> Reset Filter
					</a>
				</div>
			</form>
		</div>
	</div>
</div>
