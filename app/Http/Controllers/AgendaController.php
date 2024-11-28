<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $agenda = Agenda::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('nama_agenda', 'like', "%{$search}%")
                        ->orWhere('isi_agenda', 'like', "%{$search}%")
                        ->orWhere('tempat', 'like', "%{$search}%")
                        ->orWhere('jdwl_agenda', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Agenda/Index', compact('agenda'));
    }

    public function create()
    {
        return Inertia::render('Agenda/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_agenda' => 'required|string|max:255',
            'isi_agenda' => 'required|string',
            'jdwl_agenda' => 'required|date',
            'jadwal_awal' => 'required|date',
            'jadwal_akhir' => 'required|date|after_or_equal:jadwal_awal',
            'tempat' => 'required|string|max:255',
        ]);

        // Format dates using Carbon
        $validated['jdwl_agenda'] = Carbon::parse($validated['jdwl_agenda'])->format('Y-m-d H:i:s');
        $validated['jadwal_awal'] = Carbon::parse($validated['jadwal_awal'])->format('Y-m-d H:i:s');
        $validated['jadwal_akhir'] = Carbon::parse($validated['jadwal_akhir'])->format('Y-m-d H:i:s');

        Agenda::create($validated);

        return redirect()->route('agenda.index')->with('message', [
            'severity' => 'success',
            'detail' => 'Agenda berhasil ditambahkan',
            'life' => 3000
        ]);
    }

    public function edit(Agenda $agenda)
    {
        return Inertia::render('Agenda/Edit', [
            'agenda' => $agenda
        ]);
    }

    public function update(Request $request, Agenda $agenda)
    {
        $validated = $request->validate([
            'nama_agenda' => 'required|string|max:255',
            'isi_agenda' => 'required|string',
            'jdwl_agenda' => 'required|date',
            'jadwal_awal' => 'required|date',
            'jadwal_akhir' => 'required|date|after_or_equal:jadwal_awal',
            'tempat' => 'required|string|max:255',
        ]);

        // Format dates using Carbon
        $validated['jdwl_agenda'] = Carbon::parse($validated['jdwl_agenda'])->format('Y-m-d H:i:s');
        $validated['jadwal_awal'] = Carbon::parse($validated['jadwal_awal'])->format('Y-m-d H:i:s');
        $validated['jadwal_akhir'] = Carbon::parse($validated['jadwal_akhir'])->format('Y-m-d H:i:s');

        $agenda->update($validated);

        return redirect()->route('agenda.index')->with('message', [
            'severity' => 'success',
            'detail' => 'Agenda berhasil diperbarui',
            'life' => 3000
        ]);
    }

    public function destroy(Agenda $agenda)
    {
        try {
            $agenda->delete();
            return redirect()->back()->with('message', [
                'severity' => 'success',
                'detail' => 'Agenda berhasil dihapus',
                'life' => 3000
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('message', [
                'severity' => 'error',
                'detail' => 'Gagal menghapus agenda',
                'life' => 3000
            ]);
        }
    }
}
