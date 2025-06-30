<?php
/** */

class LoginControlador extends Controlador
{
    private $modelo = "";
    private $sesion;

    function __construct()
    {
        //llama al método modelo enviando el nombre del modelo a instanciar
        $this->modelo = $this->modelo("LoginModelo");
    }

    public function caratula()  {
        
        //llama al método vista enviando el nombre de la vista
        $this->vista("loginCaratulaVista", []);
    }
}
