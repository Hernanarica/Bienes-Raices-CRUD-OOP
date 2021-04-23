<?php

use App\Auth\Auth;

session_start();

require_once '../vendor/autoload.php';

(new Auth())->logOut();
header('location: ../index.php');