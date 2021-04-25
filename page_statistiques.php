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
       class="d-flex align-items-center col-md-2 mb-2 mb-md-0 text-dark text-decoration-none">
        <img src="pic/logo-fr.jpg" height="75px" width="75px">
    </a>

    <ul class='nav col-12 col-md-auto mb-2 justify-content-center mb-md-0'>
        <li><a href='index.php'
               class='nav-link px-2 link-dark'>Page d'accueil</a></li>
        <li><a href='question_page.php' class='nav-link px-2 link-dark'>Page
                des Questions</a>
        </li>
        <?php
        if ($person->getClass() != 3) {
            echo "<li><a href='transfer_question.php' class='nav-link px-2 link-dark'>Transférer</a></li>";
            echo "<li><a href='course_shifiting.php' class='nav-link px-2 link-dark'>Déplacement du Cours</a></li>";
        }
        if ($person->getClass() == 2) {
            echo "<li><a href='page_statistiques.php' class='nav-link px-2 link-danger'>Statistiques</a></li>";
        }
        ?>
        <li><a href='profil.php' class='nav-link px-2 link-dark'>Profil</a></li>
    </ul>

    <div class='col-md-3 text-end'>

<?php
if (isset($_SESSION['password']) and ($person->getClass() == 2)) {
    echo "Bienvenue"." ".$person->getLastname()." ".$person->getFirstname();
    echo "<a href='functions/disconnection.php' style='color: white'><button type='button' class='btn btn-danger'>Déconnexion</button></a>
           </div>
    </header>";

//   Get the number of all questions with status values of "Ouvert"
    $query
        = "select count(*) from php_question where php_question.status='Ouvert'";
    mysqli_select_db($conn, 'db_21912824_2');
    $result = mysqli_query($conn, $query);
    while ($rows = $result->fetch_row()) {
        $count_rows = $rows[0];
    }


    echo "<div class='row'>
            <div class='col-md-3'>
                <p>Nombre de Question Ouvert</p>
            </div>
            
            <div class='col-md-3'>
                <p>Catégories de question</p>
            </div>
            
            <div class='col-md-4'>
                <p>Temps de réponse moyen aux questions</p>
            </div>
           
        </div>";

    echo "<div class='row'>
            <div class='col-md-3'>
                <p>$count_rows</p>
            </div>";

//    Show all courses covered by the question
    $query = "select distinct php_question.name_cours from php_question ";
    $result = mysqli_query($conn, $query);
    echo "<div class='col-md-3'> 
            <ul>";
    while ($rows = $result->fetch_row()) {
        echo "<li>$rows[0]</li>";
    }
    echo "</ul>";

//    Show average time to solve a problem
    $query
        = "select round(avg(datediff(php_question.closetime_que, php_question.uptime_que))*24,1) from php_question where php_question.closetime_que is not null";
    $result = mysqli_query($conn, $query);
    while ($rows = $result->fetch_row()) {
        $time_avg = $rows[0];
    }
    echo "</div>
        <div class='col-md-2'>
                <p>$time_avg"." "."heures"."</p>
      </div>
       </div>";

}
?>