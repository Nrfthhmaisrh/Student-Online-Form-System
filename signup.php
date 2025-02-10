<?php
session_start();
include 'db_config.php'; // Ensure database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $institution = trim($_POST['institution']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate inputs 
    if (empty($fullname) || empty($email) || empty($role) || empty($institution) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
    } elseif (strlen($password) < 8) {
        $_SESSION['error'] = "Password must be at least 8 characters long.";
    } else {
        // Prevent SQL Injection
        $email = mysqli_real_escape_string($conn, $email);
        $fullname = mysqli_real_escape_string($conn, $fullname);
        $role = mysqli_real_escape_string($conn, $role);
        $institution = mysqli_real_escape_string($conn, $institution);
        $password = mysqli_real_escape_string($conn, $password); // Password stored as plain text ❌

        // Check if email already exists
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['error'] = "Email is already registered.";
        } else {
            // Insert new user without hashing password
            $query = "INSERT INTO users (username, password, email, role, institution, last_login) VALUES (?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $last_login = date("Y-m-d H:i:s"); // Add last login as a current timestamp
            $stmt->bind_param("ssssss", $fullname, $password, $email, $role, $institution, $last_login);
            
            if ($stmt->execute()) {
                $_SESSION['success'] = "Registration successful! Please login.";
                header("Location: login.php");
                exit();
            } else {
                $_SESSION['error'] = "Registration failed. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - iStudent Portal</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; text-align: center; }
        .form-container { width: 50%; margin: 50px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        .form-container h2 { margin-bottom: 20px; }
        .form-group { margin-bottom: 15px; text-align: left; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-group input, .form-group select { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; }
        .btn { width: 100%; padding: 15px; font-size: 18px; color: white; background-color: #007bff; border: none; border-radius: 5px; cursor: pointer; transition: 0.3s; }
        .btn:hover { background-color: #0056b3; }
        .error { color: red; margin-bottom: 10px; }
        .success { color: green; margin-bottom: 10px; }
    </style>
</head>
<body>

    <div class="form-container">
        <h2>Sign Up</h2>

        <!-- Display Error or Success Messages -->
        <?php if (isset($_SESSION['error'])): ?>
            <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION['success'])): ?>
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php endif; ?>

        <form action="signup.php" method="post">
            <div class="form-group">
                <label for="fullname">Full Name *</label>
                <input type="text" id="fullname" name="fullname" placeholder="Enter Full Name" required>
            </div>
            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" placeholder="Enter Email Address" required>
            </div>
            <div class="form-group">
                <label for="role">Role *</label>
                <select id="role" name="role" required>
                    <option value="">Select Role...</option>
                    <option value="Student">Student</option>
                    <option value="Staff">Staff</option>
                </select>
            </div>
            <div class="form-group">
                <label for="institution">Institution *</label>
                <select id="institution" name="institution" required>
                    <option value="">Select Institution...</option>
                    <option value="Universiti Malaya (UM)">Universiti Malaya (UM)</option>
                    <option value="Universiti Kebangsaan Malaysia (UKM)">Universiti Kebangsaan Malaysia (UKM)</option>
                    <option value="Universiti Putra Malaysia (UPM)">Universiti Putra Malaysia (UPM)</option>
                    <option value="Universiti Sains Malaysia (USM)">Universiti Sains Malaysia (USM)</option>
                    <option value="Universiti Teknologi Malaysia (UTM)">Universiti Teknologi Malaysia (UTM)</option>
                    <option value="Universiti Teknologi MARA (UiTM)">Universiti Teknologi MARA (UiTM)</option>
                    <option value="Universiti Utara Malaysia (UUM)">Universiti Utara Malaysia (UUM)</option>
                    <option value="Universiti Malaysia Sabah (UMS)">Universiti Malaysia Sabah (UMS)</option>
                    <option value="Universiti Malaysia Sarawak (UNIMAS)">Universiti Malaysia Sarawak (UNIMAS)</option>
                    <option value="Universiti Pendidikan Sultan Idris (UPSI)">Universiti Pendidikan Sultan Idris (UPSI)</option>
                </select>
            </div>
            <div class="form-group">
                <label for="password">Password *</label>
                <input type="password" id="password" name="password" placeholder="Enter Password" required>
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password *</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
            </div>
            <button type="submit" class="btn">Sign Up</button>
        </form>
        <p>Already have an account? <a href="login.php">Log In</a></p>
    </div>

</body>
</html>