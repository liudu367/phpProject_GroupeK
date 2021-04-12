<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include('./class/People/people.php');
$conn = require_once('./functions/connection_db.php');

if (isset($_SESSION['password']) == false) {
    header('location:login.php');
}

use People\people;

$person = new people();
$person->setUserPara($conn, $_SESSION['username']);

//Get arrays of my questions
if (json_decode($person->getMyQuestions($conn), true) != null) {
    $data = json_decode($person->getMyQuestions($conn), true);

    $index = array_keys($data);
//column Code

    foreach ($data as $key => $value) {
        $codeArr[] = $value['code'];
    }
//column Title

    foreach ($data as $key => $value) {
        $titleArr[] = $value['title'];
    }

//column Respondent

    foreach ($data as $key => $value) {
        $resArr[] = $value['Respondent'];
    }
//column status

    foreach ($data as $key => $value) {
        $staArr[] = $value['status'];
    }
//column update_time

    foreach ($data as $key => $value) {
        $updtArr[] = $value['update_time'];
    }
}

// Get questions I answered
if (json_decode($person->getMyParti($conn), true) != null) {
    $data1 = json_decode($person->getMyParti($conn), true);
    $index1 = array_keys($data1);
//column Code
    $codeArr1 = array();
    foreach ($data1 as $key => $value) {
        $codeArr1[] = $value['code'];
    }
//column Title
    $titleArr1 = array();
    foreach ($data1 as $key => $value) {
        $titleArr1[] = $value['title'];
    }
//column Question Asker
    $qaArr1 = array();
    foreach ($data1 as $key => $value) {
        $qaArr1[] = $value['Question Asker'];
    }
//column Respondent
    $resArr1 = array();
    foreach ($data1 as $key => $value) {
        $resArr1[] = $value['Respondent'];
    }
//column status
    $staArr1 = array();
    foreach ($data1 as $key => $value) {
        $staArr1[] = $value['status'];
    }
//column update_time
    $updtArr1 = array();
    foreach ($data1 as $key => $value) {
        $updtArr1[] = $value['update_time'];
    }

}


?>
<!DOCTYPE>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Index</title>
    <!--css/js file references-->
    <link rel="stylesheet" href="./css/bootstrap.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/bootstrap.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="/"
           class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <svg class="bi me-2" width="40" height="32">
                <use xlink:href="#bootstrap"></use>
            </svg>
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href="index.php"
                   class="nav-link px-2 link-secondary">Home</a></li>
            <li><a href="question_page.php" class="nav-link px-2 link-dark">Question</a>
            </li>
            <li><a href="#" class="nav-link px-2 link-dark">Pricing</a></li>
            <li><a href="#" class="nav-link px-2 link-dark">FAQs</a></li>
            <li><a href="profil.php" class="nav-link px-2 link-dark">Profil</a>
            </li>
        </ul>

        <div class="col-md-3 text-end">
            <?php
            if (isset($_SESSION['password'])) {
                echo "Bienvenue"." ".$person->getNom()." ".$person->getPrenom();
                echo " <a href='functions/disconnection.php' style='color: white'><button type='button' class='btn btn-danger'>Déconnexion</button></a>
    </div>
  </header>
  <div class='container py-5' id = 'Course'>
  <h2 class='pb-2 text-danger' > Mes Questions </h2 > 
      <div class='row row-cols-4 '>
            <div class='col-md-5'>
                <p>Titre</p>
            </div>
            <div class='col-md'>
                <p>Répondant</p>
            </div>
            <div class='col-md'>
                <p>statuts</p>
            </div>
            <div class='col-md'>
                <p>Temps de mise à jour</p>
            </div>
        </div>";


            }
            ?>
            <!-- My question-->
            <?php

            if (json_decode($person->getMyQuestions($conn), true) != null) {
                foreach ($index as $v) {
                    echo "<div class='row row-cols-4'>
            <div class='col-md-5'>
                <p><a class='text-danger' style='text-decoration: none' href='post_template.php?code_que=$codeArr[$v]'> $titleArr[$v] </a></p>
            </div>
            <div class='col-md'>
                <p>$resArr[$v]</p>
            </div>
            <div class='col-md'>
                <p>$staArr[$v]</p>
            </div>
            <div class='col-md'>
                <p>$updtArr[$v]</p>
            </div>
        </div>";
                }
            }
            ?>
            <h2 class="h2 text-danger">Participés</h2>
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


            <?php


            //    Questions I participated in answering
            if (json_decode($person->getMyParti($conn), true) != null) {
                foreach ($index1 as $v1) {
                    echo " <div class='row row-cols-5 '>
            <div class='col-md-5'>
                <p><a class='text-danger' style='text-decoration: none' href='post_template.php?code_que=$codeArr1[$v1]'> $titleArr1[$v1] </a></p>
            </div>
            <div class='col-md-2'>
                <p>$qaArr1[$v1]</p>
            </div>
            <div class='col-md-2'>
                <p>$resArr1[$v1]</p>
            </div>
            <div class='col-md-1'>
                <p>$staArr1[$v1]</p>
            </div>
            <div class='col-md-2'>
                <p>$updtArr1[$v1]</p>
            </div>
        </div>";
                }


            }
            ?>


        </div>
    </div>
