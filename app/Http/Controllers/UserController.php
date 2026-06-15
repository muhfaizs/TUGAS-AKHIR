<?php

namespace App\Http\Controllers;

use App\Models\Puskesmas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private function checkSuperAdmin()
    {
        if (auth()->check() && !in_array(auth()->user()->role, ['super_admin', 'admin'])) {
            abort(403, 'Akses Ditolak: Halaman ini hanya untuk Super Admin.');
        }
    }

    public function index(Request $request)
    {
        $this->checkSuperAdmin();

        $query = User::query();
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('role')) {
            $roleMapping = [
                'Bidan' => 'bidan',
                'Dinas Kesehatan' => 'dinas_kesehatan',
                'Kader' => 'kader',
                'Pasien' => 'patient',
                'Super Admin' => 'super_admin'
            ];
            
            $role = $roleMapping[$request->role] ?? $request->role;
            if($role) {
                $query->where('role', $role);
            }
        }
        
        $users = $query->orderBy('name', 'asc')->paginate(10)->withQueryString();
        
        // Format roles back for view
        $users->getCollection()->transform(function ($user) {
            $map = [
                'bidan' => 'Bidan',
                'dinas_kesehatan' => 'Dinas Kesehatan',
                'kader' => 'Kader',
                'patient' => 'Pasien',
                'super_admin' => 'Super Admin'
            ];
            $user->role = $map[$user->role] ?? $user->role;
            $user->is_active = $user->status === 'active';
            return $user;
        });

        return view('users.index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        $this->checkSuperAdmin();

        $roles = [
            'super_admin' => 'Super Admin',
            'bidan' => 'Bidan',
            'kader' => 'Kader',
            'upt_kb' => 'UPT KB',
            'dinas_kesehatan' => 'Dinas Kesehatan',
            'patient' => 'Pasien',
        ];

        $statuses = [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'verified' => 'Verified',
        ];

        $puskesmas = Puskesmas::orderBy('name')->get();

        return view('users.create', [
            'roles' => $roles,
            'statuses' => $statuses,
            'puskesmas' => $puskesmas,
        ]);
    }

    public function store(Request $request)
    {
        $this->checkSuperAdmin();

        // Fallback set username to nik if empty
        if (empty($request->username)) {
            $request->merge(['username' => $request->nik]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'nik' => 'required|string|min:16|max:18|unique:users,nik',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:super_admin,bidan,kader,upt_kb,dinas_kesehatan,patient',
            'status' => 'required|in:active,inactive,verified',
            'puskesmas_id' => 'nullable|exists:puskesmas,id',
        ]);

        User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'nik' => $validated['nik'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'status' => $validated['status'],
            'puskesmas_id' => $validated['puskesmas_id'] ?? null,
        ]);

        return redirect()->route('users.index')->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $this->checkSuperAdmin();

        $roles = [
            'super_admin' => 'Super Admin',
            'bidan' => 'Bidan',
            'kader' => 'Kader',
            'upt_kb' => 'UPT KB',
            'dinas_kesehatan' => 'Dinas Kesehatan',
            'patient' => 'Pasien',
        ];

        $statuses = [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'verified' => 'Verified',
        ];

        $puskesmas = Puskesmas::orderBy('name')->get();

        return view('users.edit', [
            'user' => $user,
            'roles' => $roles,
            'statuses' => $statuses,
            'puskesmas' => $puskesmas,
        ]);
    }

    public function update(Request $request, User $user)
    {
        $this->checkSuperAdmin();

        // Fallback set username to nik if empty
        if (empty($request->username)) {
            $request->merge(['username' => $request->nik]);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'nik' => ['required', 'string', 'min:16', 'max:18', Rule::unique('users', 'nik')->ignore($user->id)],
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'role' => 'required|in:super_admin,bidan,kader,upt_kb,dinas_kesehatan,patient',
            'status' => 'required|in:active,inactive,verified',
            'puskesmas_id' => 'nullable|exists:puskesmas,id',
        ]);

        $user->update([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['email'],
            'nik' => $validated['nik'],
            'phone' => $validated['phone'] ?? null,
            'role' => $validated['role'],
            'status' => $validated['status'],
            'puskesmas_id' => $validated['puskesmas_id'] ?? null,
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        $this->checkSuperAdmin();

        if ($user->id === auth()->id()) {
            return back()->with('warning', 'Kamu tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}
