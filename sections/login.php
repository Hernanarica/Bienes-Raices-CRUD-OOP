<?php


?>
<main class="contenedor seccion contenido-centrado">
	<h1>Iniciar sesión</h1>
	<form action="actions/login.php" method="post" class="formulario">
		<fieldset>
			<legend>Datos de registro</legend>
			<label for="email">Email</label>
			<input type="email" name="email" placeholder="Ingresa tu email" id="email" autocomplete="off">
			<!--				<div class="msj-error">-->
			<!--					&#215; -->
			<!--				</div>-->
			<label for="password">Contraseña</label>
			<input type="password" name="password" placeholder="Ingresa tu contraseña" id="password" autocomplete="off">
		</fieldset>
		<input type="submit" value="Registrar" class="boton boton-verde">
	</form>
</main>
