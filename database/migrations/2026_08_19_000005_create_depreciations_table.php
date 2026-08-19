<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('depreciations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
            $table->string('period', 7);
            $table->unsignedTinyInteger('year');
            $table->unsignedTinyInteger('month');
            $table->decimal('expense_amount', 16, 2);
            $table->decimal('accumulated_after', 16, 2)->default(0);
            $table->decimal('book_value_after', 16, 2)->default(0);
            $table->enum('status', ['pending', 'posted'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['asset_id', 'period']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('depreciations');
    }
};
