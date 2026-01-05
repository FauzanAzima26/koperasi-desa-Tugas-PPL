@extends('template.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header">Transaksi</h5>
            <div class="card-datatable text-nowrap">
                <div class="col-12 col-sm-6 col-md-8">
                    <button type="button" id="btnAdd" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#animationModal">
                        Buat transaksi
                    </button>
                </div>
                <table id="anggotaTable" data-url="{{ route('transaksi.data') }}" class="datatables-ajax table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No.Transaksi</th>
                            <th>tanggal</th>
                            <th>Jenis</th>
                            <th>Kategori</th>
                            <th>Jumlah</th>
                            <th>Keterangan</th>
                            <th>Username</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @include('transaksi.form-input')

@endsection

@push('js')
    <script src="{{ asset('assets/backend/transaksi.js') }}"></script>
@endpush
