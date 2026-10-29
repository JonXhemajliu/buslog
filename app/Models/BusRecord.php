<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BusRecord extends Model
{
    public const TYPE_SERVICE = 'service';
    public const TYPE_DEFECT = 'defect';

    public const SEVERITIES = ['low', 'medium', 'high', 'critical'];
    public const STATUSES = ['open', 'in_progress', 'resolved'];

    protected $fillable = [
        'bus_id',
        'type',
        'title',
        'description',
        'record_date',
        'odometer_km',
        'cost',
        'workshop',
        'severity',
        'status',
        'next_service_date',
        'resolved_at',
    ];

    protected $casts = [
        'record_date' => 'date',
        'next_service_date' => 'date',
        'resolved_at' => 'datetime',
        'cost' => 'decimal:2',
    ];

    public function bus(): BelongsTo
    {
        return $this->belongsTo(Bus::class);
    }
}