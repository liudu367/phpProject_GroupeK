<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set('Europe/Paris');
include_once("../class/People/people.php");
include_once("../class/question/question.php");
$conn = require_once("./connection_db.php");

use People\people;

$person = new people();
$person->setAll($conn, $_SESSION["username"]);
$code_user = $person->getCode();

$content_re = $_POST['content_re'];
$code_que = $_POST['code_que'];
$dt_re = date("Y-m-d H:i:s");


$query
    = "insert into php_responses (code_re, title_re, content_re, dt_re, father_id, code_que, code_user, uptime_re) values (NULL,NULL,'$content_re','$dt_re',NULL,'$code_que','$code_user','$dt_re')";
mysqli_select_db($conn, "db_21912824_2");
if ($result = mysqli_query($conn, $query)) {

    echo "Soumission Success";
    echo "<script>
        setTimeout(function(){window.location.href='../post_template.php?code_que=$code_que';},2000);
    </script>";

} else {
    if (isset($_POST['code_user'])) {
        unset($_POST['code_user']);
    }
    if (isset($_POST['content_re'])) {
        unset($_POST['content_re']);
    }
    $_POST['code_que'] = $code_que;
    echo "Soumission echec ";
    echo "<script>
        setTimeout(function(){window.location.href='../post_template.php?code_que=$code_que';},2000);
    </script>";
}


