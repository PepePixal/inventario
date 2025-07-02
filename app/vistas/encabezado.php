<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario | <?php print $datos["titulo"] ?></title>
    <!-- Bootstrap CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    </head>
<body>
    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <a href="#" class="navbar-brand">Inventario</a>
    </nav>
    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
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
                <div class="card p-4 mt-3 bg-light">
                    <div class="card-header text-center">
                        <h2><?php print $datos["subtitulo"]; ?></h2>
                    </div>
                    <div class="card-body">