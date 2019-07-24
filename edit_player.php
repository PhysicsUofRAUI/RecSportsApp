<?php
require_once "pdo.php";
session_start();

if (!isset($_SESSION['name']))
{
  die("ACCESS DENIED");
}

if ( isset($_POST['player_name']))
{
  if((strlen($_POST['player_name']) > 1))
  {
    // The sql command needed
    $sql = "UPDATE players SET player_name = :player_name, goals = :goals, assists = :assists,
              WHERE player_id = :player_id";

    // Using pdo prepared statements to avoid sql injection
    $stmt = $pdo->prepare($sql);

    $stmt->execute(array(
        ':player_name' => $_POST['player_name'],
        ':goals' => $_POST['goals'],
        ':assists' => $_POST['assists'],
        ':team_id' => $_POST['team_id']));

    $_SESSION['success'] = 'Record updated';
    header( 'Location: index.php' ) ;
    return;
  }
}

// Guardian: Make sure that customer_id is present
if ( ! isset($_GET['player_id']) ) {
  $_SESSION['error'] = "Missing id";
  header('Location: index.php');
  return;
}

// getting the entry to edit
$stmt = $pdo->prepare("SELECT * FROM players where player_id = :player_id");
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
$t_name = htmlentities($row['player_name']);
$goals = htmlentities($row['goals']);
$assists = htmlentities($row['assists']);
$team_id = $row['player_id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Beer League Database</title>
</head>
<body>

  <p>Edit team</p>
  <form method="post" id="editForm">
  <input type="hidden" name="player_id" value="<?= $player_id ?>">
  <p>First Name:
  <input type="text" name="player_name" size="60" value="<?= $p_name ?>" /></p>
  <p>Last Name:
  <input type="text" name="goals" size="60" value="<?= $goals ?>" /></p>
  <p>Last Name:
  <input type="text" name="assists" size="60" value="<?= $goals ?>" /></p>
  </form>

  <input type="submit" value="Update" form="editForm">
  <input type="submit" name="cancel" value="Cancel" form="editForm">
</body>
</html>