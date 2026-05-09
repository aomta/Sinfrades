<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

// FIX: UserController ini tidak ada di dokumen asli, sekarang ditambahkan lengkap
class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $data = $query->latest()->paginate(10)->withQueryString();

        return view('user.index', compact('data'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|max:100',
            'email' => 'required|email|unique:users,email,' . $id,
            'role'  => 'required|in:admin,petugas,warga',
            'no_hp' => 'nullable|max:20',
            'dusun' => 'nullable|max:100',
        ]);

        $user->update($request->only(['name', 'email', 'role', 'no_hp', 'dusun']));

        return redirect()->route('user.index')->with('success', 'Data user berhasil diupdate!');
    }

    public function destroy($id)
    {
        // Jangan hapus diri sendiri
        if (auth()->id() == $id) {
            return redirect()->route('user.index')->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        User::findOrFail($id)->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
    }
}
