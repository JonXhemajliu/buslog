<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        return redirect()->route('company.dashboard')->with('tab', 'buses');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate' => 'required|unique:buses',
            'model' => 'required',
            'capacity' => 'required|integer|min:1',
            'year' => 'required|integer|min:1900',
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        $validated['company_id'] = auth('company')->id();
        Bus::create($validated);

        return redirect()->route('company.dashboard')
            ->with('tab', 'buses')
            ->with('success', 'Autobusi u shtua me sukses!');
    }

    public function update(Request $request, Bus $bus)
    {
        abort_if($bus->company_id !== auth('company')->id(), 403);

        $validated = $request->validate([
            'plate' => 'required|unique:buses,plate,' . $bus->id,
            'model' => 'required',
            'capacity' => 'required|integer|min:1',
            'year' => 'required|integer|min:1900',
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        $bus->update($validated);

        return redirect()->route('company.dashboard')
            ->with('tab', 'buses')
            ->with('success', 'Autobusi u përditësua me sukses!');
    }

    public function destroy(Bus $bus)
    {
        abort_if($bus->company_id !== auth('company')->id(), 403);

        $bus->delete();

        return redirect()->route('company.dashboard')
            ->with('tab', 'buses')
            ->with('success', 'Autobusi u fshi me sukses!');
    }
}