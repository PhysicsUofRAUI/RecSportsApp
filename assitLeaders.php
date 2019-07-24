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
   <h2>Assist Leaders</h2>
   <table border="1">
   <?php
     // retrieve all the entries and display them
     // would prefer to list them in order according to points
     $stmt = $pdo->query("SELECT player_name, assists, player_id FROM players");
     while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
         echo("<tr><td>");
         echo(htmlentities($row['player_name']));
         echo("</td><td>");
         echo(htmlentities($row['assists']));
         echo("</td><td>");
         echo('<a href="edit_player.php?player_id='.$row['player_id'].'">Edit</a>');
         echo("</td></tr>\n");
     }
   ?>
 </table>
 </body>
 </html>
