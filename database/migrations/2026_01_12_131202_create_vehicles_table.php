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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('plate')->unique();
            $table->string('model')->nullable();
            $table->year('year')->nullable();
            $table->integer('current_km')->default(0);

            $table->foreignUuid('region_id')
                ->constrained('regions')
                ->onDelete('cascade');

            $table->foreignUuid('vehicle_type_id')
                ->constrained('vehicle_types')
                ->onDelete('cascade');

            $table->string('status')->default('active');
            $table->integer('oil_change_km')->nullable();

            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
