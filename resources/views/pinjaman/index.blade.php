@extends('template.main')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="card">
            <h5 class="card-header">Pinjaman</h5>
            <div class="card-datatable text-nowrap">
                <table id="anggotaTable" data-url="{{ route('pinjaman.data') }}" class="datatables-ajax table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Anggota</th>
                            <th>NIK</th>
                            <th>No Transaksi</th>
                            <th>Jumlah Pinjaman</th>
                            <th>Tenor Bulan</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    @include('pinjaman.form-input')
@endsection

@push('js')
    <script src="{{ asset('assets/backend/pinjaman.js') }}"></script>
@endpush
