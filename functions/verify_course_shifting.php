<?php
//start the session of user
session_start();
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Europe/Paris');
require_once('../class/People/people.php');
$conn = require_once('connection_db.php');

// if the password isn't set, back to page 'login.php'
if (isset($_SESSION['password']) == false) {
    header('location:login.php');
}

/*define the var $person as class people and set all of its coordinates with username*/

use People\people;

$person = new people();
$person->setUserPara($conn, $_SESSION['username']);


$name_course = $_POST["name_course"];
$type_course = $_POST["type_course"];
$time_course = $_POST["time_course"];
$code_course = $_POST["code_course"];
$time_change = $_POST["time_change"];
$email_admin = $_POST["email_admin"];
$uptime_que = date("Y-m-d H:i:s");
$code_user = $person->getCodeUser();


echo $code_course;


$query
    = "insert into php_demand(code_dem, dt_cours_org, dt_cours_new, dt_dem, updt_dem, status_dem, code_cours, code_user,email_admin) 
        values(NULL,'$time_course','$time_change','','$uptime_que','Attend','$code_course','$code_user','$email_admin')";
mysqli_select_db($conn, 'db_21912824_2');
if ($result = mysqli_query($conn, $query)) {
    echo "Soumission Success";

    $email1 = $person->getEmail();
    $to = $email_admin;
    $subject = 'Déplacement';
    $message = 'Je vous déja envoyé un déplacement du cours';
    $headers = 'From: '."$email1"."\r\n".
        'X - Mailer: PHP / '.phpversion();
    if (mail($to, $subject, $message, $headers) == true) {
        echo "<script>
        setTimeout(function(){window.location.href='../index.php';},2000);
    </script>";
    }


} else {
    echo "Soumission Echec";
    echo "<script>
        setTimeout(function(){window.location.href='../course_shifiting.php';},2000);
    </script>";
}












