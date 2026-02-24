<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\data_user_model;
use Illuminate\Support\Facades\Hash;

class EditProfilController extends Controller
{
    // Menampilkan halaman profil
    public function editProfil()
    {
        $id = session('user.id'); 
        $user = data_user_model::find($id);
        
        return view('penyewa.profil', compact('user'));
    }

    // Update informasi profil dan password (opsional)
    public function updateProfil(Request $request)
    {
        // Validasi dasar
        $rules = [
            'nama-lengkap' => 'required|min:3|max:50',
            'email' => 'required|email',
            'telepon' => 'nullable|min:10|max:15',
        ];

        // Jika password lama diisi, berarti user ingin ubah password
        if (!empty($request->input('password-lama'))) {
            $rules['password-lama'] = 'required';
            $rules['password-baru'] = 'required|min:6';
            $rules['password-konfirmasi'] = 'required|same:password-baru';
        }

        $request->validate($rules, [
            'nama-lengkap.required' => 'Nama lengkap wajib diisi',
            'nama-lengkap.min' => 'Nama lengkap minimal 3 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password-lama.required' => 'Password lama wajib diisi jika ingin mengubah password',
            'password-baru.required' => 'Password baru wajib diisi',
            'password-baru.min' => 'Password baru minimal 6 karakter',
            'password-konfirmasi.required' => 'Konfirmasi password wajib diisi',
            'password-konfirmasi.same' => 'Konfirmasi password tidak cocok dengan password baru',
        ]);

        $id = session('user.id');
        $user = data_user_model::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        // Data yang akan diupdate
        $dataToUpdate = [
            'nama_user' => $request->input('nama-lengkap'),
            'email' => $request->email,
            'nomor_telepon' => $request->input('telepon'),
        ];

        // Jika password lama diisi, cek dan update password
        if (!empty($request->input('password-lama'))) {
            // Verifikasi password lama
            if (!Hash::check($request->input('password-lama'), $user->password)) {
                return redirect()->back()->with('error', 'Password lama tidak sesuai')->withInput();
            }
            
            // Tambahkan password baru ke data update
            $dataToUpdate['password'] = Hash::make($request->input('password-baru'));
        }

        // Update data user
        $user->update($dataToUpdate);

        // Update session dengan data baru
        session([
            'user.name' => $request->input('nama-lengkap'),
            'user.email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    // Update profil admin
    public function updateProfilAdmin(Request $request)
    {
        // Validasi dasar
        $rules = [
            'nama-lengkap' => 'required|min:3|max:50',
            'email' => 'required|email',
        ];

        // Jika password lama diisi, berarti admin ingin ubah password
        if (!empty($request->input('password-lama'))) {
            $rules['password-lama'] = 'required';
            $rules['password-baru'] = 'required|min:6';
            $rules['password-konfirmasi'] = 'required|same:password-baru';
        }

        $request->validate($rules, [
            'nama-lengkap.required' => 'Nama lengkap wajib diisi',
            'nama-lengkap.min' => 'Nama lengkap minimal 3 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password-lama.required' => 'Password lama wajib diisi jika ingin mengubah password',
            'password-baru.required' => 'Password baru wajib diisi',
            'password-baru.min' => 'Password baru minimal 6 karakter',
            'password-konfirmasi.required' => 'Konfirmasi password wajib diisi',
            'password-konfirmasi.same' => 'Konfirmasi password tidak cocok dengan password baru',
        ]);

        $id = session('admin.id');
        $admin = data_user_model::find($id);

        if (!$admin) {
            return redirect()->back()->with('error', 'Admin tidak ditemukan');
        }

        // Data yang akan diupdate
        $dataToUpdate = [
            'nama_user' => $request->input('nama-lengkap'),
            'email' => $request->email,
        ];

        // Jika password lama diisi, cek dan update password
        if (!empty($request->input('password-lama'))) {
            // Verifikasi password lama
            if (!Hash::check($request->input('password-lama'), $admin->password)) {
                return redirect()->back()->with('error', 'Password lama tidak sesuai')->withInput();
            }
            
            // Tambahkan password baru ke data update
            $dataToUpdate['password'] = Hash::make($request->input('password-baru'));
        }

        // Update data admin
        $admin->update($dataToUpdate);

        // Update session dengan data baru
        session([
            'admin.name' => $request->input('nama-lengkap'),
            'admin.email' => $request->email,
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    // Update profil pemilik
    public function updateProfilPemilik(Request $request)
    {
        // Validasi dasar
        $rules = [
            'nama-lengkap' => 'required|min:3|max:50',
            'email' => 'required|email',
            'telepon' => 'nullable|min:10|max:15',
        ];

        // Jika password lama diisi, berarti pemilik ingin ubah password
        if (!empty($request->input('password-lama'))) {
            $rules['password-lama'] = 'required';
            $rules['password-baru'] = 'required|min:6';
            $rules['password-konfirmasi'] = 'required|same:password-baru';
        }

        $request->validate($rules, [
            'nama-lengkap.required' => 'Nama lengkap wajib diisi',
            'nama-lengkap.min' => 'Nama lengkap minimal 3 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'password-lama.required' => 'Password lama wajib diisi jika ingin mengubah password',
            'password-baru.required' => 'Password baru wajib diisi',
            'password-baru.min' => 'Password baru minimal 6 karakter',
            'password-konfirmasi.required' => 'Konfirmasi password wajib diisi',
            'password-konfirmasi.same' => 'Konfirmasi password tidak cocok dengan password baru',
        ]);

        $id = session('user.id');
        $user = data_user_model::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        // Data yang akan diupdate
        $dataToUpdate = [
            'nama_user' => $request->input('nama-lengkap'),
            'email' => $request->email,
            'nomor_telepon' => $request->input('telepon'),
        ];

        // Jika password lama diisi, cek dan update password
        if (!empty($request->input('password-lama'))) {
            // Verifikasi password lama
            if (!Hash::check($request->input('password-lama'), $user->password)) {
                return redirect()->back()->with('error', 'Password lama tidak sesuai')->withInput();
            }
            
            // Tambahkan password baru ke data update
            $dataToUpdate['password'] = Hash::make($request->input('password-baru'));
        }

        // Update data user
        $user->update($dataToUpdate);

        // Update session dengan data baru
        session([
            'user.name' => $request->input('nama-lengkap'),
            'user.email' => $request->email,
            'user.nomor_telepon' => $request->input('telepon'),
        ]);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui');
    }

    // Update foto profil
    public function updatePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'photo.required' => 'Silakan pilih foto terlebih dahulu',
            'photo.image' => 'File harus berupa gambar',
            'photo.mimes' => 'Format foto harus jpeg, png, jpg, atau gif',
            'photo.max' => 'Ukuran foto maksimal 2MB',
        ]);

        $id = session('user.id');
        $user = data_user_model::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User tidak ditemukan');
        }

        try {
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                
                if ($file->isValid()) {
                    // Use base64 for Cloudinary upload
                    $base64 = base64_encode($file->get());
                    $mime = $file->getMimeType();
                    $dataUri = "data:$mime;base64,$base64";
                    
                    $upload = \CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary::uploadApi()->upload($dataUri, [
                        'folder' => 'profile_photos'
                    ]);
                    
                    // Update user photo URL
                    $user->update([
                        'foto_profil' => $upload['secure_url']
                    ]);
                    
                    // Update session with new photo
                    session(['user.foto_profil' => $upload['secure_url']]);
                    
                    return redirect()->back()->with('success', 'Foto profil berhasil diperbarui');
                } else {
                    return redirect()->back()->with('error', 'File upload tidak valid');
                }
            }
        } catch (\Exception $e) {
            \Log::error('Cloudinary Error (Profile Photo): ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengupload foto: ' . $e->getMessage());
        }

        return redirect()->back()->with('error', 'Tidak ada file yang diupload');
    }
}
