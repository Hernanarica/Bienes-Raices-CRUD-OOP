<?php

use App\Session\Session;
use App\Propiedad\Propiedad;
use App\Validate\Validate;
use App\Imagen\Imagen;

require_once '../vendor/autoload.php';
session_start();

$data = $_POST;
$pk   = intval($_GET[ 'pk' ]);

try {
	$validate = new Validate($_POST, [
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
		Session::set('old_data', $data);
		header("location: ../admin/index.php?s=editar-propiedad&pk={$_GET[ 'pk' ]}");
		exit;
	}

	$imageName = (new Propiedad())->eliminarPorPk($pk);
	if (!empty($_FILES[ 'imagen' ][ 'tmp_name' ])) {
		$imagen           = new Imagen($_FILES[ 'imagen' ]);
		$nombreImagen     = $imagen->guardar('../test-images/');
		$data[ 'imagen' ] = $nombreImagen;

		unlink("../test-images/{$imageName->getImagen()}");
	} else {
		$data[ 'imagen' ] = $imageName->getImagen();
	}
//	echo "<pre>";
//	print_r();
//	echo "</pre>";
//	exit;

	$data[ 'pk' ] = $pk;

	$propiedad = (new Propiedad())->update($data);
	if ($propiedad) {
		header('location: ../admin/index.php');
		exit;
	}
	header("location: ../admin/index.php?s=editar-propiedad&pk={$_GET[ 'pk' ]}");
	exit;

} catch (\App\Exception\InvalidRuleException $e) {
	echo "error";
}
