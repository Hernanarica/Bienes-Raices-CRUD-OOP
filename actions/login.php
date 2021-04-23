<?php

use App\Auth\Auth;

session_start();

require_once '../vendor/autoload.php';

$email    = $_POST[ 'email' ];
$password = $_POST[ 'password' ];

$auth = (new Auth())->autenticate($email, $password);

if ($auth) {
	header('location: ../index.php');
	exit;
}

header('location: ../index.php?s=login');





