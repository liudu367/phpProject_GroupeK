<?php
session_start();
require_once('../class/People/people.php');

use People\people;

$person = new people();
$conn = require_once('connection_db.php');
if ($person->verifyPassword($conn, $_POST['username'], $_POST['password'])
    == true
) {
    $_SESSION['username'] = $_POST['username'];
    $_SESSION['password'] = $_POST['password'];
    header('location:../index.php');
} else {
    header('location:../login.php');
}

