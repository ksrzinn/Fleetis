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
        Schema::create('freights', function (Blueprint $table) {
            $table->uuid('id')
                ->primary()
                ->default(DB::raw('gen_random_uuid()'));

            $table->uuid('vehicle_id')
                ->constrained('vehicles')
                ->onDelete('cascade');

            $table->uuid('trailer_id')
                ->nullable()
                ->constrained('vehicles')
                ->onDelete('cascade');


            $table->uuid('driver_id')
                ->constrained('drivers')
                ->onDelete('cascade');

            $table->uuid('region_id')
                ->constrained('regions')
                ->onDelete('cascade');

            $table->string('freight_type');
            $table->string('status');

            $table->uuid('freight_fixed_price_id')
                ->nullable()
                ->constrained('freight_fixed_prices')
                ->onDelete('set null');

            $table->date('date');

            $table->integer('km_start');
            $table->integer('km_end')->nullable();

            // SNAPSHOTS 🔥
            $table->decimal('fixed_value_snapshot', 10, 2)->nullable();
            $table->decimal('km_rate_snapshot', 10, 2)->nullable();
            $table->decimal('total_value', 10, 2)->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freights');
    }
};
