<?php include_once("encabezado.php"); ?>

    <!-- Mostrar mensaje de error o éxito -->
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
                
    <form action="<?php print RUTA; ?>LoginControlador/verificar" method="post">
        <div class="form-group text-start">
            <label for="usuario">* Usuario:</label>
            <input id="usuario" name="usuario" type="email" class="form-control" placeholder="Usuario. Tu correo electrónico" required>
        </div>
        <div class="form-group text-start mt-2">
            <label for="clave">* Contraseña:</label>
            <input id="clave" name="clave" type="password" class="form-control" placeholder="Tu contraseña" required>
        </div>
        <div class="form-group text-start mt-3 mb-3">
            <input type="submit" value="Enviar" class="btn btn-success">
        </div>
        <!-- enlace a controlador login / método olvidoVerificar -->
        <a href="<?php print RUTA; ?>LoginControlador/olvidoVerificar">¿Olvidaste tu clave de acceso?</a><br>   
    </form>
<?php include_once("piepagina.php"); ?>
           