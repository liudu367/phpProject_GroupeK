<?php
session_start();
header("Content-Type: text/html; charset=utf-8");
include_once("./class/People/people.php");
include_once("./class/question/question.php");
$conn = require_once("./functions/connection_db.php");

use People\people;
use question\question;

$person = new people();
$person->setUserPara($conn, $_SESSION["username"]);


$question = new question();
$codeQue = $_GET["code_que"];
$question->setAll($conn, $codeQue);
$questionAll = $question->getAll();
$author = new people();
$nameAuthor = $author->getFullname($conn, $questionAll[6]);


if (json_decode($question->getAllResponses($conn), true) != null) {
    $allResponses = json_decode($question->getAllResponses($conn), true);
    $index = array_keys($allResponses);
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
                echo "<li><a href='course_shifiting.php' class='nav-link px-2 link-dark'>Déplacement du Cours</a></li>";
            } ?>
            <li><a href='profil.php' class='nav-link px-2 link-dark'>Profil</a>
            </li>
        </ul>
        <div class="col-md-3 text-end">
            <?php
            echo "Bienvenue"." ".$person->getNom()." ".$person->getPrenom(); ?>
            <a href='functions/disconnection.php' style='color: white'>
                <button type='button' class='btn btn-danger'>Déconnexion
                </button>
            </a>
        </div>
    </header>

    <main class="border">
        <div class="row">
            <div class="col-lg-6">
                <h3 class="text-danger"> Question : <?php
                    echo $questionAll[1]; ?> </h3>
            </div>
        </div>
        <div class="row">
            <div class="col-sm">
                <?php
                if ($questionAll[4] == 'ouvert') {
                    echo "<span class='badge bg-primary rounded-pill'>$questionAll[4]</span>";
                } else {
                    echo "<span class='badge bg-danger rounded-pill'>$questionAll[4]</span>";
                }


                ?>
            </div>
        </div>


        <div class='d-flex text-muted pt-3'>
            <svg class='bd-placeholder-img flex-shrink-0 me-2 rounded'
                 width='32' height='32' xmlns='http://www.w3.org/2000/svg'
                 role='img' aria-label='Placeholder: 32x32'
                 preserveAspectRatio='xMidYMid slice' focusable='false'><title>
                    Placeholder</title>
                <rect width='100%' height='100%' fill='#007bff'></rect>
                <text x='50%' y='50%' fill='#007bff' dy='.3em'>32x32</text>
            </svg>
            <p class='pb-3 mb-0 small lh-sm border-bottom text-dark'>
                <strong class='d-block text-dark'><?php
                    echo "@".$nameAuthor; ?></strong>
                <?php
                echo $questionAll[2]; ?>
            </p>
        </div>
        <div class="my-3 p-3 bg-body rounded shadow-sm">
            <h6 class="border-bottom pb-2 mb-0">Réponses</h6>

            <?php
            if (json_decode($question->getAllResponses($conn), true) != null) {
                foreach ($index as $v) {
                    $numero = $v + 1;
                    $nameRes = $allResponses[$v]['respondent'];
                    $dateTime = $allResponses[$v]['dt'];
                    $content = $allResponses[$v]['content'];
                    echo "
             <div class='d-flex text-muted pt-3'>
                <svg class='bd-placeholder-img flex-shrink-0 me-2 rounded' width='32' height='32' xmlns='http://www.w3.org/2000/svg' role='img' aria-label='Placeholder: 32x32' preserveAspectRatio='xMidYMid slice' focusable='false'><title>Placeholder</title><rect width='100%' height='100%' fill='#007bff'></rect><text x='50%' y='50%' fill='#007bff' dy='.3em'>32x32</text></svg>
                <p class='pb-3 mb-0 small lh-sm border-bottom text-dark'>
                <strong class='d-block text-dark'>@$nameRes $numero </strong>
                $content &nbsp; &nbsp;&nbsp; $dateTime
                </p>
            </div>
             ";


                }


            }
            ?>

        </div>
        <!--Response-->
        <div class="">
            <h3 class="border-bottom text-danger">Répondre</h3>
            <form action="./functions/verify_reply.php" method="post">
                <div class='d-flex text-muted pt-3'>
                    <textarea name="content_re"
                              style="width: 800px; height:150px "
                              placeholder="votre contenu" required></textarea>
                </div>
                <input type="number" name="code_que" value='<?php
                echo $codeQue; ?>' hidden>
                <input type="number" name="code_user" value='<?php
                echo $person->getCodeUser(); ?>' hidden>

                <?php
                if ($questionAll[4] == 'ouvert') {
                    echo "<div class='d-flex text-muted pt-2'>
                    <input class='btn btn-danger' type='submit'
                           value='Répondre'>
                     </div>";
                } else {
                    echo "<p class='text-danger'>Cette question est fermée et vous pouvez uniquement consulter cette question et sa réponse.</p>";
                }
                ?>
            </form>
    </main>
</body>
</html>
