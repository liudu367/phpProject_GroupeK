<?php
session_start();
include('./class/People/people.php');
$conn = require_once('./functions/connection_db.php');
if (isset($_SESSION['password']) == false) {
    header('location:login.php');
}

use People\people;

$person = new people();
$person->setUserPara($conn, $_SESSION['username']);
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
    <script type="text/javascript">
        var data = <?php
            // get the courses of student in format of JSON
            if ($person->getClass() == 3) {
                echo $person->getCoursJson_stu($conn);
            } elseif ($person->getClass() == 1) {
                echo $person->getProfJson($conn);
            }
            ?>;

        function selectProfessor() {
            var source = document.getElementById("course");
            var target = document.getElementById("prof");
            var selected = source.options[source.selectedIndex].value;
            target.innerHTML = "";
            for (var i = 0; i < data[selected].length; i++) {
                var opt = document.createElement("option");
                opt.value = data[selected][i];
                opt.innerHTML = data[selected][i];
                document.getElementById("prof").appendChild(opt);
            }
        }
    </script>
</head>
<body>
<div class="container">
    <header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom">
        <a href="#"
           class="d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none">
            <img src="pic/logo-fr.jpg" height="75px" width="75px">
        </a>

        <ul class="nav col-12 col-md-auto mb-2 justify-content-center mb-md-0">
            <li><a href='index.php'
                   class='nav-link px-2 link-dark'>Page d'accueil</a></li>
            <li><a href='question_page.php' class='nav-link px-2 link-danger'>Page
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

    <!--the block of questionnaire-->
    <main>
        <div class="row g-5">
            <div class="col-md-7 col-lg-8">
                <h4 class="mb-3 text-danger fw-bold">Question</h4>
                <form action="functions/verify_question.php" method="post"
                      class="needs-validation" novalidate="">
                    <div class="row g-3">

                        <!--the block of title-->
                        <div class="col-12">
                            <label for="title" class="form-label">Titre</label>
                            <input type="text" class="form-control" id="title"
                                   name="title_que"
                                   placeholder="Titre de votre question"
                                   required>
                            <div class="invalid-feedback">
                                Veuillez saisir le titre de votre question
                            </div>
                        </div>

                        <!--the block of question content-->
                        <div class="col-12">
                            <label for="content" class="form-label">Contenu
                                <span
                                        class="text-muted"></span></label>
                            <textarea class="form-control" id="content"
                                      name="content_que"
                                      placeholder="écrire votre question"
                                      required></textarea>
                            <div class="invalid-feedback">
                                Veuillez saisir votre question
                            </div>
                        </div>


                        <div class="col-md-5">
                            <label for="course" class="form-label">Cours</label>
                            <select class="form-select" id="course"
                                    name="name_cours"
                                    onchange="selectProfessor()"
                                    required>
                                <option value="">Choisir...</option>


                                <?php
                                if ($person->getClass() == 3) {
                                    $index
                                        = array_keys(json_decode($person->getCoursJson_stu($conn),
                                        true));
                                    foreach ($index as $v) {
                                        echo "<option value='$v'>".$v
                                            ."</option>";
                                    }
                                }

                                if ($person->getClass() == 1) {
                                    $index1
                                        = array_keys(json_decode($person->getProfJson($conn),
                                        true));
                                    foreach ($index1 as $v1) {
                                        echo "<option value='$v1'>".$v1
                                            ."</option>";
                                    }

                                }

                                ?>
                            </select>
                        </div>


                        <div class="col-md-4">
                            <label for="prof"
                                   class="form-label">Professeur</label>
                            <select class="form-select" id="prof"
                                    name="email_prof"
                                    required>
                                <option value="">Choisir...</option>
                            </select>
                            <div class="invalid-feedback">
                                Veuillez choisir un professeur
                            </div>
                        </div>

                        <hr class="my-4">

                        <?php
                        if ($person->getClass() == 2) {
                            echo "vous n'avez pas le droit à poser des questions";


                        } else {
                            echo "<button class='w-100 btn btn-danger btn-lg'
                                type='submit'>
                            Poser La Question
                        </button>";
                        }

                        ?>


                </form>
            </div>
        </div>
    </main>
</div>
</body>
</html>


<!--<script>-->
<!--    setTimeout(function () {-->
<!--        window.location.href = 'index.php';-->
<!--    }, 2000);-->
<!--</script>-->

