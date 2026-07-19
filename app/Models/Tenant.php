<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    protected $fillable = ['user_id', 'room_id', 'lease_start', 'lease_end', 'deposit', 'status'];
    protected $casts    = ['lease_start' => 'date', 'lease_end' => 'date'];

    public function user()           { return $this->belongsTo(User::class); }
    public function room()           { return $this->belongsTo(Room::class); }
    public function invoices()       { return $this->hasMany(Invoice::class); }
    public function utilityRecords() { return $this->hasMany(UtilityRecord::class); }

    public function currentInvoice() {
        return $this->invoices()->where('status', 'pending')->latest()->first();
    }
}