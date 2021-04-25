<?php
/*this page will destroy the session and get back to the login page*/
session_start();
header('Content-Type: text/html; charset=utf-8');

session_destroy();
header('location:../login.php');