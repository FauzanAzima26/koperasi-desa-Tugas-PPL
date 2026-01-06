<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Pest\Support\Str;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggota = Anggota::query()->orderBy('created_at', 'desc')->get();

        return view('transaksi.index', compact('anggota'));
    }

    public function getData()
    {
        $anggota = Transaksi::with('user', 'anggota')->orderBy('created_at', 'desc');

        return DataTables::of($anggota)
            ->addIndexColumn()

            ->editColumn('user_id', function ($row) {
                return $row->user->name ?? '-';
            })

            ->editColumn('jumlah', function ($row) {
                return 'Rp ' . number_format($row->jumlah, 0, ',', '.');
            })

            ->editColumn('anggota_id', function ($row) {
                return $row->anggota->nama ?? '-';
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

            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $noTransaksi = 'TRX-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        $request->validate([
            'tanggal' => 'required|date_format:Y-m-d',
            'jenis' => 'required|in:pengeluaran,pemasukan',
            'kategori' => 'required|in:simpanan,pinjaman,angsuran,operasional',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'required|string|max:255',
            'anggota_id' => 'required|exists:anggota,id'
        ]);

        $data = $request->only([
            'tanggal',
            'jenis',
            'kategori',
            'jumlah',
            'keterangan',
            'anggota_id'
        ]);

        $data['no_transaksi'] = $noTransaksi;
        $data['user_id'] = Auth::id();

        $anggota = Transaksi::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $anggota
        ]);
    }

    public function show($id)
    {
        $anggota = Transaksi::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => $anggota
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'tanggal' => 'sometimes|required|date_format:Y-m-d',
            'jenis' => 'sometimes|required|in:pemasukan,pengeluaran',
            'kategori' => 'sometimes|required|in:pinjaman,angsuran,simpanan,operasional',
            'jumlah' => 'sometimes|required|numeric|min:0',
            'keterangan' => 'sometimes|required|string|max:255',
            'anggota_id' => 'sometimes|required|exists:anggota,id',
        ]);

        $anggota = Transaksi::findOrFail($id);

        $data = array_filter(
            $request->only([
                'tanggal',
                'jenis',
                'kategori',
                'jumlah',
                'keterangan',
                'anggota_id'
            ]),
            fn($v) => $v !== null
        );

        $data['user_id'] = Auth::id();

        $anggota->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => $anggota
        ]);
    }

    public function destroy($id)
    {
        $anggota = Transaksi::findOrFail($id);

        $anggota->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
