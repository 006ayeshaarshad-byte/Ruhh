<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <title>Journal</title>
    <link rel="stylesheet" href="journal.css">
     <link rel="stylesheet" href="https://www.fontspace.com/j-journey-diary-font-f108742" type="text/css"/>  
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body>


<h1>Journal<span>.</span></h1>
<button id="backBtn" class="back-btn" title="Back to Dashboard">
  <i class="fas fa-arrow-left" style="color: rgb(194, 178, 237); font-size: 30px;"></i>
</button>
<br> 

    <div class="container">


    <div class="note-container">
         <div class="btn">   
          
        <br>
            <button id="addnote"> <i class="fa-regular fa-pen-to-square" style="color: rgb(194, 178, 237);"></i> <br><i style="color:#85cce2 ; font-size: 25px; text-align: center; font-family: 'J Journey Diary', cursive ;">add entry</i></button>
    </div>

    <div class="newnotes"> 

    </div>

</div> 
<div class="addform" id="addForm">
    <div class="head">
          <h3>New Journal Entry</h3> 
    <button class="icon"> <i class="fa-regular fa-circle-xmark" style="color: rgb(194, 178, 237); font-size: 30px; ;"></i></i> </button>
    </div>
    <div class="inputs">    
        <input type="text" id="entryTitle" name="entryTitle" placeholder="label" required>

    </div>
    <div class="inputs">
        <p>Date</p>
        <input type="date" id="entryDate" name="entryDate" required> </input>
    </div>
    <div class="inputs"> 

        <p>Thoughts</p> 
        <textarea id="entryContent" name="entryContent" rows="4" required></textarea>
    </div>
    <div class="inputs">
    <p>Mood</p>
    <select id="entryMood">
        <option value="happy"> (˶˃ ᵕ ˂˶)Happy</option>
          <option value="loved"> (´｡• ◡ •｡`)❤︎ Loved</option>
        <option value="sad"> (╥﹏╥) Sad</option>
        <option value="angry"> ( ,,⩌'︿'⩌ꐦ,,) Angry</option>
        <option value="annoyed"> (￣へ￣) Annoyed</option>
        <option value="hug"> (つ｡˃ ᵕ ˂)つ Needs a hug</option>
        <option value="confused"> (´･_･`) Confused</option>
        <option value="grateful"> (ㅅ´ ˘ `) grateful</option>
        <option value="excited"> ₍₍⚞(˶˃ ꒳ ˂˶)⚟⁾⁾ Excited</option>
    </select>
</div>

    
    <br>
        <button id="addbtn">save journal entry</button> 

</div>

    </div>


    
    <h2></h2>
    <p></p>

    <button></button>

<audio id="clickSound" src="click.mp3"></audio>

<!-- Mood Tracker Graph -->
<h2 style="text-align: center; color: #992ca8; margin: 40px 0 20px;">Mood Tracker</h2>
<div class="mood-graph-container">
  <canvas id="moodChart" width="800" height="400"></canvas>
</div>

    <script src="journal.js"></script>


<div class="viewNote" id="viewNote">
  <div class="viewContent">
    
    <button id="closeView" class="view-close-icon"><i class="fa-regular fa-circle-xmark" style="color: rgb(194, 178, 237); font-size: 30px;"></i></button>

    <h2 id="viewTitle"></h2>

    <p id="viewDate"></p>
    <p id="viewMood"></p>
    <div id="viewText"></div>

  </div>
</div>
</xai:function_call> 




<xai:function_call name="edit_file">
<!-- <parameter name="path">c:/xampp/htdocs/ruhh.2/journal.php -->
</body>

</html>
