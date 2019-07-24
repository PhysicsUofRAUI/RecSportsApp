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
if ( isset($_POST['team_name']))
{
  if((strlen($_POST['team_name']) > 1))
  {
    $sql = "INSERT INTO teams (team_name, points)
              VALUES (:team_name, :points)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':team_name' => $_POST['team_name'],
        ':points' => $_POST['points'],));

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
if ( isset($_POST['team_name']) )
{
  if(strlen($_POST['team_name']) < 1)
  {
    $_SESSION['error'] = "Team name is required";
    header("Location: addTeam.php");
    return;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Customer Database</title>

</head>
<body>

<h1>
  Customer Database
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
<p>Team Name:
<input type="text" name="team_name" size="60"/></p>
<p>Points:
<input type="number" step=1 name="points"/></p>
</form>


<input type="submit" value="Add" form="addForm">
<input type="submit" name="cancel" value="Cancel" form="addForm">
</body>
</html>
