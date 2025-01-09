<x-layout>
	<x-slot name="title">Halaman Daftar Perolehan</x-slot>
	<x-slot name="page_heading">Daftar Perolehan</x-slot>

	<div class="card">
		<div class="card-body">
			@include('utilities.alert')
			<div class="d-flex justify-content-end mb-3">
				@can('tambah perolehan')
				<button type="button" class="btn btn-primary" data-toggle="modal"
					data-target="#commodity_acquisition_create_modal">
					<i class="fas fa-fw fa-plus"></i>
					Tambah Data
				</button>
				@endcan
			</div>

			<div class="row">
				<div class="col-lg-12">
					<x-datatable>
						<thead>
							<tr>
								<th scope="col">#</th>
								<th scope="col">Nama</th>
								<th scope="col">Deskripsi</th>
								<th scope="col">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($commodityAcquisitions as $commodityAcquisition)
							<tr>
								<th scope="row">{{ $loop->iteration }}</th>
								<td>{{ $commodityAcquisition->name }}</td>
								<td>{{ Str::limit($commodityAcquisition->description, 55, '...') }}</td>
								</td>
								<td class="text-center">
									<div class="btn-group">
										@can('detail perolehan')
										<a data-id="{{ $commodityAcquisition->id }}" class="btn btn-sm btn-info text-white show-modal mr-2"
											data-toggle="modal" data-target="#show_commodity_acquisition">
											<i class="fas fa-fw fa-search"></i>
										</a>
										@endcan
										@can('ubah perolehan')
										<a data-id="{{ $commodityAcquisition->id }}"
											class="btn btn-sm btn-success text-white edit-modal mr-2" data-toggle="modal"
											data-target="#commodity_acquisition_edit_modal">
											<i class="fas fa-fw fa-edit"></i>
										</a>
										@endcan
										@can('hapus perolehan')
										<form action="{{ route('perolehan.destroy', $commodityAcquisition->id) }}" method="POST">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-danger delete-button">
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
	@include('commodity-acquisitions.modal.create')
	@include('commodity-acquisitions.modal.show')
	@include('commodity-acquisitions.modal.edit')
	@endpush

	@push('js')
	@include('commodity-acquisitions._script')
	@endpush
</x-layout>
