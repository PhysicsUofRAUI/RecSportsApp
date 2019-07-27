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
    $sql = "UPDATE players SET player_name = :player_name, goals = :goals, assists = :assists
              WHERE player_id = :player_id";

    // Using pdo prepared statements to avoid sql injection
    $stmt = $pdo->prepare($sql);

    $stmt->execute(array(
        ':player_name' => $_POST['player_name'],
        ':goals' => $_POST['goals'],
        ':assists' => $_POST['assists'],
        ':player_id' => $_POST['player_id']));

    $_SESSION['success'] = 'Record updated';
    header( 'Location: playerStats.php' ) ;
    return;
  }
}

// Guardian: Make sure that player_id is present
if ( ! isset($_GET['player_id']) ) {
  $_SESSION['error'] = "Missing id";
  header('Location: playerStats.php');
  return;
}

// getting the entry to edit
$stmt = $pdo->prepare("SELECT * FROM players where player_id = :player_id");
$stmt->execute(array(":player_id" => $_GET['player_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for player_id';
    header( 'Location: playerStats.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

// Run all entries through htmlentities to avoid html injection
$p_name = htmlentities($row['player_name']);
$goals = htmlentities($row['goals']);
$assists = htmlentities($row['assists']);
$player_id = $row['player_id'];
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
  <p>Player Name:
  <input type="text" name="player_name" size="60" value="<?= $p_name ?>" /></p>
  <p>Goals:
  <input type="number" step=1 name="goals" value="<?= $goals ?>" /></p>
  <p>Assists:
  <input type="number" step=1 name="assists" value="<?= $assists ?>" /></p>
  </form>

  <input type="submit" value="Update" form="editForm">
  <input type="submit" name="cancel" value="Cancel" form="editForm">
</body>
</html>
