<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AnggotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('anggota.index');
    }

    public function getData()
    {
        $anggota = Anggota::query()->orderBy('created_at', 'desc');

        return DataTables::of($anggota)
            ->addIndexColumn()

            ->addColumn('aksi', function ($row) {
                $updateUrl = route('anggota.update', $row->id);
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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|digits:16',
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'pekerjaan' => 'required|string|max:100',
            'usia' => 'required|integer|min:0|max:120',
            'alamat' => 'required|string|max:255',
        ]);

        $data = $request->all();

        $anggota = Anggota::create($data);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan',
            'data' => $anggota
        ]);
    }

    public function show($id)
    {
        $anggota = Anggota::findOrFail($id);

        return response()->json([
            'status' => true,
            'data' => [
                'nik' => $anggota->nik,
                'nama' => $anggota->nama,
                'jenis_kelamin' => $anggota->jenis_kelamin,
                'pekerjaan' => $anggota->pekerjaan,
                'usia' => $anggota->usia,
                'alamat' => $anggota->alamat,
            ]
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nik' => 'sometimes|required|digits:16',
            'nama' => 'sometimes|required|string|max:255',
            'jenis_kelamin' => 'sometimes|required|in:L,P',
            'pekerjaan' => 'sometimes|required|string|max:255',
            'usia' => 'sometimes|required|integer|min:0|max:120',
            'alamat' => 'sometimes|required|string|max:255',
        ]);

        $anggota = Anggota::findOrFail($id);

        $data = array_filter(
            $request->only([
                'nik',
                'nama',
                'usia',
                'jenis_kelamin',
                'pekerjaan',
                'alamat'
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
        $anggota = Anggota::findOrFail($id);

        $anggota->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus'
        ]);
    }
}
