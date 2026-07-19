<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = ['title', 'body', 'expires_at', 'created_by'];
    protected $casts    = ['expires_at' => 'date'];

    public function creator() { return $this->belongsTo(User::class, 'created_by'); }
}