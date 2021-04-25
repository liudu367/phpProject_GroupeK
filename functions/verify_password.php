<?php
/* this page will verify the password and the username of this user,
if all of these is true, it will redirect to the home page
else it will get back to the login page.
 * */
session_start();
header('Content-Type: text/html; charset=utf-8');
require_once('../class/People/people.php');
$conn = require_once('connection_db.php');


use People\people;

$person = new people();


$user = $_POST['username'];
$pwd = $_POST['password'];

if ($person->verifyPassword($conn, $user, $pwd) == true) {
    $_SESSION['username'] = $user;
    $_SESSION['password'] = $pwd;
    header('location:../index.php');
} else {
    echo "Le mot de passe ou le nom d'utilisateur est incorrect.";
    echo "<script>
        setTimeout(function(){window.location.href='../login.php';},2000);
    </script>";
}

