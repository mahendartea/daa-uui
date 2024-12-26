<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('urutan')->get();
        return Inertia::render('Admin/Menu/Index', [
            'menus' => $menus
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Menu/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'urutan' => 'required|integer',
            'aktif' => 'required|in:Y,N',
        ]);

        Menu::create($request->all());

        return redirect()->route('menus.index')
            ->with('message', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        return Inertia::render('Admin/Menu/Edit', [
            'menu' => $menu
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_menu' => 'required|string|max:255',
            'link' => 'nullable|string|max:255',
            'urutan' => 'required|integer',
            'aktif' => 'required|in:Y,N',
        ]);

        $menu = Menu::findOrFail($id);
        $menu->update($request->all());

        return redirect()->route('menus.index')
            ->with('message', 'Menu berhasil diperbarui');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();

        return redirect()->route('menus.index')
            ->with('message', 'Menu berhasil dihapus');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id_main' => 'required|exists:mainmenu,id_main',
            'items.*.urutan' => 'required|integer'
        ]);

        foreach ($request->items as $item) {
            Menu::where('id_main', $item['id_main'])
                ->update(['urutan' => $item['urutan']]);
        }

        return response()->json(['message' => 'Urutan menu berhasil diperbarui']);
    }
}
