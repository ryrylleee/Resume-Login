<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'name',
        'title',
        'address',
        'email',
        'phone',
        'github_link',
        'linkedin_link',
        'profile_summary',
        'profile_picture_path', // <-- Add this
        'skills_list',          // <-- Add this
        'education',            // <-- Add this
        'works',                // <-- Add this
        'organizations',        // <-- Add this
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'skills_list' => 'array',     // <-- Add this
        'education' => 'array',       // <-- Add this
        'works' => 'array',           // <-- Add this
        'organizations' => 'array',   // <-- Add this
    ];

    /**
     * Get the user that owns the resume.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}