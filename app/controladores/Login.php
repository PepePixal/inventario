<?php
/** */

class Login extends Controlador
{
    private $modelo = "";
    private $sesion;

    function __construct()
    {
        
    }

    public function caratula($parametros = [])
    {
        print "<h2> Hola desde la caratula de LoginControlador</h2>";
    }
}
