<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\Company;
use Illuminate\Http\Request;

class BusController extends Controller
{
    public function index()
    {
        $company = auth('company')->user();
        $buses = Bus::where('company_id', $company->id)->get();
return view('pages.buses', compact('buses'));    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate' => 'required|unique:buses',
            'model' => 'required',
            'capacity' => 'required|integer|min:1',
            'year' => 'required|integer|min:1900',
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        $validated['company_id'] = auth('company')->user()->id;
        Bus::create($validated);

        return redirect()->route('buses.index')->with('success', 'Autobusi u shtua me sukses!');
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
    return redirect()->route('buses.index')->with('success', 'Autobusi u përditësua me sukses!');
}

public function destroy(Bus $bus)
{
    abort_if($bus->company_id !== auth('company')->id(), 403);

    $bus->delete();
    return redirect()->route('buses.index')->with('success', 'Autobusi u fshi me sukses!');
}}