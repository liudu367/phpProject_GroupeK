<?php
//start the session of user
session_start();
include('./class/People/people.php');
$conn = require_once('./functions/connection_db.php');

// if the password isn't set, back to page 'login.php'
if (isset($_SESSION['password']) == false) {
    header('location:login.php');
}

/*define the var $person as class people and set all of its coordinates with username*/

use People\people;

$person = new people();
$person->setUserPara($conn, $_SESSION['username']);
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
<body>
<!--the header of index page-->
<div class='container'>
    <header class='d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom'>
        <a href="#"
           class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <img src="pic/logo-fr.jpg" height="75px" width="75px">
        </a>

        <ul class='nav col-12 col-md-auto mb-2 justify-content-center mb-md-0'>
            <li><a href='index.php'
                   class='nav-link px-2 link-danger'>Page d'accueil</a></li>
            <li><a href='question_page.php' class='nav-link px-2 link-dark'>Page
                    des Questions</a>
            </li>
            <?php
            if ($person->getClass() != 3) {
                echo "<li><a href='transfer_question.php' class='nav-link px-2 link-dark'>Transférer</a></li>";
                echo "<li><a href='course_shifiting.php' class='nav-link px-2 link-dark'>Déplacement du Cours</a></li>";
            } ?>
            <li><a href='profil.php' class='nav-link px-2 link-dark'>Profil</a>
            </li>
        </ul>

        <div class='col-md-3 text-end'>

            <!--the thread block of student page-->
            <?php
            if (isset($_SESSION['password']) and $person->getClass() == 3) {
                echo "Bienvenue"." ".$person->getNom()." ".$person->getPrenom();
                echo "
                          <a href='functions/disconnection.php' style='color: white'><button type='button' class='btn btn-danger'>Déconnexion</button></a>
                        </div>
                      </header>
                      <div class='container py-5' id = 'Course'>
                      <h2 class='pb-2 text-danger' >Fils de discussion</h2 >
                           <div class='row row-cols-4 g-4 py-5' >
                      ";

                //print threads of all courses
                $index
                    = array_keys(json_decode($person->getCoursJson_stu($conn),
                    true));
                foreach ($index as $v) {
                    echo "
            <div class='col d-flex align-items-start'>
                <div>
                    <a class='text-decoration-none text-danger' href='thread_template.php?thread=$v'> $v<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-up-square' viewBox='0 0 16 16'>
                  <path fill-rule='evenodd' d='M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 9.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z'/>
                  </svg> </a>
                    <p>Fils de Discussion $v </p >
                </div >
            </div >";
                }
            }
            ?>


            <!--the thread block of professor page-->
            <?php
            if (isset($_SESSION['password']) and ($person->getClass() == 1)
            ) {
                echo "Bienvenue"." ".$person->getNom()." ".$person->getPrenom();
                echo "
                          <a href='functions/disconnection.php' style='color: white'><button type='button' class='btn btn-danger'>Déconnexion</button></a>
                        </div>
                      </header>
                      <div class='container py-5' id = 'Course'>
                      <h2 class='pb-2 text-danger' > Fils de Discussion </h2 >
                           <div class='row row-cols-4 g-4 py-5' >
                      ";
                $index = array_keys(json_decode($person->getProfJson($conn),
                    true));
                foreach ($index as $v) {
                    echo "
            <div class='col d-flex align-items-start'>
                <div>
                    <a class='text-decoration-none text-center text-danger' href='thread_template.php?thread=$v'> $v <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-up-square' viewBox='0 0 16 16'>
                  <path fill-rule='evenodd' d='M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 9.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z'/>
                  </svg></a>
                    <p>Fils de Discussion $v </p >
                </div >
            </div >";
                }
            }
            ?>
            <!-- the thread block of admin page-->
            <?php
            if (isset($_SESSION['password']) and ($person->getClass() == 2)) {
                echo "Bienvenue"." ".$person->getNom()." ".$person->getPrenom();
                echo "
                          <a href='functions/disconnection.php' style='color: white'><button type='button' class='btn btn-danger'>Déconnexion</button></a>
                        </div>
                      </header>
                      <div class='container py-5' id = 'Course'>
                      <h2 class='pb-2 text-danger' > Fils de Discussion </h2 >
                           <div class='row row-cols-4 g-4 py-5' >
                      ";
                $data = json_decode($person->getAdminBlock($conn), true);
                foreach ($data as $v) {
                    echo "
            <div class='col d-flex align-items-start'>
                <div>
                    <a class='text-decoration-none text-danger' href='thread_template.php?thread=$v'> $v<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-arrow-up-square' viewBox='0 0 16 16'>
                  <path fill-rule='evenodd' d='M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm8.5 9.5a.5.5 0 0 1-1 0V5.707L5.354 7.854a.5.5 0 1 1-.708-.708l3-3a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 5.707V11.5z'/>
                  </svg> </a>
                    <p>Fils de Discussion $v </p >
                </div >
            </div >";
                }
            }

            ?>


        </div>
</div>
</body>
</html>


