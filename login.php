<!--the page of login -->
<!DOCTYPE>
<html lang='fr'>
<head>
    <meta charset='UTF-8'>
    <title>Help Desk Login</title>
    <!--css/js file references-->
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
<body style="background-image: url('pic/backGroundPage_UT1.jpg'); height: 100vh; -webkit-background-size: cover;-moz-background-size: cover; -o-background-size: cover; background-size: cover"
      class='text-center' data-new-gr-c-s-check-loaded='14.982.0'
      data-gr-ext-installed=''>

<main class='form-signin'>
    <div class='container align-content-center'>
        <form class='row g-3 needs-validation'
              action='./functions/verify_password.php' method='post' novalidate>
            <div class="w-100"></div>
            <div class="w-100"></div>
            <div class="w-100"></div>
            <div class="w-100"></div>
            <div class="w-100"></div>
            <div class="w-100"></div>
            <div class="w-100"></div>
            <div class="w-100"></div>
            <div class="w-100"></div>
            <div class="w-100"></div>
            <div class="w-100"></div>
            <div class="w-100"></div>

            <!--section of authentication -->
            <div class='row'>
                <div class='col'>
                    <img class='mb-4' src='./pic/logo-fr.jpg' alt='' width='120'
                         height='120'>
                    <h4 class='text-danger'>UT1 Help Desk</h4>
                </div>
            </div>

            <!--section of identify-->
            <div class='row justify-content-center'>
                <div class='col-sm-3'>
                    <label for='username' class='form-label text-danger'>IDENTIFIANT</label>
                    <input type='email' class='form-control' id='username'
                           name='username' placeholder='name@example.com'
                           required='required'>
                    <div class='invalid-feedback'>
                        nooooooooooooooooo
                    </div>
                </div>
            </div>


            <!--section fo password-->
            <div class='row justify-content-center'>
                <div class='col-sm-3'>
                    <label class="text-danger" for='floatingPassword'>MOT DE
                        PASSE</label>
                </div>
            </div>

            <div class='row justify-content-center'>
                <div class='col-Sm-3'>
                    <input type='password' class='form-control text-danger'
                           id='floatingPassword' name='password'
                           placeholder='MOT DE PASSE' required='required'>
                </div>
            </div>
            <div class="w-100"></div>

            <!--section of button connect-->
            <div class='row justify-content-center'>
                <div class='col-md-6'>
                    <button type='submit' class='btn btn-danger btn-sm'>SE
                        CONNECTER
                    </button>
                </div>
            </div>
        </form>
    </div>
</main>
</body>
</html>
