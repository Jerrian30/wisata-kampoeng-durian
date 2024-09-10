<?php
session_start();
require '../config/db.php';

// Ambil data dari form
$username = $_POST['username'];
$password = $_POST['password'];

// Validasi login
$query = "SELECT * FROM users WHERE username = ? AND password = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$username, $password]);
$user = $stmt->fetch();

if ($user) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_role'] = $user['role']; // admin, member, guest
    header("Location: ../index.php");
} else {
    echo "Username atau password salah.";
}
?>
