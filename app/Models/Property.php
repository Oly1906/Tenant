<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    protected $fillable = ['name', 'address', 'city', 'description'];

    public function rooms() { return $this->hasMany(Room::class); }
}