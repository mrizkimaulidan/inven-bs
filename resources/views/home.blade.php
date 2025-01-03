<x-layout>
	<x-slot name="title">Dashboard</x-slot>
	<x-slot name="page_heading">Dashboard</x-slot>

	<div class="row">
		<div class="col-lg-3 col-md-6 col-sm-6 col-12">
			<div class="card card-statistic-1">
				<div class="card-icon bg-primary">
					<i class="fas fa-columns"></i>
				</div>
				<div class="card-wrap">
					<div class="card-header">
						<h4>Total Barang</h4>
					</div>
					<div class="card-body">
						{{ $commodity_counts['commodity_in_total'] }}
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6 col-sm-6 col-12">
			<div class="card card-statistic-1">
				<div class="card-icon bg-success">
					<i class="fas fa-fw fa-check-circle"></i>
				</div>
				<div class="card-wrap">
					<div class="card-header">
						<h4>Kondisi Baik</h4>
					</div>
					<div class="card-body">
						{{ $commodity_counts['commodity_in_good_condition'] }}
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6 col-sm-6 col-12">
			<div class="card card-statistic-1">
				<div class="card-icon bg-warning">
					<i class="fas fa-fw fa-exclamation-circle"></i>
				</div>
				<div class="card-wrap">
					<div class="card-header">
						<h4>Kondisi Rusak Ringan</h4>
					</div>
					<div class="card-body">
						{{ $commodity_counts['commodity_in_not_good_condition'] }}
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-3 col-md-6 col-sm-6 col-12">
			<div class="card card-statistic-1">
				<div class="card-icon bg-danger">
					<i class="fas fa-fw fa-times-circle"></i>
				</div>
				<div class="card-wrap">
					<div class="card-header">
						<h4>Kondisi Rusak Berat</h4>
					</div>
					<div class="card-body">
						{{ $commodity_counts['commodity_in_heavily_damage_condition'] }}
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6 col-lg-8">
			<div class="card">
				<x-bar-chart chartTitle="Grafik Barang Berdasarkan Kondisi" chartID="chartCommodityCondition"
					:series="$charts['commodity_condition_count']['series']"
					:categories="$charts['commodity_condition_count']['categories']" :colors="['#47C363', '#FFA426', '#FC544B']">
				</x-bar-chart>
			</div>
		</div>

		<div class="col-md-6 col-lg-4">
			<div class="card">
				<div class="card-header">
					<h4>5 Barang Termahal</h4>
				</div>
				<div class="card-body">
					@foreach($commodity_order_by_price as $key => $order_by_price)
					<ul class="list-unstyled list-unstyled-border">
						<li class="media">
							<!-- <img class="mr-3 rounded-circle" width="50" src="../assets/img/avatar/avatar-1.png" alt="avatar"> -->
							<div class="media-body">
								@can('detail barang')
								<button data-id="{{ $order_by_price->id }}" class="float-right btn btn-info btn-sm show-modal"
									data-toggle="modal" data-target="#show_commodity">Detail</button>
								@endcan
								<div class="media-title">{{ $order_by_price->name }}</div>
								<span class="text-small text-muted">Harga: Rp{{
									$order_by_price->indonesian_currency($order_by_price->price) }}</span>
							</div>
						</li>
					</ul>
					@endforeach
					@can('lihat barang')
					<div class="text-center pt-1 pb-1">
						<a href="{{ route('barang.index') }}" class="btn btn-primary btn-lg btn-round">
							Lihat Semua Barang
						</a>
					</div>
					@endcan
				</div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-7">
			<x-bar-chart chartTitle="Grafik Jumlah Barang Berdasarkan Tahun Pembelian" chartID="chartCommodityCountEachYear"
				:series="$charts['commodity_each_year_of_purchase_count']['series']"
				:categories="$charts['commodity_each_year_of_purchase_count']['categories']">
			</x-bar-chart>
		</div>
		<div class="col-lg-5">
			<x-pie-chart chartTitle="Grafik Jumlah Barang Berdasarkan Perolehan"
				chartID="chartCommodityByCommodityAcquisitionCount"
				:series="$charts['commodity_by_commodity_acquisition_count']['series']"
				:categories="$charts['commodity_by_commodity_acquisition_count']['categories']"></x-pie-chart>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-6">
			<x-pie-chart chartTitle="Grafik Jumlah Barang Berdasarkan Material" chartID="chartCommodityByMaterial"
				:series="$charts['commodity_by_material_count']['series']"
				:categories="$charts['commodity_by_material_count']['categories']"></x-pie-chart>
		</div>
		<div class="col-lg-6">
			<x-pie-chart chartTitle="Grafik Jumlah Barang Berdasarkan Merk" chartID="chartCommodityByBrand"
				:series="$charts['commodity_by_brand_count']['series']"
				:categories="$charts['commodity_by_brand_count']['categories']"></x-pie-chart>
		</div>
	</div>

	<div class="row">
		<div class="col-lg-12">
			<x-bar-chart chartTitle="Grafik Jumlah Barang Berdasarkan Ruangan" chartID="chartCommodityCountEachLocation"
				:series="$charts['commodity_each_location_count']['series']"
				:categories="$charts['commodity_each_location_count']['categories']">
			</x-bar-chart>
		</div>
	</div>

	@push('modal')
	@include('commodities.modal.show')
	@endpush

	@push('js')
	@include('_script');
	@endpush
</x-layout>
