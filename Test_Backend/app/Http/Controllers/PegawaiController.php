<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pegawai = Pegawai::all();
        return response()->json(['data' => $pegawai]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'notlpn' => 'required'
        ]);

        $pegawai = new Pegawai([
            'nama' => $request->input('nama'),
            'email' => $request->input('email'),
            'alamat' => $request->input('alamat'),
            'notlpn' => $request->input('notlpn')
        ]);

        if ($pegawai->save()) {
            Log::info('Pegawai baru berhasil ditambahkan');
            return response()->json([
                'success' => true,
                'message' => 'Pegawai berhasil ditambahkan',
                'data' => $pegawai 
            ]);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal menambahkan pegawai'], 500);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pegawai = Pegawai::find($id);
        
        if ($pegawai) {
            return response()->json(['pegawai' => $pegawai]);
        } else {
            return response()->json(['message' => 'Pegawai tidak ditemukan.'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $pegawai = Pegawai::find($id);

        if (!$pegawai) {
            return response()->json(['message' => 'Pegawai tidak ditemukan'], 404);
        }

        $this->validate($request, [
            'nama' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'notlpn' => 'required'
        ]);

        $pegawai->nama = $request->input('nama');
        $pegawai->email = $request->input('email');
        $pegawai->alamat = $request->input('alamat');
        $pegawai->notlpn = $request->input('notlpn');

        if ($pegawai->save()) {
            Log::info('Pegawai dengan ID '.$id.' berhasil diupdate');
            return response()->json(['success' => true, 'message' => 'Data pegawai berhasil diupdate']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal mengupdate data pegawai'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Pegawai::destroy($id)) {
            Log::warning('Data pegawai dengan ID '.$id.' telah dihapus.');
            return response()->json(['success' => true, 'message' => 'Pegawai berhasil dihapus']);
        } else {
            return response()->json(['success' => false, 'message' => 'Gagal menghapus data pegawai'], 500);
        }
    }
}
