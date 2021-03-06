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
						<img src="../test-images/<?php echo $propiedad->getImagen(); ?>" alt="imagen de casa" class="imagen-tabla">
					</td>
					<td><?php echo $propiedad->getPrecio(); ?>$</td>
					<td>
						<a href="../actions/delete.php?pk=<?php echo $propiedad->getIdPropiedades(); ?>" class="boton-rojito-block">Eliminar</a>
						<a href="index.php?s=editar-propiedad&pk=<?php echo $propiedad->getIdPropiedades(); ?>" class="boton-amarillo-block">Actualizar</a>
					</td>
				</tr>
			<?php endforeach; ?>
		</tbody>
	</table>
</main>