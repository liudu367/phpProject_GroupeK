<?php
session_start();
date_default_timezone_set('Europe/Paris');
require_once('../class/People/people.php');
$conn = require_once('connection_db.php');

use People\people;

$title = $_POST['title_que'];
$content = $_POST['content_que'];
$namecourse = $_POST['name_cours'];
$emailprof = $_POST['email_prof'];


$student = new people();
$student->setAll($conn, $_SESSION['username']);
$code_user = $student->getCode();
$professor = new people();
$professor->setAll($conn, $emailprof);
$code_user_res = $professor->getCode();
$status = 'ouvert';
$uptime_que = date("Y-m-d H:i:s");


$query
    = "insert into php_question values (NULL,'$title','$content',$code_user_res,'$status','$namecourse',$code_user,'$uptime_que')";
mysqli_select_db($conn, 'db_21912824_2');
if ($result = mysqli_query($conn, $query)) {
    echo "Soumission Success";
    echo "<script>
        setTimeout(function(){window.location.href='../index.php';},2000);
    </script>";

} else {
    echo "Soumission echec ";
    echo "<script>
        setTimeout(function(){window.location.href='../index.php';},2000);
    </script>";
}
