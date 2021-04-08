<?php
session_start();
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
    header('location:../login.php');
}

