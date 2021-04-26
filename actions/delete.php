<?php

use App\Propiedad\Propiedad;
use App\Session\Session;
use App\Imagen\Imagen;

require_once '../vendor/autoload.php';

session_start();

$pk = $_GET[ 'pk' ];

$propiedad = new Propiedad();

if ($propiedad->delete($pk, $propiedad->getByPk($pk)->getImagen())) {
	Session::set('status_notification_success', 'Propiedad eliminada correctamente.');
	header('location: ../admin/index.php');
	exit;
}
Session::set('status_notification_error', 'Propiedad eliminada correctamente.');
header('location: ../admin/index.php');


