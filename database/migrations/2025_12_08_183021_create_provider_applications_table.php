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
        Schema::create('provider_applications', function (Blueprint $table) {
            $table->id();
            $table->string('rfc', 30)->index();
            $table->string('company_name');
            $table->string('street');
            $table->string('number');
            $table->string('neighborhood');
            $table->string('municipality');
            $table->string('state');
            $table->string('country');
            $table->string('cp')->nullable();
            $table->string('web_company')->nullable();

            // Datos bancarios
            $table->string('bank', 50)->nullable();
            $table->string('bank_account', 30)->nullable();
            $table->string('bank_account_number', 30);

            // Aprobación
            $table->string('approval_chain', 20)->default('normal');
            $table->string('status', 50)->default('pending'); // pending, approved, rejected
            $table->unsignedBigInteger('user_request_id')->nullable()->index();
            $table->unsignedBigInteger('user_approve_id')->nullable()->index();

            // Documentos
            $table->string('bank_data_file_path')->nullable();
            $table->string('tax_certificate_file_path')->nullable();

            // Notas de aprobación/rechazo
            $table->text('approval_notes')->nullable();
            $table->text('rejection_reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('provider_applications');
    }
};
