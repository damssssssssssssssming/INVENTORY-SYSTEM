<?php
$server = "sql209.infinityfree.com";    
$user = "if0_41254786";                 
$password = "vN4UzVHzH5";             
$dbname = "if0_41254786_inventoryt"; 

$conn = new mysqli($server, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>