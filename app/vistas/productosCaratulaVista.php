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
            <th>Proveedor</th>
            <th>Foto</th>
            <th>Modificar</th>
            <th>Borrar</th>
        </tr>
    </thead>
    <tbody>

        <?php
        //desde $i = 0, mientras $i < la cantidad de elementos (productos) del arreglo 'data', suma 1 a $i y ejecuta
        for($i=0; $i<count($datos['data']); $i++) {

            //Fotos
            //obtiene, de $datos['dtas'], el nombre de la subcarpeta en fotos/, 
            //del producto, según su id. (fotos/01/, etc)
            $carpeta = "fotos/".$datos['data'][$i]['id']."/";

            //define var para el nombre de la foto
            $foto = "";

            //valida si existe la carpeta o directorio
            if (file_exists($carpeta)) {
                //obtine los niveles de directorios desde la carpeta public,
                //hasta la carpeta donde estan los archivos (fotos) de cada producto (. ..) (/fotos/01/) y
                //los archivos (fotos) de la carpeta, de cada producto.
                //Cada nivel de directorio y cada archivo se almacena en un indice del arreglo indexado $archivos_array
                //[0]=>"." [1]=>".." [2]=>"nom_foto1" [3]=>"nom_foto2" etc
                $archivos_array = scandir($carpeta);

                //Como solo se muestra la primera foto del producto, en la carátula o tablero de productos,
                //obtiene el nombre del archivo foto, almacenado en el tercer índice del archivo index $archivos_array 
                $foto = RUTA."public/".$carpeta.$archivos_array[2];
                
            //si NO existe la carpeta fotos/...
            } else {
                //asigna arreglo vacio al arreglo archivos_array
                $archivos_array = [];
                //asigna una foto genérica para mostrar, cuando no haya foto del producto
                $foto = "img/placeholder.jpg";
            }

            print "<tr>";
                print "<td class='text-left'>".$datos["data"][$i]['id']."</td>";
                print "<td class='text-left'>".$datos["data"][$i]['nombre']."</td>";
                print "<td class='text-left'>".$datos["data"][$i]['proveedor']."</td>";

                print "<td class='text-left'>";
                //img con enlace que envia por url, al método modificar, de PaisesControlador, con los parámetros "id" y "página"
                print "<a href='".RUTA."ProductosControlador/modificarImagenes/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' ><img src='".$foto."' width='40'/></a>";
                print "</td>";

                //el enlace lo envia por url, al método modificar, de PaisesControlador, con los parámetros "id" y "página"
                print "<td><a href='".RUTA."ProductosControlador/modificar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."' class='btn btn-info'>Modificar</a></td>";
                //el enlace lo envia por url, al método eliminar, de PaisesControlador, con los parámetros "id" y "página"
                print "<td><a href='".RUTA."ProductosControlador/eliminar/".$datos["data"][$i]["id"]."/".$datos["pag"]["pagina"]."'  class='btn btn-danger'>Eliminar</td>";
            print "</tr>";
        }
        ?>
    </tbody>
    </table>

    <!-- carga paginación.php -->
    <?php include_once("paginacion.php"); ?>

    <a href="<?php print RUTA;?>ProductosControlador/alta/" class="btn btn-success">Nuevo Producto</a>
</div>
                
<?php include_once("piepagina.php"); ?>