<?php

use App\Propiedad\Propiedad;
use App\Imagen\Imagen;
use App\Validate\Validate;
use App\Session\Session;

require_once '../vendor/autoload.php';
session_start();

$data                     = $_POST;
$data[ 'fecha_creacion' ] = date('Y-m-d');


try {
	$validate = new Validate($data, [
		'titulo'           => ['required', 'min:2'],
		'precio'           => ['required', 'numeric'],
		'descripcion'      => ['required', 'min:2'],
		'habitaciones'     => ['required', 'numeric'],
		'wc'               => ['required', 'numeric'],
		'estacionamiento'  => ['required', 'numeric'],
		'fk_id_vendedores' => ['required'],
	]);

	if ($validate->passes()) {
		Session::set('errores', $validate->getErrores());
		Session::set('old_data', $_POST);
		header('location: ../admin/index.php?s=crear-propiedad');
		exit;
	}

	if (!empty($_FILES[ 'imagen' ][ 'tmp_name' ])) {
		$imagen           = new Imagen($_FILES[ 'imagen' ]);
		$nombreImagen     = $imagen->guardar('../test-images/');
		$data[ 'imagen' ] = $nombreImagen;
	}

	try {
		$propiedad = (new Propiedad())->create($data);
		header('location: ../admin/index.php');
		exit;
	} catch (Exception $e) {
		echo "error por creación";
	}

} catch (\App\Exception\InvalidRuleException $e) {
	echo "error por validacion";
}