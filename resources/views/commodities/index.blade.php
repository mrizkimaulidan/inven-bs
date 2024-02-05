@extends('layouts.index', ['title' => 'Halaman Data Barang', 'page_heading' => 'Daftar Barang'])

@section('content')
<div class="card">
	<div class="card-body">

		@include('utilities.alert')

		<div class="d-flex justify-content-end mb-3">
			<div class="btn-group">
				<button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#excel_menu">
					<i class="fas fa-fw fa-upload"></i>
					Import Excel
				</button>

				<form action="{{ route('barang.export') }}" method="POST">
					@csrf

					<button type="submit" class="btn btn-success mr-2">
						<i class="fas fa-fw fa-download"></i>
						Export Excel
					</button>
				</form>

				<button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#commodity_create_modal">
					<i class="fas fa-fw fa-plus"></i>
					Tambah Data
				</button>

				<form action="{{ route('barang.print') }}" method="POST">
					@csrf
					<button type="submit" class="btn btn-success">
						<i class="fas fa-fw fa-print"></i>
						Print
					</button>
				</form>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="table-responsive">
					<table class="table table-bordered table-hover" id="datatable">
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Kode Barang</th>
								<th scope="col">Nama Barang</th>
								<th scope="col">Tahun Pembelian</th>
								<th scope="col">Kondisi</th>
								<th scope="col">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($commodities as $commodity)
							<tr>
								<th scope="row">{{ $loop->iteration }}</th>
								<td>{{ $commodity->item_code }}</td>
								<td>{{ Str::limit($commodity->name, 55, '...') }}</td>
								<td>{{ $commodity->year_of_purchase }}</td>
								@if($commodity->condition === 1)
								<td>
									<span class="badge badge-pill badge-success" title="Baik">
										<i class="fas fa-fw fa-check-circle"></i>
										Baik
									</span>
								</td>
								@elseif($commodity->condition === 2)
								<td>
									<span class="badge badge-pill badge-warning" title="Kurang Baik">
										<i class="fa fa-fw fa-exclamation-circle"></i>
										Kurang Baik
									</span>
								</td>
								@else
								<td>
									<span class="badge badge-pill badge-danger" title="Rusak Berat">
										<i class="fa fa-fw fa-times-circle"></i>
										Rusak Berat</span>
								</td>
								@endif
								<td class="text-center">
									<div class="btn-group" role="group" aria-label="Basic example">
										<a data-id="{{ $commodity->id }}" class="btn btn-sm btn-info text-white show-modal mr-2"
											data-toggle="modal" data-target="#show_commodity" title="Lihat Detail">
											<i class="fas fa-fw fa-search"></i>
										</a>

										<a data-id="{{ $commodity->id }}" class="btn btn-sm btn-success text-white edit-modal mr-2"
											data-toggle="modal" data-target="#edit_commodity" title="Ubah data">
											<i class="fas fa-fw fa-edit"></i>
										</a>

										<form action="{{ route('barang.print-individual', $commodity->id) }}" method="POST">
											@csrf
											<button type="submit" class="btn btn-sm btn-primary mr-2">
												<i class="fas fa-fw fa-print"></i>
											</button>
										</form>

										<form action="{{ route('barang.destroy', $commodity) }}" method="POST">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-danger delete-button"><i
													class="fas fa-fw fa-trash-alt"></i></button>
										</form>
									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('modal')
@include('commodities.modal.show')
@include('commodities.modal.create')
@include('commodities.modal.edit')
@include('commodities.modal.import')
@endpush

@push('js')
@include('commodities._script')
@endpush