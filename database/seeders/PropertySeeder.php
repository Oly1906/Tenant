<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Property;

class PropertySeeder extends Seeder
{
    public function run(): void
    {
        Property::create([
            'name'    => 'Sunrise Apartments',
            'address' => '123 Main Street',
            'city'    => 'Phnom Penh',
        ]);
    }
}