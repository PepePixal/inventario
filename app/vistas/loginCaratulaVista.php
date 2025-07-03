<?php include_once("encabezado.php"); ?>
    <form action="#" method="post">
        <div class="form-group text-start">
            <label for="usuario">* Usuario:</label>
            <input id="usuario" type="email" class="form-control" placeholder="Usuario. Tu correo electrónico">
        </div>
        <div class="form-group text-start">
            <label for="clave">* Contraña:</label>
            <input id="clave" type="password" class="form-control" placeholder="Tu contraseña">
        </div>
        <div class="form-group text-start mt-2">
            <input type="submit" value="Enviar" class="btn btn-success">
        </div>
        <!-- enlace a controlador login / método olvidoVerificar -->
        <a href="<?php print RUTA; ?>LoginControlador/olvidoVerificar">¿Olvidaste tu clave de acceso?</a><br>   
    </form>
<?php include_once("piepagina.php"); ?>
           