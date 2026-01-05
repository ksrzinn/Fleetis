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

            $table->foreignUuid('driver_id')
                ->constrained('drivers')
                ->onDelete('cascade');

            $table->foreignUuid('vehicle_id')
                ->constrained('vehicles')
                ->onDelete('cascade');

            $table->foreignUuid('region_id')
                ->constrained('regions')
                ->onDelete('cascade');

            $table->foreignUuid('freight_fixed_price_table_id')
                ->nullable()
                ->constrained('freight_fixed_price_tables')
                ->onDelete('set null');

            $table->string('freight_type');

            $table->decimal('total_km', 10, 2)->nullable();
            $table->decimal('total_price', 10, 2)->nullable();

            $table->timestamp('closed_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index(['freight_type']);
            $table->index(['driver_id']);
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
