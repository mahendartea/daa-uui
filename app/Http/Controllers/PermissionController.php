<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PermissionController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->can('view permissions')) {
            abort(403);
        }

        $search = $request->input('search');
        $query = Permission::query();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $permissions = $query->paginate(10)
            ->through(function ($permission) {
                return [
                    'id' => $permission->id,
                    'name' => $permission->name,
                    'guard_name' => $permission->guard_name,
                    'created_at' => $permission->created_at,
                    'updated_at' => $permission->updated_at,
                ];
            });

        return Inertia::render('Permissions/Index', [
            'permissions' => $permissions,
            'filters' => $request->only(['search']),
            'can' => [
                'create_permission' => Auth::user()->can('create permissions'),
                'edit_permission' => Auth::user()->can('edit permissions'),
                'delete_permission' => Auth::user()->can('delete permissions'),
            ],
        ]);
    }

    public function create()
    {
        if (!Auth::user()->can('create permissions')) {
            abort(403);
        }

        return Inertia::render('Permissions/Create', [
            'errors' => session('errors') ? session('errors')->getBag('default')->getMessages() : (object)[],
        ]);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('create permissions')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (Permission::where('name', strtolower($value))->exists()) {
                        $fail('Nama izin sudah digunakan.');
                    }
                }
            ],
        ]);

        try {
            DB::beginTransaction();

            Permission::create([
                'name' => strtolower($validated['name']),
                'guard_name' => 'web'
            ]);

            DB::commit();

            return redirect()->route('permissions.index')->with('message', [
                'type' => 'success',
                'text' => 'Izin berhasil dibuat.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat membuat izin.'
            ])->withInput();
        }
    }

    public function edit(string|int $permissionId)
    {
        if (!Auth::user()->can('edit permissions')) {
            abort(403);
        }

        $permission = Permission::findOrFail($permissionId);

        return Inertia::render('Permissions/Edit', [
            'permission' => [
                'id' => $permission->id,
                'name' => $permission->name,
                'guard_name' => $permission->guard_name,
            ],
            'errors' => session('errors') ? session('errors')->getBag('default')->getMessages() : (object)[],
        ]);
    }

    public function update(Request $request, string|int $permissionId)
    {
        if (!Auth::user()->can('edit permissions')) {
            abort(403);
        }

        $permission = Permission::findOrFail($permissionId);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) use ($permission) {
                    $exists = Permission::where('name', strtolower($value))
                        ->where('id', '!=', $permission->id)
                        ->exists();
                    
                    if ($exists) {
                        $fail('Nama izin sudah digunakan.');
                    }
                }
            ],
        ]);

        try {
            DB::beginTransaction();

            $permission->update([
                'name' => strtolower($validated['name'])
            ]);

            DB::commit();

            return redirect()->route('permissions.index')->with('message', [
                'type' => 'success',
                'text' => 'Izin berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat memperbarui izin.'
            ])->withInput();
        }
    }

    public function destroy(string|int $permissionId)
    {
        if (!Auth::user()->can('delete permissions')) {
            abort(403);
        }

        try {
            $permission = Permission::findOrFail($permissionId);

            // Check if permission is being used by roles
            if ($permission->roles()->count() > 0) {
                return back()->withErrors([
                    'error' => 'Izin tidak dapat dihapus karena masih digunakan oleh peran.'
                ]);
            }

            DB::beginTransaction();
            $permission->forceDelete();
            DB::commit();

            return back()->with('message', [
                'type' => 'success',
                'text' => 'Izin berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat menghapus izin.'
            ]);
        }
    }
}
