<?php 
// Database Connection
$servername = "localhost";
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "studentonlineformdb"; // Replace with your database name

$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for adding a new student
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = $_POST['email'];
    $status = $_POST['status'];

    // Insert new student into the database
    $sql = "INSERT INTO student (username, email, status) VALUES ('$full_name', '$email', '$status')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New student added successfully!'); window.location.href='managestudent.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Fetch students from the database
$sql = "SELECT * FROM student";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Students</title>
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
 <main class="flex-1 p-8">
            <h2 class="text-2xl font-semibold mb-6">Manage Students</h2>
            
            <!-- Add New Student Form -->
            <div class="mb-6 bg-white p-6 rounded shadow">
                <h3 class="text-xl font-semibold mb-4">Add New Student</h3>
                <form action="managestudent.php" method="post" class="space-y-4">
                    <div>
                        <label for="full_name" class="block text-sm font-medium">Full Name</label>
                        <input type="text" id="full_name" name="full_name" required class="mt-1 block w-full p-2 border rounded">
                    </div>
                    <div>
                        <label for="email" class="block text-sm font-medium">Email</label>
                        <input type="email" id="email" name="email" required class="mt-1 block w-full p-2 border rounded">
                    </div>
                    <div>
                        <label for="status" class="block text-sm font-medium">Status</label>
                        <select id="status" name="status" required class="mt-1 block w-full p-2 border rounded">
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-500">Add Student</button>
                </form>
            </div>

            <!-- Student List Table -->
            <div class="overflow-auto rounded-lg shadow-lg">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="w-1/6 p-3 text-sm font-semibold text-left">Student ID</th>
                            <th class="w-1/4 p-3 text-sm font-semibold text-left">Full Name</th>
                            <th class="w-1/4 p-3 text-sm font-semibold text-left">Email</th>
                            <th class="w-1/6 p-3 text-sm font-semibold text-left">Status</th>
                            <th class="w-1/6 p-3 text-sm font-semibold text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php if ($result->num_rows > 0): ?>
                            <?php while($row = $result->fetch_assoc()): ?>
                                <tr class="bg-gray-50">
                                    <td class="p-3 text-sm"><?php echo $row['student_id']; ?></td>
                                    <td class="p-3 text-sm"><?php echo $row['full_name']; ?></td>
                                    <td class="p-3 text-sm"><?php echo $row['email']; ?></td>
                                    <td class="p-3 text-sm"><?php echo $row['status']; ?></td>
                                    <td class="p-3 text-sm">
                                        <a href="editstudent.php?id=<?php echo $row['id']; ?>" class="bg-green-500 text-white px-2 py-1 rounded">Edit</a>
                                        <a href="deletestudent.php?id=<?php echo $row['id']; ?>" class="bg-red-500 text-white px-2 py-1 rounded">Delete</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="p-3 text-sm text-center">No students found</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <?php $conn->close(); ?>
</body>
</html>