<?php
include 'db_config.php'; 


$sql = "SELECT attendance.attendance_id, attendance.student_id, attendance.student_name, attendance.date, attendance.status 
        FROM attendance";
$result = $conn->query($sql);

?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance</title>
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
                <h1 class="text-xl font-semibold">Attendance</h1>
            </header>

            <div class="container">
                <h1>Attendance</h1>
                <table border="1" cellpadding="10" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Student ID</th>
                            <th>Student Name</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                if ($row['student_name'] === 'NUR AINATUL MARDHIYAH BINTI MOHAMAD') { // Ensure your name is displayed
                                    echo "<tr>
                                            <td>" . $row['attendance_id'] . "</td>
                                            <td>" . $row['student_id'] . "</td>
                                            <td>" . $row['student_name'] . "</td>
                                            <td>" . $row['date'] . "</td>
                                            <td>" . ucfirst($row['status']) . "</td>
                                          </tr>";
                                }
                            }
                        } else {
                            echo "<tr><td colspan='5'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

<?php
$conn->close();
?>