<?php
// Connecting to the database
// See the readme for more info on this
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=teams',
   'teams', 'slipknot');

// See the "errors" folder for details...
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Creating the needed table
$pdo->exec('CREATE TABLE IF NOT EXISTS teams (  team_id INTEGER NOT NULL KEY AUTO_INCREMENT,
  team_name VARCHAR(255),  points INTEGER NOT NULL  )
  ENGINE=InnoDB DEFAULT CHARSET=utf8;');

$pdo->exec('CREATE TABLE IF NOT EXISTS players (  player_id INTEGER NOT NULL KEY AUTO_INCREMENT,
  player_name VARCHAR(255),  goals INTEGER NOT NULL, assists INTEGER NOT NULL  )
  ENGINE=InnoDB DEFAULT CHARSET=utf8;');

$pdo->exec('CREATE TABLE IF NOT EXISTS goalies (  goalie_id INTEGER NOT NULL KEY AUTO_INCREMENT,
  goalie_name VARCHAR(255),  wins INTEGER NOT NULL, GAA FLOAT  )
  ENGINE=InnoDB DEFAULT CHARSET=utf8;');
?>
