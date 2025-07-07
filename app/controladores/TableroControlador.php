<?php

class TableroControlador extends Controlador 
{
    private $usuario = "";
    private $modelo = "";
    private $sesion;
    
    function __construct()
    {
        //Crea sesión
        $this->sesion = new Sesion();

        //si getLogin() retorna el arreglo del usuario logueado
        if ($this->sesion->getLogin()) {   
            //obtiene el modelo TableroModelo y lo asigna a modelo
            $this->modelo = $this->modelo("TableroModelo");
            //obtiene el arreglo usuario de la sesión y lo asigna a usuario
            $this->usuario = $this->sesion->getUsuario();

        //si NO se ha obtenido el usuario logueado
        } else {
            //redirige al inicio (inventario)
            header("location:".RUTA);
        }
    }

    public function caratula($value='')
    {
        $datos = [
            "titulo" => "Sistema de Inventario",
            "subtitulo" => $this->usuario['nombres']." ".$this->usuario['apellidos'],
            "usuario" => $this->usuario,
            "admon" => true,
            "data" => [],
            "menu" => true
        ];

        $this->vista("tableroCaratulaVista", $datos);
    }

    public function logout()
    {
        //si hay un usuario logueado con la sesión iniciada
        if (isset($_SESSION['usuario'])) {
            //llama método que finaliza la sesión o login
            $this->sesion->finalizarLogin();
        }
        //redirige al usuario al inicio
        header("location:".RUTA);
    }
}


?>