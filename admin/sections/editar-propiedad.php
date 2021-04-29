<?php

use App\Propiedad\Propiedad;
use App\Vendedores\Vendedores;
use App\Session\Session;

$pk = $_GET[ 'pk' ];

$propiedad  = (new Propiedad())->getByPk($pk);
$vendedores = (new Vendedores())->getAll();

$errores  = Session::flash('errores');
$old_data = Session::flash('old_data');

if (isset($old_data['fk_id_vendedores'])) {
	$idVendedores = intval($old_data[ 'fk_id_vendedores' ] );
} else {
	$idVendedores = $propiedad->getFkIdVendedores();
}

echo "<pre>";
print_r($old_data);
echo "</pre>";
?>
<main class="contenedor sección">
	<h1>Actualizar</h1>
	<a href="index.php?s=panel" class="boton boton-verde">Volver</a>
	<form action="<?php echo "../actions/editar.php?pk={$pk}"; ?>" method="post" class="formulario" enctype="multipart/form-data">
		<fieldset>
			<legend>Información general</legend>
			<label for="titulo">Titulo</label>
			<input type="text" id="titulo" name="titulo" placeholder="Titulo propiedad" value="<?php echo $old_data['titulo'] ?? $propiedad->getTitulo(); ?>">
			<?php if (isset($errores[ 'titulo' ])): ?>
				<?php foreach ($errores['titulo'] as $error): ?>
					<div class="msj-error">
						<?php echo $error; ?>
					</div>
				<?php endforeach;?>
			<?php endif; ?>
			<label for="precio">Precio</label>
			<input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?php echo $old_data['precio'] ?? $propiedad->getPrecio(); ?>">
			<?php if (isset($errores[ 'precio' ])): ?>
				<?php foreach ($errores['precio'] as $error): ?>
					<div class="msj-error">
						<?php echo $error; ?>
					</div>
				<?php endforeach;?>
			<?php endif; ?>
			<label for="imagen">Imagen</label>
			<input type="file" id="imagen" name="imagen" value="<?php echo $propiedad->getImagen(); ?>" accept="image/jpeg, imager/png">
			<img src="../test-images/<?php echo $propiedad->getImagen(); ?>" alt="imagen de una casa">
			<label for="descripcion">Descripción</label>
			<textarea name="descripcion" id="descripcion"><?php echo $old_data['descripcion'] ?? $propiedad->getDescripcion(); ?></textarea>
			<?php if (isset($errores[ 'descripcion' ])): ?>
				<?php foreach ($errores['descripcion'] as $error): ?>
					<div class="msj-error">
						<?php echo $error; ?>
					</div>
				<?php endforeach;?>
			<?php endif; ?>
		</fieldset>
		<fieldset>
			<legend>Información propiedad</legend>
			<label for="habitaciones">Habitaciones</label>
			<input type="number" id="habitaciones" name="habitaciones" placeholder="habitaciones propiedad" min="1" max="9" step="1"
			       value="<?php echo $old_data['habitaciones'] ?? $propiedad->getHabitaciones(); ?>">
			<?php if (isset($errores[ 'habitaciones' ])): ?>
				<?php foreach ($errores['habitaciones'] as $error): ?>
					<div class="msj-error">
						<?php echo $error; ?>
					</div>
				<?php endforeach;?>
			<?php endif; ?>
			<label for="wc">Baños</label>
			<input type="number" id="wc" name="wc" placeholder="baños propiedad" value="<?php echo $old_data['wc'] ?? $propiedad->getWc(); ?>">
			<?php if (isset($errores[ 'wc' ])): ?>
				<?php foreach ($errores['wc'] as $error): ?>
					<div class="msj-error">
						<?php echo $error; ?>
					</div>
				<?php endforeach;?>
			<?php endif; ?>
			<label for="estacionamiento">Estacionamiento</label>
			<input type="number" id="estacionamiento" name="estacionamiento" placeholder="estacionamiento propiedad" value="<?php echo $old_data['estacionamiento'] ??
				$propiedad->getEstacionamiento(); ?>">
			<?php if (isset($errores[ 'estacionamiento' ])): ?>
				<?php foreach ($errores['estacionamiento'] as $error): ?>
					<div class="msj-error">
						<?php echo $error; ?>
					</div>
				<?php endforeach;?>
			<?php endif; ?>
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
			<?php if (isset($errores[ 'fk_id_vendedores' ])): ?>
				<?php foreach ($errores['fk_id_vendedores'] as $error): ?>
					<div class="msj-error">
						<?php echo $error; ?>
					</div>
				<?php endforeach;?>
			<?php endif; ?>
		</fieldset>
		<input type="submit" value="Actualizar propiedad" class="boton boton-verde">
	</form>
</main>