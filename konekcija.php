<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "forum_c";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
  die("Greska pri konekciji: " . mysqli_connect_error());
}
$konekcija = "Uspesno konektovan";
?>