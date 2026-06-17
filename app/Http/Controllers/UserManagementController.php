<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Posyandu;
use App\Models\Puskesmas;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class UserManagementController extends Controller
{
    /**
     * Display the user management page.
     */
    public function index(Request $request): View
    {
        $query = User::query();

        // Search
        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%")
                    ->orWhere('nik_ortu', 'like', "%{$search}%")
                    ->orWhere('nip_bidan', 'like', "%{$search}%")
                    ->orWhere('nomor_kontak', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($role = $request->input('role')) {
            $query->where('role', $role);
        }

        if (auth()->user()->isBidan()) {
            $query->where('role', 'kader');
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        $kabupatenList = Kabupaten::all();
        $puskesmasList = Puskesmas::all();
        $posyanduList = Posyandu::with('puskesmas')->get();

        return view('dashboard.users.index', compact('users', 'kabupatenList', 'puskesmasList', 'posyanduList'));
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', 'unique:tb_user,username'],
            'password' => ['required', 'string', 'min:8', Password::defaults()],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nomor_kontak' => ['nullable', 'string', 'max:15'],
            'role' => ['required', 'string', Rule::in(['super admin', 'bidan', 'kader', 'orang tua', 'dinkes'])],
            'nip_bidan' => ['nullable', 'digits:18'],
            'nik_ortu' => ['nullable', 'digits:16'],
            'kode_instansi_dinkes' => ['nullable', 'string', 'max:30'],
            'is_active' => ['nullable', 'boolean'],
            'kabupaten_id' => ['nullable', 'exists:kabupatens,id'],
            'puskesmas_id' => ['nullable', 'exists:puskesmas,id'],
            'posyandu_id' => ['nullable', 'exists:posyandus,id'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:tb_user,email'],
            'alamat_domisili' => ['nullable', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'role.required' => 'Role wajib dipilih.',
            'nik_ortu.digits' => 'NIK harus 16 digit angka.',
            'nip_bidan.digits' => 'NIP Bidan harus 18 digit angka.',
        ]);

        if (! isset($validated['is_active'])) {
            $validated['is_active'] = false;
        }

        if (auth()->user()->isBidan() && $validated['role'] !== 'kader') {
            abort(403, 'Bidan hanya dapat mengelola akun kader.');
        }

        User::create($validated);

        $routePrefix = auth()->user()->isBidan() ? 'bidan.kader' : 'admin.users';

        return redirect()->route($routePrefix.'.index')
            ->with('success', 'Pengguna berhasil ditambahkan.');
    }

    /**
     * Get a single user for editing (AJAX).
     */
    public function show(User $user): JsonResponse
    {
        return response()->json($user->only([
            'id_user', 'username', 'nama_lengkap', 'nomor_kontak',
            'role', 'nip_bidan', 'nik_ortu', 'kode_instansi_dinkes',
            'is_active', 'kabupaten_id', 'puskesmas_id', 'posyandu_id', 'email', 'alamat_domisili',
        ]));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'username' => ['required', 'string', 'max:50', Rule::unique('tb_user', 'username')->ignore($user->id_user, 'id_user')],
            'password' => ['nullable', 'string', 'min:8', Password::defaults()],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nomor_kontak' => ['nullable', 'string', 'max:15'],
            'role' => ['required', 'string', Rule::in(['super admin', 'bidan', 'kader', 'orang tua', 'dinkes'])],
            'nip_bidan' => ['nullable', 'digits:18'],
            'nik_ortu' => ['nullable', 'digits:16'],
            'kode_instansi_dinkes' => ['nullable', 'string', 'max:30'],
            'is_active' => ['nullable', 'boolean'],
            'kabupaten_id' => ['nullable', 'exists:kabupatens,id'],
            'puskesmas_id' => ['nullable', 'exists:puskesmas,id'],
            'posyandu_id' => ['nullable', 'exists:posyandus,id'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:tb_user,email,'.$user->id_user.',id_user'],
            'alamat_domisili' => ['nullable', 'string'],
        ], [
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username sudah digunakan.',
            'password.min' => 'Password minimal 8 karakter.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'role.required' => 'Role wajib dipilih.',
            'nik_ortu.digits' => 'NIK harus 16 digit angka.',
            'nip_bidan.digits' => 'NIP Bidan harus 18 digit angka.',
        ]);

        // Only update password if provided
        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        if (! isset($validated['is_active'])) {
            $validated['is_active'] = false;
        }

        // Prevent wiping Orang Tua's self-managed posyandu_id
        if ($validated['role'] === 'orang tua') {
            unset($validated['posyandu_id']);
            $validated['kabupaten_id'] = null;
            $validated['puskesmas_id'] = null;
        } elseif ($validated['role'] === 'super admin') {
            $validated['kabupaten_id'] = null;
            $validated['puskesmas_id'] = null;
            $validated['posyandu_id'] = null;
        } elseif ($validated['role'] !== 'kader' && $validated['role'] !== 'bidan' && $validated['role'] !== 'dinkes') {
             // catch-all for any other roles if added in future
        }

        if (auth()->user()->isBidan() && ($validated['role'] !== 'kader' || $user->role !== 'kader')) {
            abort(403, 'Bidan hanya dapat mengelola akun kader.');
        }

        $user->update($validated);

        $routePrefix = auth()->user()->isBidan() ? 'bidan.kader' : 'admin.users';

        return redirect()->route($routePrefix.'.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent deleting yourself
        if ($user->id_user === auth()->id()) {
            $routePrefix = auth()->user()->isBidan() ? 'bidan.kader' : 'admin.users';

            return redirect()->route($routePrefix.'.index')
                ->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }

        if (auth()->user()->isBidan() && $user->role !== 'kader') {
            abort(403, 'Bidan hanya dapat menghapus akun kader.');
        }

        $user->delete();

        $routePrefix = auth()->user()->isBidan() ? 'bidan.kader' : 'admin.users';

        return redirect()->route($routePrefix.'.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
