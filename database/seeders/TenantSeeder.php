<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{User, Tenant, Room, Invoice, UtilityRecord};
use Illuminate\Support\Facades\Hash;

class TenantSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name'     => 'Rith',
            'email'    => 'rith@gmail.com',
            'password' => Hash::make('1234567890'),
            'role'     => 'tenant',
            'phone'    => '+885 70798293',
        ]);

        $tenant = Tenant::create([
            'user_id'     => $user->id,
            'room_id'     => 1,
            'lease_start' => '2024-01-01',
            'lease_end'   => '2024-12-31',
            'deposit'     => 300,
        ]);

        // Sample invoices
        Invoice::create([
            'invoice_number' => 'INV-0001',
            'tenant_id'      => $tenant->id,
            'rent_amount'    => 150,
            'utility_amount' => 47,
            'total'          => 197,
            'status'         => 'paid',
            'month'          => '2024-06-01',
            'due_date'       => '2024-06-15',
            'paid_date'      => '2024-06-01',
        ]);

        Invoice::create([
            'invoice_number' => 'INV-0002',
            'tenant_id'      => $tenant->id,
            'rent_amount'    => 150,
            'utility_amount' => 35,
            'total'          => 185,
            'status'         => 'pending',
            'month'          => '2024-07-01',
            'due_date'       => '2024-07-15',
        ]);

        // Sample utility
        UtilityRecord::create([
            'tenant_id'        => $tenant->id,
            'month'            => '2024-06-01',
            'electricity_kwh'  => 120,
            'electricity_cost' => 35,
            'water_m3'         => 18,
            'water_cost'       => 12,
            'total_cost'       => 47,
        ]);
    }
}