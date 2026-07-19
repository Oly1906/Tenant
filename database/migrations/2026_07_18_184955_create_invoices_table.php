<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number')->unique();
            $table->foreignId('tenant_id')->constrained()->cascadeOnDelete();
            $table->decimal('rent_amount', 10, 2);
            $table->decimal('utility_amount', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->date('month'); // first day of month e.g. 2024-07-01
            $table->date('due_date')->nullable();
            $table->date('paid_date')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('invoices'); }
};