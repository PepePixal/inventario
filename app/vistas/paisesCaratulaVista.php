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

<div class="table-responsive">
    <table class="table table-striped" width="100%">
    <thead>
        <tr>
            <th>id</th>
            <th>Nombre</th>
            <th>Modificar</th>
            <th>Borrar</th>
        </tr>
    </thead>
    <tbody>
        <?php
        //desde i 0, mientras i < que la cantidad de elementos del arreglo 'data', suma 1 a i y ejecuta
        for($i=0; $i<count($datos['data']); $i++) {
            print "<tr>";
                print "<td class='text-left'>".$datos["data"][$i]['id']."</td>";
                print "<td class='text-left'>".$datos["data"][$i]['pais']."</td>";
                print "<td><a href='".RUTA."PaisesControlador/modificar/".$datos["data"][$i]["id"]."' class='btn btn-info'>Modificar</a></td>";
                print "<td><a href='".RUTA."PaisesControlador/eliminar/".$datos["data"][$i]["id"]."' class='btn btn-danger'>Eliminar</td>";
            print "</tr>";
        }
        ?>
    </tbody>
    </table>
    <a href="<?php print RUTA;?>PaisesControlador/alta/" class="btn btn-success">Nuevo País</a>
</div>
                
<?php include_once("piepagina.php"); ?>