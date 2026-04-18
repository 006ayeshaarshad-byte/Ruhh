<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
 
    <link rel="stylesheet" href="dashboard.css">


</head>

<body>
<main>



<div class="nav-overlay">

<a href="dashboard.php" class="logo">
  <h1>  Ruhh<span>.</span> </h1>
</a>


    <div class="nav-item home"><a href="#">HOME</a></div>
    <div class="nav-item community-post"><a href="#">COMMUNITY POST</a></div>
    <div class="nav-item AI-chat"><a href="#">AI CHAT</a></div>
    <div class="nav-item random-qoute"><a href="#">Qoute</a></div>
    <div class="nav-item blogs"><a href="#">BLOGS</a></div>
<div class="nav-item journal"><a href="journal.php">JOURNAL</a></div>
    
    
</div>



















<div class="top-right-links">
  <a href="about.html">About Us</a>
  <a href="blogs.html">Blogs</a>
<!-- Music Toggle -->
 
    <label class="switch">
        <input type="checkbox" class="toggle" id="music-toggle">
        <span class="slider"></span>
    </label> 
</div> 



 














</main>





<audio id="background-music" loop>
    <source src="music.mp3" type="audio/mpeg">
</audio>

<script src="music_landing.js"></script> 




<!--

<image src="grid.jpg" alt="grid"></a>

<a href="logout.php">Logout</a>
-->


</body>
</html>
