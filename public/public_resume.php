<?php
// public_resume.php (Public Page - No Authentication Required)
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'db_config.php';

$resume_id = $_GET['id'] ?? null;
$resumeData = null;
$error = '';

// Retrieve resume for public display (Route::get('/resume/{id}') spirit)
if (!is_numeric($resume_id) || $resume_id <= 0) {
    $error = "Invalid resume ID or ID is missing in the URL.";
} else {
    try {
        $database = new Database();
        $db = $database->connect();

        if ($db) {
            // ELOQUENT spirit: Fetch data using the ID
            $resumeData = fetchResumeData($db, $resume_id);
            if (!$resumeData) {
                // User::findOrFail($id) spirit
                $error = "Resume not found for ID: " . htmlspecialchars($resume_id);
            }
        } else {
            $error = "Could not connect to database to retrieve resume.";
        }

    } catch (Exception $e) {
        $error = "An unexpected server error occurred.";
    }
}

if ($resumeData) {
    // Assign variables for template (Blade spirit)
    extract($resumeData);
}

// Fallback data
$name = $name ?? "Resume Not Found";
$title = $title ?? "N/A";
$address = $address ?? "N/A";
$email = $email ?? "N/A";
$phone = $phone ?? "N/A";
$profile_summary = $profile_summary ?? "No profile summary available.";
$github_link = $github_link ?? "#";
$linkedin_link = $linkedin_link ?? "#";
$skills_list = $skills_list ?? [];
$education = $education ?? [];
$works = $works ?? [];
$organizations = $organizations ?? [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Public Resume: <?php echo htmlspecialchars($name); ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* Public view specific styling */
        .public-top-bar {
            justify-content: center;
            background: linear-gradient(90deg, #221c76 0%, #6a89cc 100%);
            padding: 18px 32px;
            margin-bottom: 24px;
        }
        .public-top-bar .welcome-msg {
            font-size: 24px;
            font-weight: bold;
            color: #fff;
        }
    </style>
</head>
<body>
    <div class="public-top-bar">
        <div class="welcome-msg"><?php echo htmlspecialchars($name); ?>'s Public Portfolio</div>
    </div>
    
    <?php if ($error): ?>
        <h2 style="text-align: center; color: #e74c3c; margin-top: 50px;"><?php echo htmlspecialchars($error); ?></h2>
    <?php else: ?>
    <div class="resume-layout">
        <!-- Left Column -->
        <div class="resume-left">
            <div class="profile-img-wrap">
                <img src="Profile.png" alt="Profile Picture" class="profile-pic">
            </div>
            <!-- BLADE spirit: <h1>{{ $user->name}}</h1> -->
            <h1 class="resume-name"><?php echo htmlspecialchars($name); ?></h1>
            <h3 class="resume-title"><?php echo htmlspecialchars($title); ?></h3>
            <div class="resume-contact">
                <p><?php echo htmlspecialchars($address); ?></p>
                <p><?php echo htmlspecialchars($email); ?></p>
                <p><?php echo htmlspecialchars($phone); ?></p>
            <div class="contact-links">
                <a href="<?php echo htmlspecialchars($github_link); ?>" target="_blank" class="contact-link">GitHub</a>
                <a href="<?php echo htmlspecialchars($linkedin_link); ?>" target="_blank" class="contact-link">LinkedIn</a>
            </div>
            </div>
            <div class="resume-skills">
                <h4>Skills</h4>
                <!-- BLADE spirit: <p>{{ $user->skill}}</p> -->
                <?php foreach ($skills_list as $skill): ?>
                <div class="skill-item">
                    <span><?php echo $skill['name']; ?></span>
                    <div class="skill-bar"><div class="skill-level" style="width:<?php echo $skill['level']; ?>"></div></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
        <!-- Right Column -->
        <div class="resume-right">
            <div class="main">
                <div class="about-section">
                    <h2 class="section-title">About Me</h2>
                    <div class="about-container">
                        <p><?php echo nl2br(htmlspecialchars($profile_summary)); ?></p>
                    </div>
                </div>
                <div class="projects-section">
                    <h2 class="section-title">Projects</h2>
                    <?php foreach ($works as $project): ?>
                        <div class="work-block">
                            <strong><?php echo htmlspecialchars($project['title']); ?></strong>
                            <ul class="details">
                                <?php foreach ($project['details'] as $detail): ?>
                                    <li><?php echo htmlspecialchars($detail); ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <a href="<?php echo htmlspecialchars($project['link']); ?>" target="_blank" class="project-link">
                                View Project
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="education-section">
                    <h2 class="section-title">Education</h2>
                    <?php foreach ($education as $edu): ?>
                        <div class="edu-block">
                            <strong><?php echo htmlspecialchars($edu['degree']); ?></strong>
                            <div><?php echo htmlspecialchars($edu['date']); ?></div>
                            <div><?php echo htmlspecialchars($edu['school']); ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="organizations-section">
                    <h2 class="section-title">Organizations</h2>
                    <?php foreach ($organizations as $orgName => $roles): ?>
                        <div class="org-block">
                            <strong><?php echo htmlspecialchars($orgName); ?></strong>
                            <ul class="details">
                                <?php foreach ($roles as $role): ?>
                                    <li><?php echo htmlspecialchars($role['role']); ?> — <em><?php echo htmlspecialchars($role['date']); ?></em></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</body>
</html>