<?php
  require_once "pdo.php";

  session_start();
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 <title>Beer Legue Database</title>
 <style>

/*
This styling was found at W3Schools and can be found here https://www.w3schools.com/howto/howto_js_topnav.asp
*/
 .topnav {
  overflow: hidden;
  background-color: #333;
}

.topnav a {
  float: left;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #ddd;
  color: black;
}

.topnav a.active {
  background-color: #4CAF50;
  color: white;
}
</style>
 </head>
 <body>
   <!-- navigation bar designed by W3 schools found here https://www.w3schools.com/howto/howto_js_topnav.asp -->
   <div class="topnav">
     <a class="active" href="index.php">Home</a>
     <a href="playerStats.php">Player Stats</a>
     <a href="standings.php">Standings</a>
     <a href="#goalieStats">Goalie Stats</a>
  </div>

  <!-- end of W3 schools design -->
   <h1>Player Stats</h1>
   <table border="1" id="PlayerStats">
     <th onclick="sortTable(0)">Player Name</th><th onclick="sortTable(1)">Goals</th><th onclick="sortTable(2)">Assists</th><th>Edit</th>
   <?php
     // retrieve all the entries and display them
     // would prefer to list them in order according to points
     $stmt = $pdo->query("SELECT player_name, goals, assists, player_id FROM players");
     while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {
         echo("<tr><td>");
         echo(htmlentities($row['player_name']));
         echo("</td><td>");
         echo(htmlentities($row['goals']));
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

 <!-- The following code has been copied from W3 Schools and can be found at this
 link https://www.w3schools.com/howto/howto_js_sort_table.asp
 In the above code I call this function to sort a table based on the assists, goals, or player name
 -->
 <script>
 function sortTable(n) {
   var table, rows, switching, i, x, y, shouldSwitch, dir, switchcount = 0;
   table = document.getElementById("PlayerStats");
   switching = true;
   // Set the sorting direction to ascending:
   dir = "asc";
   /* Make a loop that will continue until
   no switching has been done: */
   while (switching) {
     // Start by saying: no switching is done:
     switching = false;
     rows = table.rows;
     /* Loop through all table rows (except the
     first, which contains table headers): */
     for (i = 1; i < (rows.length - 1); i++) {
       // Start by saying there should be no switching:
       shouldSwitch = false;
       /* Get the two elements you want to compare,
       one from current row and one from the next: */
       x = rows[i].getElementsByTagName("TD")[n];
       y = rows[i + 1].getElementsByTagName("TD")[n];
       /* Check if the two rows should switch place,
       based on the direction, asc or desc: */
       if (dir == "asc") {
         if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
           // If so, mark as a switch and break the loop:
           shouldSwitch = true;
           break;
         }
       } else if (dir == "desc") {
         if (x.innerHTML.toLowerCase() < y.innerHTML.toLowerCase()) {
           // If so, mark as a switch and break the loop:
           shouldSwitch = true;
           break;
         }
       }
     }
     if (shouldSwitch) {
       /* If a switch has been marked, make the switch
       and mark that a switch has been done: */
       rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
       switching = true;
       // Each time a switch is done, increase this count by 1:
       switchcount ++;
     } else {
       /* If no switching has been done AND the direction is "asc",
       set the direction to "desc" and run the while loop again. */
       if (switchcount == 0 && dir == "asc") {
         dir = "desc";
         switching = true;
       }
     }
   }
 }
 </script>
 <!-- end of W3 code -->
