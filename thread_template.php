<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include('./class/People/people.php');
$conn = require_once('./functions/connection_db.php');

use People\people;

$person = new people();
$person->setAll($conn, $_SESSION['username']);
$thread = $_POST['thread'];


if (count(json_decode($person->getQuestionOneCourse($conn, $thread), true))
    == 0
) {
    echo "il n'y a pas de question de"." ".$thread;

} else {
    $data = json_decode($person->getQuestionOneCourse($conn, $thread), true);
    $index = array_keys($data);
//column Code
    $codeArr = array();
    foreach ($data as $key => $value) {
        $codeArr[] = $value['code'];
    }
//column Title
    $titleArr = array();
    foreach ($data as $key => $value) {
        $titleArr[] = $value['title'];
    }
//column Question Asker
    $qaArr = array();
    foreach ($data as $key => $value) {
        $qaArr[] = $value['Question Asker'];
    }
//column Respondent
    $resArr = array();
    foreach ($data as $key => $value) {
        $resArr[] = $value['Respondent'];
    }
//column status
    $staArr = array();
    foreach ($data as $key => $value) {
        $staArr[] = $value['status'];
    }
//column update_time
    $updtArr = array();
    foreach ($data as $key => $value) {
        $updtArr[] = $value['update_time'];
    }

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
<h2>$thread</h2>
<div class='list-group'>
    <ul class='list-group list-group-horizontal'>
      <li class='list-group-item'>Code</li>
      <li class='list-group-item'>Titre</li>
      <li class='list-group-item'>Questionneur</li>
      <li class='list-group-item'>Répondant</li>
      <li class='list-group-item'>statuts</li>
      <li class='list-group-item'>Temps de mise à jour</li>
    </ul>
</div>";

    foreach ($index as $v) {
        echo "
      <ul class='list-group list-group-horizontal'>
      <li class='list-group-item'>$codeArr[$v]</li>
      <form action='post_template.php' method='post'>
      <input type='number'  name='code_que' value=$codeArr[$v] hidden>
      <li class='list-group-item'><input type='submit' value='$titleArr[$v]'></li>
      </form>
      <li class='list-group-item'>$qaArr[$v]</li>
      <li class='list-group-item'>$resArr[$v]</li>
      <li class='list-group-item'>$staArr[$v]</li>
      <li class='list-group-item'>$updtArr[$v]</li>
      </ul>
      ";

    }
}








