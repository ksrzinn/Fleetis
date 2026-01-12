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
        Schema::create('freight_fixed_prices', function (Blueprint $table) {
            $table->uuid('id')
                ->primary()
                ->default(DB::raw('gen_random_uuid()'));

            $table->uuid('region_id')
                ->constrained('regions')
                ->onDelete('cascade');

            $table->string('description');
            $table->decimal('fixed_value', 10, 2);
            $table->integer('average_km')->nullable();
            $table->date('valid_from');
            $table->date('valid_until')->nullable();
            $table->boolean('active')->default(true);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freight_fixed_prices');
    }
};
