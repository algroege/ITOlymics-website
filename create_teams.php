<?php

$servername = "localhost";
$username = "multigame";
$password = "JinaVEWKcFwsJVU6";
$dbname = "mg";
// Create connection a
$conn = new mysqli($servername, $username, $password, $dbname);

  $sql = "SELECT id FROM users ORDER BY RAND() LIMIT 100";
  $result = $conn->query($sql);
  $k = 1;
  while ($user = $result->fetch_assoc()) {
    if ($k > 5) {
      $k = 1;
    }
    $var = $user['id'];
    $set_sql = "UPDATE users SET team = '$k' WHERE id = '$var'";
    $conn->query($set_sql);
    $k++;
  }
  echo "Teams wurden generiert";
  $sql = "UPDATE metadata SET value=1 WHERE name='teams_set'";
  $conn->query($sql);
  $conn->close();
?>
