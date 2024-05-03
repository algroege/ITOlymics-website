<?php
session_start();
// define variables and set to empty values
$maxcols = 5;
$show_login_form = true;
$games = array("Corn-Dosen", "Mario Kart", "Tischkicker", "Tischtennis", "UTV Rennen");
// need team names in decendeing order of PTS

// Test

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $password = $_POST['password'];
  $game_terminal = $_POST['game_terminal'];
  if ($password == "1111" && $game_terminal == $games[0]) {
    $_SESSION['userid'] = "Admin";
    $_SESSION['game_terminal'] = "Corn-Dosen"; // set game here -------------------------------------------------------------------------------------------------
    $_SESSION['game_terminal_id'] = 1; // cd 1 MaKa 2
    echo "<script> location.href='game_terminal.php'; </script>";
    exit();
  } else if ($password == "2222" && $game_terminal == $games[1]) {
    $_SESSION['userid'] = "Admin";
    $_SESSION['game_terminal'] = "Mario Kart"; // set game here -------------------------------------------------------------------------------------------------
    $_SESSION['game_terminal_id'] = 2; // cd 1 MaKa 2
    echo "<script> location.href='game_terminal.php'; </script>";
  } else if ($password == "3333" && $game_terminal == $games[2]) {
    $_SESSION['userid'] = "Admin";
    $_SESSION['game_terminal'] = "Tischkicker"; // set game here -------------------------------------------------------------------------------------------------
    $_SESSION['game_terminal_id'] = 3; // cd 1 MaKa 2
    echo "<script> location.href='game_terminal.php'; </script>";
  } else if ($password == "4444" && $game_terminal == $games[3]) {
    $_SESSION['userid'] = "Admin";
    $_SESSION['game_terminal'] = "Tischtennis"; // set game here -------------------------------------------------------------------------------------------------
    $_SESSION['game_terminal_id'] = 4; // cd 1 MaKa 2
    echo "<script> location.href='game_terminal.php'; </script>";
  } else if ($password == "5555" && $game_terminal == $games[4]) {
    $_SESSION['userid'] = "Admin";
    $_SESSION['game_terminal'] = "UTV Rennen"; // set game here -------------------------------------------------------------------------------------------------
    $_SESSION['game_terminal_id'] = 5; // cd 1 MaKa 2
    echo "<script> location.href='game_terminal.php'; </script>";
  } else if ($password == "generateteams"){
    echo "<script> location.href='create_teams.php'; </script>";
  } else if ($password == "generatematches"){
    echo "<script> location.href='create_matches.php'; </script>";
  } else {
    $errorMessage = "Passwort war ungültig<br>";
  }
}

?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Other/html.html to edit this template
-->
<html>
    <head>
        <title>ITOlympics</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="myCSS.css">
    </head>
    <body> <!-- Build Menu Bar -->
      <ul class="menu">
          <li class="menu"><a class="menu" href="index.php">Home</a></li>
          <li class="menu"><a class="menu" href="teams.php">Teams</a></li>
          <li class="menu"><a class="menu" href="index.php">Best Scores</a></li>
          <li class="menu"><a class="menu" href="registerPlayer.php">Spieler Registrieren</a></li>
          <li class="menu_right"><a class="active" href="game_terminal.php">Game Terminal</a></li>
        </ul>

        <div id = "login_container"><br><br>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <label for="cars">Game:</label><br>
          <select name="game_terminal" id="game_dropdown" width="200px">
            <?php
            for ($i = 0; $i < count($games); $i++) {
              echo "<option value=\"";
              echo $games[$i];
              echo "\">";
              echo  $games[$i];
              echo "</option>";
            }
            ?>
          </select><br><br>
          Password:<br>
          <input type="password" name="password"><br>
          <?php
          if(isset($errorMessage)) {
            echo $errorMessage;
          }
          ?>
          <input type="submit" name="submit" value="Login" id = "login_button">
          </form>
        </div>
    </body>
</html>
