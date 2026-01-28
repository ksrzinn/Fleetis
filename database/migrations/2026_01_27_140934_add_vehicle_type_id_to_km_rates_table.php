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
        Schema::table('km_rates', function (Blueprint $table) {
            $table->uuid('vehicle_type_id')
                ->constrained('vehicle_types')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('km_rates', function (Blueprint $table) {
            $table->dropColumn('vehicle_type_id');
        });
    }
};
