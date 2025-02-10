<?php
// Database connection
$host = 'localhost'; // Database host
$username = 'root'; // Database username
$password = ''; // Database password
$database = 'studentonlineformdb'; // Database name

$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die('Connection failed: ' . $conn->connect_error);
}

// Check if form data is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $submission_id = intval($_POST['submission_id']);
    $status = $_POST['status'];

    // Validate inputs
    if (!empty($submission_id) && in_array($status, ['Pending', 'Approved', 'Rejected'])) {
        // Update submission status
        $stmt = $conn->prepare("UPDATE submission SET status = ? WHERE submission_id = ?");
        $stmt->bind_param("si", $status, $submission_id);

        if ($stmt->execute()) {
            // Success message
            echo "<script>
                alert('Submission status updated successfully!');
                window.location.href = 'your_submission_page.php'; // Replace with your submissions page
            </script>";
        } else {
            // Error message
            echo "<script>
                alert('Error updating submission status. Please try again.');
                window.history.back();
            </script>";
        }

        $stmt->close();
    } else {
        echo "<script>
            alert('Invalid input data.');
            window.history.back();
        </script>";
    }
}

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
      
      <body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto py-6">
        <h1 class="text-2xl font-bold mb-4">Submissions</h1>

        <!-- Search Bar -->
        <div class="mb-6 flex justify-between">
            <input
                type="text"
                id="searchInput"
                placeholder="Search by student or assignment"
                class="w-full max-w-md p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-400"
            />
            <select id="filterStatus" class="p-2 border border-gray-300 rounded">
                <option value="">All Status</option>
                <option value="Pending">Pending</option>
                <option value="Approved">Approved</option>
                <option value="Rejected">Rejected</option>
            </select>
        </div>

        <!-- Submissions Table -->
        <div class="bg-white shadow-md rounded-lg">
            <table class="min-w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="p-4 text-left text-sm font-semibold text-gray-600">Submission ID</th>
                        <th class="p-4 text-left text-sm font-semibold text-gray-600">Student</th>
                        <th class="p-4 text-left text-sm font-semibold text-gray-600">Assignment</th>
                        <th class="p-4 text-left text-sm font-semibold text-gray-600">Submission Date</th>
                        <th class="p-4 text-left text-sm font-semibold text-gray-600">Status</th>
                        <th class="p-4 text-left text-sm font-semibold text-gray-600">Actions</th>
                    </tr>
                </thead>
                <tbody id="submissionList">
                    <?php foreach ($submissions as $submission): ?>
                        <tr class="border-t">
                            <td class="p-4 text-sm text-gray-800"><?php echo $submission['id']; ?></td>
                            <td class="p-4 text-sm text-gray-800"><?php echo $submission['student_name']; ?></td>
                            <td class="p-4 text-sm text-gray-800"><?php echo $submission['assignment_name']; ?></td>
                            <td class="p-4 text-sm text-gray-800"><?php echo $submission['submission_date']; ?></td>
                            <td class="p-4 text-sm text-gray-800"><?php echo $submission['status']; ?></td>
                            <td class="p-4 text-sm text-gray-800 flex space-x-2">
                                <form method="post" action="update_submission_status.php">
                                    <input type="hidden" name="submission_id" value="<?php echo $submission['id']; ?>">
                                    <button type="submit" name="status" value="Approved" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-500">Approve</button>
                                    <button type="submit" name="status" value="Rejected" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-500">Reject</button>
                                </form>
                                <a href="<?php echo $submission['file_url']; ?>" target="_blank" class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-500">View</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>