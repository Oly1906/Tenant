<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UtilityRecord extends Model
{
    protected $fillable = [
        'tenant_id', 'month',
        'electricity_kwh', 'electricity_cost',
        'water_m3', 'water_cost', 'total_cost'
    ];
    protected $casts = ['month' => 'date'];

    public function tenant() { return $this->belongsTo(Tenant::class); }
}