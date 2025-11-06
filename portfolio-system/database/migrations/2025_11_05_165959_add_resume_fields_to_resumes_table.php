<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            if (!Schema::hasColumn('resumes', 'title')) {
                $table->string('title')->nullable();
            }
            if (!Schema::hasColumn('resumes', 'address')) {
                $table->string('address')->nullable();
            }
            if (!Schema::hasColumn('resumes', 'phone')) {
                $table->string('phone')->nullable();
            }
            if (!Schema::hasColumn('resumes', 'profile_summary')) {
                $table->text('profile_summary')->nullable();
            }
            if (!Schema::hasColumn('resumes', 'github_link')) {
                $table->string('github_link')->nullable();
            }
            if (!Schema::hasColumn('resumes', 'linkedin_link')) {
                $table->string('linkedin_link')->nullable();
            }
            if (!Schema::hasColumn('resumes', 'skills_list')) {
                $table->json('skills_list')->nullable();
            }
            if (!Schema::hasColumn('resumes', 'education')) {
                $table->json('education')->nullable();
            }
            if (!Schema::hasColumn('resumes', 'works')) {
                $table->json('works')->nullable();
            }
            if (!Schema::hasColumn('resumes', 'organizations')) {
                $table->json('organizations')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('resumes', function (Blueprint $table) {
            $columns = ['title','address','phone','profile_summary','github_link','linkedin_link','skills_list','education','works','organizations'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('resumes', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
