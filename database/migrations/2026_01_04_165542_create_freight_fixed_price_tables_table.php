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
        Schema::create('freight_fixed_price_tables', function (Blueprint $table) {
            $table->uuid('id')
        ->primary()
        ->default(DB::raw('gen_random_uuid()'));

        $table->foreignUuid('region_id')
            ->constrained('regions');

        $table->string('description');
        // Ex: "Sorocaba", "RJ", "Campinas 2"

        $table->decimal('fixed_value', 12, 2);
        $table->decimal('average_km', 10, 2)->nullable();

        $table->date('valid_from');
        $table->date('valid_until')->nullable();

        $table->timestamps();

        $table->index(['region_id', 'valid_from']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freight_fixed_price_tables');
    }
};
