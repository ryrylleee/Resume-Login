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
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('github_link')->nullable();
            $table->string('linkedin_link')->nullable();
            $table->text('profile_summary')->nullable();
            $table->json('skills_list')->nullable();  // array of skill => level
            $table->json('education')->nullable();    // array of degrees/schools
            $table->json('works')->nullable();        // array of projects
            $table->json('organizations')->nullable();// array of orgs/roles
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};
