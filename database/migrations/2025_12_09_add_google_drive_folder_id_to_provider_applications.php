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
        Schema::table('provider_applications', function (Blueprint $table) {
            $table->string('google_drive_folder_id')->nullable()->after('tax_certificate_file_path');
            $table->index('google_drive_folder_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('provider_applications', function (Blueprint $table) {
            $table->dropIndex('provider_applications_google_drive_folder_id_index');
            $table->dropColumn('google_drive_folder_id');
        });
    }
};
