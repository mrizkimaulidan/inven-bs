@extends('layouts.stisla.index', ['title' => 'Halaman Data BOS', 'page_heading' => 'Daftar BOS'])

@section('content')
<div class="card">
  <div class="row">
    <div class="col-lg-12">
      <button type="button" class="btn btn-primary float-right mt-3 mx-3" data-toggle="modal" data-target="#school_operational_assistance_create_modal">
        <i class="fas fa-fw fa-plus"></i>
        Tambah Data
      </button>

    </div>
  </div>
  <div class="row px-3 py-3">
    <div class="col-lg-12">
      <div class="table-responsive">
        <table class="table table-bordered table-hover" id="datatable">

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
              <td>{{ date('m/d/Y H:i A', strtotime($school_operational_assistance->created_at)) }}</td>
              <td class="text-center">
                <a data-id="{{ $school_operational_assistance->id }}" class="btn btn-sm btn-info text-white show_modal" data-toggle="modal" data-target="#show_school_operational_assistance">
                  <i class="fas fa-fw fa-search"></i>
                </a>
                <a data-id="{{ $school_operational_assistance->id }}" class="btn btn-sm btn-success text-white swal-edit-button" data-toggle="modal" data-target="#school_operational_assistance_edit_modal" data-placement="top" title="Ubah data">
                  <i class="fas fa-fw fa-edit"></i>
                </a>
                <a data-id="{{ $school_operational_assistance->id }}" class="btn btn-sm btn-danger text-white swal-delete-button" data-toggle="tooltip" data-placement="top" title="Hapus data">
                  <i class="fas fa-fw fa-trash-alt"></i>
                </a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@push('modal')
@include('school-operational-assistances.modal.create')
@include('school-operational-assistances.modal.show')
@include('school-operational-assistances.modal.edit')
@endpush

@push('js')
@include('school-operational-assistances._script')
@endpush