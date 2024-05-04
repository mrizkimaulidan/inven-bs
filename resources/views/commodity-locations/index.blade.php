<x-layout>
	<x-slot name="title">Halaman Daftar Ruangan</x-slot>
	<x-slot name="page_heading">Daftar Ruangan</x-slot>

	<div class="card">
		<div class="card-body">
			@include('utilities.alert')
			<div class="d-flex justify-content-end mb-3">
				<div class="btn-group">
					@can('import ruangan')
					<button type="button" class="btn btn-primary mr-2" data-toggle="modal" data-target="#excel_menu">
						<i class="fas fa-fw fa-upload"></i>
						Import Excel
					</button>
					@endcan

					@can('export ruangan')
					<form action="{{ route('ruangan.export') }}" method="POST">
						@csrf

						<button type="submit" class="btn btn-success mr-2">
							<i class="fas fa-fw fa-download"></i>
							Export Excel
						</button>
					</form>
					@endcan

					@can('tambah ruangan')
					<button type="button" class="btn btn-primary" data-toggle="modal"
						data-target="#commodity_location_create_modal">
						<i class="fas fa-fw fa-plus"></i>
						Tambah Data
					</button>
					@endcan
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<x-datatable>
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Nama</th>
								<th scope="col">Deskripsi</th>
								<th scope="col">Tanggal Ditambahkan</th>
								<th scope="col">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($commodity_locations as $commodity_location)
							<tr>
								<th scope="row">{{ $loop->iteration }}</th>
								<td>{{ $commodity_location->name }}</td>
								<td>{{ Str::limit($commodity_location->description, 55, '...') }}</td>
								<td>{{ date('d/m/Y H:i A', strtotime($commodity_location->created_at)) }}</td>
								<td class="text-center">
									<div class="btn-group" role="group" aria-label="Basic example">
										@can('detail ruangan')
										<a data-id="{{ $commodity_location->id }}" class="btn btn-sm btn-info text-white show-modal mr-2"
											data-toggle="modal" data-target="#show_commodity_location">
											<i class="fas fa-fw fa-search"></i>
										</a>
										@endcan
										@can('ubah ruangan')
										<a data-id="{{ $commodity_location->id }}" class="btn btn-sm btn-success text-white edit-modal mr-2"
											data-toggle="modal" data-target="#commodity_location_edit_modal" data-placement="top"
											title="Ubah data">
											<i class="fas fa-fw fa-edit"></i>
										</a>
										@endcan
										@can('hapus ruangan')
										<form action="{{ route('ruangan.destroy', $commodity_location->id) }}" method="POST">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-danger text-white delete-button">
												<i class="fas fa-fw fa-trash-alt"></i>
											</button>
										</form>
										@endcan
									</div>
								</td>
							</tr>
							@endforeach
						</tbody>
					</x-datatable>
				</div>
			</div>
		</div>
	</div>

	@push('modal')
	@include('commodity-locations.modal.create')
	@include('commodity-locations.modal.show')
	@include('commodity-locations.modal.edit')
	@include('commodity-locations.modal.import')
	@endpush

	@push('js')
	@include('commodity-locations._script')
	@endpush
</x-layout>
