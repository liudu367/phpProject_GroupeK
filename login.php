<?php
header('Content-Type: text/html; charset=utf-8');
echo "
<!DOCTYPE>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <title>Help Desk Login</title>
    <!--css/js file referencccces-->
     <link rel='stylesheet' href='./css/bootstrap.css'>
    <link rel='stylesheet' href='./css/bootstrap.min.css'>
    <script src='./js/bootstrap.js'></script>
    <script src='./js/bootstrap.min.js'></script>
    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
</head>
<body class='text-center' data-new-gr-c-s-check-loaded='14.982.0' data-gr-ext-installed=''>
<main class='form-signin'>
  <form action='./functions/verify_password.php' method='post'>
    <img class='mb-4' src='./pic/logo-fr.jpg' alt='' >
    <h1 class='h3 mb-3 fw-normal'>AUTHENTIFICATION</h1>

    <div class='form-floating'>
      <input type='email' class='form-control' id='floatingInput' name='username' placeholder='name@example.com' required>
      <label for='floatingInput'>IDENTIFIANT</label>
    </div>
    <div class='form-floating'>
      <input type='password' class='form-control' id='floatingPassword' name='password' placeholder='MOT DE PASSE' required>
      <label for='floatingPassword'>MOT DE PASSE</label>
    </div>
    
    <button class='w-100 btn btn-lg btn-primary' type='submit'>SE CONNECTER</button>
  </form>
</main>
</body>
</html>";
