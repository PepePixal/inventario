<?php include_once("encabezado.php");?>
    <?php
    //valida si llave "errores" está definida en $datos y no es NULL
    if (isset($datos["errores"])) {
        //valida si el contenido de $datos['errores'] es > 0
        if(count($datos["errores"]) > 0) {
            print "<div class='alert alert-danger mt-3'><ul>";
            //itera el arreglo "errores" y por cada error
            foreach ($datos["errores"] as $error) {
                print "<li>" . $error . "</li>";
            }
            print "</ul></div>";
        }
    }
    ?>
    <form action="<?php print RUTA; ?>LoginControlador/cambiarClave" method="POST">
        <div class="form-group text-left">
            <label for="clave">* Nueva Password de acceso:</label>
            <input type="password" name="clave" class="form-control" placeholder="Ecribe tu nueva Password" >
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
