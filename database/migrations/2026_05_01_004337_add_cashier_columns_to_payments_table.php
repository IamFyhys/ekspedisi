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
        Schema::table('payments', function (Blueprint $table) {
            $table->foreignId('received_by')->nullable()->constrained('users');
            $table->foreignId('courier_id')->nullable()->constrained('users');
            $table->timestamp('paid_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['received_by']);
            $table->dropForeign(['courier_id']);
            $table->dropColumn(['received_by', 'courier_id', 'paid_at']);
        });
    }
};
