<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Europe/Paris');
require_once('../class/People/people.php');
$conn = require_once('connection_db.php');

use People\people;

$title = $_POST['title_que'];
$content = $_POST['content_que'];
$namecourse = $_POST['name_cours'];
$emailprof = $_POST['email_prof'];


// set the new object $student
$student = new people();
$student->setUserPara($conn, $_SESSION['username']);
$code_user = $student->getCodeUser();
$email_stu = $student->getEmail();

// set the new object professor
$professor = new people();
$professor->setUserPara($conn, $emailprof);
$code_user_res = $professor->getCodeUser();

// set the default value of the question status and the update time
$status = 'ouvert';
$uptime_que = date("Y-m-d H:i:s");


$query
    = "insert into php_question values (NULL,'$title','$content',$code_user_res,'$status','$namecourse',$code_user,'$uptime_que')";
mysqli_select_db($conn, 'db_21912824_2');


if ($result = mysqli_query($conn, $query)) {
    echo "Soumission Success";
//    Send the email to the professor
    $to = $emailprof;
    $subject = $title;
    $message = $content;
    $headers = 'From: '."$email_stu"."\r\n".
        'Reply - To:'."$emailprof"."\r\n".
        'X - Mailer: PHP / '.phpversion();
    if (mail($to, $subject, $message, $headers) == true) {
        echo "<script>
        setTimeout(function(){window.location.href='../index.php';},2000);
    </script>";
    }
} else {
    echo "Soumission echec ";
    echo "<script>
        setTimeout(function(){window.location.href='../index.php';},2000);
    </script>";
}
