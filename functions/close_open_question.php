<?php
/* This php file enables the update of question status */
session_start();
header('Content-Type: text/html; charset=utf-8');

// set the timezone, require the connection of database
date_default_timezone_set('Europe/Paris');
require_once('../class/People/people.php');
$conn = require_once('connection_db.php');


//  Get the code of question  & the question status
$code_que = $_GET['code_que'];
$status = $_GET['status'];


/*
 * if the question status is "Fermée"(Closed), it will update column 'status' in the table 'php_question'
 * and set the value for column 'closetime_que'
 * else, it will only update column 'status'.
 * */
if ($status == "Fermée") {
    mysqli_select_db($conn, 'db_21912824_2');
    $query
        = "update php_question set php_question.status='$status' where php_question.code_que=$code_que";
    if (mysqli_query($conn, $query)) {
        $closetime = date("Y-m-d H:i:s");
        echo $status." "."Succèss";
        $query
            = "update php_question set php_question.closetime_que = '$closetime' where php_question.code_que=$code_que";
        if (mysqli_query($conn, $query)) {
//         set the javascript function to get back to profil.php
            echo "<script>
        setTimeout(function(){window.location.href='../profil.php';},2000);
    </script>";
        }
    } else {
        echo $status." "."Echec";
        echo "<script>
        setTimeout(function(){window.location.href='../profil.php';},2000);
    </script>";
    }

} else {
    mysqli_select_db($conn, 'db_21912824_2');
    $query
        = "update php_question set php_question.status='$status' where php_question.code_que=$code_que";
    if (mysqli_query($conn, $query)) {
        echo $status." "."Succèss";
        echo "<script>
                setTimeout(function(){window.location.href='../profil.php';},2000);
             </script>";

    } else {
        echo $status." "."Echec";
        echo "<script>
                setTimeout(function(){window.location.href='../profil.php';},2000);
            </script>";


    }
}








