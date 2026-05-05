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
            $table->integer('length')->nullable()->after('weight');
            $table->integer('width')->nullable()->after('length');
            $table->integer('height')->nullable()->after('width');
            $table->decimal('volumetric_weight', 8, 2)->nullable()->after('height');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            $table->dropColumn(['length', 'width', 'height', 'volumetric_weight']);
        });
    }
};
