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

$sql = "SELECT value FROM metadata WHERE name = 'teams_set'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$teams_generated = $row['value'];
//$teams_generated = 1;
if (!$teams_generated) {
  $sql = "SELECT firstname, lastname FROM users";
  $result = $conn->query($sql);
} else {
  // get all players from each team
  //$sql = "SELECT name FROM teams WHERE id = 1";
  //$result = $conn->query($sql);
  //while($row = $result->fetch_assoc()) {
  //  $team_0_name = $row['name'];
  //}
  $team_names = array("Argon-Ionen", "CO2", "HeNe", "Nd:YAG", "Titan:Saphir");
  //$team_all = array(array());
  $team_0 = array();
  $sql = "SELECT firstname, lastname FROM users WHERE team = 1";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()) {
    $team_0[] = $row['firstname'] . " " . $row['lastname'];
  }
  $team_1 = array();
  $sql = "SELECT firstname, lastname FROM users WHERE team = 2";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()) {
    $team_1[] = $row['firstname'] . " " . $row['lastname'];
  }
  $team_2 = array();
  $sql = "SELECT firstname, lastname FROM users WHERE team = 3";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()) {
    $team_2[] = $row['firstname'] . " " . $row['lastname'];
  }
  $team_3 = array();
  $sql = "SELECT firstname, lastname FROM users WHERE team = 4";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()) {
    $team_3[] = $row['firstname'] . " " . $row['lastname'];
  }
  $team_4 = array();
  $sql = "SELECT firstname, lastname FROM users WHERE team = 5";
  $result = $conn->query($sql);
  while($row = $result->fetch_assoc()) {
    $team_4[] = $row['firstname'] . " " . $row['lastname'];
  }
  $maxrows = max(count($team_0), count($team_1), count($team_2), count($team_3), count($team_4));
  //print_r($team_all);
  //print_r($team_0);
  //$team_0 = $team_all[0][];
  //print_r($team_0);
}
$maxcols = 5;
//$players = array_merge($team_0, $team_1, $team_2, $team_3, $team_4);
$conn->close();
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
          <li class="menu"><a class="active" href="teams.php">Teams</a></li>
          <li class="menu"><a class="menu" href="index.php">Best Scores</a></li>
          <li class="menu"><a class="menu" href="registerPlayer.php">Spieler Registrieren</a></li>
          <li class="menu_right"><a class="menu" href="game_terminal.php">Game Terminal</a></li>
        </ul>

        <table>
        <?php
        if($teams_generated) {
          ?>
          <thead>
            <tr>
              <th class="table_caption" colspan="5">Teams</th>
            </tr>
            <tr>
              <th><?php echo $team_names[0];?></th>
              <th><?php echo $team_names[1];?></th>
              <th><?php echo $team_names[2];?></th>
              <th><?php echo $team_names[3];?></th>
              <th><?php echo $team_names[4];?></th>

            </tr>
          </thead>
          <tfoot>
            <tr>
              <td class="name" colspan="7">The ITO Games Association</td>
            </tr>
          </tfoot>
          <tbody>
          <?php
          // biuld Teams and Names
          $k = 0;
          while ($k < $maxrows) {
            echo "<tr>";
            echo "<td>";
            if ($k < count($team_0)) {
              echo $team_0[$k];
            }
            echo "</td><td>";
            if ($k < count($team_1)) {
              echo $team_1[$k];
            }
            echo "</td><td>";
            if ($k < count($team_2)) {
              echo $team_2[$k];
            }
            echo "</td><td>";
            if ($k < count($team_3)) {
              echo $team_3[$k];
            }
            echo "</td><td>";
            if ($k < count($team_4)) {
              echo $team_4[$k];
            }
            echo "</td>";
            echo "</tr>";
            $k++;
          }
        } else {
        // Still registering new Players, teams not yet created
        ?>
        <thead>
          <tr>
            <th class="table_caption" colspan="5">Registrierte Spieler</th>
          </tr>
        </thead>
        <tbody>
        <?php
          echo "<tr>";
          $k = 0;
          $i = 0;
          if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
              if ($i == $maxcols) {
                $i = 0;
                echo "</tr><tr>";
              }
              echo "<td class=\"name\">";
              echo $row['firstname'] . " " . $row['lastname'];
              echo "</td>";
              $i++;
              $k++;
            }
            echo "</tr>";
          }?>
        <?php
       }?>
          </tbody>
        </table>
    </body>
</html>
