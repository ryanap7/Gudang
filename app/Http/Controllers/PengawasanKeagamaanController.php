<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan;
use App\Models\PengawasanKeagamaan;
use Illuminate\Http\Request;

class PengawasanKeagamaanController extends Controller
{
    protected $customMessages = [
        'required'              => ':attribute harus diisi',
        'unique'                => 'This :attribute has already been taken.',
        'integer'               => ':Attribute must be a number.',
        'min'                   => ':Attribute must be at least :min.',
        'max'                   => ':Attribute may not be more than :max characters.',
        'exists'                => 'Not found.',
    ];

    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(PengawasanKeagamaan::orderBy('updated_at', 'DESC')
                ->get())
                ->addColumn('action', 'admin.keagamaan.action')
                ->rawColumns(['biodata', 'action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.keagamaan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kecamatan            = Kecamatan::orderBy('name')->get();

        return view('admin.keagamaan.create', compact('kecamatan'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        request()->validate([
            'kecamatan_id'          => 'required|integer',
            'tgl'                   => 'required|date',
            'nama'                  => 'nullable|string',
            'pimpinan'              => 'nullable|string',
            'alamat'                => 'nullable|string',
            'kegiatan'              => 'nullable|string',
            'jumlah_pengikut'       => 'nullable|string',
            'nomor_pendaftaran'     => 'nullable|string',
            'tgl_pendaftaran'       => 'nullable|string',
            'nomor_badan'           => 'nullable|string',
            'tgl_badan'             => 'nullable|date',
            'keterangan'            => 'nullable|string',
        ], $this->customMessages);

        $data = new PengawasanKeagamaan();
        $data->kecamatan_id             = strip_tags(request()->post('kecamatan_id'));
        $data->tgl                      = request()->post('tgl');
        $data->nama                     = strip_tags(request()->post('nama'));
        $data->pimpinan                 = strip_tags(request()->post('pimpinan'));
        $data->alamat                   = strip_tags(request()->post('alamat'));
        $data->kegiatan                 = strip_tags(request()->post('kegiatan'));
        $data->jumlah_pengikut          = strip_tags(request()->post('jumlah_pengikut'));
        $data->nomor_pendaftaran        = strip_tags(request()->post('nomor_pendaftaran'));
        $data->tgl_pendaftaran          = strip_tags(request()->post('tgl_pendaftaran'));
        $data->nomor_badan              = strip_tags(request()->post('nomor_badan'));
        $data->tgl_badan                = request()->post('tgl_badan');
        $data->keterangan               = strip_tags(request()->post('keterangan'));
        $data->save();

        return redirect()->route('admin.keagamaan.index')->with('success', "Data berhasil ditambahkan!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data               = PengawasanKeagamaan::findOrFail($id);

        return view('admin.keagamaan.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data               = PengawasanKeagamaan::findOrFail($id);
        $kecamatans         = Kecamatan::orderBY('name')->get();

        return view('admin.keagamaan.edit', compact('data', 'kecamatans'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = PengawasanKeagamaan::findOrFail($id);
        request()->validate([
            'kecamatan_id'          => 'required|integer',
            'tgl'                   => 'required|date',
            'nama'                  => 'nullable|string',
            'pimpinan'              => 'nullable|string',
            'alamat'                => 'nullable|string',
            'kegiatan'              => 'nullable|string',
            'jumlah_pengikut'       => 'nullable|string',
            'nomor_pendaftaran'     => 'nullable|string',
            'tgl_pendaftaran'       => 'nullable|string',
            'nomor_badan'           => 'nullable|string',
            'tgl_badan'             => 'nullable|date',
            'keterangan'            => 'nullable|string',
        ], $this->customMessages);

        $data->kecamatan_id             = strip_tags(request()->post('kecamatan_id'));
        $data->tgl                      = request()->post('tgl');
        $data->nama                     = strip_tags(request()->post('nama'));
        $data->pimpinan                 = strip_tags(request()->post('pimpinan'));
        $data->alamat                   = strip_tags(request()->post('alamat'));
        $data->kegiatan                 = strip_tags(request()->post('kegiatan'));
        $data->jumlah_pengikut          = strip_tags(request()->post('jumlah_pengikut'));
        $data->nomor_pendaftaran        = strip_tags(request()->post('nomor_pendaftaran'));
        $data->tgl_pendaftaran          = strip_tags(request()->post('tgl_pendaftaran'));
        $data->nomor_badan              = strip_tags(request()->post('nomor_badan'));
        $data->tgl_badan                = request()->post('tgl_badan');
        $data->keterangan               = strip_tags(request()->post('keterangan'));
        $data->save();

        return redirect()->route('admin.keagamaan.index')->with('success', "Data berhasil di edit!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = PengawasanKeagamaan::destroy($id);

        return response()->json($data);
    }

    public function filter()
    {
        return view('admin.keagamaan.filter');
    }

    public function download(Request $request)
    {
        $month          = request()->post('bulan');
        $bulan = request()->post('bulan');
        if ($bulan == 'Januari') {
            $bulan = '01';
        } else if ($bulan == 'Februari') {
            $bulan = '02';
        } else if ($bulan == 'Maret') {
            $bulan = '03';
        } else if ($bulan == 'April') {
            $bulan = '04';
        } else if ($bulan == 'Mei') {
            $bulan = '05';
        } else if ($bulan == 'Juni') {
            $bulan = '06';
        } else if ($bulan == 'Juli') {
            $bulan = '07';
        } else if ($bulan == 'Agustus') {
            $bulan = '08';
        } else if ($bulan == 'September') {
            $bulan = '09';
        } else if ($bulan == 'Oktober') {
            $bulan = '10';
        } else if ($bulan == 'November') {
            $bulan = '11';
        } else if ($bulan == 'Desember') {
            $bulan = '12';
        }
        $year           = request()->post('tahun');
        $atas_nama      = request()->post('atas_nama');
        $jabatan        = request()->post('jabatan');
        $nama           = request()->post('nama');
        $nip            = request()->post('nip');
        $today          = date('d M Y');
        $data = PengawasanKeagamaan::whereYear('tgl', '=', $year)
            ->whereMonth('tgl', '=', $month)
            ->get();

        return view('admin.keagamaan.show', compact('data', 'month', 'year', 'atas_nama', 'jabatan', 'nama', 'nip', 'today'));
    }
}
