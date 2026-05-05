<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('origin_location_id')->constrained('locations')->onDelete('cascade');
            $table->foreignId('destination_location_id')->constrained('locations')->onDelete('cascade');
            $table->decimal('price_per_kg', 12, 2);
            $table->integer('estimated_days');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rates');
    }
};
