<?php
// edit_resume.php (Private Page for CRUD Update)
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();

// Security concept: Laravel Auth middleware spirit (Session Check)
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true || !isset($_SESSION['resume_id'])) {
    header('Location: login.php');
    exit;
}

require_once 'db_config.php';

$errors = [];
$success_message = '';
$resume_id = $_SESSION['resume_id'];
$resumeData = null;

// Validation function (Laravel's validate() spirit)
function validate_data($data) {
    $errors = [];
    $clean = [];

    // Define rules: required|string|max:255
    $fields = [
        'name' => 'Name', 'title' => 'Title', 'address' => 'Address', 
        'email' => 'Email', 'phone' => 'Phone', 'profile_summary' => 'Profile Summary',
        'github_link' => 'GitHub Link', 'linkedin_link' => 'LinkedIn Link'
    ];

    foreach ($fields as $key => $label) {
        $value = trim($data[$key] ?? '');
        $clean[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');

        if (empty($value)) {
            $errors[$key] = "The " . strtolower($label) . " field is required.";
        } elseif (strlen($value) > 255 && $key !== 'profile_summary') {
            $errors[$key] = "The " . strtolower($label) . " must not exceed 255 characters.";
        }
    }
    
    // Specific validations
    if (!isset($errors['email']) && !filter_var($clean['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format.";
    }
    if (!isset($errors['github_link']) && !filter_var($clean['github_link'], FILTER_VALIDATE_URL)) {
        $errors['github_link'] = "Invalid GitHub URL format.";
    }
    if (!isset($errors['linkedin_link']) && !filter_var($clean['linkedin_link'], FILTER_VALIDATE_URL)) {
        $errors['linkedin_link'] = "Invalid LinkedIn URL format.";
    }

    return ['data' => $clean, 'errors' => $errors];
}

try {
    $database = new Database();
    $db = $database->connect();

    // 1. Handle Form Submission (POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        $validation = validate_data($_POST);
        $clean_data = $validation['data'];
        $errors = $validation['errors'];

        if (empty($errors)) {
            // ELOQUENT spirit: Update the model
            $sql = "UPDATE resumes SET
                name = :name,
                title = :title,
                address = :address,
                email = :email,
                phone = :phone,
                profile_summary = :profile_summary,
                github_link = :github_link,
                linkedin_link = :linkedin_link
                WHERE id = :id";
            
            $stmt = $db->prepare($sql);
            
            // Bind parameters
            $stmt->bindParam(':id', $resume_id, PDO::PARAM_INT);
            $stmt->bindParam(':name', $clean_data['name']);
            $stmt->bindParam(':title', $clean_data['title']);
            $stmt->bindParam(':address', $clean_data['address']);
            $stmt->bindParam(':email', $clean_data['email']);
            $stmt->bindParam(':phone', $clean_data['phone']);
            $stmt->bindParam(':profile_summary', $clean_data['profile_summary']);
            $stmt->bindParam(':github_link', $clean_data['github_link']);
            $stmt->bindParam(':linkedin_link', $clean_data['linkedin_link']);
            
            if ($stmt->execute()) {
                $success_message = "Profile updated successfully! Check your Public View.";
                // Re-fetch data to show the updated values in the form
                $resumeData = fetchResumeData($db, $resume_id);
            } else {
                $errors['db_error'] = "Database update failed.";
            }
        }
    }

    // 2. Initial Load / After POST (Fetch current data)
    if (!$resumeData) {
        $resumeData = fetchResumeData($db, $resume_id);
    }
    
    if (!$resumeData) {
        die("Error: Resume data not found for this user.");
    }
    
    // If validation failed, use POST data to repopulate the form fields
    if (!empty($errors) && $_SERVER['REQUEST_METHOD'] === 'POST') {
        $resumeData = array_merge($resumeData, $_POST);
    }

} catch (Exception $e) {
    $errors['global'] = "An unexpected server error occurred.";
}

$name = $resumeData['name'] ?? "User";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Resume</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="top-bar">
        <div class="welcome-msg">Editing Profile for, <?php echo htmlspecialchars($name); ?>!</div>
        <div class="top-actions">
            <a href="resume.php" class="action-btn edit-btn">Back to Dashboard</a>
            <a href="public_resume.php?id=<?php echo $resume_id; ?>" target="_blank" class="action-btn public-btn">Public View</a>
            <form action="logout.php" method="post" class="logout-form">
                <button type="submit" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>

    <div class="resume-layout" style="display: block; max-width: 800px;">
        <div class="main edit-form-container">
            <h2 class="section-title" style="margin-top: 0;">Edit Personal Information</h2>
            
            <?php if (isset($errors['global'])): ?>
                <div class="error-box"><?php echo htmlspecialchars($errors['global']); ?></div>
            <?php endif; ?>
            <?php if ($success_message): ?>
                <div class="success-box"><?php echo htmlspecialchars($success_message); ?></div>
            <?php endif; ?>
            
            <form method="POST" action="edit_resume.php">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($resumeData['name'] ?? ''); ?>">
                        <?php if (isset($errors['name'])) echo "<div class='error-msg'>" . htmlspecialchars($errors['name']) . "</div>"; ?>
                    </div>
                    <div class="form-group">
                        <label for="title">Title / Designation</label>
                        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($resumeData['title'] ?? ''); ?>">
                        <?php if (isset($errors['title'])) echo "<div class='error-msg'>" . htmlspecialchars($errors['title']) . "</div>"; ?>
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" id="address" name="address" value="<?php echo htmlspecialchars($resumeData['address'] ?? ''); ?>">
                        <?php if (isset($errors['address'])) echo "<div class='error-msg'>" . htmlspecialchars($errors['address']) . "</div>"; ?>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($resumeData['email'] ?? ''); ?>">
                        <?php if (isset($errors['email'])) echo "<div class='error-msg'>" . htmlspecialchars($errors['email']) . "</div>"; ?>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($resumeData['phone'] ?? ''); ?>">
                        <?php if (isset($errors['phone'])) echo "<div class='error-msg'>" . htmlspecialchars($errors['phone']) . "</div>"; ?>
                    </div>
                    <div class="form-group">
                        <label for="github_link">GitHub Link</label>
                        <input type="url" id="github_link" name="github_link" value="<?php echo htmlspecialchars($resumeData['github_link'] ?? ''); ?>">
                        <?php if (isset($errors['github_link'])) echo "<div class='error-msg'>" . htmlspecialchars($errors['github_link']) . "</div>"; ?>
                    </div>
                    <div class="form-group">
                        <label for="linkedin_link">LinkedIn Link</label>
                        <input type="url" id="linkedin_link" name="linkedin_link" value="<?php echo htmlspecialchars($resumeData['linkedin_link'] ?? ''); ?>">
                        <?php if (isset($errors['linkedin_link'])) echo "<div class='error-msg'>" . htmlspecialchars($errors['linkedin_link']) . "</div>"; ?>
                    </div>
                </div>

                <!-- Profile Summary (Takes full width) -->
                <div class="form-group full-width">
                    <label for="profile_summary">Profile Summary (About Me)</label>
                    <textarea id="profile_summary" name="profile_summary"><?php echo htmlspecialchars($resumeData['profile_summary'] ?? ''); ?></textarea>
                    <?php if (isset($errors['profile_summary'])) echo "<div class='error-msg'>" . htmlspecialchars($errors['profile_summary']) . "</div>"; ?>
                </div>

                <div class="form-group full-width">
                    <button type="submit" class="submit-btn">Save Profile Changes</button>
                </div>

                <p class="form-hint">Note: Skills, Education, Projects, and Organizations require more complex form logic (e.g., adding/deleting rows). For this activity, they are assumed to be managed separately or directly in the database.</p>
            </form>

        </div>
    </div>
</body>
</html>