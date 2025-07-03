<?php
/**
 * 
 */
class Control
{
    private $controlador = "LoginControlador";
    private $metodo = "caratula";
    private $parametros = [];

    function __construct()
    {
        //llama al método de la própia class Control ($this),
        //que divide la url por (/), retorna un arreglo index con las partes y lo asigna a $url
        $url = $this->separarURL();   

        
        //comprueba si la url no es un arreglo vacio y si dentro de ../app/controladores/ ,
        //existe un archivo con el nombre igual al valor del primer elemento [0] del arreglo $url + .php
        //(ucwords() pone en mayúscula la primera letra del valor del elemento [0] de $url)
        if ($url !=[] && file_exists("../app/controladores/" . ucwords($url[0]) . ".php")) {
            //** Controlador */
            //Obtiene el archivo controlador .php, de la $url/
            //asigna a controlador, el primer valor [0] del arreglo $url (obtenido de $_GET['url'])
            $this->controlador = ucwords($url[0]);
            //elimina el valor del primer elemento [0] del arreglo $url
            unset($url[0]);
        }

        //Carga el controlador recibido en la url
        require_once("../app/controladores/" . ucwords($this->controlador) . ".php");
        //Crea la instancia de la clase del controlador y la reasigna a $this->controlador como objeto
        $this->controlador = new $this->controlador;
                 
        //** Método */
        //valida si el segundo elemento [1] de $url, está definido y no es NULL
        if (isset($url[1])) {
            //valida si en el objeto $this->controlador existe el método con nombre igual
            //al valor del segundo elemento [1] del arreglo $url
            if (method_exists($this->controlador, $url[1])) {
                //asigna a $this->metodo el valor del elemento [1] de $url
                $this->metodo = $url[1];
                //elimina el valor del segundo elemento del arreglo $url
                unset($url[1]);
            }
        }

        //** Parámetros */
        //valida si el arreglo $url todavia tiene elementos ? asigna los valores a $this->parametros,
        //de lo contrario : le asigna un arreglo vacio []
        $this->parametros = $url ? array_values($url) : [];
        
        //** Ejecutar el método del controlador, recibidos en la url */
        //requiere la función, en un arreglo donde se indica el [archivo y el método] y 
        //los parámetros si los hay
        call_user_func_array([$this->controlador, $this->metodo], $this->parametros );

    }
    
    //función que sanetiza la URL recibida y retorna un :array
    public function separarURL() :array
    { 
        //var array para almacenar la url
        $url = [];
        
        //**Limpiar y Sanitizar la url que viene por GET */
        //si la llave 'url' de la superglobal $_GET
        if(isset($_GET['url'])) {

            //elimina / del final de la url y la reasigna
            $url = rtrim($_GET['url'], "/");
            //elimina \ del final de la url y la reasigna
            $url = rtrim($_GET['url'], "\\");
            //Filtra y sanitiza la url de cualquier carácter raro
            $url = filter_var($url, FILTER_SANITIZE_URL);
            //divide la url (string) por cada / y lo convierte en arreglo index
            $url = explode("/", $url);
        } 
        //retorna el arreglo en $url
        return $url;
    }
}