<?php
require_once "pdo.php";

session_start();

if ( ! isset($_SESSION['name']) )
{
    die('Not logged in');
}

//
// This checks to make sure required variables are set and if they it then checks
// to make sure there is valid values.
// If all that goes through then it will execute a sql statement to add a new entry
//
if ( isset($_POST['player_name']))
{
  if((strlen($_POST['player_name']) > 1))
  {
    $sql = "INSERT INTO players (player_name, goals, assists)
              VALUES (:player_name, :goals, :assists)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':player_name' => $_POST['player_name'],
        ':goals' => $_POST['goals'],
        ':assists' => $_POST['assists']));

    header('Location: index.php');
    return;
  }
}

//
// Redirects to index.php is cancel is selected
//
if(isset($_POST['cancel']))
{
  header('Location: index.php');
  return;
}

//
// Sends an error is the required variables have invalid values (empty)
//
if ( isset($_POST['player_name']) )
{
  if(strlen($_POST['player_name']) < 1)
  {
    $_SESSION['error'] = "Player name is required";
    header("Location: addPlayer.php");
    return;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Beer League Database</title>

</head>
<body>

<h1>
  Beer League Database
</h1>
<?php
if ( isset($_SESSION['error']))
{
  if ( isset($_SESSION['error']) )
  {
      echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
      unset($_SESSION['error']);
  }
}
?>


<form method="post" id="addForm">
<p>Player Name:
<input type="text" name="player_name" size="60"/></p>
<p>Goals:
<input type="number" step=1 name="goals" size="60"/></p>
<p>Assists:
<input type="number" step=1 name="assists"/></p>
</form>

<input type="submit" value="Add" form="addForm">
<input type="submit" name="cancel" value="Cancel" form="addForm">
</body>
</html>
