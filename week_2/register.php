<?php 
include 'db.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $username  = $_POST['username'];
    $email     = $_POST['email'];
    $phone     = $_POST['phone'];
    $pass      = $_POST['password'];
    $c_pass    = $_POST['C_password'];

    if ($pass !== $c_pass) {
        echo "<script>alert('Password not identical'); window.history.back();</script>";
        exit();
    }

    $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO users (full_name, username, email, phone, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $full_name, $username, $email, $phone, $hashed_password);

    if ($stmt->execute()) {
        echo "<script>alert('registered successfully '); window.location.href = 'login.html';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>