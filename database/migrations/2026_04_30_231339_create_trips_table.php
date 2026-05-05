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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->foreignId('courier_id')->constrained('users');
            $table->string('origin_branch_id');
            $table->string('destination_branch_id');
            $table->integer('total_packages')->default(0);
            $table->integer('total_received')->default(0);
            $table->timestamp('departed_at')->nullable();
            $table->timestamp('arrived_at')->nullable();
            $table->enum('status', ['on_the_way', 'completed', 'cancelled'])->default('on_the_way');
            $table->text('missing_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
