<?php
/* This page will establish a connection to the database and return a
 * object which represents the connection to the MySQL Server of university or false
 * if an error occurred */
$servername = "etu-web2.ut-capitole.fr";
$username = 21912824;
$pwd = "U01WF5";
header('Content-Type: text/html; charset=utf-8');

return $conn = mysqli_connect($servername, $username, $pwd);


