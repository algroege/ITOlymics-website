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

//Abfrage der Nutzer ID vom Login
$userid = $_SESSION['userid'];
$game_terminal = $_SESSION['game_terminal']; //------------------------------------------------- ACTIVATE
$game_id = $_SESSION['game_terminal_id'];
// define variables and set to empty values
$maxcols = 5;
$show_login_form = true;
$games = array("Corn-Dosen", "Mario Kart", "Tischkicker", "Tischtennis", "UTV Rennen");
// need team names in decendeing order of PTS
$team_names = array("Argon-Ionen", "CO2", "HeNe", "Nd:YAG", "Titan:Saphir");

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
// get this from database
$sql = "SELECT team1, team2, id FROM matches WHERE game = '$game_id' AND state = 0";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
/*
while($row = $result->fetch_assoc()) {
  print_r($row);
}*/
// used in this oci_free_descriptor
$team_0_id = $row['team1'];
$team_1_id = $row['team2'];
$team_0 = $team_names[$team_0_id-1];
$team_1 = $team_names[$team_1_id-1];

$match_id = $row['id'];

$sql = "SELECT firstname, lastname, id FROM users WHERE team = '$team_0_id'";
$result = $conn->query($sql);
$players_team_0 = array();
$player_id_team_0 = array();
while($row = $result->fetch_assoc()) {
  $players_team_0[] = $row['firstname'] . " " . $row['lastname'];
  $player_id_team_0[] = $row['id'];
}

$sql = "SELECT firstname, lastname, id FROM users WHERE team = '$team_1_id'";
$result = $conn->query($sql);
$players_team_1 = array();
$player_id_team_1 = array();
while($row = $result->fetch_assoc()) {
  $players_team_1[] = $row['firstname'] . " " . $row['lastname'];
  $player_id_team_1[] = $row['id'];
}

$players_team_all = array_merge($players_team_0, $players_team_1);
$player_id_all = array_merge($player_id_team_0, $player_id_team_1);


// get all matches for table
$sql = "SELECT team1, team2, id, teamscore1, teamscore2, state  FROM matches WHERE game = '$game_id'";
$result_matches_request = $conn->query($sql);

// Handle Data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $player_0_team_0 = $_POST["player_0_team_0"];
  $player_1_team_0 = $_POST["player_1_team_0"];
  $player_0_team_1 = $_POST["player_0_team_1"];
  $player_1_team_1 = $_POST["player_1_team_1"];
  // Scores
  $player_0_team_0_score = $_POST["player_0_team_0_score"];
  $player_1_team_0_score = $_POST["player_1_team_0_score"];
  $player_0_team_1_score = $_POST["player_0_team_1_score"];
  $player_1_team_1_score = $_POST["player_1_team_1_score"];

  // safe Vars in Session:
  $_SESSION['match_id'] = $match_id;
  $_SESSION['player_0_team_0'] = $player_0_team_0;
  $_SESSION['player_1_team_0'] = $player_1_team_0;
  $_SESSION['player_0_team_1'] = $player_0_team_1;
  $_SESSION['player_1_team_1'] = $player_1_team_1;

  $_SESSION['player_0_team_0_score'] = $player_0_team_0_score;
  $_SESSION['player_1_team_0_score'] = $player_1_team_0_score;
  $_SESSION['player_0_team_1_score'] = $player_0_team_1_score;
  $_SESSION['player_1_team_1_score'] = $player_1_team_1_score;


  // activate popup
  $show_popup = true;


}
$conn->close();

function get_username_by_id($user_id) {
  $servername = "localhost";
  $username = "multigame";
  $password = "JinaVEWKcFwsJVU6";
  $dbname = "mg";
  $conn = new mysqli($servername, $username, $password, $dbname);
  $sql = "SELECT firstname, lastname FROM users WHERE id = $user_id";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $conn->close();
  $res = $row['firstname'] . " " . $row['lastname'];
  return  $res;
}

function get_teamname_by_user_id($user_id, $team_names) {
  $servername = "localhost";
  $username = "multigame";
  $password = "JinaVEWKcFwsJVU6";
  $dbname = "mg";
  $conn = new mysqli($servername, $username, $password, $dbname);
  $sql = "SELECT team FROM users WHERE id = $user_id";
  $result = $conn->query($sql);
  $row = $result->fetch_assoc();
  $conn->close();
  $res = $row['team'];
  $res = $team_names[$res-1];
  return  $res;
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
       <div id="overlay"></div>
        <ul class="menu">
          <li class="menu"><a class="menu" href="index.php">Home</a></li>
          <li class="menu"><a class="menu" href="teams.php">Teams</a></li>
          <li class="menu"><a class="menu" href="index.php">Best Scores</a></li>
          <li class="menu"><a class="menu" href="registerPlayer.php">Spieler Registrieren</a></li>
          <li class="menu_right"><a class="active" href="logout.php">Logout</a></li>
        </ul>
        <div id="game_terminal_title"><?php echo $game_terminal ?></div>
        <!-- Ab hier unterscheiden -->
        <!-- Ab hier unterscheiden -->
        <!-- Ab hier unterscheiden -->
        <?php
        if($game_terminal == $games[0] || $game_terminal == $games[3] || $game_terminal == $games[4] || $game_terminal == $games[1]) { //--------------------------------------------------------Tt CD UTV Mario
        ?>
        <div id="game_terminal_container">
          <div id="match_container">
            <div id="match_title">aktuelles Match</div>
            <div id="match_teams"><?php echo $team_0 ?> vs. <?php echo $team_1 ?></div>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off"><br>
              <!--select player 1 team 1 -->
              <select name="player_0_team_0" id="player_dropdown" width="200" required>
                  <option hidden disabled selected value>-</option>
                  <optgroup label="<?php echo $team_0 ?>">
                  <?php
                  for ($i = 0; $i < count($players_team_0); $i++) {
                    echo "<option value=\"";
                    echo $player_id_team_0[$i];
                    echo "\">";
                    echo  $players_team_0[$i];
                    echo "</option>";
                  }
                  ?>
                  </optgroup>
              </select>
              <span>vs.</span>
              <!--select player 1 team 2 -->
              <select name="player_0_team_1" id="player_dropdown" required>
                <option hidden disabled selected value>-</option>
                <optgroup label="<?php echo $team_1 ?>">
                  <?php
                  for ($i = 0; $i < count($players_team_1); $i++) {
                    echo "<option value=\"";
                    echo $player_id_team_1[$i];
                    echo "\">";
                    echo  $players_team_1[$i];
                    echo "</option>";
                  }
                  ?>
                </optgroup>
              </select>
              <div id="score_container">
                <input type="text" class="match_score" name="player_0_team_0_score" value="" size="1" required>
                <span>:</span>
                <input type="text" class="match_score" name="player_0_team_1_score" value="" size="1" required><br>
              </div>
              <!--select player 2 team 1 -->
              <select name="player_1_team_0" id="player_dropdown" required>
                <option hidden disabled selected value>-</option>
                <optgroup label="<?php echo $team_0 ?>">
                  <?php
                  for ($i = 0; $i < count($players_team_0); $i++) {
                    echo "<option value=\"";
                    echo $player_id_team_0[$i];
                    echo "\">";
                    echo  $players_team_0[$i];
                    echo "</option>";
                  }
                  ?>
                </optgroup>
              </select>
              <span>vs.</span>
              <!--select player 2 team 2 -->
              <select name="player_1_team_1" id="player_dropdown" required>
                <option hidden disabled selected value>-</option>
                <optgroup label="<?php echo $team_1 ?>">
                  <?php
                  for ($i = 0; $i < count($players_team_1); $i++) {
                    echo "<option value=\"";
                    echo $player_id_team_1[$i];
                    echo "\">";
                    echo  $players_team_1[$i];
                    echo "</option>";
                  }
                  ?>
                </optgroup>
                <!--select player 2 team 1 -->
              </select>
              <div id="score_container">
                <input type="text" class="match_score" name="player_1_team_0_score" value="" size="1" required>
                <span>:</span>
                <input type="text" class="match_score" name="player_1_team_1_score" value="" size="1" required><br>
              </div>
              <input type="submit" id = "submit_button" value="Submit">
            </form>
          </div>
        <?php
      } else if ($game_terminal == $games[2]) { //------------------------------------------------------------------------------------------------------------------------Tischkicker
      ?>
      <div id="game_terminal_container">
        <div id="match_container">
          <div id="match_title">aktuelles Match</div>
          <div id="match_teams"><?php echo $team_0 ?> vs. <?php echo $team_1 ?></div>
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off"><br>
            <!--select player 1 team 1 -->
            <select name="player_0_team_0" id="player_dropdown" width="200" required>
              <option hidden disabled selected value>-</option>
              <optgroup label="<?php echo $team_0 ?>">
                <?php
                for ($i = 0; $i < count($players_team_0); $i++) {
                  echo "<option value=\"";
                  echo $player_id_team_0[$i];
                  echo "\">";
                  echo  $players_team_0[$i];
                  echo "</option>";
                }
                ?>
              </optgroup>
            </select>
            <span>vs.</span>
            <!--select player 1 team 2 -->
            <select name="player_0_team_1" id="player_dropdown" required>
              <option hidden disabled selected value>-</option>
              <optgroup label="<?php echo $team_1 ?>">
                <?php
                for ($i = 0; $i < count($players_team_1); $i++) {
                  echo "<option value=\"";
                  echo $player_id_team_1[$i];
                  echo "\">";
                  echo  $players_team_1[$i];
                  echo "</option>";
                }
                ?>
              </optgroup>
            </select><br>
            <!--select player 2 team 1 -->
            <select name="player_1_team_0" id="player_dropdown" required>
              <option hidden disabled selected value>-</option>
              <optgroup label="<?php echo $team_0 ?>">
                <?php
                for ($i = 0; $i < count($players_team_0); $i++) {
                  echo "<option value=\"";
                  echo $player_id_team_0[$i];
                  echo "\">";
                  echo  $players_team_0[$i];
                  echo "</option>";
                }
                ?>
              </optgroup>
            </select>
            <span>vs.</span>
            <!--select player 2 team 2 -->
            <select name="player_1_team_1" id="player_dropdown" required>
              <option hidden disabled selected value>-</option>
              <optgroup label="<?php echo $team_1 ?>">
                <?php
                for ($i = 0; $i < count($players_team_1); $i++) {
                  echo "<option value=\"";
                  echo $player_id_team_1[$i];
                  echo "\">";
                  echo  $players_team_1[$i];
                  echo "</option>";
                }
                ?>
              </optgroup>
              <!--select player 2 team 1 -->
            </select>
            <div id="score_container">
              <input type="text" class="match_score" name="player_1_team_0_score" value="" size="1" required>
              <input type="text" name="player_0_team_0_score" value="0" size="1" hidden>
              <span>:</span>
              <input type="text" class="match_score" name="player_1_team_1_score" value="" size="1" required><br>
              <input type="text" name="player_0_team_1_score" value="0" size="1" hidden>
            </div>
            <input type="submit" id = "submit_button" value="Submit">
          </form>
        </div>
      <?php
    } else if ($game_terminal == $games[111]){  //------------------------------------------------------------------------------------------------------------------------Mario Kart
      ?>
      <div id="game_terminal_container">
        <div id="match_container">
          <div id="match_title">aktuelles Match</div>
          <div id="match_teams"><?php echo $team_0 ?> vs. <?php echo $team_1 ?></div>
          <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" autocomplete="off"><br>
            <!--select player 1 team 1 -->
            <span>  1.    </span>
            <input type="text" name="player_0_team_0_score" value="1" size="1" hidden>
            <select name="player_0_team_0" id="player_dropdown" width="200" required>
                <option hidden disabled selected value>-</option>
                <?php
                for ($i = 0; $i < count($players_team_all); $i++) {
                  echo "<option value=\"";
                  echo $player_id_all[$i];
                  echo "\">";
                  echo  $players_team_all[$i];
                  echo "</option>";
                }
                ?>
            </select><br><br>
            <span>  2.    </span>
            <input type="text" name="player_0_team_1_score" value="2" size="1" hidden>
            <select name="player_0_team_1" id="player_dropdown" required>
                <option hidden disabled selected value>-</option>
                <?php
                for ($i = 0; $i < count($players_team_all); $i++) {
                  echo "<option value=\"";
                  echo $player_id_all[$i];
                  echo "\">";
                  echo  $players_team_all[$i];
                  echo "</option>";
                }
                ?>
            </select><br><br>
            <span>  3.    </span>
            <input type="text" name="player_1_team_0_score" value="3" size="1" hidden>
            <select name="player_1_team_0" id="player_dropdown" required>
                <option hidden disabled selected value>-</option>
                <?php
                for ($i = 0; $i < count($players_team_all); $i++) {
                  echo "<option value=\"";
                  echo $player_id_all[$i];
                  echo "\">";
                  echo  $players_team_all[$i];
                  echo "</option>";
                }
                ?>
            </select><br><br>
            <span>  4.    </span>
            <input type="text" name="player_1_team_1_score" value="4" size="1" hidden>
            <select name="player_1_team_1" id="player_dropdown" required>
                <option hidden disabled selected value>-</option>
                <?php
                for ($i = 0; $i < count($players_team_all); $i++) {
                  echo "<option value=\"";
                  echo $player_id_all[$i];
                  echo "\">";
                  echo  $players_team_all[$i];
                  echo "</option>";
                }
                ?>
              <!--select player 2 team 1 -->
            </select><br><br>
            <span>   </span>
            <input type="submit" id = "submit_button" value="Submit">
          </form>
        </div>

      <?php
    }
    ?>
          <div id="table_container">
            <table>
            <thead>
              <tr>
                <th>Nr.</th>
                <th>alle Matches</th>
                <th>Scores</th>

              </tr>
            </thead>
            <tfoot>
              <tr>
                <td class="name" colspan="3">The ITO Games Association</td>
              </tr>
            </tfoot>
            <tbody>
              <?php
              $i = 1;
              while($row = $result_matches_request->fetch_assoc()){
                echo "<tr>";
                echo "<td>" . $i . "</td>";
                echo "<td>" . $team_names[$row['team1']-1] . " vs. " . $team_names[$row['team2']-1] . "</td>";
                echo "<td>";
                if ($row['state']) {
                  echo $row['teamscore1'] . ":" . $row['teamscore2'];
                }
                echo "</td>";
                echo "</tr>";
                $i++;
              }
              ?>
              </tbody>
            </table>
          </div>
        </div>
        <?php
        if(isset($show_popup)) {
          ?>
          <div class="callout" id = "popup">
            <?php
            echo $player_0_team_0;
            echo $player_0_team_1;
            echo $player_1_team_0;
            echo $player_1_team_1;
            ?>
            <div class="callout-header">Ergebnis absenden?</div>
            <span class="closebtn" onclick="hidePopup()">×</span>
            <div class="callout-container">
              <div class="submit_overview"><?php echo get_username_by_id($player_0_team_0) ?> vs. <?php echo get_username_by_id($player_0_team_1) ?></div>
              <div class="submit_overview"><?php echo $player_0_team_0_score ?>:<?php echo $player_0_team_1_score ?></div><br>
              <div class="submit_overview"><?php echo get_username_by_id($player_1_team_0) ?> vs. <?php echo get_username_by_id($player_1_team_1) ?></div>
              <div class="submit_overview"><?php echo $player_1_team_0_score ?>:<?php echo $player_1_team_1_score ?></div>
              <form method="post" action="insert_match_result.php">
                <input type="submit" id = "insert_match_result_button" value="Submit">
              </form>
            </div>
          </div>
          <script>
            x = document.getElementById('overlay');
            x.style.display = 'block';

            function hidePopup() {
              x = document.getElementById('overlay');
              x.style.display = 'none';

              x = document.getElementById('popup');
              x.style.display = 'none';
            }
          </script>
        <?php
        }
        ?>

  </body>
</html>
