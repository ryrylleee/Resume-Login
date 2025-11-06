<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Resume;
// You may also need to use the User model
use App\Models\User; 

class ResumeController extends Controller
{

    public function dashboard(Request $request)
    {
        // Get the authenticated user
        $user = $request->user();

        // Use your helper to get or create the resume with default data
        $resume = $this->findOrCreateResume($user);

        // Return the DASHBOARD view and pass the resume data to it
        return view('dashboard', compact('resume'));
    }
    /**
     * Show the form for editing the user's resume.
     */
    public function edit(Request $request)
    {
        $user = $request->user();
        $resume = $this->findOrCreateResume($user);
        
        // This assumes your view is at: resources/views/resume/edit.blade.php
        return view('resume.edit', compact('resume'));
    }

    /**
     * Display the specified public resume.
     *
     * @param  int  $id  (This is the User ID from the URL)
     */
    public function show($id)
    {
        // Find the resume by the user_id
        $resume = Resume::where('user_id', $id)->firstOrFail();

        // This assumes your view is at: resources/views/public/resume.blade.php
        return view('resume.public', compact('resume'));
    }

    /**
     * Update the authenticated user's resume.
     */
    public function update(Request $request)
    {
        // 1. Get or create the resume using your helper
        $resume = $this->findOrCreateResume($request->user());

        // 2. Validate all incoming data
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'title' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'github_link' => 'nullable|url|max:255',
            'linkedin_link' => 'nullable|url|max:255',
            'profile_summary' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'skills_list' => 'nullable|json',
            'education' => 'nullable|json',
            'works' => 'nullable|json',
            'organizations' => 'nullable|json',
        ]);

        $jsonFields = ['skills_list', 'education', 'works', 'organizations'];

        foreach ($jsonFields as $field) {
            if (isset($validatedData[$field])) {
                $validatedData[$field] = json_decode($validatedData[$field], true);
            }
        }
        // 3. Handle the profile picture upload
        if ($request->hasFile('profile_picture')) {
            
            if ($resume->profile_picture_path) {
                Storage::disk('public')->delete($resume->profile_picture_path);
            }
            
            $path = $request->file('profile_picture')->store('profile_pics', 'public');
            $validatedData['profile_picture_path'] = $path;
        }

        // 4. Update the resume model
        $resume->update($validatedData);

        // 5. Redirect back to the edit page with a success message
        return redirect()->route('resume.edit')->with('status', 'Resume updated successfully!');
    
    }

    /**
     * A private helper function to find or create the resume
     * with all your default data.
     */
    private function findOrCreateResume($user)
    {
        return Resume::firstOrCreate(
            ['user_id' => $user->id],
            [ 
                'name' => 'KARYLLE L. DE LOS REYES',
                'email' => 'delosreyeskarylle@gmail.com',
                'title' => 'Aspiring Data Analyst',
                'address' => 'San Piro, Balayan, Batangas',
                'phone' => '+63 905 582 0236',
                'profile_summary' => 'Detail-oriented and analytical BS in Computer Science graduate...',
                'github_link' => 'https://github.com/ryrylleee',
                'linkedin_link' => 'https://www.linkedin.com/in/karylle-de-los-reyes-5a0844375/',
                'skills_list' => [
                    ['name' => 'C++', 'level' => '80'],
                    ['name' => 'Python', 'level' => '50'],
                    ['name' => 'Java', 'level' => '70'],
                    ['name' => 'HTML & CSS', 'level' => '80'],
                    ['name' => 'SQL', 'level' => '75'],
                    ['name' => 'PHP', 'level' => '25'],
                ],
                'education' => [
                    [
                        'degree' => 'Bachelor of Science in Computer Science', 
                        'school' => 'Batangas State University, The National Engineering University, Pablo Borbon Campus',
                        'start_date' => '2021-08', 
                        'end_date' => ''
                    ],
                    [
                        'degree' => 'Science, Technology, Engineering, and Mathematics (STEM) Strand', 
                        'school' => 'Balayan Senior High School',
                        'start_date'=> '2021-07', 
                        'end_date' => '2023-07'
                    ]
                ],
                'works' => [
                    [
                        'title' => 'Bin There, Done That: Smarter Waste Solutions', 
                        'description' => 'This project applied Java programming to develop an intelligent waste segregation system, enhancing practical skills in software development and problem-solving.', 
                        'link' => 'https://github.com/ryrylleee/Bin-There-Done-That-Smarter-Waste-Solutions'
                    ]
                ],
                'organizations' => [
                    [
                        'name' => 'Junior Philippine Computer Society (JPCS) - BatStateU Pablo Borbon', 
                        'role' => 'Assistant Secretary', 
                        'start_date' => '2024-08', 
                        'end_date' => '2025-05'
                    ],
                    [
                        'name' => 'Junior Philippine Computer Society (JPCS) - BatStateU Pablo Borbon', 
                        'role' => 'Director for External Affairs', 
                        'start_date' => '2025-08', 
                        'end_date' => ''
                    ],
                    [
                        'name' => 'College of Informatics and Computing Sciences - Student Council (CICS-SC) - BatStateU Pablo Borbon', 
                        'role' => 'Committee Head on Physical Branding and Production', 
                        'start_date' => '2025-08', 
                        'end_date' => ''
                    ],
                    [
                        'name' => 'Association of Committed Computer Science Students (ACESS) - BatStateU Pablo Borbon', 
                        'role' => 'Auditor', 
                        'start_date' => '2025-08', 
                        'end_date' => ''
                    ]
                ],
            ]
        );
    }
}