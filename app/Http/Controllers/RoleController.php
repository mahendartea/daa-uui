<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->can('view roles')) {
            abort(403);
        }

        $search = $request->input('search');
        $query = Role::query()->with('permissions');

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $roles = $query->paginate(10)
            ->through(function ($role) {
                return [
                    'id' => $role->id,
                    'name' => $role->name,
                    'permissions' => $role->permissions->pluck('name'),
                    'created_at' => $role->created_at,
                    'updated_at' => $role->updated_at,
                ];
            });

        return Inertia::render('Roles/Index', [
            'roles' => $roles,
            'filters' => $request->only(['search']),
            'can' => [
                'create_role' => Auth::user()->can('create roles'),
                'edit_role' => Auth::user()->can('edit roles'),
                'delete_role' => Auth::user()->can('delete roles'),
            ],
        ]);
    }

    public function create()
    {
        if (!Auth::user()->can('create roles')) {
            abort(403);
        }

        return Inertia::render('Roles/Create', [
            'permissions' => Permission::all()->pluck('name'),
            'errors' => session('errors') ? session('errors')->getBag('default')->getMessages() : (object)[],
        ]);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('create roles')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (Role::where('name', strtolower($value))->exists()) {
                        $fail('Nama peran sudah digunakan.');
                    }
                }
            ],
            'permissions' => ['array'],
            'permissions.*' => ['exists:permissions,name'],
        ]);

        try {
            DB::beginTransaction();

            $role = Role::create([
                'name' => strtolower($validated['name']),
                'guard_name' => 'web'
            ]);

            if (isset($validated['permissions']) && !empty($validated['permissions'])) {
                try {
                    $role->syncPermissions($validated['permissions']);
                } catch (\Exception $e) {
                    DB::rollBack();
                    return back()->withErrors([
                        'permissions' => 'Terjadi kesalahan saat menyimpan izin.'
                    ])->withInput();
                }
            }

            DB::commit();

            return redirect()->route('roles.index')->with('message', [
                'type' => 'success',
                'text' => 'Peran berhasil dibuat.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat membuat peran.'
            ])->withInput();
        }
    }

    public function edit(Role $role)
    {
        if (!Auth::user()->can('edit roles')) {
            abort(403);
        }

        return Inertia::render('Roles/Edit', [
            'role' => [
                'id' => $role->id,
                'name' => $role->name,
                'permissions' => $role->permissions->pluck('name'),
            ],
            'permissions' => Permission::all()->pluck('name'),
            'errors' => session('errors') ? session('errors')->getBag('default')->getMessages() : (object)[],
        ]);
    }

    public function update(Request $request, Role $role)
    {
        if (!Auth::user()->can('edit roles')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($role) {
                    $exists = Role::where('name', strtolower($value))
                        ->where('id', '!=', $role->id)
                        ->exists();

                    if ($exists) {
                        $fail('Nama peran sudah digunakan.');
                    }
                }
            ],
        ]);

        try {
            $role->update(['name' => strtolower($validated['name'])]);
            if ($request->has('permissions')) {
                $role->syncPermissions($request->permissions);
            }

            return redirect()->route('roles.index')->with('message', [
                'type' => 'success',
                'text' => 'Peran berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat memperbarui peran.'
            ])->withInput();
        }
    }

    public function destroy(string|int $roleId)
    {
        if (!Auth::user()->can('delete roles')) {
            abort(403);
        }

        try {
            $role = Role::findOrFail($roleId);

            // Check if role is being used by users
            if ($role->users()->count() > 0) {
                return back()->withErrors([
                    'error' => 'Peran tidak dapat dihapus karena masih digunakan oleh pengguna.'
                ]);
            }

            // Remove all permissions before deleting the role
            $role->syncPermissions([]);

            // Delete the role using Spatie's method
            $role->forceDelete();

            return back()->with('message', [
                'type' => 'success',
                'text' => 'Peran berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat menghapus peran.'
            ]);
        }
    }
}
