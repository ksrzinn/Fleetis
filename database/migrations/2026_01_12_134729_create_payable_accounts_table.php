<?php

use App\Enums\PayableAccountTypes;
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
        Schema::create('payable_accounts', function (Blueprint $table) {
            $table->uuid('id')
                ->primary()
                ->default(DB::raw('gen_random_uuid()'));

            $table->string('description');
            $table->decimal('total_value', 10, 2);
            $table->date('due_date');

            $table->integer('installments')->default(1);
            $table->boolean('is_recurring')->default(false);
            $table->string('category');

            $table->string('status')->default(PayableAccountTypes::OPEN->value);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payable_accounts');
    }
};
