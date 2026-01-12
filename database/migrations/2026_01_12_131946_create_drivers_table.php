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
        Schema::create('drivers', function (Blueprint $table) {
                $table->uuid('id')
                    ->primary()
                    ->default(DB::raw('gen_random_uuid()'));
                $table->string('name');
                $table->string('phone')->nullable();
                $table->string('cpf')->unique();
                $table->string('cnh');
                $table->string('cnh_type');
                $table->decimal('salary', 10, 2)->nullable();
                $table->string('bonus_type')->nullable();
                $table->decimal('bonus_value', 10, 2)->nullable();
                $table->timestamps();
                $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drivers');
    }
};
