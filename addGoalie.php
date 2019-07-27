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
if ( isset($_POST['goalie_name']))
{
  if((strlen($_POST['goalie_name']) > 1))
  {
    $sql = "INSERT INTO goalies (goalie_name, wins, GAA)
              VALUES (:goalie_name, :wins, :GAA)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':goalie_name' => $_POST['goalie_name'],
        ':wins' => $_POST['wins'],
        ':GAA' => $_POST['GAA']));

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
if ( isset($_POST['goalie_name']) )
{
  if(strlen($_POST['goalie_name']) < 1)
  {
    $_SESSION['error'] = "Goalie name is required";
    header("Location: addGoalie.php");
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
<p>Goalie Name:
<input type="text" name="goalie_name" size="60"/></p>
<p>Wins:
<input type="number" step=1 name="wins" size="60"/></p>
<p>GAA:
<input type="number" step="0.01" name="GAA"/></p>
</form>

<input type="submit" value="Add" form="addForm">
<input type="submit" name="cancel" value="Cancel" form="addForm">
</body>
</html>
