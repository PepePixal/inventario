<?php include_once("encabezado.php"); ?>

<!-- Mostrar mensaje de error, si los hay -->
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
        <!-- para value=, si existe $datos['data']['usuario'] entonces ? le asigna 'usuario' a value=, de lo contrario : no asigna nada a value= -->
        <input id="usuario" name="usuario" type="email" class="form-control" placeholder="Usuario. Tu correo electrónico" value="<?php print isset($datos['data']['usuario']) ? $datos['data']['usuario'] : ''; ?>"  required >
    </div>
    
    <div class="form-group text-start mt-2">
        <label for="clave">* Contraseña:</label>
            <!-- para value=, si existe $datos['data']['clave'] entonces ? le asigna 'clave' a value=, de lo contrario : no asigna nada a value= -->
        <input id="clave" name="clave" type="password" class="form-control" placeholder="Tu contraseña" value="<?php print isset($datos['data']['clave']) ? $datos['data']['clave'] : ''; ?>"  required>
    </div>

    <div class="form-group text-start mt-2">
        <!-- si el elemtno 'usuario' está definido y no son NULL, entonces ? asigna (print) 'checked' al input checkbox, de lo contrario : no asigna (print) nada '' -->
        <input type="checkbox" name="recordar" <?php print isset($datos['data']['usuario']) ? 'checked' : ''; ?> >
        <label for="recordar">Recordar</label>
    </div>

    <div class="form-group text-start mt-3 mb-3">
        <input type="submit" value="Enviar" class="btn btn-success">
    </div>
    <!-- enlace a controlador login / método olvidoVerificar -->
    <a href="<?php print RUTA; ?>LoginControlador/olvidoVerificar">¿Olvidaste tu clave de acceso?</a><br>   
</form>

<?php include_once("piepagina.php"); ?>
           