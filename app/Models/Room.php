<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['property_id', 'number', 'type', 'floor', 'size', 'price', 'status', 'amenities'];

    public function property() { return $this->belongsTo(Property::class); }
    public function tenant()   { return $this->hasOne(Tenant::class)->where('status', 'active'); }
    public function tenants()  { return $this->hasMany(Tenant::class); }

    public function isAvailable() { return $this->status === 'available'; }
}