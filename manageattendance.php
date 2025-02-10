<?php
// Database connection
$conn = mysqli_connect('localhost', 'root', '', 'studentonlineformdb');
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Handle Add Attendance
if (isset($_POST['add_attendance'])) {
    $student_id = $_POST['student_id'];
    $student_name = $_POST['student_name'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    $query = "INSERT INTO attendance (student_id, student_name, date, status) VALUES ('$student_id', '$student_name', '$date', '$status')";
    mysqli_query($conn, $query);
    header("Location: manageattendance.php");
    exit;
}

// Handle Deletion
if (isset($_GET['delete_id'])) {
    $attendance_id = $_GET['delete_id'];
    $query = "DELETE FROM attendance WHERE attendance_id = $attendance_id";
    mysqli_query($conn, $query);
    header("Location: manageattendance.php");
    exit;
}

// Handle Mark Attendance
if (isset($_GET['mark_id']) && isset($_GET['status'])) {
    $attendance_id = $_GET['mark_id'];
    $status = $_GET['status'];
    $query = "UPDATE attendance SET status = '$status' WHERE attendance_id = $attendance_id";
    mysqli_query($conn, $query);
    header("Location: manageattendance.php");
    exit;
}

// Handle Edit Attendance
if (isset($_POST['edit_attendance'])) {
    $attendance_id = $_POST['attendance_id'];
    $student_name = $_POST['student_name'];
    $date = $_POST['date'];
    $status = $_POST['status'];

    $query = "UPDATE attendance SET student_name = '$student_name', date = '$date', status = '$status' WHERE attendance_id = $attendance_id";
    mysqli_query($conn, $query);
    header("Location: manageattendance.php");
    exit;
}

// Fetch Attendance Records
$query = "SELECT attendance_id, student_id, student_name, date, status FROM attendance";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Attendance</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            width: 80%;
            margin: auto;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        table th {
            background-color: #f4f4f4;
        }
        .btn {
            padding: 5px 10px;
            text-decoration: none;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn-edit {
            background-color: #28a745;
        }
        .btn-delete {
            background-color: #dc3545;
        }
        .btn-mark {
            background-color: #007bff;
        }
        .btn-add {
            background-color: #17a2b8;
            margin-bottom: 20px;
        }
        .btn:hover {
            opacity: 0.8;
        }
        .form-container {
            margin-bottom: 20px;
        }
        .form-container form {
            display: flex;
            flex-direction: column;
            gap: 10px;
            width: 50%;
        }
        .form-container input, .form-container select, .form-container button {
            padding: 10px;
            font-size: 16px;
        }
        .form-container button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
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
    <div class="container">
        <h1>Manage Student Attendance</h1>

        <!-- Add Attendance Form -->
        <button class="btn btn-add" onclick="document.getElementById('addForm').style.display='block'">Add Attendance</button>
        <div id="addForm" class="form-container" style="display: none;">
            <h3>Add Attendance</h3>
            <form method="POST" action="">
                <input type="text" name="student_id" placeholder="Student ID" required>
                <input type="text" name="student_name" placeholder="Student Name" required>
                <input type="date" name="date" required>
                <select name="status" required>
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                </select>
                <button type="submit" name="add_attendance">Add</button>
                <button type="button" onclick="document.getElementById('addForm').style.display='none'">Cancel</button>
            </form>
        </div>

        <!-- Edit Form -->
        <?php if (isset($_GET['edit_id'])): ?>
            <?php
            $edit_id = $_GET['edit_id'];
            $edit_query = "SELECT * FROM attendance WHERE attendance_id = $edit_id";
            $edit_result = mysqli_query($conn, $edit_query);
            $edit_row = mysqli_fetch_assoc($edit_result);
            ?>
            <div class="form-container">
                <h3>Edit Attendance</h3>
                <form method="POST" action="">
                    <input type="hidden" name="attendance_id" value="<?php echo $edit_row['attendance_id']; ?>">
                    <input type="text" name="student_name" value="<?php echo $edit_row['student_name']; ?>" placeholder="Student Name" required>
                    <input type="date" name="date" value="<?php echo $edit_row['date']; ?>" required>
                    <select name="status" required>
                        <option value="present" <?php echo ($edit_row['status'] == 'present') ? 'selected' : ''; ?>>Present</option>
                        <option value="absent" <?php echo ($edit_row['status'] == 'absent') ? 'selected' : ''; ?>>Absent</option>
                    </select>
                    <button type="submit" name="edit_attendance">Update</button>
                    <button type="button" onclick="location.href='manageattendance.php'">Cancel</button>
                </form>
            </div>
        <?php endif; ?>

        <!-- Attendance Table -->
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Student ID</th>
                    <th>Student Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    $counter = 1;
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>
                                <td>{$counter}</td>
                                <td>{$row['student_id']}</td>
                                <td>{$row['student_name']}</td>
                                <td>{$row['date']}</td>
                                <td>{$row['status']}</td>
                                <td>
                                    <a href='manageattendance.php?edit_id={$row['attendance_id']}' class='btn btn-edit'>Edit</a>
                                    <a href='manageattendance.php?delete_id={$row['attendance_id']}' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a>
                                    <a href='manageattendance.php?mark_id={$row['attendance_id']}&status=present' class='btn btn-mark'>Mark Present</a>
                                    <a href='manageattendance.php?mark_id={$row['attendance_id']}&status=absent' class='btn btn-mark'>Mark Absent</a>
                                </td>
                              </tr>";
                        $counter++;
                    }
                } else {
                    echo "<tr><td colspan='6'>No attendance records found.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>
