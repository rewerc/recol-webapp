<?php 
require ("../../AAR/config.php");
if (isset($_GET["username"])) {
    $username = $_GET["username"];
    query("UPDATE aar_users SET clicks = clicks + 1 WHERE uname = '$username'");
}