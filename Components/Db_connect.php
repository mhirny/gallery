<?php
function dbConnect ($servername = "localhost", $username = "root", $password = "", $db = "gallery") {
  $conn = mysqli_connect($servername, $username, $password, $db) or die("Connection failed: " . mysqli_connect_error());
  return $conn;
}
?>