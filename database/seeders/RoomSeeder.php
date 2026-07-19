<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [
            ['number'=>'A-101','type'=>'Deluxe',  'floor'=>'1st','size'=>25,'price'=>150,'status'=>'occupied'],
            ['number'=>'A-102','type'=>'Deluxe',  'floor'=>'1st','size'=>25,'price'=>150,'status'=>'available'],
            ['number'=>'B-201','type'=>'Standard','floor'=>'2nd','size'=>20,'price'=>120,'status'=>'available'],
            ['number'=>'C-301','type'=>'Suite',   'floor'=>'3rd','size'=>35,'price'=>200,'status'=>'available'],
        ];
        foreach ($rooms as $r) {
            Room::create(array_merge(['property_id' => 1], $r));
        }
    }
}