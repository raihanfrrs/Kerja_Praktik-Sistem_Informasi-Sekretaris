<?php

namespace App\Http\Controllers;

use App\Models\mahasiswa;
use Illuminate\Http\Request;

class SuperadminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function surat(){
        return view('superadmin.master.surat');
    }

    public function createMahasiswa(){
        return view('superadmin.master.create.create_mahasiswa');
    }

    public function createDosen(){
        
    }

    public function createSurat(){
        
    }

    public function createRole(){
        
    }

    public function edit($npm){
    }
}
