<?php

//Constante para que no se corrompa la ruta url
define('RUTA', "/inventario/");

//llaves para encriptación
define("LLAVE1", "Hombresneciosque");
define("LLAVE2", "acusaisalamujer");

//clave para encriptar el password
define("CLAVE", "arrierossomos");

//Constantes para Tipos de Movimientos
define('ADMON',1);
define('VENDEDOR',2);
define('CLIENTE',1);
define('PROVEEDOR',1);

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

