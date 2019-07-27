<?php
require_once "pdo.php";
session_start();

if (!isset($_SESSION['name']))
{
  die("ACCESS DENIED");
}

if ( isset($_POST['goalie_name']))
{
  if((strlen($_POST['goalie_name']) > 1))
  {
    // The sql command needed
    $sql = "UPDATE goalies SET goalie_name = :goalie_name, wins = :wins, GAA = :GAA
              WHERE goalie_id = :goalie_id";

    // Using pdo prepared statements to avoid sql injection
    $stmt = $pdo->prepare($sql);

    $stmt->execute(array(
        ':goalie_name' => $_POST['goalie_name'],
        ':wins' => $_POST['wins'],
        ':GAA' => $_POST['GAA'],
        ':goalie_id' => $_POST['goalie_id']));

    $_SESSION['success'] = 'Record updated';
    header( 'Location: goalieStats.php' ) ;
    return;
  }
}

// Guardian: Make sure that player_id is present
if ( ! isset($_GET['goalie_id']) ) {
  $_SESSION['error'] = "Missing id";
  header('Location: goalieStats.php');
  return;
}

// getting the entry to edit
$stmt = $pdo->prepare("SELECT * FROM goalies where goalie_id = :goalie_id");
$stmt->execute(array(":goalie_id" => $_GET['goalie_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for goalie_id';
    header( 'Location: goalieStats.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

// Run all entries through htmlentities to avoid html injection
$g_name = htmlentities($row['goalie_name']);
$wins = htmlentities($row['wins']);
$GAA = htmlentities($row['GAA']);
$goalie_id = $row['goalie_id'];
?>

<!DOCTYPE html>
<html>
<head>
<title>Beer League Database</title>
</head>
<body>

  <p>Edit Goalie</p>
  <form method="post" id="editForm">
  <input type="hidden" name="goalie_id" value="<?= $goalie_id ?>">
  <p>Goalie Name:
  <input type="text" name="goalie_name" size="60" value="<?= $g_name ?>" /></p>
  <p>Wins:
  <input type="number" step=1 name="wins" value="<?= $wins ?>" /></p>
  <p>GAA:
  <input type="number" step="0.01" name="GAA" value="<?= $GAA ?>" /></p>
  </form>

  <input type="submit" value="Update" form="editForm">
  <input type="submit" name="cancel" value="Cancel" form="editForm">
</body>
</html>
