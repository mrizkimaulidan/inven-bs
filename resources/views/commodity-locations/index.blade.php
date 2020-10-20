@extends('layouts.stisla.index', ['title' => 'Halaman Data Ruang', 'page_heading' => 'Daftar Ruang'])

@section('content')
<div class="card">
  <div class="row">
    <div class="col-lg-12">
      <button type="button" class="btn btn-primary float-right mt-3 mx-3" data-toggle="modal" data-target="#commodity_location_create_modal">
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
            @foreach($commodity_locations as $commodity_location)
            <tr>
              <th scope="row">{{ $loop->iteration }}</th>
              <td>{{ $commodity_location->name }}</td>
              <td>{{ Str::limit($commodity_location->description, 55, '...') }}</td>
              <td>{{ date('d/m/Y H:i A', strtotime($commodity_location->created_at)) }}</td>
              <td class="text-center">
                <a data-id="{{ $commodity_location->id }}" class="btn btn-sm btn-info text-white show_modal" data-toggle="modal" data-target="#show_commodity_location">
                  <i class="fas fa-fw fa-search"></i>
                </a>
                <a data-id="{{ $commodity_location->id }}" class="btn btn-sm btn-success text-white swal-edit-button" data-toggle="modal" data-target="#commodity_location_edit_modal" data-placement="top" title="Ubah data">
                  <i class="fas fa-fw fa-edit"></i>
                </a>
                <a data-id="{{ $commodity_location->id }}" class="btn btn-sm btn-danger text-white swal-delete-button" data-toggle="tooltip" data-placement="top" title="Hapus data">
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
@include('commodity-locations.modal.create')
@include('commodity-locations.modal.show')
@include('commodity-locations.modal.edit')
@endpush

@push('js')
@include('commodity-locations._script')
@endpush