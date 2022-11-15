<?php

namespace App\Http\Controllers;

use App\Models\wargadesa;
use App\Models\dusun;
use App\Http\Requests\StorewargadesaRequest;
use App\Http\Requests\UpdatewargadesaRequest;
use Illuminate\Support\Facades\DB;

class WargadesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        
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
     * @param  \App\Http\Requests\StorewargadesaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorewargadesaRequest $request)
    {
        $validateData = $request->validate([
            'NIK' => 'required | max:16',
            'Nama' => 'required | max:64',
            'WargaID' => 'required',

        ]);
        wargadesa::insert([
            'NIK' => 'nik'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\wargadesa  $wargadesa
     * @return \Illuminate\Http\Response
     */
    public function show(wargadesa $wargadesa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\wargadesa  $wargadesa
     * @return \Illuminate\Http\Response
     */
    public function edit(wargadesa $wargadesa)
    {
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatewargadesaRequest  $request
     * @param  \App\Models\wargadesa  $wargadesa
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatewargadesaRequest $request, wargadesa $wargadesa)
    {
        $validateData = $request->validate([
            'nik' => 'required | max:16',
            'nama' => 'required | max:64'
        ]);
        if($validateData){
        wargadesa::where('WargaID', '=', $wargadesa)->update([
            'NIK' => 'nik'
        ]);
        }
        return redirect('/data');


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\wargadesa  $wargadesa
     * @return \Illuminate\Http\Response
     */
    public function destroy($wargadesa)
    {
        $data = wargadesa::where('WargaID', '=', $wargadesa)->delete();
        return redirect('/data')->with('success', 'Data Berhasil Dihapus');
    }

    public function getkelahiran()
    {
        return view('kelahiran', [
            "wargadesa" => \App\Models\wargadesa::all()
            ]);
    }

    public function getJK()
    {
        return view('jenis-kelamin', [
            "wargadesa" => \App\Models\wargadesa::all()
            ]);
    }

    public function getpekerjaan()
    {
        return view('pekerjaan', [
            "wargadesa" => \App\Models\wargadesa::all()
            ]);
    }

    public function getpendidikan()
    {
        return view('pendidikan', [
            "wargadesa" => \App\Models\wargadesa::all()
            ]);
    }

    public function getusia()
    {
        return view('usia', [
            "wargadesa" => \App\Models\wargadesa::all()
            ]);
    }

    

    public function getdata()
    {   
        if(request('search')){

            $cari = wargadesa::where('Nama', 'like', '%' . request('search') . '%')
                ->orwhere('NIK', 'like', '%' . request('search') ."%")
                ->orwhere('Nomor_KK', 'like', '%' . request('search')  ."%")->paginate(10)->withQueryString();
            if(count($cari)>0){
                return view('data', [
                    "wargadesa" => $cari,
                    "dusuns" => dusun::all(),
                    "checker" => 2
                    ]);
            }
            else{
                return view('data', [
                    "wargadesa" => wargadesa::Paginate(15),
                    "checker" => 0,
                    "dusuns" => dusun::all()
                    ]);
            }
            
        }
        return view('data', [
            "wargadesa" => wargadesa::Paginate(10),
            "checker" => 1,
            "dusuns" => dusun::all()
            ]);
        
       
        
    }

    public function editdata($id){
        $data = wargadesa::where('WargaID', 'like', '%'. $id. '%')->first();    
        return view('editdata', [
            "wargadesa" => $data,
            "dusuns" => dusun::all()
        ]);
    }

    public function tambahdata()
    {
        return view('tambahdata', [
            "dusuns" => dusun::all()
        ]);
    }


    
}
