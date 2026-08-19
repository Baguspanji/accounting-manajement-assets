<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Drop legacy tables from the former sharia cooperative savings
     * & loans accounting domain, replaced by the asset management module.
     */
    public function up(): void
    {
        Schema::dropIfExists('installments');
        Schema::dropIfExists('savings');
        Schema::dropIfExists('financings');
        Schema::dropIfExists('contracts');
        Schema::dropIfExists('members');
    }

    /**
     * Reverse the migrations by recreating the legacy tables.
     */
    public function down(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('member_number')->unique();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone');
            $table->text('address')->nullable();
            $table->date('joined_date');
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });

        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->json('default_journal')->nullable();
            $table->foreignId('debit_account_id')->nullable()->constrained('accounts')->nullOnDelete();
            $table->foreignId('credit_account_id')->nullable()->constrained('accounts')->nullOnDelete();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('savings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['pokok', 'wajib', 'sukarela']);
            $table->enum('transaction_type', ['setor', 'tarik']);
            $table->decimal('amount', 16, 2);
            $table->date('transaction_date');
            $table->text('notes')->nullable();
            $table->timestamps();
        });

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

        Schema::create('installments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('financing_id')->constrained()->cascadeOnDelete();
            $table->unsignedInteger('installment_number');
            $table->decimal('amount', 16, 2);
            $table->decimal('principal', 16, 2);
            $table->decimal('margin', 16, 2)->default(0);
            $table->date('due_date');
            $table->date('paid_date')->nullable();
            $table->enum('status', ['unpaid', 'paid'])->default('unpaid');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }
};
