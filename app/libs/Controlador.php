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

    //recibe parámetros y muestra mensaje
    public function mensaje($titulo='', $subtitulo, $texto, $url, $color, $url2="", $color2="", $texto2="")
    {
        //define arreglo con datos 
        $datos = [
            "titulo" => $titulo,
            "menu" => true,
            "errores" => [],
            "data" => [],
            "subtitulo" => $subtitulo,
            "texto" => $texto,
            "url" => $url,
            "color" => "alert-".$color,
            "colorBoton" => "btn-".$color,
            "textoBoton" => "<- Volver",
            "url2" => $url2,
            "colorBoton2" => "btn-".$color2,
            "textoBoton2" => $texto2,
        ];

        //llama metodo vista enviando nom archivo y datos
        $this->vista("mensaje", $datos);
        exit;
    }

    //Método envia correo con enlace para cambio de password y retorna true o false :bool
    public function enviarCorreo(string $email='')
    {
        $data = [];

        //valida si $email no contiene nada
        if ($email=="") {
            return false;
        } else {
            //busca el email en la DB y obtiene el registro del usuario
            $data = $this->modelo->buscarCorreo($email);
            //si $data no está vacio
            if (!empty($data)) {
                //encripta el id, del usuario obtenido $data
                $id = Helper::encriptar($data["id"]);
                
                $msg = "Pulsa en el enlace para cambiar tu clasve de acceso al sistema<br>";
                $msg.= "<a href='" . RUTA . "LoginControlador/cambiarClave/".$id."'>Cambiar clave de acceso</a>";
                
                $headers = "MIME-Version: 1.0\r\n";
                $headers = "Content-type:text/html; charset=UTF-8\r\n";
                $headers = "From: Inventario\r\n";
                $headers = "Reply-to: ayuda@inventario.com\r\n";
                
                $asunto = "Cambiar clave de acceso";
                
                //debuguear($id);
                Helper::mostrar($msg);
                //return true;
                //return @mail($email, $asunto, $msg, $headers);
            }
        }
    }

}