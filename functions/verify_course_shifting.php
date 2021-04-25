<?php
/* this page will verify the data and insert the demand of course shifting date into database*/
//start the session of user
session_start();
header('Content-Type: text/html; charset=utf-8');
date_default_timezone_set('Europe/Paris');


/* Require the object $conn which represents the connection to the MySQL Server
 * of university  */
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

/*get all the data transferred from 'course_shifting.php '*/
$name_course
    = $_POST["name_course"]; # the name of this course , ex: Programmation structurée
$type_course = $_POST["type_course"]; # the type of this courser, ex: CM, TD...
$time_course
    = $_POST["time_course"]; # the original class schedule of this course
$code_course = $_POST["code_course"]; # the identity of this course
$time_change = $_POST["time_change"]; # the class schedule after change
$email_admin
    = $_POST["email_admin"]; # the email of administrator in charge of this demand
$uptime_que = date("Y-m-d H:i:s");    # the update time of this demand

$code_user
    = $person->getCodeUser(); # the identity of user who makes this demand


# set the SQL query to insert this course shifting demand into table 'php_demand'
$query
    = "insert into php_demand(code_dem, dt_cours_org, dt_cours_new, dt_dem, updt_dem, status_dem, code_cours, code_user,email_admin) 
        values(NULL,'$time_course','$time_change','','$uptime_que','Attend','$code_course','$code_user','$email_admin')";
mysqli_select_db($conn, 'db_21912824_2');


/* if the query is executed successfully, the server will send a email to the administrator in charge of this demand
and get back to page 'index.php'*/
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












