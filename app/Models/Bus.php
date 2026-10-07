<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    protected $fillable = ['plate', 'model', 'capacity', 'year', 'status', 'company_id'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}