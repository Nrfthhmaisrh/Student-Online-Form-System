<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "studentonlineformdb");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission for updating student details
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_number = $_POST['phone_number'];
    $course_id = $_POST['course_id'];

    $sql = "UPDATE student SET name=?, email=?, phone_number=?, course_id=? WHERE student_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssii", $name, $email, $phone_number, $course_id, $student_id);
    if ($stmt->execute()) {
        echo "<script>alert('Details updated successfully!');</script>";
    } else {
        echo "<script>alert('Error updating details: " . $conn->error . "');</script>";
    }
    $stmt->close();
}

// Fetch student details
$student_id = 1; // Assume student ID is fetched dynamically in production
$sql = "SELECT student_id, name, email, phone_number, course_id FROM student WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
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
            <input type="text" placeholder="Search..." class="p-2 rounded border">
        </div>
        <button class="bg-red-500 px-3 py-1 rounded-md text-white">Logout</button>
    </div>

    <div class="flex">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="profile">
                <img src="img/img1.png" alt="Profile Picture"> 
                <h2>NUR AINATUL MARDHIYAH BINTI MOHAMAD</h2>
                <p>2024388929</p>
            </div>
            <h3 class="nav-title">Navigation</h3>
            <ul>
                <li><a href="student.php" class="block px-3 py-2 text-gray-700 rounded hover:bg-gray-300">Dashboard</a></li>
                <li><a href="courses.php" class="block px-3 py-2 text-gray-700 rounded hover:bg-gray-300">My Courses</a></li>
                <li><a href="attendance.php" class="block px-3 py-2 text-gray-700 rounded hover:bg-gray-300">Attendance</a></li>
                <li><a href="submission.php" class="block px-3 py-2 text-gray-700 rounded hover:bg-gray-300">Submissions</a></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="flex-1">
            <header class="bg-gray-600 text-white p-4">
                <h1 class="text-xl font-semibold">Dashboard</h1>
            </header>

            <main class="p-6">
                <h2 class="text-2xl font-semibold text-gray-800">Welcome, Nur Ainatul Mardhiyah Binti Mohamad</h2>
                <p class="text-gray-600">Manage your academic details below.</p>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Personal Information -->
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Personal Information</h3>
                        <ul class="text-gray-600">
                            <li><strong>Name:</strong> <?php echo $student['name']; ?></li>
                            <li><strong>Email:</strong> <?php echo $student['email']; ?></li>
                            <li><strong>Phone:</strong> <?php echo $student['phone_number']; ?></li>
                            <li><strong>Enrolled Course:</strong> <?php echo $student['course_id']; ?></li>
                        </ul>
                        <button class="bg-blue-500 text-white px-3 py-1 rounded-md mt-2" onclick="openEditModal()">Edit</button>
                    </div>

                    <!-- Attendance Summary -->
                    <div class="bg-white shadow-md rounded-lg p-4">
                        <h3 class="text-lg font-semibold text-gray-800 mb-2">Attendance Summary</h3>
                        <p class="text-gray-600">You have attended <strong>20</strong> out of <strong>25</strong> classes.</p>
                        <div class="w-full bg-gray-200 rounded-full h-4 mt-2">
                            <div class="bg-green-600 h-4 rounded-full" style="width: 80%;"></div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center hidden">
        <div class="bg-white p-6 rounded-md shadow-lg w-96">
            <h2 class="text-xl font-semibold mb-4">Edit Personal Information</h2>
            <form method="POST" action="">
                <input type="hidden" name="student_id" value="<?php echo $student['student_id']; ?>">
                <label class="block mb-2 text-sm font-medium">Name:</label>
                <input type="text" name="name" value="<?php echo $student['name']; ?>" class="w-full mb-4 p-2 border rounded">
                <label class="block mb-2 text-sm font-medium">Email:</label>
                <input type="email" name="email" value="<?php echo $student['email']; ?>" class="w-full mb-4 p-2 border rounded">
                <label class="block mb-2 text-sm font-medium">Phone:</label>
                <input type="text" name="phone_number" value="<?php echo $student['phone_number']; ?>" class="w-full mb-4 p-2 border rounded">
                <label class="block mb-2 text-sm font-medium">Course ID:</label>
                <input type="text" name="course_id" value="<?php echo $student['course_id']; ?>" class="w-full mb-4 p-2 border rounded">
                <div class="flex justify-end">
                    <button type="button" class="bg-gray-500 text-white px-3 py-1 rounded-md mr-2" onclick="closeEditModal()">Cancel</button>
                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded-md">Save</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal() {
            document.getElementById('editModal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>
</body>
</html>
