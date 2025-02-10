<?php

$conn = new mysqli("localhost", "root", "", "studentonlineformdb");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Dashboard statistics
$total_students = $conn->query("SELECT COUNT(*) AS count FROM student")->fetch_assoc()['count'];
$total_courses = $conn->query("SELECT COUNT(*) AS count FROM course")->fetch_assoc()['count'];
$total_enrollments = $conn->query("SELECT COUNT(*) AS count FROM enrollment")->fetch_assoc()['count'];
$pending_submissions = $conn->query("SELECT COUNT(*) AS count FROM submission WHERE status = 'pending'")->fetch_assoc()['count'];
$pending_submissions = $conn->query("SELECT COUNT(*) AS count FROM submission")->fetch_assoc()['count'];


// Handle form submissions (add/update/delete staff)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $role = $_POST['role'];

        $sql = "INSERT INTO staff (name, email, password, role) VALUES ('$name', '$email', '$password', '$role')";
        $conn->query($sql);
    } elseif ($action === 'update') {
        $staff_id = $_POST['staff_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];

        $sql = "UPDATE staff SET name='$name', email='$email', role='$role' WHERE staff_id='$staff_id'";
        $conn->query($sql);
    } elseif ($action === 'delete') {
        $staff_id = $_POST['staff_id'];

        $sql = "DELETE FROM staff WHERE staff_id='$staff_id'";
        $conn->query($sql);
    }
}
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
        <h1 class="text-2xl font-bold mb-6">Manage Staff</h1>

        <!-- Add Staff Form -->
        <form method="POST" class="mb-8">
            <input type="hidden" name="action" value="add">
            <div class="grid grid-cols-4 gap-4">
                <input type="text" name="name" placeholder="Name" class="border p-2" required>
                <input type="email" name="email" placeholder="Email" class="border p-2" required>
                <input type="password" name="password" placeholder="Password" class="border p-2" required>
                <select name="role" class="border p-2" required>
                    <option value="admin">Admin</option>
                    <option value="staff">Staff</option>
                </select>
                <button type="submit" class="btn">Add Staff</button>
            </div>
        </form>

        <!-- Staff Table -->
        <table class="table-auto w-full bg-white rounded-lg shadow-lg">
            <thead>
                <tr>
                    <th class="p-4">#</th>
                    <th class="p-4">Name</th>
                    <th class="p-4">Email</th>
                    <th class="p-4">Role</th>
                    <th class="p-4">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM staff";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr class='text-center'>
                            <td class='p-4'>{$row['staff_id']}</td>
                            <td class='p-4'>{$row['name']}</td>
                            <td class='p-4'>{$row['email']}</td>
                            <td class='p-4'>" . ucfirst($row['role']) . "</td>
                            <td class='p-4'>
                                <form method='POST' class='inline'>
                                    <input type='hidden' name='action' value='delete'>
                                    <input type='hidden' name='staff_id' value='{$row['staff_id']}'>
                                    <button type='submit' class='btn btn-delete'>Delete</button>
                                </form>
                                <button class='btn' onclick='populateForm(" . json_encode($row) . ")'>Edit</button>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='5' class='p-4 text-center'>No staff found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</div>

<script>
    function populateForm(data) {
        document.getElementById('editForm').classList.remove('hidden');
        document.getElementById('editStaffId').value = data.staff_id;
        document.getElementById('editName').value = data.name;
        document.getElementById('editEmail').value = data.email;
        document.getElementById('editRole').value = data.role;
    }
</script>

</body>
</html>
