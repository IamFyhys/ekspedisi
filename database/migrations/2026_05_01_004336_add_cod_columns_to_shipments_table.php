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
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('cod_received_at')->nullable();
            $table->foreignId('cod_received_by')->nullable()->constrained('users');
            $table->foreignId('cod_courier_id')->nullable()->constrained('users');
            $table->string('cod_method')->nullable();
            $table->text('cod_note')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropForeign(['cod_received_by']);
            $table->dropForeign(['cod_courier_id']);
            $table->dropColumn([
                'paid_at',
                'cod_received_at',
                'cod_received_by',
                'cod_courier_id',
                'cod_method',
                'cod_note',
            ]);
        });
    }
};
