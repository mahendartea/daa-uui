<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Submenu;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubmenuController extends Controller
{
    public function index()
    {
        $submenus = Submenu::with('menu')->orderBy('urutan')->get();
        return Inertia::render('Admin/Submenu/Index', [
            'submenus' => $submenus
        ]);
    }

    public function create()
    {
        $menus = Menu::where('aktif', 'Y')->orderBy('urutan')->get();
        return Inertia::render('Admin/Submenu/Create', [
            'menus' => $menus
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_sub' => 'required|string|max:50',
            'link_sub' => 'nullable|string',
            'id_main' => 'required|exists:mainmenu,id_main',
            'id_submain' => 'nullable|integer',
            'urutan' => 'required|integer',
            'aktif' => 'required|in:Y,N',
        ]);

        Submenu::create($validated);

        return redirect()->route('submenus.index')
            ->with('message', 'Submenu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $submenu = Submenu::findOrFail($id);
        $menus = Menu::where('aktif', 'Y')->orderBy('urutan')->get();
        return Inertia::render('Admin/Submenu/Edit', [
            'submenu' => $submenu,
            'menus' => $menus
        ]);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nama_sub' => 'required|string|max:50',
            'link_sub' => 'nullable|string',
            'id_main' => 'required|exists:mainmenu,id_main',
            'id_submain' => 'nullable|integer',
            'urutan' => 'required|integer',
            'aktif' => 'required|in:Y,N',
        ]);

        $submenu = Submenu::findOrFail($id);
        $submenu->update($validated);

        return redirect()->route('submenus.index')
            ->with('message', 'Submenu berhasil diperbarui');
    }

    public function destroy($id)
    {
        $submenu = Submenu::findOrFail($id);
        $submenu->delete();

        return redirect()->route('submenus.index')
            ->with('message', 'Submenu berhasil dihapus');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.id_sub' => 'required|exists:submenu,id_sub',
            'items.*.urutan' => 'required|integer'
        ]);

        foreach ($request->items as $item) {
            Submenu::where('id_sub', $item['id_sub'])
                ->update(['urutan' => $item['urutan']]);
        }

        return response()->json(['message' => 'Urutan submenu berhasil diperbarui']);
    }
}
