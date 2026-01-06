<?php

$servername = "localhost";
$username = "root";
$password = "";
$database = "marwadi_studyspace";

$conn = mysqli_connect($servername,$username,$password, $database);

if(!$conn){
    die("Failed to coneect ".mysqli_connect_error());
}

?>