<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asset_disposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')->constrained()->cascadeOnDelete();
            $table->date('disposal_date');
            $table->enum('disposal_type', ['sale', 'write_off', 'transfer']);
            $table->decimal('sale_price', 16, 2)->default(0);
            $table->decimal('accumulated_depreciation', 16, 2)->default(0);
            $table->decimal('book_value', 16, 2)->default(0);
            $table->decimal('gain_loss', 16, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asset_disposals');
    }
};
