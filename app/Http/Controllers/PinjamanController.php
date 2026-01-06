<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Pinjaman;
use Pest\Support\Str;
use App\Models\Transaksi;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Logging\OpenTestReporting\Status;
use Yajra\DataTables\Facades\DataTables;

class PinjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('pinjaman.index');
    }

    public function getData()
    {
        $anggota = Pinjaman::with('transaksi', 'anggota')->orderBy('created_at', 'desc');

        return DataTables::of($anggota)
            ->addIndexColumn()

            ->addColumn('NamaAnggota', function ($row) {
                return $row->anggota->nama ?? '-';
            })

            ->addColumn('NikAnggota', function ($row) {
                return $row->anggota->nik ?? '-';
            })

            ->addColumn('NoTransaksi', function ($row) {
                return $row->transaksi->no_transaksi ?? '-';
            })

            ->addColumn('JumlahPinjaman', function ($row) {
                return $row->transaksi->jumlah ?? '-';
            })

            ->editColumn('tenor_bulan', function ($row) {
                return $row->tenor_bulan ?? '-';
            })

            ->addColumn('aksi', function ($row) {
                $updateUrl = route('transaksi.update', $row->id);
                return '
                <div class="d-flex gap-1">
                    <button class="btn btn-warning btn-sm editBtn"
                        data-id="' . $row->id . '"
                        data-update="' . $updateUrl . '">
                        <i class="ti ti-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-sm deleteBtn" data-id="' . $row->id . '">
                        <i class="ti ti-trash"></i>
                    </button>
                </div>
            ';
            })

            ->rawColumns(['aksi', 'NamaAnggota', 'NikAnggota', 'NoTransaksi', 'JumlahPinjaman'])
            ->make(true);
    }

    public function show($id)
    {
        $anggota = Pinjaman::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $anggota
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'tenor_bulan' => 'sometimes|integer|min:1|max:360',
            'status' => 'sometimes|required|in:lunas,belum_lunas',
        ]);

        $anggota = Pinjaman::findOrFail($id);

        $data = array_filter(
            $request->only([
                'tenor_bulan',
                'status',
            ]),
            fn($v) => $v !== null
        );

        $anggota->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => $anggota
        ]);
    }

    public function destroy($id)
    {

        $anggota = Pinjaman::findOrFail($id);

        $anggota->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
