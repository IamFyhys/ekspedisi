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
        Schema::table('cash_drawers', function (Blueprint $table) {
            $table->decimal('starting_balance', 18, 2)->change();
            $table->decimal('current_balance', 18, 2)->change();
            $table->decimal('closing_balance', 18, 2)->nullable()->change();
        });

        Schema::table('shipments', function (Blueprint $table) {
            $table->decimal('total_price', 18, 2)->change();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('amount', 18, 2)->change();
        });

        Schema::table('rates', function (Blueprint $table) {
            $table->decimal('price_per_kg', 18, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cash_drawers', function (Blueprint $table) {
            $table->decimal('starting_balance', 12, 2)->change();
            $table->decimal('current_balance', 12, 2)->change();
            $table->decimal('closing_balance', 12, 2)->nullable()->change();
        });

        Schema::table('shipments', function (Blueprint $table) {
            $table->decimal('total_price', 12, 2)->change();
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->decimal('amount', 12, 2)->change();
        });

        Schema::table('rates', function (Blueprint $table) {
            $table->decimal('price_per_kg', 12, 2)->change();
        });
    }
};
