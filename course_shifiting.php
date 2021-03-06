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
        // Get the course table of professor and get all administrators of these courses
        var course_tab = <?php
            if ($person->getClass() == 1) {
                echo $person->getMyCourseTable($conn);
            }
            ?>;

        var course_admin_tab = <?php
            if ($person->getClass() == 1) {
                echo $person->getMyCourseAdmin($conn);
            }  ?> ;

        // Depending on the course selected, all the course types involved in the course are displayed
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

        // Depending on the type selected, all the course time involved in the course are displayed
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

        // Depending on the time selected,  the only one course code involved in the course is displayed
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

        // Depending on the course name selected,  all the course administrator involved in the course are displayed
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
           class="d-flex align-items-center col-md-2 mb-2 mb-md-0 text-dark text-decoration-none">
            <img src="pic/logo-fr.jpg" height="75px" width="75px">
        </a>
        <!--the navigate bar of this page-->
        <ul class='nav col-12 col-md-auto mb-2 justify-content-center mb-md-0'>
            <li><a href='index.php'
                   class='nav-link px-2 link-dark'>Page d'accueil</a></li>
            <li><a href='question_page.php' class='nav-link px-2 link-dark'>Page
                    des Questions</a>
            </li>
            <?php
            if ($person->getClass() != 3) {
                echo "<li><a href='transfer_question.php' class='nav-link px-2 link-dark'>Transf??rer</a></li>";
                echo "<li><a href='course_shifiting.php' class='nav-link px-2 link-danger'>D??placement du Cours</a></li>";
            }
            if ($person->getClass() == 2) {
                echo "<li><a href='page_statistiques.php' class='nav-link px-2 link-dark'>Statistiques</a></li>";
            }

            ?>
            <li><a href='profil.php' class='nav-link px-2 link-dark'>Profil</a>
            </li>
        </ul>

        <!--the login status-->
        <?php
        // if the password of session is set, it will display the welcome block
        if (isset($_SESSION['password'])) {
            echo "<div class='col-md-3 text-end'>";
            echo "Bienvenue"." ".$person->getLastname()." "
                .$person->getFirstname();
            echo "<a href='functions/disconnection.php' style='color: white'>
                <button type='button' class='btn btn-danger'>D??connexion
                </button>
            </a>
            </div>
    </header> ";
        }
        ?>


        <!--the page view of professor-->
        <?php
        //       if the class is 1 (professor)
        if ($person->getClass() == 1) {
//  Display the board where you can propose a change of course schedule
            echo "
        <h2 class='h2 text-danger'></h2>

        <div class='row row-cols-7'>
            <h4 class='mb-3 text-danger fw-bold'>Demander le d??placement</h4>
            <div class='row row-cols-7'>
            
            <div class='row'>
               <div class='col-md-3'>
               <p>Nom du Cours</p>
               </div>
               
               <div class='col-md-2'>
               <p>Type du Cours</p>
               </div>
               
               <div class='col-md-3'>
               <p>Temps Origianal</p>
               </div>
            </div>
            
           <div class='row'>
           <form class='row row-cols-7 pb-3 border-bottom' method='post'
                  action='functions/verify_course_shifting.php'>
                   <div class='row row-cols-7'>
            
            <div class='row pb-3'>
               <div class='col-md-3'>
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

            echo "<div class='col-md-2'>
                    <select class='form-select' id='type_course'
                            name='type_course'
                            onchange='selectTime()'
                            required>
                        <option value=''>Choisir...</option>
                    </select>
                </div>";

            echo "
                <div class='col-md-3'>
                    <select class='form-select' id='time_course'
                            name='time_course'
                            onchange='selectCode()'
                            required>
                        <option value=''>Choisir...</option>
                    </select>

                </div>
           </div>";


            echo "       
             <div class='row'>
               <div class='col-md-2'>
                <p>Code du cours</p>
            </div>
            
            <div class='col-md-3'>
                <p>Temps Chang??</p>
            </div>

            <div class='col-md-3'>
                <p>Admin D??mand??</p>
            </div>
            
            </div>";


            echo " <div class='row pb-3'>
                <div class='col-md-2'>
                    <select class='form-select' id='code_course'
                            name='code_course'
                            onchange=''
                            required>
                        <option value=''>Choisir...</option>
                    </select>
                </div>
                
                <div class='col-md-3'>
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
        </div>
        <div class='row'>
                <div class='col-lg-5'>
                    <input type='submit' class='btn btn-danger form-control'
                           value='Demander'>
                </div>
            </form>
        </div>      
               
           
            </div>";

//          Show the schedule of classes taught
            echo "
        <h4 class='mb-3 text-danger fw-bold'>Mes cours</h4>";
            echo " <div class='row row-cols-6'>
                    <div class='col-md-3'>
                    <p>Nom du cours</p>
                    </div>
                    
                    <div class='col-md-2 text-center'>
                    <p>Type du cours</p>
                    </div>
                    
                    <div class='col-md-2 text-center'>
                    <p>Temps du cours</p>
                    </div>
                    
                    <div class='col-md-2 text-center'>
                    <p>Code du cours</p>
                    </div>
                   
                   </div>";

            $courseTable = json_decode($person->getMyCourseTableHTML($conn),
                true);
            $index = array_keys($courseTable);
            foreach ($index as $value) {
                echo "<div class='row row-cols-6 pb-1'>
                        <div class='col-md-3'>";
                echo $courseTable[$value]["name_course"];
                echo "</div>";

                echo "<div class='col-md-2 text-center'>";
                echo $courseTable[$value]["type_course"];
                echo "</div>";

                echo "<div class='col-md-2 text-center'>";
                echo $courseTable[$value]["dt_course"];
                echo "</div>";

                echo "<div class='col-md-2 text-center'>";
                echo $courseTable[$value]["code_course"];
                echo "</div>";
                echo "</div>";
            }

            echo "<h4 class='mb-3 text-danger fw-bold border-top pt-2 pb-2'>Mes demandes</h4>";
            echo "<div class='row row-cols-7 pb-2'>
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

            echo "<div class='col-md-2'>";
            echo "Code du cours";
            echo "</div>";

            echo "<div class='col-md-2'>";
            echo "Email Admin";
            echo "</div>";

            echo "</div>";

//  Display a record of requests for course time changes ever sent by the professor
            $demandTable = json_decode($person->getMyDemandProf($conn),
                true);
            $index = array_keys($demandTable);
            foreach ($index as $value) {
                echo "<div class='row row-cols-7 pb-2'>
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

                echo "<div class='col-md-2'>";
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
        //       if the class is 2 (administrator)
        if ($person->getClass() == 2) {
//            Show all course request commands for which the administrator is responsible
            echo "<h4 class='mb-3 text-danger fw-bold '>Mes demandes Responsables</h4>";
            echo "<div class='row row-cols-7'>
            <div class='col-md-2 text-center'>";
            echo "Code de Demande";
            echo "</div>";

            echo "<div class='col-md-2 text-center'>";
            echo "Temps Original";
            echo "</div>";

            echo "<div class='col-md-2 text-center'>";
            echo "Temps Nouveau";
            echo "</div>";

            echo "<div class='col-md-1 text-center'>";
            echo "Status";
            echo "</div>";

            echo "<div class='col-md-1 text-center'>";
            echo "Code du cours";
            echo "</div>";

            echo "<div class='col-md-2 text-center'>";
            echo "Email Admin";
            echo "</div>";

            echo "<div class='col-md-2 text-center'>";
            echo "Bouton de gestion";
            echo "</div>";


            echo "</div>";


            $demandRespTab = json_decode($person->getMyDemandAdmin($conn),
                true);
            if ($demandRespTab != null) {
                $index = array_keys($demandRespTab);
                foreach ($index as $value) {
                    echo "<div class='row row-cols-7 '>
                        <div class='col-md-2 text-danger text-center'>";
                    echo $demandRespTab[$value]["code_dem"];
                    echo "</div>";

                    echo "<div class='col-md-2 text-center'>";
                    echo $demandRespTab[$value]["dt_cours_org"];
                    echo "</div>";

                    echo "<div class='col-md-2 text-center'>";
                    echo $demandRespTab[$value]["dt_cours_new"];
                    echo "</div>";

                    echo "<div class='col-md-1 text-center'>";
                    echo $demandRespTab[$value]["status_dem"];
                    echo "</div>";

                    echo "<div class='col-md-1 text-center'>";
                    echo $demandRespTab[$value]["code_cours"];
                    echo "</div>";

                    echo "<div class='col-md-2 text-center'>";
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
                          <input  class='btn btn-danger' type='submit'  value='Accepte'>
                      </form>";
                        echo "</div>";

                        echo "<div class='col-md-1'>";
                        echo "<form class='col-md-1' method='post' action='functions/verify_shifting_admin.php'>
                           <input hidden name='code_dem' type='number' value='$code_dem'>
                          <input hidden name='status_demand' type='text' value='Refuse'>
                          <input class='btn btn-primary'   type='submit'  value='Refuse'>
                      </form>";
                        echo "</div>";

                    } else {
                        echo "<div class='col-md-2 text-center'>
                        Vous avez d??j?? choisi.
                        </div>";
                    }
                    echo "</div>";

                }


            }


        }


        ?>

</div>
</body>
</html>


<!--the course table block of professor page-->
<?php


?>







