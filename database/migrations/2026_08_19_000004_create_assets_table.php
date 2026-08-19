<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('asset_number', 50)->unique();
            $table->string('name');
            $table->foreignId('category_id')->nullable()->constrained('asset_categories')->nullOnDelete();
            $table->string('serial_number')->nullable();
            $table->string('location')->nullable();
            $table->string('responsible_person')->nullable();
            $table->string('supplier')->nullable();
            $table->date('acquisition_date');
            $table->decimal('acquisition_cost', 16, 2);
            $table->decimal('residual_value', 16, 2)->default(0);
            $table->unsignedInteger('useful_life');
            $table->foreignId('depreciation_method_id')->constrained('depreciation_methods');
            $table->unsignedBigInteger('production_capacity')->nullable();
            $table->enum('status', ['active', 'disposed', 'written_off', 'maintenance'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
