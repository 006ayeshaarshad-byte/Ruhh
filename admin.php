<?php
session_start();
require_once "config.php";

// Not logged in
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

// Double check role from database (extra secure)
$email = $_SESSION['email'];

$stmt = $conn->prepare("SELECT role FROM users WHERE email=?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// If not admin → block access
if (!$user || $user['role'] !== 'admin') {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>

<html>
<head>
    <title>Admin Panel</title>
</head>
<body>

<h1>Welcome Admin <?php echo $_SESSION['name']; ?>kingggg 👑</h1>

<p>This page is only accessible to admins.</p>

<a href="logout.php">Logout</a>

</body>
</html>