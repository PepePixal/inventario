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

<!-- enctype="multipart/form-data" para poder subir archivos, fotos, a traves del form -->
<form action="<?php print RUTA?>ProductosControlador/alta/" method="POST" enctype="multipart/form-data"
    
    <div class="form-group text-start mt-2">
        <label for="idCategoria">* Categoría:</label>
            <!-- si la var 'baja' está definida y no es null, viene de baja lógica. deshabilita el select -->
        <select name="idCategoria" id="idCategoria" class="form-control"
            <?php if(isset($datos['baja'])) { print " disabled "; } ?>
        >
        <option value="void">--- Selecciona una Categoría ---</option>
        
        <!-- obtiene el resto de options para el select, de $datos, con un for  -->
        <?php
            //desde i = 0, mientras i sea menor que el total de elementos del array categorias
            for ($i=0; $i < count($datos["categorias"]); $i++) {
                //obtiene el id de cada categoria en la posición $i y lo asigna al value='' de la option, que es lo que se envía.
                print "<option value='".$datos["categorias"][$i]["id"]."'";

                //si la var "categoria", que viene de modificar() o de bajaLogica(), es igual a id de la categoría del select,
                //asígnale selected para que se muestre como seleccionada
                if(isset($datos["data"]["idCategoria"]) && $datos["data"]["idCategoria"] == $datos["categorias"][$i]["id"]) {
                    print " selected ";
                }
                
                //obtiene el nombre de la categoría en la posición $i y lo imprime como opción seleccionable
                print ">".$datos["categorias"][$i]["categoria"]."</option>";
            }
        ?>
        </select>
    </div>


    <div class="form-group text-start mt-2">
        <label for="nombre">* Nombre:</label>
        <!-- si se ha recibido pais, desde vista, se asigna el pais al value del input-->
        <!-- si se ha recibido baja, desde vista, se pone el input en disabled (desactivado)-->
        <input type="text" name="nombre" id="nombre" class="form-control" required 
        value="<?php isset($datos['data']['nombre']) ? print $datos['data']['nombre'] : '';?>"
        <?php if (isset($datos['baja'])) { print " disabled "; }?>
        ">
    </div>
    
    <div class="form-group text-start mt-2">
        <label for="descripcion">* Descripción:</label>
        <!-- si se ha recibido pais, desde vista, se asigna el pais al value del input-->
        <!-- si se ha recibido baja, desde vista, se pone el input en disabled (desactivado)-->
        <input type="text" name="descripcion" id="descripcion" class="form-control" required 
        value="<?php isset($datos['data']['descripcion']) ? print $datos['data']['descripcion'] : '';?>"
        <?php if (isset($datos['baja'])) { print " disabled "; }?>
        ">
    </div>

    <div class="form-group text-start mt-2">
        <label for="priecio">* Precio:</label>
        <!-- si se ha recibido pais, desde vista, se asigna el pais al value del input-->
        <!-- si se ha recibido baja, desde vista, se pone el input en disabled (desactivado)-->
        <input type="text" name="precio" id="precio" class="form-control" required
        value="<?php isset($datos['data']['precio']) ? print $datos['data']['precio'] : '';?>"
        <?php if (isset($datos['baja'])) { print " disabled "; }?>
        ">
    </div>

    <div class="form-group text-start mt-2">
        <label for="fotos">Foto:</label>
        <!-- si se ha recibido pais, desde vista, se asigna el pais al value del input-->
        <!-- si se ha recibido baja, desde vista, se pone el input en disabled (desactivado)-->
        <input type="file" multiple name="fotos[]" id="fotos" class="form-control" 
        value="<?php isset($datos['data']['fotos']) ? print $datos['data']['fotos'] : '';?>"
        <?php if (isset($datos['baja'])) { print " disabled "; }?>
        ">
    </div>

    <div class="form-group text-start mt-2">
        <label for="ubicacion">Ubicación:</label>
        <!-- si se ha recibido pais, desde vista, se asigna el pais al value del input-->
        <!-- si se ha recibido baja, desde vista, se pone el input en disabled (desactivado)-->
        <input type="text" name="ubicacion" id="ubicacion" class="form-control" 
        value="<?php isset($datos['data']['ubicacion']) ? print $datos['data']['ubicacion'] : '';?>"
        <?php if (isset($datos['baja'])) { print " disabled "; }?>
        ">
    </div>

    <div class="form-group text-start mt-2">
        <label for="iva">Iva:</label>
        <!-- si se ha recibido pais, desde vista, se asigna el pais al value del input-->
        <!-- si se ha recibido baja, desde vista, se pone el input en disabled (desactivado)-->
        <input type="text" name="iva" id="iva" class="form-control"
        value="<?php isset($datos['data']['iva']) ? print $datos['data']['iva'] : '';?>"
        <?php if (isset($datos['baja'])) { print " disabled "; }?>
        ">
    </div>

    <div class="form-group text-start mt-2">
        <label for="maximo">Stock máximo:</label>
        <!-- si se ha recibido pais, desde vista, se asigna el pais al value del input-->
        <!-- si se ha recibido baja, desde vista, se pone el input en disabled (desactivado)-->
        <input type="text" name="maximo" id="maximo" class="form-control"  
        value="<?php isset($datos['data']['maximo']) ? print $datos['data']['maximo'] : '';?>"
        <?php if (isset($datos['baja'])) { print " disabled "; }?>
        ">
    </div>
    
    <div class="form-group text-start mt-2">
        <label for="minimo">Stock mínimo:</label>
        <!-- si se ha recibido pais, desde vista, se asigna el pais al value del input-->
        <!-- si se ha recibido baja, desde vista, se pone el input en disabled (desactivado)-->
        <input type="text" name="minimo" id="minimo" class="form-control"  
        value="<?php isset($datos['data']['minimo']) ? print $datos['data']['minimo'] : '';?>"
        <?php if (isset($datos['baja'])) { print " disabled "; }?>
        ">
    </div>
    
    <div class="form-group text-start mt-2">
        <label for="comentario">Comentario:</label>
        <!-- si se ha recibido pais, desde vista, se asigna el pais al value del input-->
        <!-- si se ha recibido baja, desde vista, se pone el input en disabled (desactivado)-->
        <input type="text" name="comentario" id="comentario" class="form-control" 
        value="<?php isset($datos['data']['comentario']) ? print $datos['data']['comentario'] : '';?>"
        <?php if (isset($datos['baja'])) { print " disabled "; }?>
        ">
    </div>

    <div class="form-group text-start mt-2">
        <label for="idProveedor">* Proveedor:</label>
            <!-- si la var 'baja' está definida y no es null, viene de baja lógica. deshabilita el select -->
        <select name="idProveedor" id="idProveedor" class="form-control"
            <?php if(isset($datos['baja'])) { print " disabled "; } ?>
        >
        <option value="void">--- Selecciona un Proveedor ---</option>
        
        <!-- obtiene el resto de options para el select, de $datos, con un for  -->
        <?php
            //desde i = 0, mientras i sea menor que el total de elementos del array "proveedores"
            for ($i=0; $i < count($datos["proveedores"]); $i++) {
                //obtiene el id de cada tipo de proveedor y lo asigna al value='' de la option, que es lo que se envía.
                print "<option value='".$datos["proveedores"][$i]["id"]."'";

                //si la var "idProveedor", que viene de modificar() o de bajaLogica(), es igual a id del proveedor del select,
                //asígnale selected para que se muestre como seleccionada
                if(isset($datos["data"]["idProveedor"]) && $datos["data"]["idProveedor"] == $datos["proveedores"][$i]["id"]) {
                    print " selected ";
                }
                
                //obtiene el nombre del proveedor en la posicion $i y lo imprime como opción seleccionable
                print ">".$datos["proveedores"][$i]["nombre"]."</option>";
            }
        ?>
        </select>
    </div>

    <div class="form-group text-start">
        <!-- si se ha recibido id, desde vista, se asigna el id al value del input oculto, para enviar-->
        <input type="hidden" name="id" id="id" class="form-control"
        value="<?php if (isset($datos['data']['id'])) { print $datos['data']['id']; } else { print ""; } ?>">

        <!-- si se ha recibido pagina, desde vista, se asigna la pagina al value del input oculto, para enviar-->
        <input type="hidden" name="pagina" id="pagina" class="form-control"
        value="<?php if (isset($datos['pagina'])) { print $datos['pagina']; } else { print "1"; } ?>">

        <!-- si se ha recibido baja, desde vista, muestra botnes Eliminar y Volver -->
        <?php if (isset($datos['baja'])) { ?>
            <a href="<?php print RUTA;?>ProductosControlador/bajaLogica/<?php print $datos['data']['id']."/".$datos["pagina"]; ?>" 
            class="btn btn-danger mt-3 me-2">Eliminar Producto</a>

            <a href="<?php print RUTA.'ProductosControlador/'.$datos['pagina']; ?>" class="btn btn-secondary mt-3"><- Volver</a>
            <p class="mt-3 text-danger"><b>Una vez eliminado el Producto, no se podrá recuperar</b></p>
            
            <!-- si NO se ha recibido baja, desde vista, muestra el input Enviar país y botón Volver-->
        <?php } else { ?>

            <input type="submit" value="Enviar Producto" class="btn btn-success mt-4 me-2 ">
             
            <a href="<?php print RUTA;?>ProductosControlador" class="btn btn-secondary mt-4 "><- Tornar</a>

        <?php } ?>
    </div>
</form>

<?php include_once("piepagina.php"); ?>