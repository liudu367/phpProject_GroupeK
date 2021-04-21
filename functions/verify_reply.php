<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
date_default_timezone_set('Europe/Paris');
include_once("../class/People/people.php");
include_once("../class/question/question.php");
$conn = require_once("./connection_db.php");

use People\people;

$person = new people();
$person->setUserPara($conn, $_SESSION["username"]);
$code_user = $person->getCodeUser();
$class = $person->getClass();

$content_re = $_POST['content_re'];
$code_que = $_POST['code_que'];
$dt_re = date("Y-m-d H:i:s");


$query
    = "insert into php_responses (code_re, title_re, content_re, dt_re, father_id, code_que, code_user, uptime_re) values (NULL,NULL,'$content_re','$dt_re',NULL,'$code_que','$code_user','$dt_re')";
mysqli_select_db($conn, "db_21912824_2");
if ($result = mysqli_query($conn, $query)) {
    $from = $person->getEmail();
    $subject = "Réponse";
    $message = $content_re;
    if ($class == 3) {
        echo "Soumission Success";
        echo "<script>
        setTimeout(function(){window.location.href='../index.php';},2000);
    </script>";
    }
    echo "Soumission Success";


    if ($class == 1 or $class == 2) {
        $query = "select DISTINCT a1.email_user
                  from 
                (select php_users.email_user
                FROM php_question, php_users
                where php_question.code_que = '$code_que' and php_question.code_user = php_users.code_user 
                union 
                select pu1.email_user
                from php_responses,php_users pu1
                where php_responses.code_que = '$code_que' and php_responses.code_user = pu1.code_user ) as a1
                where a1.email_user not in ('$from')";
        mysqli_select_db($conn, 'db_21912824_2');
        $result = mysqli_query($conn, $query);


        if ($result->num_rows > 0) {
            while ($rows = $result->fetch_row()) {
                $headers = 'From: '."$from"."\r\n".
                    'Reply - To:'."$rows[0]"."\r\n".
                    'X - Mailer: PHP / '.phpversion();
                mail($rows[0], $subject, $message, $headers);
            }
        }

        echo "Soumission Success";
        echo "<script>
        setTimeout(function(){window.location.href='../index.php';},2000);
    </script>";
    }


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


