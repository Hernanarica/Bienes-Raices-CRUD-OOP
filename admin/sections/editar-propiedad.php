<?php

use App\Propiedad\Propiedad;
use App\Vendedores\Vendedores;

$pk = $_GET[ 'pk' ];

$propiedad = (new Propiedad())->getByPk($pk);
$vendedores = (new Vendedores())->getAll();

$idVendedores = $propiedad->getFkIdVendedores();
?>
<main class="contenedor sección">
	<h1>Actualizar</h1>
	<a href="index.php?s=panel" class="boton boton-verde">Volver</a>
	<form method="post" class="formulario" enctype="multipart/form-data">
		<fieldset>
			<legend>Información general</legend>
			<label for="titulo">Titulo</label>
			<input type="text" id="titulo" name="titulo" placeholder="Titulo propiedad" value="<?php echo $propiedad->getTitulo(); ?>">
			<label for="precio">Precio</label>
			<input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?php echo $propiedad->getPrecio(); ?>">
			<label for="imagen">Imagen</label>
			<input type="file" id="imagen" name="imagen" value="<?php echo $propiedad->getImagen(); ?>" accept="image/jpeg, imager/png">
			<img src="../test-images/<?php echo $propiedad->getImagen();?>" alt="imagen de una casa">
			<label for="descripcion">Descripción</label>
			<textarea name="descripcion" id="descripcion"><?php echo $propiedad->getDescripcion(); ?></textarea>
		</fieldset>
		<fieldset>
			<legend>Información propiedad</legend>
			<label for="habitaciones">Habitaciones</label>
			<input
				type="number"
				id="habitaciones"
				name="habitaciones"
				placeholder="habitaciones propiedad"
				min="1"
				max="9"
				step="1"
				value="<?php echo $propiedad->getHabitaciones();?>">
			<label for="wc">Baños</label>
			<input type="number" id="wc" name="wc" placeholder="baños propiedad" value="<?php echo $propiedad->getWc();?>">
			<label for="estacionamiento">Estacionamiento</label>
			<input
				type="number"
				id="estacionamiento"
				name="estacionamiento"
				placeholder="estacionamiento propiedad"
				value="<?php echo $propiedad->getEstacionamiento();?>">
		</fieldset>
		<fieldset>
			<legend>Vendedor</legend>
			<select name="fk_id_vendedores">
				<option value="">--Seleccione--</option>
				<?php foreach ($vendedores as $vendedor): ?>
					<option <?php echo $idVendedores === $vendedor->getIdVendedores() ? 'selected' : ''; ?> value="<?php echo $vendedor->getIdVendedores(); ?>"><?php echo
						$vendedor->getNombre();
						?></option>
				<?php endforeach; ?>
			</select>
		</fieldset>
		<input type="submit" value="Actualizar propiedad" class="boton boton-verde">
	</form>
</main>