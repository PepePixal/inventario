<?php
/** */

class LoginControlador extends Controlador
{
    private $modelo = "";
    private $sesion;

    function __construct()
    {
        //llama al método modelo (en Controlador), enviando el nombre del modelo a instanciar
        $this->modelo = $this->modelo("LoginModelo");
    }

    public function caratula()  {
        //define arreglos con datos a enviar a la vista
        $datos = [
            "titulo" => "Entrada",
            "subtitulo" => "Sistema de inventario"
        ];

        //llama al método vista enviando el nombre de la vista y datos
        $this->vista("loginCaratulaVista", $datos);
    }

    public function olvidoVerificar() {

        //var para los errores de validación
        $errores = [];

        //si el método de la consulta al método olvidoVerificar es tipo POST
        if($_SERVER['REQUEST_METHOD'] == "POST") {
            //obtiene el usuaro (email) recibido en el POST
            $usuario = $_POST['usuario'] ?? "";
            //valida si el usuario viene vacio
            if (empty($usuario)) {
                //agrega error al arreglo $errores
                array_push($errores, "El Usuario (email) es obligatorio");
            }
            //valida si el filtrado del formato del email NO es correcto
            if (filter_var($usuario, FILTER_VALIDATE_EMAIL) == false) {
                //agrega error al arreglo $errores
                array_push($errores, "El formato del correo No es válido");
            }

            //si no hay ningún error de validación
            if (empty($errores)) {

                //si no viene vacio el resultado de la busqueda del usuario (email) en la BD
                if (!empty($this->modelo->buscarCorreo($usuario))) {

                    debuguear($this->modelo->buscarCorreo($usuario));

                    //envia el correo al email del usuario y si el envio es correcto recibe true
                    if ($this->enviarCorreo($usuario)) {
                        //como el envio del correo ha sido correcto
                        //llama método mensaje, enviando argumentos
                        $this->mensaje(
                            "Cambio Password",
                            "Cambio del password de acceso",
                            "Se ha enviado un correo a <b>".$usuario."</b> para que pueda cambiar su password de acceso. Cualquier duda, comunica con nosotros. No olvides revisar tu bandeja de spam.",
                            "login",
                            "warning"
                        );
                    } else {
                        //como el envio del correo ha sido Erroneo
                        //llama método mensaje, enviando argumentos
                        $this->mensaje(
                            "Cambio Password",
                            "Cambio del password de acceso",
                            "Error al enviar el mensaje. Inténtalo más tarde",
                            "login",
                            "danger"
                        );
                    }

                } else {
                   array_push($errores, "NO se encontro el correo");
                }
            }
        }

        //define arreglos con datos a enviar a la vista
        $datos = [
            "titulo" => "Olvido",
            "subtitulo" => "¿Olvidaste tu Password?",
            "errores" => $errores
        ];

        //llama al método vista enviando el nombre de la vista y datos
        $this->vista("loginOlvidoVista", $datos);
    }

    public function enviarCorreo($email='')
    {
        $data = [];
        //valida si $email no contiene nada
        if ($email=="") {
            return false;
        } else {
            //busca el correo en la DB
            $data = $this->modelo->buscarCorreo($email);
            //si $data no está vacio
            if (!empty($data)) {
                $id = 1; //Helper::encriptar($data["id"]);
                $msg = "Pulsa en el enlace para cambiar tu clasve de acceso al sistema<br>";
                $msg.= "<a href='" . RUTA . "login/cambiarclave/" .$id."'>Cambiar clave de acceso</a>";

                $headers = "MIME-Version: 1.0\r\n";
                $headers = "Content-type:text/html; charset=UTF-8\r\n";
                $headers = "From: Inventario\r\n";
                $headers = "Reply-to: ayuda@inventario.com\r\n";

                $asunto = "Cambiar clave de acceso";

                //debuguear($msg);
                //return true;
                return @mail($email, $asunto, $msg, $headers);
            }
        }
    }

}
