<?php
session_start();
include 'db_config.php';

// Fetch students
$students_query = "SELECT student_id, name FROM student";
$students_result = mysqli_query($conn, $students_query);
$students = mysqli_fetch_all($students_result, MYSQLI_ASSOC);

// Fetch courses
$courses_query = "SELECT course_id, course_name FROM course";
$courses_result = mysqli_query($conn, $courses_query);
$courses = mysqli_fetch_all($courses_result, MYSQLI_ASSOC);

// Fetch enrollments
$enrollments_query = "SELECT e.enrollment_id, s.name AS student_name, c.course_name, e.enrollment_date FROM enrollment e 
                      JOIN student s ON e.student_id = s.student_id 
                      JOIN course c ON e.course_id = c.course_id";
$enrollments_result = mysqli_query($conn, $enrollments_query);
$enrollments = mysqli_fetch_all($enrollments_result, MYSQLI_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Enrollments</title>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

      <body class="bg-gray-100">
    <main class="flex-1 p-6">
        <h1 class="text-2xl font-bold mb-4">Manage Enrollments</h1>

        <form method="POST" action="enroll_student.php">
            <label for="student">Student</label>
            <select name="student_id" id="student">
                <option value="">Select a student</option>
                <?php foreach ($students as $student): ?>
                    <option value="<?= $student['student_id'] ?>"><?= $student['name'] ?></option>
                <?php endforeach; ?>
            </select>

            <label for="course">Course</label>
            <select name="course_id" id="course">
                <option value="">Select a course</option>
                <?php foreach ($courses as $course): ?>
                    <option value="<?= $course['course_id'] ?>"><?= $course['course_name'] ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit">Enroll</button>
        </form>

        <h2 class="text-xl font-bold mb-4">Enrollment List</h2>
        <table>
            <thead>
                <tr>
                    <th>Enrollment ID</th>
                    <th>Student</th>
                    <th>Course</th>
                    <th>Enrollment Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($enrollments as $enrollment): ?>
                    <tr>
                        <td><?= $enrollment['enrollment_id'] ?></td>
                        <td><?= $enrollment['student_name'] ?></td>
                        <td><?= $enrollment['course_name'] ?></td>
                        <td><?= $enrollment['enrollment_date'] ?></td>
                        <td>
                            <form method="POST" action="delete_enrollment.php">
                                <input type="hidden" name="enrollment_id" value="<?= $enrollment['enrollment_id'] ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const saveButtons = document.querySelectorAll('.btn-save');
            const cancelButtons = document.querySelectorAll('.btn-cancel');
            const deleteButtons = document.querySelectorAll('.btn-delete');

            saveButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.parentElement.parentElement;
                    const cells = row.querySelectorAll('td');
                    const enrollmentData = {
                        id: cells[0].innerText,
                        student: cells[1].innerText,
                        course: cells[2].innerText,
                        date: cells[3].innerText
                    };
                    // TODO: Send enrollmentData to the server using AJAX
                    console.log('Save clicked', enrollmentData);
                    alert('Changes saved!');
                });
            });

            cancelButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // TODO: Reset changes to original values
                    alert('Changes cancelled!');
                });
            });

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.parentElement.parentElement;
                    const enrollmentId = row.querySelector('td').innerText;
                    // TODO: Send delete request to the server using AJAX
                    console.log('Delete clicked', enrollmentId);
                    row.remove();
                    alert('Record deleted!');
                });
            });
        });
    </script>
</body>
</html>
