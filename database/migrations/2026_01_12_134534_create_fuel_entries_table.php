<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('fuel_entries', function (Blueprint $table) {
            $table->uuid('id')
                ->primary()
                ->default(DB::raw('gen_random_uuid()'));
            $table->uuid('vehicle_id')
                ->constrained('vehicles')
                ->onDelete('cascade');
            $table->uuid('driver_id')
                ->constrained('drivers')
                ->onDelete('cascade');
            $table->uuid('region_id')
                ->constrained('regions')
                ->onDelete('cascade');

            $table->decimal('liters', 10, 2);
            $table->decimal('total_value', 10, 2);
            $table->string('gas_station')->nullable();

            $table->date('date');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuel_entries');
    }
};
