<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // 1. Tampilkan Daftar User
    public function index()
    {
        $users = User::latest()->get();
        return view('admin.users.index', compact('users'));
    }

    // 2. Tampilkan Form Tambah User
    public function create()
    {
        return view('admin.users.create');
    }

    // 3. Simpan User Baru ke Database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,customer',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User baru berhasil ditambahkan!');
    }

    // 4. Tampilkan Detail User
    public function show($id)
    {
        // $user = User::findOrFail($id);
        // return view('admin.users.show', compact('user'));

        $user = User::with('creator')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    // 5. Tampilkan Form Edit User
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    // 6. Simpan Perubahan Edit
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,customer',
            'password' => 'nullable|string|min:8', // Password opsional saat edit
        ]);

        // $user->name = $request->name;
        // $user->email = $request->email;
        // $user->role = $request->role;

        // // Jika form password diisi, update passwordnya
        // if ($request->filled('password')) {
        //     $user->password = Hash::make($request->password);
        // }

        // $user->save();

        $user->name = $request->name;
        $user->email = $request->email;

        // DETEKSI PERUBAHAN ROLE
        if ($user->role !== $request->role) {
            // Jika role-nya beda dengan yang lama, catat sejarahnya!
            $user->previous_role = $user->role;
            $user->role = $request->role;
            $user->role_changed_by = auth()->id(); // Catat ID Admin yang lagi login
            $user->role_changed_at = now();        // Catat waktu saat ini
        }

        // Jika form password diisi, update passwordnya
        if ($request->filled('password')) {
            $user->password = \Illuminate\Support\Facades\Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'Data user berhasil diperbarui!');
    }

    // 7. Hapus User
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Keamanan: Cegah admin menghapus akunnya sendiri
        if (auth()->id() === $user->id) {
            return redirect()->route('admin.users.index')->with('error', 'Akses ditolak! Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User berhasil dihapus!');
    }

}
