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

// app/Models/Utility.php
    class Utility extends Model
    {
        protected $guarded = [];

        public function tenant() { return $this->belongsTo(Tenant::class); }

        // ភ្លើងប្រើប្រាស់ = ថ្មី - ចាស់
        public function getElectricityUsageAttribute()
        {
            return $this->electricity_new - $this->electricity_old;
        }

        public function getElectricityCostAttribute()
        {
            return $this->electricity_usage * $this->electricity_rate;
        }

        // ទឹកប្រើប្រាស់ = ថ្មី - ចាស់ (ដូចគ្នា)
        public function getWaterUsageAttribute()
        {
            return $this->water_new - $this->water_old;
        }

        public function getWaterCostAttribute()
        {
            return $this->water_usage * $this->water_rate;
        }

        public function getTotalCostAttribute()
        {
            return $this->electricity_cost + $this->water_cost;
        }
    }