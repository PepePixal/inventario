<?php

//Constante para que no se corrompa la ruta url
define('RUTA', "/inventario/");

//llaves para encriptación
define("LLAVE1", "Hombresneciosque");
define("LLAVE2", "acusaisalamujer");

//clave para encriptar el password
define("CLAVE", "arrierossomos");

//paginación. registros a mostrar por página
define("TAMANO_PAGINA", 5);
//paginador. cantidad máxima de números por paginador
define("PAGINAS_MAXIMAS", 4);

//Const tabla estadomovimientos
define('ABIERTO',1);
define('CERRADO',2);

//Const tabla estadoproducto
define('ACTIVO',1);
define('INACTIVO',2);

//Const tabla estadousuario
define('USUARIO_ACTIVO',1);
define('USUARIO_INACTIVO',2);
define('USUARIO_SUSPENDIDO',3);

//Const tabla tipomovimiento
define('ORDEN',1);
define('ENTRADA',2);
define('DEVOLUCION',3);
define('VENTA',4);

//Const tabla tipousuario
define('ADMON',1);
define('VENDEDOR',2);
define('CLIENTE',3);
define('PROVEEDOR',4);

//incluye, una sola vez, la class libs/Helper.php
require_once("libs/Helper.php");
//incluye, una sola vez, la class libs/Control.php
require_once("libs/Control.php");
//incluye, una sola vez, la class libs/Cotrolador.php
require_once("libs/Controlador.php");
//incluye, una sola vez, la class libs/MySQLdb.php
require_once("libs/MySQLdb.php");
//incluye, una sola vez, la class libs/Sesion.php
require_once("libs/Sesion.php");

