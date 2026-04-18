<?php
session_start();
require_once "config.php"; // make sure this has your $conn connection

// ======================
 //REGISTER
 //======================
if (isset($_POST['register'])) {
   $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // hash password
    $role = $_POST['role'];

  //  Check if email already exists
    $stmt = $conn->prepare("SELECT email FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
       $_SESSION['register_error'] = "Email already exists.";
       $_SESSION['active_form'] = "register";
        header("Location: login.php");
        exit();
   } else {
       // Insert new user
       $stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
       $stmt->bind_param("ssss", $name, $email, $password, $role);
       if ($stmt->execute()) {
           $_SESSION['success_message'] = "Registration successful! You can now log in.";
           header("Location: login.php");
           exit();
       } else {
           $_SESSION['register_error'] = "Error during registration. Please try again. " . $stmt->error;
           $_SESSION['active_form'] = "register";
           header("Location: login.php");
           exit();
       }
   }
}
?> 





















<?php

// ======================
 //LOGIN
 //======================
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Successful login
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: admin.php");
            } else {
                header("Location: dashboard.php");
            }
            exit();
        } else {
            $_SESSION['login_error'] = "Incorrect password.";
            $_SESSION['active_form'] = "login";
            header("Location: login.php");
            exit();
        }
    } else {
        $_SESSION['login_error'] = "No account found with this email.";
        $_SESSION['active_form'] = "login";
        header("Location: login.php");
        exit();
    }
}
?>
