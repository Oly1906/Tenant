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
            $table->decimal('electricity_kwh', 10, 2)->default(0);
            $table->decimal('electricity_cost', 10, 2)->default(0);
            $table->decimal('water_m3', 10, 2)->default(0);
            $table->decimal('water_cost', 10, 2)->default(0);
            $table->decimal('total_cost', 10, 2)->default(0);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('utility_records'); }
};