<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include('./class/People/people.php');
$conn = require_once('./functions/connection_db.php');

use People\people;

$person = new people();
$person->setUserPara($conn, $_SESSION['username']);

$thread = $_GET['thread'];
$_SESSION['thread'] = $thread;

if ($person->getClass() == 1 or $person->getClass() == 2) {
    if (json_decode($person->getAllThreadQues($conn, $thread), true) == null) {
        echo "<script>
        setTimeout(function(){window.location.href='index.php';},2000);
    </script>";
        echo "il n'y a pas de question de"." ".$thread;

    } else {
        $data = json_decode($person->getAllThreadQues($conn, $thread), true);
        $index = array_keys($data);
//column Code
        $codeArr = array();
        foreach ($data as $key => $value) {
            $codeArr[] = $value['code'];
        }
//column Title
        $titleArr = array();
        foreach ($data as $key => $value) {
            $titleArr[] = $value['title'];
        }
//column Question Asker
        $qaArr = array();
        foreach ($data as $key => $value) {
            $qaArr[] = $value['Question Asker'];
        }
//column Respondent
        $resArr = array();
        foreach ($data as $key => $value) {
            $resArr[] = $value['Respondent'];
        }
//column status
        $staArr = array();
        foreach ($data as $key => $value) {
            $staArr[] = $value['status'];
        }
//column update_time
        $updtArr = array();
        foreach ($data as $key => $value) {
            $updtArr[] = $value['update_time'];
        }

    }


} elseif ($person->getClass() == 3) {
    if (json_decode($person->getStuThreadQues($conn, $thread), true) == null) {
        echo "<script>
        setTimeout(function(){window.location.href='index.php';},2000);
    </script>";
        echo "il n'y a pas de question de"." ".$thread;

    } else {
        $data1 = json_decode($person->getStuThreadQues($conn, $thread), true);
        $index1 = array_keys($data1);
//column Code
        $codeArr = array();
        foreach ($data1 as $key => $value) {
            $codeArr[] = $value['code'];
        }
//column Title
        $titleArr = array();
        foreach ($data1 as $key => $value) {
            $titleArr[] = $value['title'];
        }
//column Question Asker
        $qaArr = array();
        foreach ($data1 as $key => $value) {
            $qaArr[] = $value['Question Asker'];
        }
//column Respondent
        $resArr = array();
        foreach ($data1 as $key => $value) {
            $resArr[] = $value['Respondent'];
        }
//column status
        $staArr = array();
        foreach ($data1 as $key => $value) {
            $staArr[] = $value['status'];
        }
//column update_time
        $updtArr = array();
        foreach ($data1 as $key => $value) {
            $updtArr[] = $value['update_time'];
        }
    }


}


?>
<!DOCTYPE>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <title>Index</title>
    <!--css/js file references-->
    <link rel='stylesheet' href='./css/bootstrap.css'>
    <link rel='stylesheet' href='./css/bootstrap.min.css'>
    <script src='./js/bootstrap.js'></script>
    <script src='./js/bootstrap.min.js'></script>
</head>

<div class="container">
    <h2 class="h2 text-danger"><?php
        echo $thread; ?></h2>
    <div class="row row-cols-5 ">
        <div class="col-md-5">
            <p>Titre</p>
        </div>
        <div class="col-md-2">
            <p>Questionneur</p>
        </div>
        <div class="col-md-2">
            <p>Répondant</p>
        </div>
        <div class="col-md-1">
            <p>statuts</p>
        </div>
        <div class="col-md-2">
            <p>Temps de mise à jour</p>
        </div>
    </div>

    <!--the view page model of professor/admin-->
    <?php
    if (json_decode($person->getAllThreadQues($conn, $thread), true) != null
        and ($person->getClass() == 1 or $person->getClass() == 2)
    ) {
        foreach ($index as $v) {
            echo "
        <div class='row row-cols-5 '>
            <div class='col-md-5'>
                <p><a class='text-danger' style='text-decoration: none' href='post_template.php?code_que=$codeArr[$v]'> $titleArr[$v] </a></p>
            </div>
            <div class='col-md-2'>
                <p>$qaArr[$v]</p>
            </div>
            <div class='col-md-2'>
                <p>$resArr[$v]</p>
            </div>
            <div class='col-md-1'>
                <p>$staArr[$v]</p>
            </div>
            <div class='col-md-2'>
                <p>$updtArr[$v]</p>
            </div>
        </div>
      ";

        }
    } ?>
    <!--the view page model of student-->
    <?php
    if (json_decode($person->getStuThreadQues($conn, $thread), true) != null
        and $person->getClass() == 3
    ) {
        foreach ($index1 as $v) {
            echo "
        <div class='row row-cols-5 '>
            <div class='col-md-5'>
                <p><a class='text-danger' style='text-decoration: none' href='post_template.php?code_que=$codeArr[$v]'> $titleArr[$v] </a></p>
            </div>
            <div class='col-md-2'>
                <p>$qaArr[$v]</p>
            </div>
            <div class='col-md-2'>
                <p>$resArr[$v]</p>
            </div>
            <div class='col-md-1'>
                <p>$staArr[$v]</p>
            </div>
            <div class='col-md-2'>
                <p>$updtArr[$v]</p>
            </div>
        </div>
      ";

        }
    } ?>


</div>






