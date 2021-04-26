<?php
use App\Session\Session;

$errores  = Session::flash('errores');
$old_data = Session::flash('old_data');
?>
<main class="contenedor seccion contenido-centrado">
	<h1>Registra un nuevo usuario</h1>
	<form action="actions/register.php" method="post" class="formulario">
		<fieldset>
			<legend>Datos de registro</legend>
			<label for="email">Email</label>
			<input type="email" name="email" value="<?php echo $old_data[ 'email' ] ?? '' ?>" placeholder="Ingresa tu email" id="email" autocomplete="off">
			<?php if (isset($errores[ 'email' ])): ?>
				<?php foreach ($errores[ 'email' ] as $error): ?>
					<div class="msj-error"><?php echo $error; ?></div>
				<?php endforeach; ?>
			<?php endif; ?>
			<label for="password">Contraseña</label>
			<input type="password" name="password" placeholder="Ingresa tu contraseña" id="password" autocomplete="off">
			<?php if (isset($errores[ 'password' ])): ?>
				<?php foreach ($errores[ 'password' ] as $error): ?>
					<div class="msj-error"><?php echo $error; ?></div>
				<?php endforeach; ?>
			<?php endif; ?>
		</fieldset>
		<input type="submit" value="Registrar" class="boton boton-verde">
	</form>
</main>
