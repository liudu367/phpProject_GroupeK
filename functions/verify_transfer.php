<?php
/* this page will verify the demand of transferring question */
session_start();
header('Content-Type: text/html; charset=utf-8');
include('../class/People/people.php');
$conn = require_once('connection_db.php');

if (isset($_SESSION['password']) == false) {
    header('location:login.php');
}

use People\people;

// set a new object $person for the user
$person = new people();
$person->setUserPara($conn, $_SESSION['username']);
$email_original = $person->getEmail();

// get all data transferred from page "transfer_question.php"
$email_transfer = $_GET['email_transfer'];
$code_course = $_GET['code_cours'];

// set a SQL query in order to get the code user of $email_transfer
mysqli_select_db($conn, 'db_21912824_2');
$query
    = "select php_users.code_user  from php_users where php_users.email_user ='$email_transfer'";
$result = mysqli_query($conn, $query);
if ($result->num_rows > 0) {
    while ($rows = $result->fetch_row()) {
        $code_transfer = $rows[0];
    }
}


// set a SQL query in order to update the code of responsible user of this  question
// if the query is executed successfully, the server will send a email to the new responsible user of this question.

$query
    = "update php_question set php_question.code_user_res = '$code_transfer' where php_question.code_que = '$code_course'";
if (mysqli_query($conn, $query)) {
    echo "Transmission réussie";
    //    Send the email to the professor
    $to = $email_transfer;
    $subject = 'Question Transfert';
    $message = 'Je vous déja envoyé une Question';
    $headers = 'From: '."$email_original"."\r\n".
        'Reply - To:'."$email_transfer"."\r\n".
        'X - Mailer: PHP / '.phpversion();
    if (mail($to, $subject, $message, $headers) == true) {
        echo "<script>
        setTimeout(function(){window.location.href='../transfer_question.php';},2000);
    </script>";
    }
} else {
    echo "panne de transmission";
    echo "<script>
        setTimeout(function(){window.location.href='../transfer_question.php';},2000);
    </script>";
}





