@extends('template.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header">Anggota</h5>
            <div class="card-datatable text-nowrap">
                <div class="col-12 col-sm-6 col-md-8">
                    <button type="button" id="btnAdd" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#animationModal">
                        Tambah anggota
                    </button>
                </div>
                <table id="anggotaTable" data-url="{{ route('anggota.data') }}" class="datatables-ajax table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Pekerjaan</th>
                            <th>Usia</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @include('anggota.form-input')

@endsection

@push('js')
    <script src="{{ asset('assets/backend/anggota.js') }}"></script>
@endpush
