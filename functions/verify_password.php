<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
require_once('../class/People/people.php');

use People\people;

$person = new people();
$conn = require_once('connection_db.php');
$user = $_POST['username'];
$pwd = $_POST['password'];
if ($person->verifyPassword($conn, $user, $pwd) == true) {
    $_SESSION['username'] = $user;
    $_SESSION['password'] = $pwd;
    header('location:../index.php');

} else {
    echo "";
    echo "<script>
        setTimeout(function(){window.location.href='../login.php';},2000);
    </script>";
}

