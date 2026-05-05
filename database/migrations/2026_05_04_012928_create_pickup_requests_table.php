<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('pickup_requests', function (Blueprint $table) {
            $table->id();

            // Data pelanggan
            $table->string('pickup_code')->unique(); // PKP-20260501-XXXX
            $table->string('sender_name');
            $table->string('sender_phone');
            $table->text('sender_address');
            $table->string('sender_city');
            $table->decimal('sender_lat', 10, 8)->nullable();
            $table->decimal('sender_lng', 11, 8)->nullable();

            // Detail paket
            $table->decimal('estimated_weight', 8, 2);
            $table->string('goods_type');
            $table->text('goods_description')->nullable();
            $table->string('receiver_name');
            $table->string('receiver_phone');
            $table->text('receiver_address');
            $table->string('receiver_city');

            // Jadwal
            $table->date('pickup_date');
            $table->enum('pickup_time', [
                '08:00-10:00',
                '10:00-12:00',
                '13:00-15:00',
                '15:00-17:00'
            ]);

            // Relasi
            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('customer_id')
                  ->nullable()->constrained('users');
            $table->foreignId('courier_id')
                  ->nullable()->constrained('users');
            $table->foreignId('assigned_by')
                  ->nullable()->constrained('users');
            $table->foreignId('processed_by')
                  ->nullable()->constrained('users');

            // Status
            $table->enum('status', [
                'pending',           // baru masuk
                'assigned_pickup',   // sudah di-assign ke kurir
                'on_the_way',        // kurir dalam perjalanan
                'picked_up',         // paket sudah diambil
                'arrived_at_branch', // sampai di cabang
                'processed',         // kasir sudah proses
                'cancelled',         // dibatalkan
            ])->default('pending');

            // Data setelah pickup
            $table->decimal('actual_weight', 8, 2)->nullable();
            $table->string('pickup_photo')->nullable();
            $table->text('pickup_note')->nullable();
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamp('arrived_at')->nullable();

            // Jika dibatalkan
            $table->text('cancel_reason')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pickup_requests');
    }
};
