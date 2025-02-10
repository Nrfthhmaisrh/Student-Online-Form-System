<?php
$conn = new mysqli("localhost", "root", "", "studentonlineformdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$student_id = 1;

// Fetch student information
$sql = "SELECT name, email, phone_number, course_id FROM student WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    $student = [
        'name' => 'Not Available',
        'email' => 'Not Available',
        'phone_number' => 'Not Available',
        'course_id' => null
    ];
}

$stmt->close();

// Fetch course information (if applicable)
$course_name = 'Not Available';
if (!empty($student['course_id'])) {
    $sql = "SELECT course_name FROM courses WHERE course_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student['course_id']);
    $stmt->execute();
    $stmt->bind_result($course_name);
    $stmt->fetch();
    $stmt->close();
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Submissions</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
       .navbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: #66c2a6;
    padding: 10px 20px;
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
      
   
 </div>

 </div>
 <div class="flex">
     <!-- Sidebar -->
     <aside class="sidebar">
         <div class="profile">
             <img src="img/img 1.png" alt="Profile Picture"> 
             <h2>NUR AINATUL MARDHIYAH BINTI MOHAMAD</h2>
             <p>2024388929</p>
         </div>


    
         <h3 class="nav-title">Navigation</h3>
            <ul>
                <li class="nav-item">
                    <a href="student.php">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h11M9 21H3a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z" />
                        </svg>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="courses.php">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16l-4-4m0 0l4-4m-4 4h16" />
                        </svg>
                        My Courses
                    </a>
                </li>
                <li class="nav-item">
                    <a href="attandance.php">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3" />
                        </svg>
                        Attendance
                    </a>
                </li>
                <li class="nav-item">
                    <a href="submission.php">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                        </svg>
                        Submissions
                    </a>
                </li>
            </ul>
        </aside>

      <!-- Main Content -->
      <div class="flex-1">
        <!-- Header -->
        <header class="bg-gray-600 text-white p-4 flex justify-between items-center">
            <h1 class="text-xl font-semibold">View Submission</h1>
        </header>

  

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <header class="bg-blue-600 text-white p-4 rounded-lg mb-6">
                <h1 class="text-xl font-semibold">Submissions</h1>
            </header>

         <!-- Main Content -->
         <main class="p-6">
                <section>
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4">Your Submissions</h2>
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <table class="min-w-full border-collapse border border-gray-300">
                            <thead>
                                <tr>
                                    <th class="p-2 border border-gray-300">Submission ID</th>
                                    <th class="p-2 border border-gray-300">Assignment Name</th>
                                    <th class="p-2 border border-gray-300">Submission Date</th>
                                    <th class="p-2 border border-gray-300">File</th>
                                    <th class="p-2 border border-gray-300">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    while ($row = $result->fetch_assoc()) {
                                        echo "<tr>
                                            <td class='p-2 border border-gray-300'>{$row['submission_id']}</td>
                                            <td class='p-2 border border-gray-300'>" . htmlspecialchars($row['assignment_name']) . "</td>
                                            <td class='p-2 border border-gray-300'>" . htmlspecialchars($row['submission_date']) . "</td>
                                            <td class='p-2 border border-gray-300'><a href='" . htmlspecialchars($row['file_url']) . "' class='text-blue-600' download>Download</a></td>
                                            <td class='p-2 border border-gray-300'>
                                                <button class='bg-blue-500 text-white px-3 py-1 rounded-md'>Edit</button>
                                                <button class='bg-red-500 text-white px-3 py-1 rounded-md'>Delete</button>
                                            </td>
                                        </tr>";
                                    }
                                } else {
                                    echo "<tr>
                                        <td colspan='5' class='text-center text-gray-600'>No submissions found</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </main>
        </div>
    </div>

    <?php
    // Clean up
    $stmt->close();
    $conn->close();
    ?>
</body>
</html>
