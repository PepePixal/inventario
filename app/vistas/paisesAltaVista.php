<?php include_once("encabezado.php"); ?>

<!-- Para mostrar los errores de validación, si los hay -->
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

<form action="<?php print RUTA?>PaisesControlador/alta/" method="POST">
    <div class="form-group text-left">
        <label for="pais">* País:</label>
        <input type="text" name="pais" id="pais" class="form-control" 
        value="<?php isset($datos['data']['pais']) ? $datos['data']['pais'] : '';?>">
    </div>

    <div class="form-group text-left">
        <input type="hidden" name="id" id="id" class="form-control"
        value="<?php if(isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">

        <input type="submit" value="Enviar" class="btn btn-success mt-3">

        <a href="<?php print RUTA;?>PaisesControlador" class="btn btn-secondary mt-3"><- Volver</a>
    </div>
</form>

<?php include_once("piepagina.php"); ?>