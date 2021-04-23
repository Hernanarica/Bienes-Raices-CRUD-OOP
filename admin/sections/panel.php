<?php

use App\Propiedad\Propiedad;

$propiedades = (new Propiedad())->getAll();
?>
<main class="contenedor sección">
	<h1>Administrador de vienes raíces</h1>
	<a href="index.php?s=crear-propiedad" class="boton boton-verde">Crear propiedad</a>
	<table class="propiedades">
		<thead>
			<tr>
				<th>ID</th>
				<th>Titulo</th>
				<th>Imagen</th>
				<th>Precio</th>
				<th>Acciones</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($propiedades as $propiedad): ?>
				<tr>
					<td><?php echo $propiedad->getIdPropiedades(); ?></td>
					<td><?php echo $propiedad->getTitulo(); ?></td>
					<td>
						<img src="" alt="imagen de casa" class="imagen-tabla">
					</td>
					<td><?php echo $propiedad->getPrecio(); ?>$</td>
					<td>
						<a href="" class="boton-rojito-block">Eliminar</a>
						<a href="" class="boton-amarillo-block">Actualizar</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</main>