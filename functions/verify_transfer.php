<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include('../class/People/people.php');
$conn = require_once('connection_db.php');

if (isset($_SESSION['password']) == false) {
    header('location:login.php');
}

use People\people;

$person = new people();
$person->setUserPara($conn, $_SESSION['username']);
$email_transfer = $_GET['email_transfer'];
$code_course = $_GET['code_cours'];

mysqli_select_db($conn, 'db_21912824_2');
$query
    = "select php_users.code_user  from php_users where php_users.email_user ='$email_transfer'";
$result = mysqli_query($conn, $query);
if ($result->num_rows > 0) {
    while ($rows = $result->fetch_row()) {
        $code_transfer = $rows[0];
    }
}

$query
    = "update php_question set php_question.code_user_res = $code_transfer where php_question.code_que = $code_course";
if (mysqli_query($conn, $query)) {
    echo "Transmission réussie";
    echo "<script>
        setTimeout(function(){window.location.href='../transfer_question.php';},2000);
    </script>";
} else {
    echo "panne de transmission";
    echo "<script>
        setTimeout(function(){window.location.href='../transfer_question.php';},2000);
    </script>";
}




