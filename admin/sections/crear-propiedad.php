<?php

use App\Vendedores\Vendedores;
use App\Session\Session;


$vendedores = (new Vendedores())->getAll();

$errores = Session::flash('errores');
$old_data = Session::flash('old_data');

//Guardamos el Id del vendedor
$idVendedores = isset($old_data['fk_id_vendedores']) ? intval($old_data['fk_id_vendedores']) : '';
?>
<main class="contenedor sección">
	<h1>Crear</h1>
	<a href="index.php?s=panel" class="boton boton-verde">Volver</a>
	<form action="../actions/crear.php" method="post" class="formulario" enctype="multipart/form-data">
		<fieldset>
			<legend>Información general</legend>
			<label for="titulo">Titulo</label>
			<input type="text" id="titulo" name="titulo" placeholder="Titulo propiedad" value="<?php echo $old_data[ 'titulo' ] ?? '' ?>">
			<?php if (isset($errores[ 'titulo' ])) : ?>
				<?php foreach ($errores['titulo'] as $error): ?>
					<div class="msj-error">
						<?php echo $error; ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
			<label for="precio">Precio</label>
			<input type="number" id="precio" name="precio" placeholder="Precio propiedad" value="<?php echo $old_data[ 'precio' ] ?? '' ?>">
			<?php if (isset($errores[ 'precio' ])) : ?>
				<?php foreach ($errores['precio'] as $error): ?>
					<div class="msj-error">
						<?php echo $error; ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
			<label for="imagen">Imagen</label>
			<input type="file" id="imagen" name="imagen" accept="image/jpeg, imager/png">
			<label for="descripcion">Descripción</label>
			<textarea name="descripcion" id="descripcion"><?php echo $old_data[ 'descripcion' ] ?? '' ?></textarea>
			<?php if (isset($errores[ 'descripcion' ])) : ?>
				<?php foreach ($errores['descripcion'] as $error): ?>
					<div class="msj-error">
						<?php echo $error; ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
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
				value="<?php echo $old_data[ 'habitaciones' ] ?? '' ?>">
			<?php if (isset($errores[ 'habitaciones' ])) : ?>
				<?php foreach ($errores['habitaciones'] as $error): ?>
					<div class="msj-error">
						<?php echo $error; ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
			<label for="wc">Baños</label>
			<input type="number" id="wc" name="wc" placeholder="baños propiedad" value="<?php echo $old_data[ 'wc' ] ?? '' ?>">
			<?php if (isset($errores[ 'wc' ])) : ?>
				<?php foreach ($errores['wc'] as $error): ?>
					<div class="msj-error">
						<?php echo $error; ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
			<label for="estacionamiento">Estacionamiento</label>
			<input type="number" id="estacionamiento" name="estacionamiento" placeholder="estacionamiento propiedad" value="<?php echo $old_data[ 'estacionamiento' ] ?? '' ?>">
			<?php if (isset($errores[ 'estacionamiento' ])) : ?>
				<?php foreach ($errores['estacionamiento'] as $error): ?>
					<div class="msj-error">
						<?php echo $error; ?>
					</div>
				<?php endforeach; ?>
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
			<?php if (isset($errores[ 'fk_id_vendedores' ])) : ?>
				<?php foreach ($errores['fk_id_vendedores'] as $error): ?>
					<div class="msj-error">
						<?php echo $error; ?>
					</div>
				<?php endforeach; ?>
			<?php endif; ?>
		</fieldset>
		<input type="submit" value="Crear propiedad" class="boton boton-verde">
	</form>
</main>