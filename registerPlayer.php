<?php
// define variables and set to empty values
$servername = "localhost";
$username = "multigame";
$password = "JinaVEWKcFwsJVU6";
$dbname = "mg";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$name = $surname = $group = "";
$sql = "SELECT value FROM metadata WHERE name = 'teams_set'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$teams_generated = $row['value'];
if ($teams_generated) {
  echo "<script> location.href='index.php'; </script>";
}
$show_registration_form = true;
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = test_input($_POST["name"]);
  $surname = test_input($_POST["surname"]);
  $group = test_input($_POST["group"]);
  //check for name in Database
  //$sql = "SELECT id FROM users where firstname like \"" . $name . "\" and lastname like \"" . $surname\";
  $sql = "SELECT id FROM users WHERE firstname='$name' and lastname='$surname'";
  $result = $conn->query($sql);
  if ($result->num_rows > 0) {
    $erroer_entry_exists = "Name oder Nachname bereits vorhanden";
  } else {
    //insert new Player in Database
    $sql = "INSERT INTO users (firstname, lastname, itogroup, team)
    VALUES ('$name', '$surname', '$group', '0')";

    if ($conn->query($sql) === TRUE) {
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $show_registration_form = false;
  }
}
function test_input($data) {
 $data = trim($data);
 $data = stripslashes($data);
 $data = htmlspecialchars($data);
 return $data;
}
?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/ClientSide/html.html to edit this template
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
          <li class="menu"><a class="active" href="registerPlayer.php">Spieler Registrieren</a></li>
          <li class="menu_right"><a class="menu" href="game_terminal.php">Game Terminal</a></li>
        </ul>
        <div id="register_container">
          <div id="register_title">Registrieren</div>
          <?php
          if($show_registration_form) {
          ?>
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <?php
          if(isset($erroer_entry_exists)) {
            echo $erroer_entry_exists;
          }
          ?>
              <label for="fname">Vorname:</label><br>
              <input type="text" id="fname" name="name" size="15" value="" required><br><br>
              <label for="lname">Nachname:</label><br>
              <input type="text" id="lname" name="surname" size="15" value="" required><br><br>
              <label for="lname">Gruppe:</label><br>
              <select name="group" id="player_dropdown" width="300">
                <option value="gast">Gast</option>
                <option value="student">Student*in</option>
                <option value="3do">3DO</option>
                <option value="hms">HMS</option>
                <option value="ide">IDE</option>
                <option value="kom">KOM</option>
                <option value="ods">ODS</option>
                <option value="verwaltung">Verwaltung</option>
              </select><br><br>
              <input type="reset" value="reset">
              <input type="submit" value="Submit">
          </form>
          <?php
        } else {
          ?>
          <div id="text">Hallo <?php echo $name ?>, <br><br>
            Du bist registriert :)<br><br>
            zu den <a href="teams.php">Teams</a></div>
        <?php
        }
        ?>
        </div>
    </body>
</html>
