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

<form action="<?php print RUTA?>UsuariosControlador/alta/" method="POST">

    <div class="form-group text-start">
        <label for="tipoUsuario">* Tipo de Usuario:</label>
            <!-- si la var 'baja' está definida y no es null, viene de baja lógica. deshabilita el select -->
        <select name="tipoUsuario" id="tipoUsuario" class="form-control"
            <?php if(isset($datos['baja'])) { print " disabled "; } ?>
        >
        <option value="void">--- Selecciona un tipo de Usuario ---</option>
        
        <!-- obtiene el resto de options para el select, de $datos, con un for  -->
        <?php
            //desde i = 0, mientras i sea menor que el total de elementos del array TipoUsuarios
            for ($i=0; $i < count($datos["tiposUsuarios"]); $i++) {
                //obtiene el id de cada tipo de usuario y lo asigna al value='' de la option, que es lo que se envía.
                print "<option value='".$datos["tiposUsuarios"][$i]["id"]."'";

                //si la var "tipoUsuario", que viene de modificar() o de bajaLogica(), es igual a id del tipoUsuarios del select,
                //asígnale selected para que se muestre como seleccionada
                if(isset($datos["data"]["tipoUsuario"]) && $datos["data"]["tiposUsuario"] == $datos["tiposUsuarios"][$i]["id"]) {
                    print " selected ";
                }
                
                //obtiene el tipoUsuario (string) de cada tipo de usuario y lo imprime como opción seleccionable
                print ">".$datos["tiposUsuarios"][$i]["tipoUsuario"]."</option>";
            }
        ?>
        </select>
    </div>

    <div class="form-group text-start mt-2">
        <label for="nombres">* Nombre:</label>
        <!-- si se ha recibido pais, desde vista, se asigna el pais al value del input-->
        <!-- si se ha recibido baja, desde vista, se pone el input en disabled (desactivado)-->
        <input type="text" name="nombres" id="nombres" class="form-control" required 
        value="<?php isset($datos['data']['nombres']) ? print $datos['data']['nombres'] : '';?>"
        <?php if (isset($datos['baja'])) { print " disabled "; }?>
        ">
    </div>
    
    <div class="form-group text-start mt-2">
        <label for="apellidos">* Apellidos:</label>
        <!-- si se ha recibido pais, desde vista, se asigna el pais al value del input-->
        <!-- si se ha recibido baja, desde vista, se pone el input en disabled (desactivado)-->
        <input type="text" name="apellidos" id="apellidos" class="form-control" required 
        value="<?php isset($datos['data']['apellidos']) ? print $datos['data']['apellidos'] : '';?>"
        <?php if (isset($datos['baja'])) { print " disabled "; }?>
        ">
    </div>

    <div class="form-group text-start mt-2">
        <label for="direccion">Dirección:</label>
        <!-- si se ha recibido pais, desde vista, se asigna el pais al value del input-->
        <!-- si se ha recibido baja, desde vista, se pone el input en disabled (desactivado)-->
        <input type="text" name="direccion" id="direccion" class="form-control" 
        value="<?php isset($datos['data']['direccion']) ? print $datos['data']['direccion'] : '';?>"
        <?php if (isset($datos['baja'])) { print " disabled "; }?>
        ">
    </div>

    <div class="form-group text-start mt-2">
        <label for="telefono">Teléfono:</label>
        <!-- si se ha recibido pais, desde vista, se asigna el pais al value del input-->
        <!-- si se ha recibido baja, desde vista, se pone el input en disabled (desactivado)-->
        <input type="text" name="telefono" id="telefono" class="form-control" 
        value="<?php isset($datos['data']['telefono']) ? print $datos['data']['telefono'] : '';?>"
        <?php if (isset($datos['baja'])) { print " disabled "; }?>
        ">
    </div>

    <div class="form-group text-start mt-2">
        <label for="correo">* Correo:</label>
        <!-- si se ha recibido pais, desde vista, se asigna el pais al value del input-->
        <!-- si se ha recibido baja, desde vista, se pone el input en disabled (desactivado)-->
        <input type="email" name="correo" id="correo" class="form-control" required 
        value="<?php isset($datos['data']['correo']) ? print $datos['data']['correo'] : '';?>"
        <?php if (isset($datos['baja'])) { print " disabled "; }?>
        ">
    </div>

    <div class="form-group text-start mt-2">
        <label for="genero">* Género:</label>
            <!-- si la var 'baja' está definida y no es null, viene de baja lógica. deshabilita el select -->
        <select name="genero" id="genero" class="form-control"
            <?php if(isset($datos['baja'])) { print " disabled "; } ?>
        >
        <option value="void">--- Selecciona un Género ---</option>
        
        <!-- obtiene el resto de options para el select, de $datos, con un for  -->
        <?php
            //desde i = 0, mientras i sea menor que el total de elementos del array TipoUsuarios
            for ($i=0; $i < count($datos["generos"]); $i++) {
                //obtiene el id de cada tipo de usuario y lo asigna al value='' de la option, que es lo que se envía.
                print "<option value='".$datos["generos"][$i]["id"]."'";

                //si la var "tipoUsuario", que viene de modificar() o de bajaLogica(), es igual a id del tipoUsuarios del select,
                //asígnale selected para que se muestre como seleccionada
                if(isset($datos["data"]["genero"]) && $datos["data"]["genero"] == $datos["generos"][$i]["id"]) {
                    print " selected ";
                }
                
                //obtiene el tipoUsuario (string) de cada tipo de usuario y lo imprime como opción seleccionable
                print ">".$datos["generos"][$i]["genero"]."</option>";
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
            <a href="<?php print RUTA;?>UsuariosControlador/bajaLogica/<?php print $datos['data']['id']."/".$datos["pagina"]; ?>" 
            class="btn btn-danger mt-3 me-2">Eliminar Usuario</a>

            <a href="<?php print RUTA.'UsuariosControlador/'.$datos['pagina']; ?>" class="btn btn-secondary mt-3"><- Volver</a>
            <p class="mt-3 text-danger"><b>Una vez eliminado el Usuario, no se podrá recuperar</b></p>
            
            <!-- si NO se ha recibido baja, desde vista, muestra el input Enviar país y botón Volver-->
            <?php } else { ?>

            <input type="submit" value="Enviar Usuario" class="btn btn-success mt-3 me-2 "> 
            <a href="<?php print RUTA;?>UsuariosControlador" class="btn btn-secondary mt-3 "><- Volver</a>
        <?php } ?>
    </div>
</form>

<?php include_once("piepagina.php"); ?>