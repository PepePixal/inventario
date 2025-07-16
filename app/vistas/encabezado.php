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
        <a href="<?php print RUTA ?>" class="navbar-brand">Inventario</a>
        <?php
        if (isset($datos['menu']) && $datos['menu'] == true) {
            if (isset($datos['admon']) && $datos['admon'] == true) {

                print "<ul class='navbar-nav' mr-auto mt-2 mt-lg-0'>";
                    print "<li class='nav-item'>";
                        //hipervínculo a /inventario/compras, con class condicionada
                        print "<a href='".RUTA."ComprasControlador' class='nav-link  ";
                        //si $datos['activo'] existe y no es NULL y $datos['activo'] es igual a "compras"
                        //agrega la class "active" a <a href=
                        if (isset($datos['activo']) && $datos['activo']=="compras") print "active";
                        print " '>Compras</a> ";
                    print "</li>";

                    print "<li class='nav-item'>";
                        //hipervínculo a /inventario/entradas, con class condicionada
                        print "<a href='".RUTA."EntradasControlador' class='nav-link  ";
                        //si $datos['activo'] existe y no es NULL y $datos['activo'] es igual a "entradas"
                        //agrega la class "active" a <a href=
                        if (isset($datos['activo']) && $datos['activo']=="entradas") print "active";
                        print " '>Entradas</a> ";
                    print "</li>";

                    print "<li class='nav-item'>";
                        //hipervínculo a /inventario/ventas, con class condicionada
                        print "<a href='".RUTA."VentasControlador' class='nav-link  ";
                        //si $datos['activo'] existe y no es NULL y $datos['activo'] es igual a "ventas"
                        //agrega la class "active" a <a href=
                        if (isset($datos['activo']) && $datos['activo']=="ventas") print "active";
                        print " '>Ventas</a> ";
                    print "</li>";
                    
                    print "<li class='nav-item'>";
                        //hipervínculo a /inventario/devoluciones, con class condicionada
                        print "<a href='".RUTA."DevolucionesControlador' class='nav-link  ";
                        //si $datos['activo'] existe y no es NULL y $datos['activo'] es igual a "devoluciones"
                        //agrega la class "active" a <a href=
                        if (isset($datos['activo']) && $datos['activo']=="devoluciones") print "active";
                        print " '>Devoluciones</a> ";
                    print "</li>";

                    print "<li class='nav-item'>";
                        //hipervínculo a /inventario/stock, con class condicionada
                        print "<a href='".RUTA."StockControlador' class='nav-link  ";
                        //si $datos['activo'] existe y no es NULL y $datos['activo'] es igual a "stock"
                        //agrega la class "active" a <a href=
                        if (isset($datos['activo']) && $datos['activo']=="stock") print "active";
                        print " '>Stock</a> ";
                    print "</li>";

                    print "<li class='nav-item'>";
                        //hipervínculo a /inventario/proveedores, con class condicionada
                        print "<a href='".RUTA."ProveedoresControlador' class='nav-link  ";
                        //si $datos['activo'] existe y no es NULL y $datos['activo'] es igual a "proveedores"
                        //agrega la class "active" a <a href=
                        if (isset($datos['activo']) && $datos['activo']=="proveedores") print "active";
                        print " '>Proveedores</a> ";
                    print "</li>";
                    
                    print "<li class='nav-item'>";
                        //hipervínculo a /inventario/productos, con class condicionada
                        print "<a href='".RUTA."ProductosControlador' class='nav-link  ";
                        //si $datos['activo'] existe y no es NULL y $datos['activo'] es igual a "productos"
                        //agrega la class "active" a <a href=
                        if (isset($datos['activo']) && $datos['activo']=="productos") print "active";
                        print " '>Productos</a> ";
                    print "</li>";

                    print "<li class='nav-item'>";
                        //hipervínculo a /inventario/usuarios, con class condicionada
                        print "<a href='".RUTA."UsuariosControlador' class='nav-link  ";
                        //si $datos['activo'] existe y no es NULL y $datos['activo'] es igual a "usuarios"
                        //agrega la class "active" a <a href=
                        if (isset($datos['activo']) && $datos['activo']=="usuarios") print "active";
                        print " '>Usuarios</a> ";
                    print "</li>";
                    
                    print "<li class='nav-item'>";
                        //hipervínculo a /inventario/categorias, con class condicionada
                        print "<a href='".RUTA."CategoriasControlador' class='nav-link  ";
                        //si $datos['activo'] existe y no es NULL y $datos['activo'] es igual a "categorias"
                        //agrega la class "active" a <a href=
                        if (isset($datos['activo']) && $datos['activo']=="categorias") print "active";
                        print " '>Categorias</a> ";
                    print "</li>";

                    print "<li class='nav-item'>";
                        //hipervínculo a /inventario/paises, con class condicionada
                        print "<a href='".RUTA."PaisesControlador' class='nav-link  ";
                        //si $datos['activo'] existe y no es NULL y $datos['activo'] es igual a "paises"
                        //agrega la class "active" a <a href=
                        if (isset($datos['activo']) && $datos['activo']=="paises") print "active";
                        print " '>Países</a> ";
                    print "</li>";

                    print "<li class='nav-item'>";
                        //hipervínculo a /inventario/respaldo, con class condicionada
                        print "<a href='".RUTA."RespaldoControlador' class='nav-link  ";
                        //si $datos['activo'] existe y no es NULL y $datos['activo'] es igual a "respaldo"
                        //agrega la class "active" a <a href=
                        if (isset($datos['activo']) && $datos['activo']=="respaldo") print "active";
                        print " '>Respaldo</a> ";
                    print "</li>";
                print "</ul>";
            }

            print "<ul class='nav nav-bar-nav ms-auto'>";
                print "<li class='nav-item'>";
                    print "<a href='".RUTA."tablero/perfil' class='nav-link'>";
                        print' <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="white" class="bi bi-person-square" viewBox="0 0 16 16">
                        <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                        <path d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1v-1c0-1-1-4-6-4s-6 3-6 4v1a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1z"/>
                        </svg> ';
                    print "</a>";
                print "</li>";

                print "<li class='nav-item'>";
                    print "<a href='".RUTA."tablero/logout' class='nav-link'>";
                        print' <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"/>
                        <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"/>
                        </svg> ';
                    print "</a>";
                print "</li>";
            print "</ul>";
        }
        ?>
    </nav>
    <div class="container-fluid">
        <div class="row content">
            <div class="col-sm-1"></div>
            <div class="col-sm-10">
                <div class="card p-4 mt-3 bg-light">
                    <div class="card-header text-center">
                        <h2><?php print $datos["subtitulo"]; ?></h2>
                    </div>
                    <div class="card-body">