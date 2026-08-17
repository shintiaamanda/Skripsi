<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Register;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function index(Request $request): View
    {
        $query = Register::query();

        if ($search = $request->input('search')) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        }

        return view('admin.register.index', [
            'users' => $query->latest()->paginate(10)->withQueryString(),
            'filters' => $request->only('search'),
        ]);
    }

    public function create(): View
    {
        return view('admin.register.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'username' => 'required|string|max:255|unique:register,username',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|string|in:siswa,guru_bk,orang_tua,kepala_sekolah',
        ]);

        Register::create($validated);

        return redirect()->route('admin.register.index')->with('toast', [
            'type' => 'success',
            'message' => 'Akun berhasil ditambahkan.',
        ]);
    }

    public function edit(Register $register): View
    {
        return view('admin.register.edit', [
            'user' => $register,
        ]);
    }

    public function update(Request $request, Register $register): RedirectResponse
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'username' => 'required|string|max:255|unique:register,username,' . $register->id_register . ',id_register',
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:siswa,guru_bk,orang_tua,kepala_sekolah',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $register->update($validated);

        return redirect()->route('admin.register.index')->with('toast', [
            'type' => 'success',
            'message' => 'Akun berhasil diperbarui.',
        ]);
    }

    public function destroy(Register $register): RedirectResponse
    {
        $register->delete();

        return redirect()->route('admin.register.index')->with('toast', [
            'type' => 'success',
            'message' => 'Akun berhasil dihapus.',
        ]);
    }
}
