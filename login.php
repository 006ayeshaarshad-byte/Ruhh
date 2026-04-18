<?php
session_start();
$errors = [

'login' => $_SESSION['login_error'] ?? '',
'register' => $_SESSION['register_error'] ?? ''
];
$active_form = $_SESSION['active_form'] ?? 'login'; 
session_unset();

function showerror($error) {
    return !empty($error) ? "<p class='error-message'>$error</p>" : '';
}

function isactiveform($formname, $active_form) {
    return $formname === $active_form ? 'active' : '';
}


?>





























<!DOCTYPE html>
<html lang="en">    

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
  <title>Login Page</title>
  <link rel="stylesheet" href="login.css">
</head>

<body> 
<div class="container"> 
    <div class="form-box <?php echo isactiveform('login', $active_form); ?>" id="login-form">
        <form action="login_register.php" method = "post"> 
             
            <h2>Login</h2> 
            <?php echo showerror($errors['login']); ?>
            

            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required> 
             <button type="submit" name="login"> Login </button>
             <p class="message">Don't have an account? <a href="#" onclick="showform('register-form')">Register</a></p>

        
        
        
        </form>
    </div>



<div class="form-box <?php echo isactiveform('register', $active_form); ?>" id="register-form">
        <form action="login_register.php" method = "post"> 
            <h2>Register</h2> 
            <?php echo showerror($errors['register']); ?>
        
            <input type="text" name="name" placeholder="Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required> 
            <select name="role" required>
                <option value="" disabled selected>Select Role</option>
                <option value="user">User</option>
                <option value="admin">Admin</option>
            </select>
             <button type="submit" name="register"> Register </button>

             <p class="message">Already have an account? <a href="#" onclick="showform('login-form')">Login</a></p>

        
        
        
        </form>
    </div>
</div>

<script src="script.js" ></script>

</body>
























</html>