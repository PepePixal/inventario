<?php
/** */

class LoginControlador extends Controlador
{
    private $modelo = "";
    private $sesion;

    function __construct()
    {
        //llama al método modelo() (en Controlador), enviándole el nombre del modelo a instanciar y
        //lo asigna a $this->modelo
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

    //Método envia correo y retorna true o false :bool
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
    
    public function cambiarClave($id="")
    {
        //obtiene el $id original, tras desencriptarlo
        $id = Helper::desencriptar($id);                    
        //arreglo para los posibles errores de validación
        $errores = [];

        //si el método HTTP para acceder a la página, ha sido POST
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //obtiene clave, verifica y id de la superG $_POST,
            //si etan vacias les asigna "", para que no de error.
            $clave1 = $_POST['clave'] ?? "";
            $clave2 = $_POST['verifica'] ?? "";
            $id = $_POST['id'] ?? "";

            //** Validaciones de la info recibida en $_POST */
            //si las claves 1 o 2 vienen vacias del form, en $_POST
            if (empty($clave1)) {
                array_push($errores, "La password es obligatoria");
            }
            if (empty($clave2)) {
                array_push($errores, "La confirmación de la password es obligatoria");
            }
            //si las claves son diferentes
            if ($clave1 != $clave2) {
                array_push($errores, "La password no coincide");
            }

            //si no hay errores de validación, de los datos del form
            if (count($errores)==0) {
                //hashea o encripta la clave1 y la asigna a $clave (120carácteres)
                //hash_hmac() requiere: "algoridmo", "clave a hashear (string)", "clave secreta (string)"
                $clave = hash_hmac("sha512", $clave1, CLAVE);

                //define arreglo con la clave y el id
                $data = ["clave"=>$clave, "id"=>$id];

                //si el método actualizarClaveAcceso() retorna true:
                if ($this->modelo->actualizarClaveAcceso($data)) {
                    //llama met mensaje() éxito
                    $this->mensaje(
                        "Cambio Password",
                        "Cambio del password de acceso",
                        "La password se modificó correctamente",
                        "LoginControlador",
                        "success"
                    );
                
                } else {
                    //llama met mensaje() error
                    $this->mensaje(
                        "Cambio Password",
                        "Cambio del password de acceso",
                        "Hubo un error al actualizar la Password. Inténtalo más tarde",
                        "LoginControlador",
                        "darger"
                    );
                }

            }

        //si método no ha sido POST ha sido GET entonces: 
        //valida el valor de $id, retornado por el met. desencriptar()
        } else if ($id=="error") {
            //llama método mensaje, enviando argumentos de error
            $this->mensaje(
                "Cambio Password",
                "Cambio del password de acceso",
                "Error url manipulada",
                "LoginControlador",
                "danger"
            );
        } 

        //define datos para enviar a la vista
        $datos = [
            "titulo" => "Cambio Password",
            "subtitulo" => "Cambiar contraseña",
            "errores" => $errores,
            "data" => $id
        ];

        //llama método vista enviando archivo y datos
        $this->vista("loginCambiarVista", $datos);
    }
}

