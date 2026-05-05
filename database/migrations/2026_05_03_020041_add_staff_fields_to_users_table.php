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
        Schema::table('users', function (Blueprint $table) {
            // Alamat bertingkat
            $table->string('province_id')->nullable()->after('address');
            $table->string('province_name')->nullable()->after('province_id');
            $table->string('regency_id')->nullable()->after('province_name');
            $table->string('regency_name')->nullable()->after('regency_id');
            $table->string('district_id')->nullable()->after('regency_name');
            $table->string('district_name')->nullable()->after('district_id');
            $table->text('address_detail')->nullable()->after('district_name');

            // Data kendaraan kurir
            $table->string('sim_type')->nullable()->after('role');
            $table->string('sim_photo')->nullable()->after('sim_type');
            $table->string('vehicle_type')->nullable()->after('sim_photo');
            $table->string('vehicle_plate')->nullable()->after('vehicle_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'province_id', 'province_name', 'regency_id', 'regency_name', 
                'district_id', 'district_name', 'address_detail',
                'sim_type', 'sim_photo', 'vehicle_type', 'vehicle_plate'
            ]);
        });
    }
};
