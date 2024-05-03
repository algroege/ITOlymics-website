<?php
set_time_limit(80);
$servername = "localhost";
$username = "multigame";
$password = "JinaVEWKcFwsJVU6";
$dbname = "mg";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$create_query = "INSERT INTO matches(team1,team2,game) VALUES ";
$rand_query = "SELECT id FROM teams ORDER BY RAND() LIMIT 100";


for ($i = 1; $i < 6; $i++) {
  $done = 0;
  while ($done < 1) {
    $prim = $conn->query($rand_query);
    $sec = $conn->query($rand_query);
    $create_list = "";
    $success = True;
    while ($team1 = $prim->fetch_assoc()) {
      $team2 = $sec->fetch_assoc();
      if ($team1['id'] == $team2['id']) {
        $success = False;
        break;
      }
      $create_list = $create_list . "(" . $team1['id'] . "," . $team2['id'] . "," . $i ."), ";
    }
    if (! $success) {
      continue;
    }
    $create_list = substr($create_list, 0, -2);
    $conn->query($create_query . $create_list);
    //sleep(1)
    $done++;
  }
  echo $create_list;
}
echo $create_list;

?>
