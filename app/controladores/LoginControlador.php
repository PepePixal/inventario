<?php

class LoginControlador extends Controlador
{
    protected $modelo = "";
    private $sesion;

    function __construct()
    {
        //llama al método modelo() (en Controlador), enviándole el nombre del modelo a instanciar y
        //lo asigna a $this->modelo
        $this->modelo = $this->modelo("LoginModelo");
    }

    //muestra la vista Inicial para loguearse 
    public function caratula()  {

        //valida si existen datos de cookies en la super glob $_COOKIES
        if (isset($_COOKIE['datos'])) {

            //divide el string de $_COOKIE['DATOS'], en string separados por | y genera un 
            //nuevo arreglo indexado que asigna a $datos_array
            $datos_array = explode("|", $_COOKIE['datos']);
            //obtiene el usuario (email) de $datos_array
            $usuario = $datos_array[0];
            //obtiene la clave encriptada de $datos_array y la desencripta
            $clave = Helper::desencriptar($datos_array[1]);
            //define nuevo arreglo data con el usuario y la clave, para enviar a la vista
            $data = [
                'usuario' => $usuario,
                'clave' => $clave
            ];
        
          //si no hat cookies  
        } else {
            //asigna arreglo vacio, para que la vista no de undefined $data en $datos 
            $data = [];
        }

        //define arreglos con datos a enviar a la vista
        $datos = [
            "titulo" => "Entrada",
            "subtitulo" => "Entrada al Sistema de inventario",
            "data" => $data
        ];

        //llama al método vista enviando el nombre de la vista y datos
        $this->vista("loginCaratulaVista", $datos);
    }

    //proceso de verificación de email y cambio de password
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

    
    //desencripta y verifica la url de origen, verifica la nueva password y 
    //actualiza la password en la DB
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

    //verifica el usuario (email) y password, para loguearse
    public function verificar()
    {
        //define array errores de validación
        $errores = [];

        //si el método HTTP del server, para acceder a la página, ha sido POST
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $id = $_POST["id"] ?? "";
            $usuario = $_POST["usuario"] ?? "";
            $clave = $_POST["clave"] ?? "";

            //si $_POST['recordar'] (usuario logueado) esta definida y no es NULL,
            //significa que está checked,
            //entonces ? asinga "on" a $recordar, de lo contrario : asigna "off"
            $recordar = isset($_POST['recordar']) ? "on" : "off";

            //$valor será, el email de usuario | y la clave encriptada.
            $valor = $usuario."|".Helper::encriptar($clave);

            //si el checkbox recordar está en on, para recordar el usuario y la contraseña de la sesión:
            if ($recordar == "on") {
                //time() retorna (unix time), la cantidad de segundos transcurridos desde el 1/1/1970 hasta hoy,
                //si le suman los segundos que tiene una semana (60*60*24*7), se obtiene tenemos la cantidad de segundos
                //hasta una semana posterior a hoy. Esta cantidad de segundos se usará para indicar el tiempo de validez
                //de las cookies que generemos. Las cookies caduran al cabo de una semana de haber sido generadas.
                $fecha = time() + (60*60*24*7);
            } else {
                //obtiene una fecha, en segundos, expirada por un segundo
                $fecha = time()-1;
            }

            //setcookie() envia la cabecera HTTP necesaria al navegador, para crear o actualizar una cookie.
            //requiere: nom_cookie, valor (opcional), caducidad, en seg unix time (opcinal), RUTA (opcional) 
            setcookie("datos", $valor, $fecha, RUTA);

            // debuguear($valor);

            //validaciones de los datos del form, recibido en POST
            if (empty($usuario)) {
                array_push($errores, "El Usuario (email) es obligatorio");
            }
            //valida si el filtrado del formato del email NO es correcto
            if (filter_var($usuario, FILTER_VALIDATE_EMAIL) == false) {
                //agrega error al arreglo $errores
                array_push($errores, "El formato del correo No es válido");
            }
            if (empty($clave)) {
                array_push($errores, "La Contraseña es obligatoria");
            }

            //si NO hay errores de validación de los datos del form
            if (count($errores) == 0) {
                //hashea o encripta la clave y la asigna a $clave (128carácteres)
                //hash_hmac() requiere: "algoridmo", "clave a hashear (string)", "clave secreta (string)"
                $clave = hash_hmac("sha512", $clave, CLAVE);

                //busca el correo (usuario) en la DB
                $data = $this->modelo->buscarCorreo($usuario);

                //valida si data contiene algo y si la clave de la DB es igual a la del form
                if ($data && $data['clave'] == $clave) {
                    
                    //inicia sesión, nueva instancia de class Sesión() y asigna el objto a $sesion
                    $this->sesion = new Sesion();

                    //método que asigna el usuario enviado en $data al $_SESSION['usuario']
                    $this->sesion->iniciarLogin($data);

                    //redirige a la ruta url inventario/TableroControlador/    
                    header('Location:'.RUTA."TableroControlador");
                }
                
                //llama método mensaje, enviando datos
                $this->mensaje(
                    "Entrada",
                    "Entrada al Sistema de Inventario",
                    "Hubo un error al loguearse en el sistema. El usuario o la contraseña, no son válidos.",
                    "LoginController",
                    "danger"
                );
            }
        }

        //define datos para enviar a la vista
        $datos = [
            "titulo" => "Entrada",
            "subtitulo" => "Entrada al Sistema de inventario",
            "errores" => $errores,
        ];

        //llama al método vista enviando el nombre de la vista y datos
        $this->vista("loginCaratulaVista", $datos);
    }

}
?>

