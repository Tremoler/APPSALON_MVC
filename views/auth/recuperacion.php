<h1 class="nombre-pagina">Olvide Password</h1>
<p class="descripcion-pagina">Reestablece tu password colocando tu email</p>

<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

<form class="formulario" method="POST" action="/recuperacion">
    <div class="campo">
        <label for="email">Email</label>
        <input
        type="email"
        name="email"
        id="email"
        placeholder="Tu Email"
        />
    </div>

    <input class="boton" type="submit" value="Enviar Mail">
</form>

<div class="acciones">
    <a href="/crear-cuenta">Aun no tiene una cuenta? Crear una</a>
    <a href="/">Ya tienes una cuenta? Inicia Sesion</a>
</div>