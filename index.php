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
     <li><a href="addTeam.php">Add a new team</a></li>
     <li><a href="addPlayer.php">Add a new player</a></li>
     <li>
       <a
         <?php
         if(isset($_SESSION['name']))
         {
           echo(' href="logout.php">Logout');
         }
         else {
           echo(' href="login.php">Login');
         }
         ?>
       </a>
     </li>
   </ul>
 </body>
 </html>
