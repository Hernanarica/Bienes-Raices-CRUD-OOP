<?php

use App\Propiedad\Propiedad;
use App\Imagen\Imagen;

require_once '../vendor/autoload.php';
session_start();

$data                     = $_POST;
$data[ 'fecha_creacion' ] = date('Y-m-d');

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
	echo "error";
}
