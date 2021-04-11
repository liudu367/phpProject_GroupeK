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

    echo "<!DOCTYPE>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <title>Index</title>
    <!--css/js file references-->
    <link rel='stylesheet' href='./css/bootstrap.css'>
    <link rel='stylesheet' href='./css/bootstrap.min.css'>
    <script src='./js/bootstrap.js'></script>
    <script src='./js/bootstrap.min.js'></script>
    <script type='text/javascript'>
    var data =";
    echo $person->getJSONCourses($conn).";";
    echo " 
      function selectProfessor(){
      var source = document.getElementById('course');
      var target = document.getElementById('prof');
      var selected = source.options[source.selectedIndex].value;
      target.innerHTML='';
      for (var i= 0; i < data[selected].length;i++){
           var opt = document.createElement('option');
               opt.value = data[selected][i];
               opt.innerHTML = data[selected][i];
               document.getElementById('prof').appendChild(opt);
               
      }      
      } 
    </script>
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
      <li><a href='profil.php' class='nav-link px-2 link-dark'>Profil</a></li>
    </ul>

    <div class='col-md-3 text-end'>";

// the login status
    if (isset($_SESSION['password'])) {
        echo "Bienvenue"." ".$person->getNom()." ".$person->getPrenom();
    }
    echo " <a href='functions/disconnection.php' style='color: white'><button type='button' class='btn btn-danger'>Déconnexion</button></a>
    </div>
  </header>
  
  <main>
  <div class='row g-5'>
      <div class='col-md-7 col-lg-8'>
        <h4 class='mb-3'>Question</h4>
        <form action='functions/verify_question.php' method='post' class='needs-validation' novalidate=''>
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
              <textarea class='form-control' id='content' name='content_que' placeholder='écrire votre question' required></textarea>
              <div class='invalid-feedback'>
               Veuillez saisir votre question
              </div>
            </div>";

    echo "     <div class='col-md-5'>
              <label for='course' class='form-label'>Cours</label>
              <select class='form-select' id='course' name='name_cours' onchange='selectProfessor()' required>
                <option value=''>Choisir...</option>";

    $index = array_keys(json_decode($person->getJSONCourses($conn), true));

    foreach ($index as $v) {
        echo "<option value='$v'>".$v."</option>";
    }

    echo "</select>";
    echo "        <div class='invalid-feedback'>
                Veuillez sélectionner un cours
              </div>
            </div>";

    echo "
            <div class='col-md-4'>
              <label for='prof' class='form-label'>Professeur</label>
              <select class='form-select' id='prof' name='email_prof' required>
                <option value=''>Choisir...</option>
              </select>
              <div class='invalid-feedback'>
                Veuillez choisir un professeur
              </div>
            </div>


          <hr class='my-4'>


          <button class='w-100 btn btn-danger btn-lg' type='submit'>Poser La Question</button>
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
