<x-layout>
	<x-slot name="title">Halaman Daftar Prodi</x-slot>
	<x-slot name="page_heading">Daftar Prodi</x-slot>

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
							@foreach($departments as $department)
							<tr>
								<th scope="row">{{ $loop->iteration }}</th>
								<td>{{ $department->name }}</td>
								<td>{{ Str::limit($department->description, 55, '...') }}</td>
								</td>
								<td class="text-center">
									<div class="btn-group">
										<a data-id="{{ $department->id }}" class="btn btn-sm btn-info text-white show-modal mr-2"
											data-toggle="modal" data-target="#show_department">
											<i class="fas fa-fw fa-search"></i>
										</a>
										<a data-id="{{ $department->id }}"
											class="btn btn-sm btn-success text-white edit-modal mr-2" data-toggle="modal"
											data-target="#department_edit_modal">
											<i class="fas fa-fw fa-edit"></i>
										</a>
										<form action="{{ route('prodi.destroy', $department->id) }}" method="POST">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-danger delete-button">
												<i class="fas fa-fw fa-trash-alt"></i>
											</button>
										</form>
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
	@include('departments.modal.create')
	@include('departments.modal.show')
	@include('departments.modal.edit')
	@endpush

	@push('js')
	@include('departments._script')
	@endpush
</x-layout>
