<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "studentonlineformdb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize variables
$course_id = $course_name = $credits = $instructor = "";
$is_edit = false;

// Check if course_id is passed for editing
if (isset($_GET['id'])) {
    $course_id = $_GET['id'];
    $is_edit = true;

    // Fetch course details
    $sql = "SELECT * FROM course WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $course_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();
        $course_name = $course['course_name'];
        $credits = $course['credits'];
        $instructor = $course['instructor'];
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_name = $_POST['course_name'];
    $credits = $_POST['credits'];
    $instructor = $_POST['instructor'];

    if (isset($_POST['course_id']) && !empty($_POST['course_id'])) {
        // Update course
        $course_id = $_POST['course_id'];
        $sql = "UPDATE course SET course_name = ?, credits = ?, instructor = ? WHERE course_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $course_name, $credits, $instructor, $course_id);
    } else {
        // Add new course
        $sql = "INSERT INTO course (course_name, credits, instructor) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $course_name, $credits, $instructor);
    }

    if ($stmt->execute()) {
        header("Location: managecourses.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }
}

// Fetch all courses for the table
$sql = "SELECT * FROM course";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Courses</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #66c2a6;
            padding: 10px 20px;
        }
        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            width: 250px;
            background-color: #f8f9fa;
            min-height: 100vh;
            padding: 20px;
        }

        .sidebar .profile {
            text-align: center;
            margin-bottom: 20px;
        }

        .sidebar .profile img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            margin: 0 auto; 
            display: block; 
        }

        .sidebar .profile h2 {
            font-size: 14px;
            font-weight: 600;
            margin-top: 10px;
        }

        .sidebar .profile p {
            font-size: 14px;
            color: #6c757d;
        }

        .sidebar .nav-title {
            font-size: 14px;
            text-transform: uppercase;
            margin-bottom: 10px;
            color: #6c757d;
        }

        .sidebar .nav-item {
            list-style: none;
            margin-bottom: 10px;
        }

        .sidebar .nav-item a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #333;
            font-size: 15px;
            padding: 10px;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .sidebar .nav-item a:hover {
            background-color: #66c2a6;
            color: #fff;
        }

        .sidebar .nav-item a svg {
            margin-right: 10px;
        }
/* General Styling */
body {
    font-family: 'Arial', sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f8f9fa;
}

/* Add Course Button */
.btn-primary {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-primary:hover {
    background-color: #0056b3;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 20px 0;
    background-color: #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
    overflow: hidden;
}

table th, table td {
    padding: 15px;
    text-align: left;
    border-bottom: 1px solid #dee2e6;
}

table th {
    background-color: #007bff;
    color: #fff;
    font-size: 16px;
}

table tr:nth-child(even) {
    background-color: #f2f2f2;
}

table tr:hover {
    background-color: #e9ecef;
}

/* Search Bar */
input[type="text"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    outline: none;
    transition: box-shadow 0.3s ease;
}

input[type="text"]:focus {
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* Form Styling */
form {
    background-color: #fff;
    padding: 20px;
    margin: 20px auto;
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    max-width: 500px;
}

form .form-group {
    margin-bottom: 15px;
}

form label {
    font-size: 14px;
    font-weight: bold;
    margin-bottom: 5px;
    display: block;
}

form input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 14px;
    outline: none;
}

form button {
    background-color: #28a745;
    color: #fff;
    border: none;
    padding: 10px 15px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

form button:hover {
    background-color: #218838;
}

/* Responsive Design */
@media (max-width: 768px) {
    table, input[type="text"], form {
        width: 100%;
        font-size: 14px;
    }

    table th, table td {
        padding: 10px;
    }

    .btn-primary {
        padding: 8px 16px;
        font-size: 14px;
    }
}

    </style>
</head>

<body class="bg-gray-100">

        <!-- Navbar -->
      <div class="navbar">
        <div class="search-bar">
          <input type="text" placeholder="Search...">
        </div>
    <button class="bg-red-500 px-3 py-1 rounded-md"  onclick="window.location.href='login.php';">Logout</button>
        </div>
        
    <div class="flex h-screen">
         <!-- Sidebar -->
         <aside class="sidebar">
            <div class="profile">
                <img src="img/img0.jpg" alt="Profile Picture"> 
                <h2>NUR FATHIHAH MAISARAH BINTI PIEI</h2>
                <p>2024947793</p>
            </div>


            <h3 class="nav-title">Navigation</h3>
            <ul>
                <li class="nav-item">
                    <a href="staff.php">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21H3a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="managestudent.php">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l-4-4m0 0l4-4m-4 4h16" />
                        </svg>
                        Manage Student
                    </a>
                </li>
                <li class="nav-item">
                    <a href="managecourses.php">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3" />
                        </svg>
                        Manage Courses
                    </a>
                </li>
                <li class="nav-item">
                    <a href="manageenrollements.php">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        Manage Enrollments
                        </a>
                </li>
                <li class="nav-item">
                    <a href="manageattendance.php">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        Manage Attendance
                    </a>
                </li>
                <li class="nav-item">
                    <a href="viewsubmission.php">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2H6a2 2 0 00-2 2v6m16 0a2 2 0 012 2v1a2 2 0 01-2 2h-4a2 2 0 01-2-2v-1a2 2 0 012-2m-4 0v1a2 2 0 01-2 2h-4a2 2 0 01-2-2v-1a2 2 0 012-2m4 0H6" />
                        </svg>
                        Submissions
                    </a>
                </li>
            </ul>
            
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <div class="flex justify-between mb-6">

            </div>
            <form action="managecourses.php" method="post">
    <div class="form-group">
        <label for="course_name">Course Name</label>
        <input type="text" class="form-control" name="course_name" id="course_name" required>
    </div>
    <div class="form-group">
        <label for="credits">Credits</label>
        <input type="number" class="form-control" name="credits" id="credits" min="1" required>
    </div>
    <div class="form-group">
        <label for="instructor">Instructor</label>
        <input type="text" class="form-control" name="instructor" id="instructor" required>
    </div>
    <button type="submit" class="btn btn-success">Add Course</button>
</form>

            
            <table class="min-w-full bg-white shadow-md rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-4 text-left">Course ID</th>
                        <th class="p-4 text-left">Course Name</th>
                        <th class="p-4 text-left">Credits</th>
                        <th class="p-4 text-left">Instructor</th>
                        <th class="p-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr class="border-t">
                        <td class="p-4"><?= $row['course_id'] ?></td>
                        <td class="p-4"><?= $row['course_name'] ?></td>
                        <td class="p-4"><?= $row['credits'] ?></td>
                        <td class="p-4"><?= $row['instructor'] ?></td>
                        <td class="p-4">
                            <a href="managecourses.php?id=<?= $row['course_id'] ?>" class="bg-green-500 text-white px-3 py-1 rounded">Edit</a>
                            <a href="managecourses.php?id=<?= $row['course_id'] ?>" class="bg-red-500 text-white px-3 py-1 rounded" onclick="return confirm('Are you sure?');">Delete</a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </main>
    </div>

    <?php $conn->close(); ?>
</body>
</html>


