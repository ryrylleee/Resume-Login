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
        Schema::table('resumes', function (Blueprint $table) {
            // This adds the new column. 
            // We make it 'nullable' because the user isn't required to upload a picture.
            // 'after' places it nicely in the table, but is optional.
            $table->string('profile_picture_path')->nullable()->after('profile_summary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            // This lets you roll back the change if needed
            $table->dropColumn('profile_picture_path');
        });
    }
};