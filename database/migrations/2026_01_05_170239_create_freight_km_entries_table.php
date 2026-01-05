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
        Schema::create('freight_km_entries', function (Blueprint $table) {
            $table->uuid('id')
                ->primary()
                ->default(DB::raw('gen_random_uuid()'));

            $table->foreignUuid('freight_id')
                ->constrained('freights')
                ->cascadeOnDelete();

            $table->decimal('km', 10, 2);
            $table->decimal('price_per_km', 10, 2);

            $table->timestamp('reported_at');

            $table->timestamps();

            $table->index(['freight_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freight_km_entries');
    }
};
