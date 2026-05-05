<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->timestamp('delivered_at')->nullable();
            if (!Schema::hasColumn('shipments', 'received_by')) {
                $table->string('received_by')->nullable();
            }
            $table->string('receiver_relation')->nullable();
            $table->text('delivery_note')->nullable();
            $table->string('proof_photo')->nullable();
            $table->text('digital_signature')->nullable(); // Store as base64 or path
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn(['delivered_at', 'received_by', 'receiver_relation', 'delivery_note', 'proof_photo', 'digital_signature']);
        });
    }
};
