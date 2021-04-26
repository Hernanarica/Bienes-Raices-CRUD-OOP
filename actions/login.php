<?php

use App\Auth\Auth;
use App\Validate\Validate;
use App\Session\Session;

session_start();

require_once '../vendor/autoload.php';

$email    = $_POST[ 'email' ];
$password = $_POST[ 'password' ];

try {
	$validation = new Validate($_POST, [
		'email'    => ['required'],
		'password' => ['required', 'min:6'],
	]);

	if (!$validation->passes()) {
		$auth = (new Auth())->autenticate($email, $password);
		if ($auth) {
			Session::set('status_notification', [
				'status'  => true,
				'message' => 'Bienvenido al sistema',
			]);

			header('location: ../index.php');
			exit;
		}

		Session::set('old_data', $_POST);
		Session::set('status_notification', [
			'status'  => false,
			'message' => 'Los datos ingresados son incorrectos.',
		]);
		header('location: ../index.php?s=login');
		exit;
	}

	Session::set('old_data', $_POST);
	Session::set('errores', $validation->getErrores());

	header('location: ../index.php?s=login');
	exit;
} catch (\App\Exception\InvalidRuleException $e) {
	Session::set('status_notification', [
		'status'  => false,
		'message' => $e->getMessage(),
	]);
	header('location: ../index.php?s=login');
}

