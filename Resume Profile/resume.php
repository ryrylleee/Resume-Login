<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}
$name = "KARYLLE L. DE LOS REYES";
$title = "Aspiring Data Analyst";
$address = "San Piro, Balayan, Batangas";
$email = "delosreyeskarylle@gmail.com";
$phone = "+63 905 582 0236";

$profileSummary = "Detail-oriented and analytical BS in Computer Science graduate with a solid foundation in SQL, Python, and data visualization. Experienced in handling academic projects that translate raw datasets into clear, actionable insights. Strong problem-solving skills, proficiency in statistical analysis, and a keen interest in leveraging data to drive business performance. Adept at collaborating in teams and eager to contribute to data-driven decision-making as an entry-level Data Analyst.";

$education = [
    [
        "degree" => "Bachelor of Science in Computer Science",
        "date" => "August 2021 - Present",
        "school" => "Batangas State University - The National Engineering University - Alangilan"
    ],
    [
        "degree" => "Science, Technology, Engineering, and Mathematics (STEM) Strand",
        "date"=> "July 2021 - July 2023",
        "school" => "Balayan Senior High School"
    ]
];
$works = [
    [
        "title" => "Bin There, Done That: Smarter Waste Solutions",
        "details" => [
            "This project applied Java programming to create an interactive waste management system. Object Oriented Programming (OOP) principles were utilized to design a modular and scalable application. This project is designed to educate users about proper waste disposal while promoting eco-friendly habits."
        ],
        "link" => "https://github.com/ryrylleee/Bin-There-Done-That-Smarter-Waste-Solutions"
    ]
];
$organizations = [
    "Junior Philippine Computer Society (JPCS) - BatStateU Alangilan Student Chapter" => [
        [
            "role" => "Assistant Secretary",
            "date" => "August 2024 - May 2025"
        ],
        [
            "role" => "Director for External Affairs",
            "date" => "August 2025 - Present"
        ]
    ],
    "College of Informatics and Computing Sciences - Student Council (CICS-SC)" => [
        [
            "role" => "Committee Head on Physical Branding and Production",
            "date" => "August 2025 - Present"
        ]
    ],
    "Association of Committed Computer Science Students (ACESS)" => [
        [
            "role" => "Auditor",
            "date" => "August 2025 - Present"
        ]
    ]
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Resume</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="top-bar">
        <div class="welcome-msg">Welcome, <?php echo htmlspecialchars($name); ?>!</div>
        <form action="logout.php" method="post" class="logout-form">
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
    <div class="resume-layout">
        <!-- Left Column -->
        <div class="resume-left">
            <div class="profile-img-wrap">
                <img src="Profile.png" alt="Profile Picture" class="profile-pic">
            </div>
            <h1 class="resume-name"><?php echo $name; ?></h1>
            <h3 class="resume-title"><?php echo $title; ?></h3>
            <div class="resume-contact">
                <p><?php echo $address; ?></p>
                <p><?php echo $email; ?></p>
                <p><?php echo $phone; ?></p>
            <div class="contact-links">
                <a href="https://github.com/ryrylleee" target="_blank" class="contact-link">GitHub</a>
                <a href="https://www.linkedin.com/in/karylle-de-los-reyes-5a0844375/" target="_blank" class="contact-link">LinkedIn</a>
            </div>
            </div>
            <div class="resume-skills">
                <h4>Skills</h4>
                <div class="skill-item">
                    <span>C++</span>
                    <div class="skill-bar"><div class="skill-level" style="width:80%"></div></div>
                </div>
                <div class="skill-item">
                    <span>Python</span>
                    <div class="skill-bar"><div class="skill-level" style="width:50%"></div></div>
                </div>
                <div class="skill-item">
                    <span>Java</span>
                    <div class="skill-bar"><div class="skill-level" style="width:70%"></div></div>
                </div>
                <div class="skill-item">
                    <span>HTML &amp; CSS</span>
                    <div class="skill-bar"><div class="skill-level" style="width:80%"></div></div>
                </div>
                <div class="skill-item">
                    <span>SQL</span>
                    <div class="skill-bar"><div class="skill-level" style="width:75%"></div></div>
                </div>
                <div class="skill-item">
                    <span>PHP</span>
                    <div class="skill-bar"><div class="skill-level" style="width:25%"></div></div>
                </div>
            </div>
        </div>
        <!-- Right Column -->
        <div class="resume-right">
            <div class="main">
                <div class="about-section">
                    <h2 class="section-title">About Me</h2>
                    <div class="about-container">
                        <p><?php echo $profileSummary; ?></p>
                    </div>
                </div>
                <div class="projects-section">
                    <h2 class="section-title">Projects</h2>
                    <?php foreach ($works as $project): ?>
                        <div class="work-block">
                            <strong><?php echo $project['title']; ?></strong>
                            <ul class="details">
                                <?php foreach ($project['details'] as $detail): ?>
                                    <li><?php echo $detail; ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <a href="<?php echo $project['link']; ?>" target="_blank" class="project-link">
                                View Project
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="education-section">
                    <h2 class="section-title">Education</h2>
                    <?php foreach ($education as $edu): ?>
                        <div class="edu-block">
                            <strong><?php echo $edu['degree']; ?></strong>
                            <div><?php echo $edu['date']; ?></div>
                            <div><?php echo $edu['school']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="organizations-section">
                    <h2 class="section-title">Organizations</h2>
                    <?php foreach ($organizations as $orgName => $roles): ?>
                        <div class="org-block">
                            <strong><?php echo $orgName; ?></strong>
                            <ul class="details">
                                <?php foreach ($roles as $role): ?>
                                    <li><?php echo $role['role']; ?> — <em><?php echo $role['date']; ?></em></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>