<?php include_once("encabezado.php");?>

    <form action="<?php print RUTA; ?>LoginControlador/cambiarClave" method="POST">
        <div class="form-group text-left">
            <label for="clave">* Nueva Password de acceso:</label>
            <input type="password" name="clave" class="form-control" placeholder="Ecribe tu nueva Password" required>
        </div>
        <div class="form-group text-left mt-2">
            <label for="verifica">* Confirmar la nueva Password:</label>
            <input type="password" name="verifica" class="form-control" placeholder="Repite tu nueva Password" required>
        </div>
        <div class="form-group text-left mt-4">
            <input type="submit" value="Enviar Password" class="btn btn-success">
            <!-- input oculto para enviar el id, recibido en $datos['data'] -->
            <input type="hidden" name="id" id="id" value="<?php print $datos['data']; ?>">
        </div>
    </form>

<?php include_once("piepagina.php");?>
