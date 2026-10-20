<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;

class BusController extends Controller
{
    private function companyId()
    {
        return auth('company')->check()
            ? auth('company')->id()
            : auth('employee')->user()->company_id;
    }

    private function redirectAfter($message)
    {
        if (auth('company')->check()) {
            return redirect()->route('company.dashboard')
                ->with('tab', 'buses')
                ->with('success', $message);
        }

        return redirect()->route('dashboard')->with('success', $message);
    }

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

        $validated['company_id'] = $this->companyId();
        Bus::create($validated);

        return $this->redirectAfter('Autobusi u shtua me sukses!');
    }

    public function update(Request $request, Bus $bus)
    {
        abort_if($bus->company_id !== $this->companyId(), 403);

        $validated = $request->validate([
            'plate' => 'required|unique:buses,plate,' . $bus->id,
            'model' => 'required',
            'capacity' => 'required|integer|min:1',
            'year' => 'required|integer|min:1900',
            'status' => 'required|in:active,inactive,maintenance',
        ]);

        $bus->update($validated);

        return $this->redirectAfter('Autobusi u përditësua me sukses!');
    }

    public function destroy(Bus $bus)
    {
        abort_if($bus->company_id !== $this->companyId(), 403);

        $bus->delete();

        return $this->redirectAfter('Autobusi u fshi me sukses!');
    }
}