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
            if (!Schema::hasColumn('shipments', 'departed_at')) {
                $table->timestamp('departed_at')->nullable();
            }
            if (!Schema::hasColumn('shipments', 'arrived_at')) {
                $table->timestamp('arrived_at')->nullable();
            }
            if (!Schema::hasColumn('shipments', 'received_by')) {
                $table->foreignId('received_by')->nullable()->constrained('users');
            }
            if (!Schema::hasColumn('shipments', 'failed_reason')) {
                $table->string('failed_reason')->nullable();
            }
            if (!Schema::hasColumn('shipments', 'failed_note')) {
                $table->text('failed_note')->nullable();
            }
            if (!Schema::hasColumn('shipments', 'failed_photo')) {
                $table->string('failed_photo')->nullable();
            }
            if (!Schema::hasColumn('shipments', 'failed_at')) {
                $table->timestamp('failed_at')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shipments', function (Blueprint $table) {
            // No easy way to rollback conditional columns safely without checking again
        });
    }
};
