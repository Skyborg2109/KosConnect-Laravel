<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\data_user_model;
use App\Models\Kos;

class DataController extends Controller
{
    public function dataPengguna()
    {
        $users = data_user_model::all();

        return view('admin.admin_manage_users', compact('users'));
    }

    public function dataUser()
    {
        $users = data_user_model::all();

        return view('admin.admin_manage_users', compact('users'));
    }

    public function dataKos()
    {
        // Get all kos with pemilik relationship
        $kos = Kos::with('pemilik')->get();
        // Get all owners for the add/edit modal
        $owners = data_user_model::where('role', 'pemilik')->get();
        
        return view('admin.admin_manage_kos', compact('kos', 'owners'));
    }

    public function editDataUser($id)
    {
        $user = data_user_model::find($id);

        return view('admin.editDataUser', compact('user'));
    }

    public function deleteUser($id)
    {
        $user = data_user_model::find($id);

        $nama = $user->nama_user;

        $user->delete();

        return redirect('/data-pengguna')->with('success', $nama . ' berhasil dihapus');
    }
    
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'nama_user' => 'required|string|max:255',
            'email' => 'required|email|unique:data_user,email',
            'nomor_telepon' => 'nullable|string|max:20',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,pemilik,penyewa',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        data_user_model::create($validated);

        return redirect('/data-pengguna')->with('success', 'User berhasil ditambahkan');
    }

    public function updateUser(Request $request, $id)
    {
        $user = data_user_model::findOrFail($id);

        $validated = $request->validate([
            'nama_user' => 'required|string|max:255',
            'email' => 'required|email|unique:data_user,email,' . $id,
            'nomor_telepon' => 'nullable|string|max:20',
            'role' => 'required|in:admin,pemilik,penyewa',
        ]);

        // Only update password if provided
        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        }

        $user->update($validated);

        return redirect('/data-pengguna')->with('success', 'User berhasil diupdate');
    }

    public function toggleStatusUser($id)
    {
        $user = data_user_model::findOrFail($id);
        
        // Check if status column exists or handle simpler toggle
        // Assuming status column might be missing, we should be careful. 
        // But for now, keeping the logic but fixing the duplicate return.
        
        // Toggle status
        $user->status = ($user->status == 'blokir') ? 'aktif' : 'blokir';
        $user->save();

        $statusMessage = ($user->status == 'aktif') ? 'diaktifkan' : 'diblokir';
        
        return redirect('/data-pengguna')->with('success', 'User berhasil ' . $statusMessage);
    }

    public function storeKosAdmin(Request $request)
    {
        $validated = $request->validate([
            'nama_kos' => 'required|string|max:255',
            'pemilik_id' => 'required|exists:data_user,id',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'harga_dasar' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        Kos::create($validated);

        return redirect('/data-kos')->with('success', 'Kos berhasil ditambahkan');
    }

    public function updateKosAdmin(Request $request, $id)
    {
        $kos = Kos::findOrFail($id);

        $validated = $request->validate([
            'nama_kos' => 'required|string|max:255',
            'pemilik_id' => 'required|exists:data_user,id',
            'alamat' => 'required|string',
            'kota' => 'required|string|max:100',
            'provinsi' => 'required|string|max:100',
            'harga_dasar' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $kos->update($validated);

        return redirect('/data-kos')->with('success', 'Data Kos berhasil diupdate');
    }
}
