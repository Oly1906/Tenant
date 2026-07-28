<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('utility_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->date('month');

            // ភ្លើង — លេខរាប់ចាស់/ថ្មី
            $table->decimal('electricity_old',   10, 2)->default(0);
            $table->decimal('electricity_new',   10, 2)->default(0);
            $table->decimal('electricity_rate',  10, 2)->default(0.25); // តម្លៃ/kWh
            $table->decimal('electricity_usage', 10, 2)->default(0);    // new - old
            $table->decimal('electricity_cost',  10, 2)->default(0);    // usage × rate

            // ទឹក — ដូចគ្នា
            $table->decimal('water_old',   10, 2)->default(0);
            $table->decimal('water_new',   10, 2)->default(0);
            $table->decimal('water_rate',  10, 2)->default(0.50);       // តម្លៃ/m³
            $table->decimal('water_usage', 10, 2)->default(0);          // new - old
            $table->decimal('water_cost',  10, 2)->default(0);          // usage × rate

            $table->decimal('total_cost',  10, 2)->default(0);
            $table->unique(['tenant_id', 'month']); // ១ខែ ១ record ក្នុងម្នាក់
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('utility_records'); }
};