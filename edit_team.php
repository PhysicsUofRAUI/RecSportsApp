<?php
require_once "pdo.php";
session_start();

if (!isset($_SESSION['name']))
{
  die("ACCESS DENIED");
}

if ( isset($_POST['team_name']))
{
  if((strlen($_POST['team_name']) > 1))
  {
    // The sql command needed
    $sql = "UPDATE teams SET team_name = :team_name, points = :points
              WHERE team_id = :team_id";

    // Using pdo prepared statements to avoid sql injection
    $stmt = $pdo->prepare($sql);

    $stmt->execute(array(
        ':team_name' => $_POST['team_name'],
        ':points' => $_POST['points'],
        ':team_id' => $_POST['team_id']));

    $_SESSION['success'] = 'Record updated';
    header( 'Location: standings.php' ) ;
    return;
  }
}

// Guardian: Make sure that customer_id is present
if ( ! isset($_GET['team_id']) ) {
  $_SESSION['error'] = "Missing id";
  header('Location: index.php');
  return;
}

// getting the entry to edit
$stmt = $pdo->prepare("SELECT * FROM teams where team_id = :team_id");
$stmt->execute(array(":team_id" => $_GET['team_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for team_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

// Run all entries through htmlentities to avoid html injection
$t_name = htmlentities($row['team_name']);
$points = htmlentities($row['points']);
$team_id = $row['team_id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Beer League Database</title>
</head>
<body>

  <p>Edit team</p>
  <form method="post" id="editForm">
  <input type="hidden" name="team_id" value="<?= $team_id ?>">
  <p>Team Name:
  <input type="text" name="team_name" size="60" value="<?= $t_name ?>" /></p>
  <p>Points:
  <input type="number" step=1 name="points" value="<?= $points ?>" /></p>
  </form>

  <input type="submit" value="Update" form="editForm">
  <input type="submit" name="cancel" value="Cancel" form="editForm">
</body>
</html>
