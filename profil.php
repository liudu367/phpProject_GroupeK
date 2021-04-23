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

//Get arrays of my Question in charge
if (json_decode($person->getMyCharge($conn), true) != null) {
    $data2 = json_decode($person->getMyCharge($conn), true);
    $index2 = array_keys($data2);
//column Code
    $codeArr2 = array();
    foreach ($data2 as $key => $value) {
        $codeArr2[] = $value['code'];
    }
//column Title
    $titleArr2 = array();
    foreach ($data2 as $key => $value) {
        $titleArr2[] = $value['title'];
    }

//column Respondent

    foreach ($data2 as $key => $value) {
        $resArr2[] = $value['Question Asker'];
    }
//column status

    foreach ($data2 as $key => $value) {
        $staArr2[] = $value['status'];
    }
//column update_time

    foreach ($data2 as $key => $value) {
        $updtArr2[] = $value['update_time'];
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
    <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4">
        <a href="#"
           class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <img src="pic/logo-fr.jpg" height="75px" width="75px">
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href='index.php'
                   class='nav-link px-2 link-dark'>Page d'accueil</a></li>
            <li><a href='question_page.php' class='nav-link px-2 link-dark'>Page
                    des Questions</a>
            </li>
            <?php
            if ($person->getClass() != 3) {
                echo "<li><a href='transfer_question.php' class='nav-link px-2 link-dark'>Transférer</a></li>";
                echo "<li><a href='course_shifiting.php' class='nav-link px-2 link-dark'>Déplacement du Cours</a></li>";
            } ?>
            <li><a href='profil.php'
                   class='nav-link px-2 link-danger'>Profil</a>
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
                <p>Responsable</p>
            </div>
            <div class='col-md'>
                <p>Statuts</p>
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
                <p><a class='text-danger' style='text-decoration: none' href='post_template.php?code_que=$codeArr[$v]'> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='text-center bi bi-question-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z'/>
                </svg>$titleArr[$v] </a></p>
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
                    <p>Responsable</p>
                </div>
                <div class="col-md-1">
                    <p>Statuts</p>
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
                <p><a class='text-danger' style='text-decoration: none' href='post_template.php?code_que=$codeArr1[$v1]'> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='text-center bi bi-question-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z'/>
                </svg>$titleArr1[$v1] </a></p>
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


            <?php
            if ($person->getClass() == 1 or $person->getClass() == 2) {
                echo "<div class='container py-5' id = 'Course'>
                <h2 class='pb-2 text-danger' > Mes Responsables </h2 >
                <div class='row row-cols-4 '>
                    <div class='col-md-5'>
                        <p>Titre</p>
                    </div>
                    <div class='col-md-2'>
                        <p>Questionneur</p>
                    </div>
                    <div class='col-md-1'>
                        <p>Statuts</p>
                    </div>
                    <div class='col-md-2'>
                        <p>Temps de mise à jour</p>
                    </div>
                    <div class='col-md-2 text-center' >
                        <p>Interrupteur</p>
                    </div>
                </div>";

                //            Get my questions in Charge
                if (json_decode($person->getMyCharge($conn), true) != null) {
                    $index2 = array_keys($data2);
                    foreach ($index2 as $v2) {
                        echo "<div class='row row-cols-4'>
            <div class='col-md-5'>
                <p><a class='text-danger' style='text-decoration: none' href='post_template.php?code_que=$codeArr2[$v2]'> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='text-center bi bi-question-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z'/>
                </svg>$titleArr2[$v2] </a></p>
            </div>
            <div class='col-md-2'>
                <p>$resArr2[$v2]</p>
            </div>
            <div class='col-md-1'>
                <p>$staArr2[$v2]</p>
            </div>
            <div class='col-md-2'>
                <p>$updtArr2[$v2]</p>
            </div>
            <div class='col-md-1'>
                <a class='btn-sm btn-danger text-decoration-none' href='functions/close_open_question.php?code_que=$codeArr2[$v2]&status=fermée' >Fermer</a>
            </div>
            <div class='col-md-1'>
                <a class='btn-sm btn-primary text-decoration-none' href='functions/close_open_question.php?code_que=$codeArr2[$v2]&status=ouvert' >Ouvrir</a>
            </div>
        </div>";
                    }
                }
            }
            ?>


        </div>
    </div>
</div>
</body>
</html>
