<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use App\Models\BusRecord;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class BusRecordController extends Controller
{
    /** Historiku i një autobusi (JSON). */
    public function index(Bus $bus): JsonResponse
    {
        $this->authorizeBus($bus);

        $records = $bus->records()
            ->orderByDesc('record_date')
            ->orderByDesc('id')
            ->get()
            ->map(fn (BusRecord $r) => $this->format($r))
            ->values();

        return response()->json(['records' => $records]);
    }

    public function store(Request $request, Bus $bus): JsonResponse
    {
        $this->authorizeBus($bus);

        $record = $bus->records()->create($this->validated($request));

        return response()->json(['record' => $this->format($record)], 201);
    }

    public function update(Request $request, BusRecord $record): JsonResponse
    {
        $this->authorizeBus($record->bus);

        $record->update($this->validated($request, $record));

        return response()->json(['record' => $this->format($record->refresh())]);
    }

    /** Shënon defektin si të zgjidhur me një klikim. */
    public function resolve(BusRecord $record): JsonResponse
    {
        $this->authorizeBus($record->bus);
        abort_unless($record->type === BusRecord::TYPE_DEFECT, 422, 'Vetëm defektet mund të zgjidhen.');

        $record->update(['status' => 'resolved', 'resolved_at' => now()]);

        return response()->json(['record' => $this->format($record->refresh())]);
    }

    public function destroy(BusRecord $record): JsonResponse
    {
        $this->authorizeBus($record->bus);

        $record->delete();

        return response()->json(['ok' => true]);
    }

    private function validated(Request $request, ?BusRecord $existing = null): array
    {
        $data = $request->validate([
            'type' => ['required', Rule::in([BusRecord::TYPE_SERVICE, BusRecord::TYPE_DEFECT])],
            'title' => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:2000'],
            'record_date' => ['required', 'date', 'before_or_equal:today'],
            'odometer_km' => ['nullable', 'integer', 'min:0', 'max:5000000'],
            'cost' => ['nullable', 'numeric', 'min:0', 'max:99999999.99'],
            'workshop' => ['nullable', 'string', 'max:150'],
            'severity' => ['required_if:type,defect', 'nullable', Rule::in(BusRecord::SEVERITIES)],
            'status' => ['nullable', Rule::in(BusRecord::STATUSES)],
            'next_service_date' => ['nullable', 'date', 'after_or_equal:record_date'],
        ]);

        if ($data['type'] === BusRecord::TYPE_SERVICE) {
            $data['severity'] = null;
            $data['status'] = 'resolved';
        } else {
            $data['next_service_date'] = null;
            $data['status'] ??= 'open';
        }

        $data['resolved_at'] = $data['status'] === 'resolved'
            ? ($existing?->resolved_at ?? now())
            : null;

        return $data;
    }

    private function format(BusRecord $r): array
    {
        return [
            'id' => $r->id,
            'type' => $r->type,
            'title' => $r->title,
            'description' => $r->description,
            'record_date' => $r->record_date->toDateString(),
            'odometer_km' => $r->odometer_km,
            'cost' => $r->cost !== null ? (float) $r->cost : null,
            'workshop' => $r->workshop,
            'severity' => $r->severity,
            'status' => $r->status,
            'next_service_date' => $r->next_service_date?->toDateString(),
            'resolved_at' => $r->resolved_at?->toDateString(),
        ];
    }

    /**
     * Autobusi duhet t'i përkasë kompanisë së përdoruesit të kyçur
     * (kompani direkt, ose punonjës i asaj kompanie).
     */
    private function authorizeBus(Bus $bus): void
    {
        $companyId = Auth::guard('company')->check()
            ? Auth::guard('company')->id()
            : Auth::guard('employee')->user()?->company_id;

        abort_unless($companyId && (int) $bus->company_id === (int) $companyId, 403);
    }
}