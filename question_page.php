<?php
session_start();
include('./class/People/people.php');
$conn = require_once('./functions/connection_db.php');

if (isset($_SESSION['password']) == false) {
    header('location:login.php');
}

use People\people;

$person = new people();
$person->setAll($conn, $_SESSION['username']);
//the navigate bar
// if the user is student
if ($person->getClass() == 3) {
    echo "
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
<div class='container'>
  <header class='d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom'>
    <a href='/' class='d-flex align-items-center col-md-3 mb-2 mb-md-0 text-dark text-decoration-none'>
      <svg class='bi me-2' width='40' height='32'><use xlink:href='#bootstrap'></use></svg>
    </a>

    <ul class='nav col-12 col-md-auto mb-2 justify-content-center mb-md-0'>
      <li><a href='index.php' class='nav-link px-2 link-secondary'>Home</a></li>
      <li><a href='question_page.php' class='nav-link px-2 link-dark'>Question</a></li>
      <li><a href='#' class='nav-link px-2 link-dark'>Pricing</a></li>
      <li><a href='#' class='nav-link px-2 link-dark'>FAQs</a></li>
      <li><a href='#' class='nav-link px-2 link-dark'>About</a></li>
    </ul>

    <div class='col-md-3 text-end'>";

// the login status
if (isset($_SESSION['password'])) {
    echo "Bienvenue"." ".$person->getNom()." ".$person->getPrenom();
}
    echo " <a href='functions/disconnection.php' style='color: white'><button type='button' class='btn btn-primary'>Déconnexion</button></a>
    </div>
  </header>
  
  <main>
  <div class='row g-5'>
      <div class='col-md-7 col-lg-8'>
        <h4 class='mb-3'>Question</h4>
        <form action='functions' method='post' class='needs-validation' novalidate=''>
          <div class='row g-3'>";

    echo "
          <div class='col-12'>
              <label for='title' class='form-label'>Titre</label>
              <input type='text' class='form-control' id='title' name='title_que' placeholder='Titre de votre question' required>
              <div class='invalid-feedback'>
                Veuillez saisir le titre de votre question
              </div>
            </div>
            
            <div class='col-12'>
              <label for='content' class='form-label'>Contenu <span class='text-muted'></span></label>
              <textarea class='form-control' id='content' name='content_que' placeholder='écrire votre question'></textarea>
              <div class='invalid-feedback'>
               Veuillez saisir votre question
              </div>
            </div>";

    echo "     <div class='col-md-5'>
              <label for='course' class='form-label'>Country</label>
              <select class='form-select' id='course' name='name_cours' required>
                <option value=''>Choose...</option>";

    $result = $person->getCourses($conn, $person->getEmail());
    if ($result->num_rows > 0) {
        while ($rows = $result->fetch_row()) {
            echo "<option value='$rows[0]'>".$rows[0]."</option>";
        }
    }
    echo "</select>";
    echo "        <div class='invalid-feedback'>
                Please select a cours
              </div>
            </div>";

    echo "
            <div class='col-md-4'>
              <label for='state' class='form-label'>State</label>
              <select class='form-select' id='state' required=''>
                <option value=''>Choose...</option>
                <option>California</option>
              </select>
              <div class='invalid-feedback'>
                Please provide a valid state.
              </div>
            </div>

            <div class='col-md-3'>
              <label for='zip' class='form-label'>Zip</label>
              <input type='text' class='form-control' id='zip' placeholder='' required=''>
              <div class='invalid-feedback'>
                Zip code required.
              </div>
            </div>
          </div>

          <hr class='my-4'>

          <hr class='my-4'>

          <button class='w-100 btn btn-primary btn-lg' type='submit'>Poser La Question</button>
        </form>
      </div>
    </div>
</main>
</div> 









</body>
</html>";
} else {

    echo "vous n'avez pas le droit de poser des questions";
}


//select DISTINCTROW t.email_user
//from (select DISTINCTROW php_course.name_cours,php_course.type_cours,p2.email_user from php_users p1,php_register,php_promotion,php_course, php_users p2 where p1.code_user=php_register.code_user and php_register.code_promo=php_promotion.code_promo and php_promotion.code_promo=php_course.code_promo and p1.email_user='mengying.zhao@ut-capitole.fr' and php_course.code_prof = p2.code_user and php_course.name_cours='Programmation structuree'  union
//select DISTINCTROW php_course.name_cours,php_course.type_cours,p2.email_user from php_users p1,php_register,php_promotion,php_course, php_users p2 where p1.code_user=php_register.code_user and php_register.code_promo=php_promotion.code_promo and php_promotion.code_promo=php_course.code_promo and p1.email_user='mengying.zhao@ut-capitole.fr' and php_course.code_cours_respon = p2.code_user and php_course.name_cours='Programmation structuree') as t
