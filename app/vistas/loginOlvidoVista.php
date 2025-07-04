<?php include_once("encabezado.php"); ?>
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