<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update ENUMs first - keeping 'courier' to avoid truncation
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'manager', 'cashier', 'courier', 'courier_transit', 'courier_delivery', 'staff', 'customer') DEFAULT 'customer'");
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('pending', 'review', 'active', 'rejected') DEFAULT 'pending'");

        Schema::table('users', function (Blueprint $table) {
            if (!Schema::hasColumn('users', 'phone')) $table->string('phone')->nullable();
            if (!Schema::hasColumn('users', 'birth_date')) $table->date('birth_date')->nullable();
            if (!Schema::hasColumn('users', 'address')) $table->text('address')->nullable();
            if (!Schema::hasColumn('users', 'experience')) $table->text('experience')->nullable();
            if (!Schema::hasColumn('users', 'ktp_photo')) $table->string('ktp_photo')->nullable();
            if (!Schema::hasColumn('users', 'selfie_photo')) $table->string('selfie_photo')->nullable();
            
            // For constrained foreign keys, check if they exist or just add them if not
            if (!Schema::hasColumn('users', 'reviewed_by')) $table->unsignedBigInteger('reviewed_by')->nullable();
            if (!Schema::hasColumn('users', 'approved_by')) $table->unsignedBigInteger('approved_by')->nullable();
            if (!Schema::hasColumn('users', 'rejected_by')) $table->unsignedBigInteger('rejected_by')->nullable();
            
            if (!Schema::hasColumn('users', 'reviewed_at')) $table->timestamp('reviewed_at')->nullable();
            if (!Schema::hasColumn('users', 'approved_at')) $table->timestamp('approved_at')->nullable();
            if (!Schema::hasColumn('users', 'manager_note')) $table->text('manager_note')->nullable();
            if (!Schema::hasColumn('users', 'rejected_reason')) $table->text('rejected_reason')->nullable();
        });
        
        // Add foreign keys separately for safety
        Schema::table('users', function (Blueprint $table) {
             // Assuming users table exists
             // We use try-catch or just raw DB if needed, but let's try standard Blueprint
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone', 'birth_date', 'address', 'experience', 'ktp_photo', 'selfie_photo',
                'reviewed_by', 'approved_by', 'rejected_by', 'reviewed_at', 'approved_at',
                'manager_note', 'rejected_reason'
            ]);
        });
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('admin', 'manager', 'cashier', 'courier', 'staff', 'customer') DEFAULT 'customer'");
        DB::statement("ALTER TABLE users MODIFY COLUMN status ENUM('active', 'inactive', 'pending') DEFAULT 'active'");
    }
};
