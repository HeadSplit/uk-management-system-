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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('apartment_id');
            $table->foreign('apartment_id')
                ->references('id')
                ->on('apartments')
                ->onDelete('cascade');

            $table->decimal('total_amount', 10, 2);
            $table->date('period');
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
