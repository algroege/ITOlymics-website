<?php // define variables and set to empty values
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
// $teams_generated = 1;
$games = array("Corn-Dosen", "Mario Kart", "Tischkicker", "Tischtennis", "UTV Rennen");
$team_names = array("Argon-Ionen", "CO2", "HeNe", "Nd:YAG", "Titan:Saphir");

//$sql = "SELECT name, corn-dosen, mario kart, tischkicker, tischtennis, utv rennen, totalscore FROM teams ORDER BY totalscore DESC";
$sql = "SELECT name, totalscore FROM teams ORDER BY totalscore DESC";
$result = $conn->query($sql);
  //print_r($result);
  //print_r($team_all);
  //print_r($team_0);
  //$team_0 = $team_all[0][];
  //print_r($team_0);

//$players = array_merge($team_0, $team_1, $team_2, $team_3, $team_4);

// $scores = array(
  // array($team_names[0], -1, 2, 3, 4, 5),
  // array($team_names[1], 9, 2, 3, -1, 5),
  // array($team_names[2], 6, 2, 3, 4, 5),
  // array($team_names[3], 3, 2, 0, 4, -1),
  // array($team_names[4], 1, 2, 3, 4, 5)
// );

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
          <li class="menu"><a class="active" href="index.php">Home</a></li>
          <li class="menu"><a class="menu" href="teams.php">Teams</a></li>
          <li class="menu"><a class="menu" href="index.php">Best Scores</a></li>
          <li class="menu"><a class="menu" href="registerPlayer.php">Spieler Registrieren</a></li>
          <li class="menu_right"><a class="menu" href="game_terminal.php">Game Terminal</a></li>
        </ul>

        <table>
        <thead>
          <tr>
            <th class="table_caption" colspan="7">Total Scores</th>
          </tr>
          <tr>
            <th>Team</th>
            <?php
              $sql = "SELECT id, name FROM games";
              $result = $conn->query($sql);
              $game_ids = array();
              while ($game = $result->fetch_assoc()) {
                $game_ids[] = $game['id'];
                echo "<th>" . $game['name'] . "</th>";
              }
              ?>
            <th>Total</th>
          </tr>
        </thead>
        <tfoot>
          <tr>
            <td class="name" colspan="7">The ITO Games Association</td>
          </tr>
        </tfoot>
        <tbody>
          <?php
            $sql = "SELECT id, name, totalscore FROM teams ORDER BY totalscore DESC";
            $result = $conn->query($sql);
            while ($team = $result->fetch_assoc()) {
              echo "<tr>";
              echo "<td class=\"name\">" . $team['name'] . "</td>";
              $subsql = "select sum(teamscore) gamescore from (select case when team1=" . $team['id'] . " then teamscore1 when team2=" . $team['id'] . " then teamscore2 end teamscore from matches where game=1) s";
              $subresult = $conn->query($subsql)->fetch_assoc();
              echo "<td> " . $subresult['gamescore'] . " </td>";
              $subsql = "select sum(teamscore) gamescore from (select case when team1=" . $team['id'] . " then teamscore1 when team2=" . $team['id'] . " then teamscore2 end teamscore from matches where game=2) s";
              $subresult = $conn->query($subsql)->fetch_assoc();
              echo "<td> " . $subresult['gamescore'] . " </td>";
              $subsql = "select sum(teamscore) gamescore from (select case when team1=" . $team['id'] . " then teamscore1 when team2=" . $team['id'] . " then teamscore2 end teamscore from matches where game=3) s";
              $subresult = $conn->query($subsql)->fetch_assoc();
              echo "<td> " . $subresult['gamescore'] . " </td>";
              $subsql = "select sum(teamscore) gamescore from (select case when team1=" . $team['id'] . " then teamscore1 when team2=" . $team['id'] . " then teamscore2 end teamscore from matches where game=4) s";
              $subresult = $conn->query($subsql)->fetch_assoc();
              echo "<td> " . $subresult['gamescore'] . " </td>";
              $subsql = "select sum(teamscore) gamescore from (select case when team1=" . $team['id'] . " then teamscore1 when team2=" . $team['id'] . " then teamscore2 end teamscore from matches where game=5) s";
              $subresult = $conn->query($subsql)->fetch_assoc();
              echo "<td> " . $subresult['gamescore'] . " </td>";
              echo "<td class=\"total_score\">" . $team['totalscore']. "</td>";
              echo "</tr>";
            }
          ?>
          </tbody>
        </table><br>
        <?php
        // ask matches
        // get all matches for table
        for($k=0; $k < 5; $k++) {
          $game_id = $k+1;
          $sql = "SELECT team1, team2, id, teamscore1, teamscore2, state  FROM matches WHERE game = '$game_id'";
          $result_matches_request = $conn->query($sql);
          ?>
          <div id="table_container_single">
            <table>
            <thead>
              <tr>
                <th class="table_caption" colspan="3"><?php echo $games[$k]?></th>
              </tr>
              <tr>
                <th>Nr.</th>
                <th>alle Matches</th>
                <th>Scores</th>

              </tr>
            </thead>
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
        <br>
        <?php
        }
        ?>
    </body>
</html>
