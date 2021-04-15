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
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="#"
           class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <img src="pic/logo-fr.jpg" height="75px" width="75px">
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href='index.php'
                   class='nav-link px-2 link-danger'>Page d'accueil</a></li>
            <li><a href='question_page.php' class='nav-link px-2 link-dark'>Page
                    des Questions</a>
            </li>
            <?php
            if ($person->getClass() != 3) {
                echo "<li><a href='transfer_question.php' class='nav-link px-2 link-dark'>Transférer</a></li>";
            } ?>
            <li><a href='profil.php' class='nav-link px-2 link-dark'>Profil</a>
            </li>
        </ul>
        <!--the bar of login-->
        <div class='col-md-3 text-end'>
            <?php
            if (isset($_SESSION['password'])) {
                echo "Bienvenue"." ".$person->getNom()." ".$person->getPrenom();
            }
            ?>
            <a href='functions/disconnection.php' style='color: white'>
                <button type='button' class='btn btn-danger'>Déconnexion
                </button>
            </a>
        </div>
    </header>
    <h2 class="h2 text-danger"><?php
        echo $thread; ?></h2>
    <div class="row row-cols-5 ">
        <div class="col-md-5">
            <p class="fw-bold text-danger">Titre</p>
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
                <p><a class='text-danger' style='text-decoration: none' href='post_template.php?code_que=$codeArr[$v]'>
                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='text-center bi bi-question-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z'/>
                </svg> $titleArr[$v] </a></p>
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
                <p><a class='text-danger' style='text-decoration: none' href='post_template.php?code_que=$codeArr[$v]'> <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='text-center bi bi-question-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z'/>
                </svg>$titleArr[$v] </a></p>
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






