<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('tracking_number')->unique();
            $table->string('sender_name');
            $table->string('sender_phone');
            $table->foreignId('origin_location_id')->constrained('locations');
            $table->foreignId('origin_subdistrict_id')->constrained('subdistricts');
            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->text('receiver_address');
            $table->foreignId('destination_location_id')->constrained('locations');
            $table->foreignId('destination_subdistrict_id')->constrained('subdistricts');
            $table->string('item_name');
            $table->integer('weight');
            $table->decimal('total_price', 12, 2);
            $table->string('payment_method');
            $table->string('status')->default('pending');
            $table->foreignId('branch_id')->constrained();
            $table->foreignId('cashier_id')->constrained('users');
            $table->foreignId('courier_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
