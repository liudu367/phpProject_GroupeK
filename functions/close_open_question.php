<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
require_once('../class/People/people.php');
$conn = require_once('connection_db.php');

$code_que = $_GET['code_que'];
$status = $_GET['status'];

mysqli_select_db($conn, 'db_21912824_2');
$query
    = "update php_question set php_question.status='$status' where php_question.code_que=$code_que";
if (mysqli_query($conn, $query)) {
    echo strtoupper($status)." "."Succèss";
    echo "<script>
        setTimeout(function(){window.location.href='../profil.php';},2000);
    </script>";
} else {
    echo strtoupper($status)." "."échec";
    echo "<script>
        setTimeout(function(){window.location.href='../profil.php';},2000);
    </script>";
}

