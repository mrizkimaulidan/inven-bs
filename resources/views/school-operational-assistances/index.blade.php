<x-layout>
	<x-slot name="title">Halaman Daftar BOS</x-slot>
	<x-slot name="page_heading">Daftar BOS</x-slot>

	<div class="card">
		<div class="card-body">
			@include('utilities.alert')
			<div class="d-flex justify-content-end mb-3">
				@can('tambah bos')
				<button type="button" class="btn btn-primary" data-toggle="modal"
					data-target="#school_operational_assistance_create_modal">
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
								<th scope="col">Tanggal Ditambahkan</th>
								<th scope="col">Aksi</th>
							</tr>
						</thead>
						<tbody>
							@foreach($school_operational_assistances as $school_operational_assistance)
							<tr>
								<th scope="row">{{ $loop->iteration }}</th>
								<td>{{ $school_operational_assistance->name }}</td>
								<td>{{ Str::limit($school_operational_assistance->description, 55, '...') }}</td>
								<td>{{ date('m/d/Y H:i A', strtotime($school_operational_assistance->created_at)) }}
								</td>
								<td class="text-center">
									<div class="btn-group">
										@can('detail bos')
										<a data-id="{{ $school_operational_assistance->id }}"
											class="btn btn-sm btn-info text-white show-modal mr-2" data-toggle="modal"
											data-target="#show_school_operational_assistance">
											<i class="fas fa-fw fa-search"></i>
										</a>
										@endcan
										@can('ubah bos')
										<a data-id="{{ $school_operational_assistance->id }}"
											class="btn btn-sm btn-success text-white edit-modal mr-2" data-toggle="modal"
											data-target="#school_operational_assistance_edit_modal">
											<i class="fas fa-fw fa-edit"></i>
										</a>
										@endcan
										@can('hapus bos')
										<form action="{{ route('bantuan-dana-operasional.destroy', $school_operational_assistance->id) }}"
											method="POST">
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
	@include('school-operational-assistances.modal.create')
	@include('school-operational-assistances.modal.show')
	@include('school-operational-assistances.modal.edit')
	@endpush

	@push('js')
	@include('school-operational-assistances._script')
	@endpush
</x-layout>
