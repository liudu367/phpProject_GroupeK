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
$person->setAll($conn, $_SESSION['username']);

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
      <li><a href='profil.php' class='nav-link px-2 link-dark'>Profil</a></li>
    </ul>

    <div class='col-md-3 text-end'>";

if (isset($_SESSION['password'])) {
    echo "Bienvenue"." ".$person->getNom()." ".$person->getPrenom();
}
echo " <a href='functions/disconnection.php' style='color: white'><button type='button' class='btn btn-primary'>Déconnexion</button></a>
    </div>
  </header>
  <div class='container py-5' id = 'Course'>
  <h2 class='pb-2 border-bottom' > Profil </h2 >
       <div class='row row-cols-4 g-4 py-5' >
  ";