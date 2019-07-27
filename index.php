<?php
  require_once "pdo.php";

  session_start();
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 <title>Beer Legue Database</title>
 </head>
 <body>
   <h1>Welcome to the database for Beer Legues!</h1>
   <ul>
     <li><a href="standings.php">Standings</a></li>
     <li><a href="playerStats.php">How about them players?</a></li>
     <li><a href="goalieStats.php">How about them goalies?</a></li>
         <?php
         if(isset($_SESSION['name']))
         {
           echo('<li><a href="addTeam.php">Add a new team</a></li>');
           echo('<li><a href="addPlayer.php">Add a new player</a></li>');
           echo('<li><a href="addGoalie.php">Add a new goalie</a></li>');
           echo('<li><a href="logout.php">Logout');
         }
         else {
           echo('<li><a href="login.php">Login');
         }
         ?>
       </a>
     </li>
   </ul>
 </body>
 </html>
