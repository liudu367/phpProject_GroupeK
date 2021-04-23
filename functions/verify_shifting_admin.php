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


$status = $_POST['status_demand'];
$code_dem = $_POST['code_dem'];
if ($status == "Accepte") {
    $datetime_new = $_POST['dt_cours_new'];
    $code_cours = $_POST['code_cours'];
}


if ($status == "Accepte") {
    $query
        = "update php_demand set php_demand.status_dem ='$status' where php_demand.code_dem ='$code_dem'";
    mysqli_select_db($conn, 'db_21912824_2');

    if ($result = mysqli_query($conn, $query)) {
        echo "Soumission Success";
        $query
            = "update php_course set php_course.dt_cours = '$datetime_new' where php_course.code_cours = '$code_cours'";
        $result = mysqli_query($conn, $query);
        echo "<script>
        setTimeout(function(){window.location.href='../course_shifiting.php';},2000);
       </script>";
    } else {
        echo "Soumission Echec";
        echo "<script>
        setTimeout(function(){window.location.href='../course_shifiting.php';},2000);
    </script>";
    }

} else {
    $query
        = "update php_demand set php_demand.status_dem ='$status' where php_demand.code_dem ='$code_dem'";
    mysqli_select_db($conn, 'db_21912824_2');

    if ($result = mysqli_query($conn, $query)) {
        echo "Soumission Success";
        echo "<script>
        setTimeout(function(){window.location.href='../course_shifiting.php';},2000);
    </script>";
    } else {
        echo "Soumission Echec";
        echo "<script>
        setTimeout(function(){window.location.href='../course_shifiting.php';},2000);
    </script>";
    }
}

if ($status == "Refuse") {
    $query
        = "update php_demand set php_demand.status_dem ='$status' where php_demand.code_dem ='$code_dem'";
    mysqli_select_db($conn, 'db_21912824_2');

    if ($result = mysqli_query($conn, $query)) {
        echo "Soumission Success";
        echo "<script>
        setTimeout(function(){window.location.href='../course_shifiting.php';},2000);
    </script>";
    } else {
        echo "Soumission Echec";
        echo "<script>
        setTimeout(function(){window.location.href='../course_shifiting.php';},2000);
    </script>";
    }


}










