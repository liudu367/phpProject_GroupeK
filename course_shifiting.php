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
    <script type="text/javascript">

        var course_tab = <?php
            if ($person->getClass() == 1) {
                echo $person->getMyCourseTable($conn);
            }
            ?>;

        var course_admin_tab = <?php
            if ($person->getClass() == 1) {
                echo $person->getMyCourseAdmin($conn);
            }  ?> ;

        function selectType() {
            var source = document.getElementById("name_course");
            var target = document.getElementById("type_course");
            var selected = source.options[source.selectedIndex].value;
            target.innerHTML = "";

            var kk = document.createElement("option");
            kk.value = "";
            kk.innerHTML = "Choisir...";
            document.getElementById("type_course").append(kk);


            for (var i = 0; i < Object.keys(course_tab[selected]).length; i++) {
                var k = Object.keys(course_tab[selected]);
                var opt = document.createElement("option");
                opt.value = k[i];
                opt.innerHTML = k[i];
                document.getElementById("type_course").appendChild(opt);
            }
        }

        function selectTime() {
            var source1 = document.getElementById("name_course");
            var source2 = document.getElementById("type_course");
            var target1 = document.getElementById("time_course");
            var selected1 = source1.options[source1.selectedIndex].value;
            var selected2 = source2.options[source2.selectedIndex].value;
            target1.innerHTML = "";

            var kk = document.createElement("option");
            kk.value = "";
            kk.innerHTML = "Choisir...";
            document.getElementById("time_course").append(kk);


            for (var i = 0; i < Object.keys(course_tab[selected1][selected2]).length; i++) {
                var time_table = Object.keys(course_tab[selected1][selected2]);
                var opt = document.createElement("option");
                opt.value = time_table[i];
                opt.innerHTML = time_table[i];
                document.getElementById("time_course").appendChild(opt);
            }
        }

        function selectCode() {
            var source1 = document.getElementById("name_course");
            var source2 = document.getElementById("type_course");
            var source3 = document.getElementById("time_course");
            var target = document.getElementById("code_course");
            var selected1 = source1.options[source1.selectedIndex].value;
            var selected2 = source2.options[source2.selectedIndex].value;
            var selected3 = source3.options[source3.selectedIndex].value;
            target.innerHTML = "";

            var kk = document.createElement("option");
            kk.value = "";
            kk.innerHTML = "Choisir...";
            document.getElementById("code_course").append(kk);


            var opt = document.createElement("option");
            opt.value = course_tab[selected1][selected2][selected3];
            opt.innerHTML = course_tab[selected1][selected2][selected3];
            document.getElementById("code_course").appendChild(opt);

        }

        function selectAdmin() {
            var source = document.getElementById("name_course");
            var target = document.getElementById("email_admin");
            var selected = source.options[source.selectedIndex].value;
            target.innerHTML = "";

            for (var i = 0; i < course_admin_tab[selected].length; i++) {
                var opt = document.createElement("option");
                opt.value = course_admin_tab[selected][i];
                opt.innerHTML = course_admin_tab[selected][i];
                document.getElementById("email_admin").appendChild(opt);

            }


        }


    </script>
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
                   class='nav-link px-2 link-dark'>Page d'accueil</a></li>
            <li><a href='question_page.php' class='nav-link px-2 link-dark'>Page
                    des Questions</a>
            </li>
            <?php
            if ($person->getClass() != 3) {
                echo "<li><a href='transfer_question.php' class='nav-link px-2 link-dark'>Transférer</a></li>";
                echo "<li><a href='course_shifiting.php' class='nav-link px-2 link-danger'>Déplacement du Cours</a></li>";
            } ?>
            <li><a href='profil.php' class='nav-link px-2 link-dark'>Profil</a>
            </li>
        </ul>
        <!--the login status-->
        <?php
        //        the login status
        if (isset($_SESSION['password'])) {
            echo "<div class='col-md-3 text-end'>";
            echo "Bienvenue"." ".$person->getNom()." ".$person->getPrenom();
            echo "<a href='functions/disconnection.php' style='color: white'>
                <button type='button' class='btn btn-danger'>Déconnexion
                </button>
            </a>
            </div>
    </header> ";
        }
        ?>

        <!--the page view of professor-->
        <?php
        if ($person->getClass() == 1) {
            echo "

        <h2 class='h2 text-danger'></h2>

        <div class='row row-cols-7'>
            <h4 class='mb-3 text-danger fw-bold'>Demander le déplacement</h4>
            <div class='row row-cols-7'>

            <div class='col-md-2'>
                <p>Nom du Cours</p>
            </div>
            <div class='col-md-1'>
                <p>Type de cours</p>
            </div>
            <div class='col-md-3'>
                <p>Temps Original</p>
            </div>

            <div class='col-md-1'>
                <p>Code du cours</p>
            </div>
            
            <div class='col-md-1'>
                <p>Temps Changé</p>
            </div>

            <div class='col-md-3'>
                <p>Admin Démandé</p>
            </div>
        </div>
        
            <form class='row row-cols-7 pb-3 border-bottom' method='post'
                  action='functions/verify_course_shifting.php'>
                <div class='col-md-2'>
                    <select class='form-select' id='name_course'
                            name='name_course'
                            onchange='selectType(); selectAdmin()'
                            required>
                        <option value=''>Choisir...</option>";


            $index1
                = array_keys(json_decode($person->getMyCourse($conn),
                true));
            foreach ($index1 as $v1) {
                echo "<option value='$v1'>".$v1
                    ."</option>";
            }

            echo " </select>
                </div>";

            echo "<div class='col-md-1'>
                    <select class='form-select' id='type_course'
                            name='type_course'
                            onchange='selectTime()'
                            required>
                        <option value=''>Choisir...</option>
                    </select>
                </div>

                <div class='col-md-3'>
                    <select class='form-select' id='time_course'
                            name='time_course'
                            onchange='selectCode()'
                            required>
                        <option value=''>Choisir...</option>
                    </select>

                </div>

                <div class='col-md-1'>
                    <select class='form-select' id='code_course'
                            name='code_course'
                            onchange=''
                            required>
                        <option value=''>Choisir...</option>
                    </select>
                </div>
                
                <div class='col-md-1'>
                    <input type='datetime-local' class='form-control' id='time_change'
                            name='time_change'
                            onchange=''
                            required>   
                </div>
                
                <div class='col-md-3'>
                    <select class='form-select' id='email_admin'
                            name='email_admin'
                            onchange=''
                            required>
                        <option value=''>Choisir...</option>
                    </select>
                </div>
                <div class='col-md-1'>
                    <input type='submit' class='btn btn-danger'
                           value='Demander'>
                </div>
            </form>
        </div>

        <h4 class='mb-3 text-danger fw-bold'>Mes cours</h4>";
            echo " <div class='row row-cols-6'>
                    <div class='col-md-3'>
                    <p>Nom du cours</p>
                    </div>
                    
                    <div class='col-md-2'>
                    <p>Type du cours</p>
                    </div>
                    
                    <div class='col-md-2'>
                    <p>Temps du cours</p>
                    </div>
                    
                    <div class='col-md-2'>
                    <p>Code du cours</p>
                    </div>
                   
                   </div>";

            $courseTable = json_decode($person->getMyCourseTableHTML($conn),
                true);
            $index = array_keys($courseTable);
            foreach ($index as $value) {
                echo "<div class='row row-cols-6'>
                        <div class='col-md-3'>";
                echo $courseTable[$value]["name_course"];
                echo "</div>";

                echo "<div class='col-md-2'>";
                echo $courseTable[$value]["type_course"];
                echo "</div>";

                echo "<div class='col-md-2'>";
                echo $courseTable[$value]["dt_course"];
                echo "</div>";

                echo "<div class='col-md-2'>";
                echo $courseTable[$value]["code_course"];
                echo "</div>";
                echo "</div>";
            }

            echo "<h4 class='mb-3 text-danger fw-bold border-top pt-3'>Mes demandes</h4>";
            echo "<div class='row row-cols-7'>
                        <div class='col-md-2'>";
            echo "Code de Demande";
            echo "</div>";

            echo "<div class='col-md-2'>";
            echo "Temps Original";
            echo "</div>";

            echo "<div class='col-md-2'>";
            echo "Temps Nouveau";
            echo "</div>";

            echo "<div class='col-md-1'>";
            echo "Status";
            echo "</div>";

            echo "<div class='col-md-1'>";
            echo "Code du cours";
            echo "</div>";

            echo "<div class='col-md-2'>";
            echo "Email Admin";
            echo "</div>";

            echo "</div>";


            $demandTable = json_decode($person->getMyDemandProf($conn),
                true);
            $index = array_keys($demandTable);
            foreach ($index as $value) {
                echo "<div class='row row-cols-7'>
                        <div class='col-md-2'>";
                echo $demandTable[$value]["code_dem"];
                echo "</div>";

                echo "<div class='col-md-2'>";
                echo $demandTable[$value]["dt_cours_org"];
                echo "</div>";

                echo "<div class='col-md-2'>";
                echo $demandTable[$value]["dt_cours_new"];
                echo "</div>";

                echo "<div class='col-md-1'>";
                echo $demandTable[$value]["status_dem"];
                echo "</div>";

                echo "<div class='col-md-1'>";
                echo $demandTable[$value]["code_cours"];
                echo "</div>";

                echo "<div class='col-md-2'>";
                echo $demandTable[$value]["email_admin"];
                echo "</div>";


                echo "</div>";
            }


        }
        ?>
        <!--the page view of admin-->
        <?php
        if ($person->getClass() == 2) {
            echo "<h4 class='mb-3 text-danger fw-bold '>Mes demandes Responsables</h4>";
            echo "<div class='row row-cols-7'>
            <div class='col-md-2'>";
            echo "Code de Demande";
            echo "</div>";

            echo "<div class='col-md-2'>";
            echo "Temps Original";
            echo "</div>";

            echo "<div class='col-md-2'>";
            echo "Temps Nouveau";
            echo "</div>";

            echo "<div class='col-md-1'>";
            echo "Status";
            echo "</div>";

            echo "<div class='col-md-1'>";
            echo "Code du cours";
            echo "</div>";

            echo "<div class='col-md-2'>";
            echo "Email Admin";
            echo "</div>";

            echo "</div>";


            $demandRespTab = json_decode($person->getMyDemandAdmin($conn),
                true);
            $index = array_keys($demandRespTab);
            foreach ($index as $value) {
                echo "<div class='row row-cols-7 '>
                        <div class='col-md-2 text-danger'>";
                echo "<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='text-center bi bi-question-circle-fill' viewBox='0 0 16 16'><path d='M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z'/>
                </svg>";
                echo $demandRespTab[$value]["code_dem"];
                echo "</div>";

                echo "<div class='col-md-2'>";
                echo $demandRespTab[$value]["dt_cours_org"];
                echo "</div>";

                echo "<div class='col-md-2'>";
                echo $demandRespTab[$value]["dt_cours_new"];
                echo "</div>";

                echo "<div class='col-md-1'>";
                echo $demandRespTab[$value]["status_dem"];
                echo "</div>";

                echo "<div class='col-md-1'>";
                echo $demandRespTab[$value]["code_cours"];
                echo "</div>";

                echo "<div class='col-md-2'>";
                echo $demandRespTab[$value]["email_admin"];
                echo "</div>";


                $code_dem = $demandRespTab[$value]["code_dem"];
                $datetime_new = $demandRespTab[$value]["dt_cours_new"];
                $code_cours = $demandRespTab[$value]["code_cours"];
                $status_dem = $demandRespTab[$value]['status_dem'];


                if ($status_dem != 'Refuse'
                    and $demandRespTab[$value]["status_dem"] != 'Accepte'
                ) {
                    echo "<div class='col-md-1'>";
                    echo "<form class='col-md-1' method='post' action='functions/verify_shifting_admin.php'>
                          <input hidden name='dt_cours_new' type='text' value='$datetime_new'>
                          <input hidden name='code_cours' type='number' value='$code_cours'>
                          <input hidden name='code_dem' type='number' value='$code_dem'>
                          <input hidden name='status_demand' type='text' value='Accepte'>
                          <input type='submit'  value='Accepte'>
                      </form>";
                    echo "</div>";

                    echo "<div class='col-md-1'>";
                    echo "<form class='col-md-1' method='post' action='functions/verify_shifting_admin.php'>
                           <input hidden name='code_dem' type='number' value='$code_dem'>
                          <input hidden name='status_demand' type='text' value='Refuse'>
                          <input type='submit'  value='Refuse'>
                      </form>";
                    echo "</div>";
                    echo "</div>";

                }
                echo "</div>";

            }


        }


        ?>

</div>
</body>
</html>


<!--the course table block of professor page-->
<?php


?>







