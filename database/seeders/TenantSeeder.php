<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\{User, Tenant, Invoice, UtilityRecord};
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
        ]);

        $tenant = Tenant::create([
            'user_id'     => $user->id,
            'room_id'     => 1,
            'lease_start' => '2026-01-01',
            'lease_end'   => '2026-12-31',
            'deposit'     => 300,
        ]);

        // Invoices
        Invoice::create([
            'invoice_number' => 'INV-0001',
            'tenant_id'      => $tenant->id,
            'rent_amount'    => 150,
            'utility_amount' => 47,
            'total'          => 197,
            'status'         => 'paid',
            'month'          => '2026-06-01',
            'due_date'       => '2026-06-15',
            'paid_date'      => '2026-06-01',
        ]);

        Invoice::create([
            'invoice_number' => 'INV-0002',
            'tenant_id'      => $tenant->id,
            'rent_amount'    => 150,
            'utility_amount' => 35,
            'total'          => 185,
            'status'         => 'pending',
            'month'          => '2026-07-01',
            'due_date'       => '2026-07-15',
            'paid_date'      => null,
        ]);

        // Utility — ប្រើ old/new/rate ថ្មី
        UtilityRecord::create([
            'tenant_id'          => $tenant->id,
            'month'              => '2026-06-27',
            'electricity_old'    => 100,
            'electricity_new'    => 220,
            'electricity_rate'   => 0.25,
            'electricity_usage'  => 120,
            'electricity_cost'   => 30.00,
            'water_old'          => 10,
            'water_new'          => 28,
            'water_rate'         => 0.50,
            'water_usage'        => 18,
            'water_cost'         => 9.00,
            'total_cost'         => 39.00,
        ]);
    }
}
