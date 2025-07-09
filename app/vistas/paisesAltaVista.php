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
        <!-- si se ha recibido pais, desde vista, se asigna el pais al value del input-->
        <!-- si se ha recibido baja, desde vista, se pone el input en disabled (desactivado)-->
        <input type="text" name="pais" id="pais" class="form-control" required 
        value="<?php isset($datos['data']['pais']) ? print $datos['data']['pais'] : '';?>"
        <?php if (isset($datos['baja'])) { print " disabled "; }?>
        ">
    </div>

    <div class="form-group text-left">
        <!-- si se ha recibido id, desde vista, se asigna el id al value del input oculto-->
        <input type="hidden" name="id" id="id" class="form-control"
        value="<?php if(isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">

        <!-- si se ha recibido baja, desde vista, muestra botnes Eliminar y Volver -->
        <?php if (isset($datos['baja'])) { ?>
            <a href="<?php print RUTA;?>PaisesControlador/bajaLogica/<?php print $datos['data']['id']; ?>" 
            class="btn btn-danger mt-3 me-2">Eliminar País</a>

            <a href="<?php print RUTA;?>PaisesControlador" class="btn btn-secondary mt-3"><- Volver</a>
            <p class="mt-3 text-danger"><b>Una vez eliminado el País, no se podrá recuperar</b></p>
            
        <!-- si NO se ha recibido baja, desde vista, muestra el input Enviar país y botón Volver-->
        <?php } else { ?>
            <input type="submit" value="Enviar país" class="btn btn-success mt-3 me-2 ">
    
            <a href="<?php print RUTA;?>PaisesControlador" class="btn btn-secondary mt-3 "><- Volver</a>
        
        <?php } ?>
    </div>
</form>

<?php include_once("piepagina.php"); ?>