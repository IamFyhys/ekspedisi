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
        Schema::table('shifts', function (Blueprint $table) {
            $table->decimal('physical_cash', 12, 2)->nullable()->after('total_revenue');
            $table->decimal('difference', 12, 2)->nullable()->after('physical_cash');
            $table->foreignId('approved_by')->nullable()->after('status')->constrained('users');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shifts', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropColumn(['physical_cash', 'difference', 'approved_by', 'approved_at']);
        });
    }
};
