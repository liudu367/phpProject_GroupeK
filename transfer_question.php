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

//Get two-dimensional arrays of my Question in charge
if (json_decode($person->getMyQuesInCharge($conn), true) != null) {
    $data2 = json_decode($person->getMyQuesInCharge($conn), true);
    $index2 = array_keys($data2);

//Decompose the two-dimensional array containing all the problems of the board into several one-dimensional arrays
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
    if ($person->getClass() == 1) {
        $listProf = json_decode($person->getTransferJson($conn, $codeArr2),
            true);
    } elseif ($person->getClass() == 2) {
        $listAdmin = json_decode($person->getTransferAdminJson($conn), true);
    }
}


?>
<!--the header of page -->
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
    <header class='d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 border-bottom'>
        <a href="#"
           class="d-flex align-items-center col-md-2 mb-2 mb-md-0  text-dark text-decoration-none">
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
                echo "<li><a href='transfer_question.php' class='nav-link px-2 link-danger'>Transférer</a></li>";
                echo "<li><a href='course_shifiting.php' class='nav-link px-2 link-dark'>Déplacement du Cours</a></li>";
            }
            if ($person->getClass() == 2) {
                echo "<li><a href='page_statistiques.php' class='nav-link px-2 link-dark'>Statistiques</a></li>";
            }
            ?>
            <li><a href='profil.php' class='nav-link px-2 link-dark'>Profil</a>
            </li>
        </ul>
        <div class="col-md-3 text-end">

            <?php
            //the status of login
            //if the password is set, there will be a navigate bar.
            if (isset($_SESSION['password'])) {
                echo "Bienvenue"." ".$person->getLastname()." "
                    .$person->getFirstname();
                echo " <a href='functions/disconnection.php' style='color: white'><button type='button' class='btn btn-danger'>Déconnexion</button></a>
                            </div>
                          </header>";
            }
            ?>
            <div class="container py-5" id="Course">
                <h2 class="pb-2 text-danger"> Mes Responsables </h2>
                <div class="row row-cols-4 ">
                    <div class="col-md-4">
                        <p>Titre</p>
                    </div>
                    <div class="col-md-2">
                        <p>Questionneur</p>
                    </div>
                    <div class="col-md-1">
                        <p>Statuts</p>
                    </div>
                    <div class="col-md-2">
                        <p>Temps de mise à jour</p>
                    </div>
                    <div class="col-md-2 ">
                        <p>Interrupteur</p>
                    </div>
                </div>


                <?php
                if ($person->getClass() == 1 or $person->getClass() == 2) {

                    //  Get my questions in Charge
                    if (json_decode($person->getMyQuesInCharge($conn), true)
                        != null
                    ) {
                        $index2 = array_keys($data2);
                        foreach ($index2 as $v2) {
                            echo "<div class='row row-cols-4'>
            <div class='col-md-4'>
                <p><a class='text-danger' style='text-decoration: none' href='post_template.php?code_que=$codeArr2[$v2]'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='text-center bi bi-question-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z'/>
                </svg> $titleArr2[$v2] </a></p>
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
            
            <form  class='form-floating' method='get' action='functions/verify_transfer.php'>  
            <input type='number' name='code_cours' value='$codeArr2[$v2]' hidden>
            <select class='form-control-sm' ' name='email_transfer'>";
                            //If the class equals 1, a list of all teachers will be displayed.
                            if ($person->getClass() == 1) {
                                foreach ($listProf[$codeArr2[$v2]] as $value) {
                                    echo "<option  value='$value'>$value</option>";
                                }
                                //If the class equals 2, a list of all administrators will be displayed.
                            } elseif ($person->getClass() == 2) {
                                foreach ($listAdmin as $value) {
                                    echo "<option value='$value'>$value</option>";
                                }
                            }

                            echo "
            </select>
            <div class='col-md-1'>
            <button type='submit' class='btn-sm btn btn-danger' ><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-box-arrow-in-up-right' viewBox='0 0 16 16'>
    <path fill-rule='evenodd' d='M6.364 13.5a.5.5 0 0 0 .5.5H13.5a1.5 1.5 0 0 0 1.5-1.5v-10A1.5 1.5 0 0 0 13.5 1h-10A1.5 1.5 0 0 0 2 2.5v6.636a.5.5 0 1 0 1 0V2.5a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 .5.5v10a.5.5 0 0 1-.5.5H6.864a.5.5 0 0 0-.5.5z'/>
    <path fill-rule='evenodd' d='M11 5.5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793l-8.147 8.146a.5.5 0 0 0 .708.708L10 6.707V10.5a.5.5 0 0 0 1 0v-5z'/>
</svg></button>
            </div>
            </form>
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






