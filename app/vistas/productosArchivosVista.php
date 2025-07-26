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
            <th>Archivo</th>
            <th>Tamaño</th>
            <th>Foto</th>
            <th>Borrar</th>
        </tr>
    </thead>
    <tbody>

        <?php
        //como los nombres de las fotos están a partir del índice [2] del arreglo index $archivos_array que viene en $datos['archivos']
        //Desde $i = 2, mientras $i < la cantidad de elementos (fotos) del arreglo '$archivos_array que viene en $datos['archivos'],
        //suma 1 a $i y ejecuta
        for($i=2; $i<count($datos['archivos']); $i++) {

            //define la url relativa a la carpeta de fotos de cada producto segun su id
            $carpeta = "fotos/".$datos["data"]["id"]."/";

            print "<tr>";
                print "<td class='text-left'>".$datos["archivos"][$i]."</td>";
                //obtiene el tamaño en bytes del archivo (foto) con filesize() y
                //lo convierte a la correspondiente unidad con el método medidaSize()
                print "<td class='text-left'>".Helper::medidaSize(filesize($carpeta.$datos["archivos"][$i]))."</td>";
                
                print "<td class='text-left'>";
                //ruta completa, necesaria para html, del archivo (foto)
                print "<img src='".RUTA."public/".$carpeta.$datos["archivos"][$i]."' width='40'/></a>";
                print "</td>";

                //envia por url, al método borrarImagen, el "id" del producto y indice $i del nombre de la foto,
                //porque un producto puede tener varias fotos, la primera está en el índice [2] del arreglo $datos["archivos"]
                print "<td><a href='".RUTA."ProductosControlador/borrarImagen/".$datos["data"]["id"]."/".$i."' class='btn btn-danger'>Eliminar</td>";
            print "</tr>";
        }
        ?>
    </tbody>
    </table>

    <!-- carga paginación.php -->
    <?php include_once("paginacion.php"); ?>

    <!-- Form para subir una nueva imagen via POST -->
    <form action="<?php print RUTA;?>ProductosControlador/modificarImagenes/" method="POST" enctype="multipart/form-data">
        <!-- Envia via POST el id del producto y la pagina, si existen y son diferentes a NULL -->
        <input type="hidden" name="id" id="id" 
        value="<?php if (isset($datos['data']['id'])) {print $datos['data']['id'];} else {print "";} ?>">
        <input type="hidden" name="pagina" id="pagina" 
        value="<?php if (isset($datos['pagina'])) {print $datos['pagina'];} else {print "1";} ?>">
        <div class="form-group text-left">
            <div class="form-group text-left">
                <label for="fotos">Añadir foto:</label>
                <input type="file" name="foto" id="foto" class="form-control">
                <input type="submit" value="Subir foto" class="btn btn-success mt-3">
            </div>
        </div>
    </form>

    <!-- <a href="<?php print RUTA;?>ProductosControlador/altaImagen/" class="btn btn-success mt-3 me-3 ">Subir una imagen</a> -->
    <a href="<?php print RUTA.'ProductosControlador/'.$datos['pagina']; ?>" class="btn btn-secondary mt-3"><- Volver</a>

</div>
                
<?php include_once("piepagina.php"); ?>