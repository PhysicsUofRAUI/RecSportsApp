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
     <li><a href="goalLeaders.php">Who is putting the Puck in the net?</a></li>
     <li><a href="assitLeaders.php">What about helpers?</a></li>
     <li><a href="goalieWins.php">Who is the best backstopper?</a></li>
     <li><a href="addTeam.php">Add a new team</a></li>
     <li><a href="addPlayer.php">Add a new team</a></li>
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
