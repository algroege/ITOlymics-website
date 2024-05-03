<?php
session_start();
if(!isset($_SESSION['userid'])) {
  echo "<script> location.href='game_terminal_login.php'; </script>";
  exit();
}

$servername = "localhost";
$username = "multigame";
$password = "JinaVEWKcFwsJVU6";
$dbname = "mg";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


if(!isset($_SESSION['player_0_team_0'])) {
  die("keine Daten erhalten");
}
//send data to databease
// Update Matches
$games = array("Corn-Dosen", "Mario Kart", "Tischkicker", "Tischtennis", "UTV Rennen");
$team_names = array("Argon-Ionen", "CO2", "HeNe", "Nd:YAG", "Titan:Saphir");
// Update points for players

$user11 = $_SESSION['player_0_team_0'];
$user12 = $_SESSION['player_1_team_0'];
$user21 = $_SESSION['player_0_team_1'];
$user22 = $_SESSION['player_1_team_1'];

$id = $_SESSION['match_id'];

$userscore11 = $_SESSION['player_0_team_0_score'];
$userscore12 = $_SESSION['player_1_team_0_score'];
$userscore21 = $_SESSION['player_0_team_1_score'];
$userscore22 = $_SESSION['player_1_team_1_score'];

$teamscore1 = 0;
$teamscore2 = 0;

$success = false;

/*
[id] => 1
[user11] =>
[user12] =>
[user21] =>
[user22] =>
[teamscore1] => 0
[teamscore2] => 0
[userscore11] => 0
[userscore12] => 0
[userscore21] => 0
[userscore22] => 0
[game] => 1
[team1] => 4
[team2] => 1
[state] => 0
*/
if ($_SESSION['game_terminal_id'] == 1 || $_SESSION['game_terminal_id'] == 4 || $_SESSION['game_terminal_id'] == 5) { // Corndosen oder Tischtennis oder UTV
  if ($userscore11 > $userscore21 && $userscore12 > $userscore22) {
    $teamscore1 = 3;
  } else if ($userscore11 < $userscore21 && $userscore12 < $userscore22) {
    $teamscore2 = 3;
  } else {
    $teamscore1 = 1;
    $teamscore2 = 1;
  }
}


if ($_SESSION['game_terminal_id'] == 2) { // Mario Kart

  if (($userscore11 + $userscore12) < 3) {
    $teamscore1 = 3;
  } else if (3 > ($userscore21 + $userscore22)) {
    $teamscore2 = 3;
  } else {
    $teamscore1 = 1;
    $teamscore2 = 1;
  }
}
if ($_SESSION['game_terminal_id'] == 3) { // Tischkicker
  $userscore11 = $userscore12;
  $userscore21 = $userscore22;
  if ($userscore12 > $userscore22) {
    $teamscore1 = 3;
  } else if ($userscore12 < $userscore22) {
    $teamscore2 = 3;
  } else {
    $teamscore1 = 1;
    $teamscore2 = 1;
  }
}


$sql = "UPDATE matches SET ";
$sql .= "user11 = $user11, ";
$sql .= "user21 = $user21, ";
$sql .= "user12 = $user12, ";
$sql .= "user22 = $user22, ";
$sql .= "userscore11 = $userscore11, ";
$sql .= "userscore12 = $userscore12, ";
$sql .= "userscore21 = $userscore21, ";
$sql .= "userscore22 = $userscore22, ";
$sql .= "teamscore1 = $teamscore1, ";
$sql .= "teamscore2 = $teamscore2, ";
$sql .= "state = 1 ";
$sql .= "WHERE id=$id";

if($conn->query($sql)) {
  echo "Record updated successfully";
  $success = true;
} else {
  echo "Error updating record: " . $conn->error;
}


// Delete all Session Variables we dont need anymore

unset($_SESSION['player_0_team_0']);
unset($_SESSION['player_1_team_0']);
unset($_SESSION['player_0_team_1']);
unset($_SESSION['player_1_team_1']);

unset($_SESSION['player_0_team_0_score']);
unset($_SESSION['player_1_team_0_score']);
unset($_SESSION['player_0_team_1_score']);
unset($_SESSION['player_1_team_1_score']);
unset($_SESSION['match_id']);


// redirect to game_terminal
if ($success) {
  echo "<script> location.href='game_terminal.php'; </script>";
}
$conn->close();
?>
