<?php include_once("encabezado.php"); ?>
    <form action="<?php print RUTA; ?>LoginControlador/olvidoVerificar" method="post">
        <div class="form-group text-start">
            <label for="usuario">* Correo:</label>
            <input id="usuario" name="usuario" type="email" class="form-control" placeholder="Escribe tu email de usuario" required>
        </div>
        <div class="form-group text-start mt-2">
            <input type="submit" value="Enviar" class="btn btn-success">
            <!-- enlace a controlador login / método lolvidoVerificar -->
            <a href="<?php print RUTA; ?>login" class="btn btn-danger"><- Volver</a><br>   
        </div>
    </form>
<?php include_once("piepagina.php"); ?>