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
            // Transit Columns
            $table->timestamp('departed_at')->nullable();
            $table->timestamp('arrived_at')->nullable();
            if (!Schema::hasColumn('shipments', 'received_by')) {
                $table->foreignId('received_by')->nullable()->constrained('users');
            }
            
            // Delivery Columns
            $table->string('failed_reason')->nullable();
            $table->text('failed_note')->nullable();
            $table->string('failed_photo')->nullable();
            $table->timestamp('failed_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropForeign(['received_by']);
            $table->dropColumn(['departed_at', 'arrived_at', 'received_by', 'failed_reason', 'failed_note', 'failed_photo', 'failed_at']);
        });
    }
};
