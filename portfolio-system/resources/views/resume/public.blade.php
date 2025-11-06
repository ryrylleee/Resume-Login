<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{ $resume->name ?? 'Public Resume' }} - Portfolio and Resume">
    <title>Public Resume: {{ $resume->name ?? 'User' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap">
</head>
@php
    function formatResumeDate($isoDate) {
        if (empty($isoDate)) {
            return 'Present';
        }
        try {
            // Use PHP's built-in date formatting
            return \Carbon\Carbon::createFromFormat('Y-m', $isoDate)->format('F Y');
        } catch (\Exception $e) {
            // Fallback for bad data
            return $isoDate;
        }
    }
@endphp
<body>
    <div class="public-top-bar">
        <div class="welcome-msg">
            {{ $resume->name ?? 'User' }}'s Public Portfolio
        </div>
    </div>
    
    <div class="resume-layout">
        <div class="resume-left">
            <div class="profile-img-wrap">
                {{-- 
                  FIX: Changed to dynamically show the uploaded profile picture
                  or a placeholder if one doesn't exist.
                --}}
                @if(!empty($resume->profile_picture_path))
                    <img src="{{ asset('storage/' . $resume->profile_picture_path) }}" alt="Profile Picture" class="profile-pic">
                @else
                    <img src="https://placehold.co/140x140/6a89cc/FFF?text=Profile" alt="Profile Picture" class="profile-pic">
                @endif
            </div>

            <h1 class="resume-name">{{ $resume->name ?? 'Unnamed User' }}</h1>
            <h3 class="resume-title">{{ $resume->title ?? 'No Title Provided' }}</h3>

            <div class="resume-contact">
                <p><strong>Address:</strong><br>{{ $resume->address ?? 'No address provided' }}</p>
                <p><strong>Email:</strong><br>{{ $resume->email ?? 'No email provided' }}</p>
                <p><strong>Phone:</strong><br>{{ $resume->phone ?? 'No phone number provided' }}</p>

                <div class="contact-links">
                    @if(!empty($resume->github_link))
                        <a href="{{ $resume->github_link }}" target="_blank" class="contact-link">GitHub</a>
                    @endif
                    @if(!empty($resume->linkedin_link))
                        <a href="{{ $resume->linkedin_link }}" target="_blank" class="contact-link">LinkedIn</a>
                    @endif
                </div>
            </div>

            @if(!empty($resume->skills_list))
            <div class="resume-skills">
                <h4>Skills</h4>
                @foreach ($resume->skills_list as $skill)
                    <div class="skill-item">
                        <span>{{ $skill['name'] ?? 'Unnamed Skill' }}</span>
                        <div class="skill-bar-outer">
                            <div class="skill-level-inner" style="width:{{ $skill['level'] ?? '80' }}%"></div>
                        </div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>

        <div class="resume-right">
            <div class="main">
                <div class="about-section">
                    <h2 class="section-title">About Me</h2>
                    <div class="about-container">
                        <p>{!! nl2br(e($resume->profile_summary ?? 'No summary provided.')) !!}</p>
                    </div>
                </div>

                @if(!empty($resume->works))
                <div class="projects-section">
                    <h2 class="section-title">Work Experience / Projects</h2>
                    @foreach ($resume->works as $project)
                        <div class="work-block">
                            <strong>{{ $project['title'] ?? 'Untitled Project' }}</strong>
                            <p style="font-size: 0.9rem; margin-top: 5px;">{{ $project['description'] ?? '' }}</p>
                            
                            @if(!empty($project['link']))
                            <a href="{{ $project['link'] }}" target="_blank" class="project-link">
                                View Project
                            </a>
                            @endif
                        </div>
                    @endforeach
                </div>
                @endif

                @if(!empty($resume->education))
                <div class="education-section">
                    <h2 class="section-title">Education</h2>
                    @foreach ($resume->education as $edu)
                        <div class="edu-block">
                            <strong>{{ $edu['degree'] ?? 'Degree not specified' }}</strong>
                            <div>{{ $edu['school'] ?? 'School not specified' }}</div>
                        <div>{{ formatResumeDate($edu['start_date'] ?? null) }} - {{ formatResumeDate($edu['end_date'] ?? null) }}</div>                        </div>
                    @endforeach
                </div>
                @endif
                
                @if(!empty($resume->organizations))
                <div class="organizations-section">
                    <h2 class="section-title">Organizations</h2>
                    @foreach ($resume->organizations as $org)
                        <div class="org-block">
                            <strong>{{ $org['name'] ?? 'Organization Name' }}</strong>
                            <div>{{ $org['role'] ?? 'Role not specified' }}</div>
                        <div>{{ formatResumeDate($org['start_date'] ?? null) }} - {{ formatResumeDate($org['end_date'] ?? null) }}</div>                        </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>