<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['roles', 'permissions']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->orderByDesc('created_at')
            ->paginate(10)
            ->through(function ($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'roles' => $user->roles->pluck('name'),
                    'permissions' => $user->permissions->pluck('name'),
                    'created_at' => Carbon::parse($user->created_at)->format('Y-m-d'),
                    'updated_at' => Carbon::parse($user->updated_at)->format('Y-m-d'),
                ];
            });

        return Inertia::render('Users/Index', [
            'users' => $users,
            'can' => [
                'create_user' => Auth::user()->can('create users'),
                'edit_user' => Auth::user()->can('edit users'),
                'delete_user' => Auth::user()->can('delete users'),
            ]
        ]);
    }

    public function create()
    {
        if (!Auth::user()->can('create users')) {
            abort(403);
        }

        $roles = Role::all()->pluck('name')->map(function ($name) {
            return $name;
        })->toArray();

        return Inertia::render('Users/Create', [
            'roles' => $roles,
            'errors' => session('errors') ? session('errors')->getBag('default')->getMessages() : (object)[],
        ]);
    }

    public function store(Request $request)
    {
        if (!Auth::user()->can('create users')) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'string', 'exists:roles,name'],
        ]);

        try {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
            ]);

            $user->assignRole($validated['role']);

            return redirect()->route('users.index')->with('message', [
                'type' => 'success',
                'text' => 'User berhasil dibuat.'
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat membuat user. Silakan coba lagi.'
            ])->withInput();
        }
    }

    public function edit(User $user)
    {
        if (!Auth::user()->can('edit users')) {
            abort(403);
        }

        $roles = Role::all()->pluck('name')->map(function ($name) {
            return $name;
        })->toArray();

        return Inertia::render('Users/Edit', [
            'user' => $user->load('roles'),
            'roles' => $roles,
            'errors' => session('errors') ? session('errors')->getBag('default')->getMessages() : (object)[],
        ]);
    }

    public function update(Request $request, User $user)
    {
        if (!Auth::user()->can('edit users')) {
            abort(403);
        }

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'string', 'exists:roles,name'],
        ];

        // Only validate password if it's provided
        if ($request->filled('password')) {
            $rules['password'] = ['confirmed', Rules\Password::defaults()];
        }

        $validated = $request->validate($rules);

        try {
            $user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Update password if provided
            if ($request->filled('password')) {
                $user->update(['password' => Hash::make($validated['password'])]);
            }

            // Sync roles
            $user->syncRoles([$validated['role']]);

            return redirect()->route('users.index')->with('message', [
                'type' => 'success',
                'text' => 'User berhasil diperbarui.'
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat memperbarui user.'
            ])->withInput();
        }
    }

    public function destroy(User $user)
    {
        if (!Auth::user()->can('delete users')) {
            abort(403);
        }

        try {
            if ($user->id === Auth::id()) {
                return back()->withErrors([
                    'error' => 'Anda tidak dapat menghapus akun Anda sendiri.'
                ]);
            }

            $user->delete();

            return back()->with('message', [
                'type' => 'success',
                'text' => 'User berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return back()->withErrors([
                'error' => 'Terjadi kesalahan saat menghapus user.'
            ]);
        }
    }
}
