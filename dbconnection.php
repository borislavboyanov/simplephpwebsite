<?php
  $dbServername = "localhost";
  $dbUsername = "root";
  $dbPassword = "";
  $dbName = "diplomnarabota";

  // Create connection
  $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

  // Check connection
  if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
  }

  if(!isset($_SESSION)) {
session_start();
}
?>
