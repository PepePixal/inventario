<?php
/** */

class Controlador
{
    function __construct(){}

    //recibe el nombre del modelo, valida y retorna una instancia de la class
    public function modelo($modelo = '')
    {
        //valida si el $modelo recibido existe en ../app/modelos/
        if(file_exists("../app/modelos/" . $modelo . ".php")) {
            //Carga el modelo y su class
            require_once("../app/modelos/" . $modelo . ".php");
            //retorna una nueva instancia de la class en $modelo
            return new $modelo;
        } else {
            //para el código y muestra mensaje
            die("El modelo " . $modelo . " No existe");
        }
    }

    //recibe nombre de la vista y datos, valida y carga la vista
    public function vista($vista='', $datos=[]) 
    {
        //valida si la $vista recibida exsiste en ../app/vista
        if(file_exists("../app/vistas/" . $vista . ".php")) {
            //carga el archivo de vista
            require_once("../app/vistas/" . $vista . ".php");
        } else {
            die("La vista " . $vista . "No existe");
        }
    }

}