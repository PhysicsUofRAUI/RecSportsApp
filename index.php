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

/*
end of W3 Schools Styling
*/

h1 {
  text-align: center;
}

table {
  width: 50%;
  margin-left: 25%;
  margin-right: 25%;
}

body {
  background-image: url("photoOfMyBackyardRinkWithoutTrees.png");
}
</style>
 </head>
 <body>
   <!-- navigation bar designed by W3 schools found here https://www.w3schools.com/howto/howto_js_topnav.asp -->
   <div class="topnav">
     <a class="active" href="index.php">Home</a>
     <a href="playerStats.php">Player Stats</a>
     <a href="standings.php">Standings</a>
     <a href="goalieStats.php">Goalie Stats</a>
     <?php
     if(isset($_SESSION['name']))
     {
       echo('<a href="addTeam.php">Add a new team</a>');
       echo('<a href="addPlayer.php">Add a new player</a>');
       echo('<a href="addGoalie.php">Add a new goalie</a>');
       echo('<a href="logout.php">Logout</a>');
     }
     else {
       echo('<a href="login.php">Login</a>');
     }
     ?>
  </div>
   <h1>Welcome to the database for Beer Legues!</h1>
 </body>
 </html>
