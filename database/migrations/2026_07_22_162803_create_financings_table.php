<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financings', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('contract_id')->constrained('contracts');
            $table->decimal('amount', 16, 2);
            $table->decimal('margin', 16, 2)->default(0);
            $table->unsignedInteger('tenor');
            $table->date('transaction_date');
            $table->decimal('remaining', 16, 2)->default(0);
            $table->enum('status', ['active', 'paid_off', 'default'])->default('active');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('financings');
    }
};