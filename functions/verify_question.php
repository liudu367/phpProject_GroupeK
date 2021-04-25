<?php
/* this page will verify the question and insertt the data of question into database*/
session_start();
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Europe/Paris');
require_once('../class/People/people.php');
$conn = require_once('connection_db.php');

use People\people;

// get all the data from page 'question_page.php'
$title = $_POST['title_que'];       # the title of question
$content = $_POST['content_que'];   # the content of question
$namecourse = $_POST['name_cours']; # the name of courser involved by question
$emailprof
    = $_POST['email_prof'];  # the email of professor in charge of question


if (isset($title) == false or isset($content) == false or isset($emailprof)
    == false or isset($namecourse) == false
) {
    echo "ECHEC";
    echo "<script>
        setTimeout(function(){window.location.href='../question_page.php';},2000);
    </script>";
}


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


//  set a SQL query in order to insert all data of question into table 'php_question'
$query
    = "insert into php_question values (NULL,'$title','$content','$code_user_res','$status','$namecourse',$code_user,'$uptime_que', NULL)";
mysqli_select_db($conn, 'db_21912824_2');


if ($result = mysqli_query($conn, $query)) {
    echo "Soumission Success";

//  if the query is executed successfully, the server will send the email to the professor
    $to = $emailprof;
    $subject = $title;
    $message = $content;
    $headers = 'From: '."$email_stu"."\r\n".
        'Reply - To:'."$emailprof"."\r\n".
        'X - Mailer: PHP / '.phpversion();
    if (mail($to, $subject, $message, $headers) == true) {
//      use the javascript function in order to get back to page "index.php"
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
