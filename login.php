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
 <div class='container'>
  <form class='row g-3 needs-validation' action='./functions/verify_password.php' method='post' novalidate>
    <div class='row'>
        <div class='col align-content-center'>
             <img class='mb-4' src='./pic/logo-fr.jpg' alt='' width='120' height='120' >
             <h4 class='text-danger'>AUTHENTIFICATION</h4>
        </div>
    </div>

     
    <div class='row justify-content-center'>
       <div class='col-md-2'>
       <label for='username' class='form-label'>IDENTIFIANT</label>
       <input type='email' class='form-control' id='username' name='username' placeholder='name@example.com' required='required'>
       <div class='invalid-feedback'>
         nooooooooooooooooo
        </div>
       </div>
    </div>
    
  
   
    <div class='row justify-content-center'>
       <div class='col-md-2'>       
       <label for='floatingPassword'>MOT DE PASSE</label>
       </div>
     </div>
   
    <div class='row justify-content-center'>
       <div class='col-md-2'>
       <input type='password' class='form-control' id='floatingPassword' name='password' placeholder='MOT DE PASSE' required='required'>
       </div>
    </div>
 
    <div class='row justify-content-center'>
      <div class='col-md-6'>
         <button type='submit' class='btn btn-danger btn-sm' >SE CONNECTER </button>
      </div>
    </div>
  </form>
</div>
</main>
</body>
</html>";
