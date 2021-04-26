<?php
require_once '../vendor/autoload.php';
session_start();

use App\Usuario\Usuario;
use App\Validate\Validate;
use App\Session\Session;

try {
	$validation = new Validate($_POST, [
		'email'    => ['required'],
		'password' => ['required', 'min:6'],
	]);

	if (!$validation->passes()) {
		$usuario = new Usuario();
		if ($usuario->register($_POST)) {
			Session::set('status_notification_success', 'Te has registrado con exito');
			header('location: ../index.php');
			exit;
		}

		Session::set('status_notification_error', 'Los datos ingresados son incorrectos.');
		Session::set('old_data', $_POST);
		header('location: ../index.php?s=registrar');
		exit;
	}

	Session::set('old_data', $_POST);
	Session::set('errores', $validation->getErrores());

	header('location: ../index.php?s=registrar');
	exit;
} catch (\App\Exception\InvalidRuleException $e) {
	echo 'erro';
}
