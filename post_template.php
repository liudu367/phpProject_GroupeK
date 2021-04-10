<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
include_once('./class/People/people.php');
include_once('./class/question/question.php');
$conn = require_once('./functions/connection_db.php');

use People\people;
use question\question;

$person = new people();
$person->setAll($conn, $_SESSION['username']);

$question = new question();
$codeQue = $_POST['code_que'];
$question->setAll($conn, $codeQue);
$data = json_decode($question->getAllResponses($conn), true);


$questionAll = $question->getAll();

foreach ($questionAll as $v) {
    echo $v;
}










