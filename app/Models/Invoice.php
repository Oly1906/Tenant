<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $fillable = [
        'invoice_number', 'tenant_id', 'rent_amount',
        'utility_amount', 'total', 'status', 'month', 'due_date', 'paid_date'
    ];
    protected $casts = ['month' => 'date', 'due_date' => 'date', 'paid_date' => 'date'];

    public function tenant() { return $this->belongsTo(Tenant::class); }
}