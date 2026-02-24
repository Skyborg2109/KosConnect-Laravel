<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EditController extends Controller
{
    public function editprofil()
    {
        $id= session('id');

        $user = User::find($id);
        
        return view('penyewa.profil');
    }
}
