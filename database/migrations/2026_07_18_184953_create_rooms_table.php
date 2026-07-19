<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->constrained()->cascadeOnDelete();
            $table->string('number');
            $table->string('type')->default('Standard'); // Standard, Deluxe, Suite
            $table->string('floor')->nullable();
            $table->decimal('size', 8, 2)->nullable(); // m²
            $table->decimal('price', 10, 2);
            $table->enum('status', ['available', 'occupied'])->default('available');
            $table->text('amenities')->nullable(); // JSON string
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('rooms'); }
};