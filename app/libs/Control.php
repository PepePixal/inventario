<?php
/**
 * 
 */
class Control
{
    //controlador por defecto
    private $controlador = "LoginControlador";
    //método por defecto
    private $metodo = "caratula";
    private $parametros = [];

    function __construct()
    {
        //llama al método de la própia class Control ($this),
        //que divide la url por (/), retorna un arreglo indexado con las partes y lo asigna a $url
        $url = $this->separarURL();   

        //comprueba si $url no es un arreglo vacio y si dentro de ../app/controladores/ ,
        //existe un archivo con el nombre igual al valor del primer elemento del arreglo $url[0] + ".php"
        //(ucwords() pone en mayúscula la primera letra del valor del elemento [0] de $url)
        if ($url !=[] && file_exists("../app/controladores/" . ucwords($url[0]) . ".php")) {

            //** Controlador */
            //Obtiene el nombre del archivo controlador, del primre elemento del arreglo $url[0],
            //poniendo la primera letra en mayùscula (ucwords()) y lo asigna a controlador
            $this->controlador = ucwords($url[0]);
            //elimina el valor del primer elemento [0] del arreglo $url
            unset($url[0]);
        }

        //Carga el controlador recibido en la url.
        //controlador tiene asignado "LoginControlador", por defecto, por si viene vacio
        require_once("../app/controladores/" . ucwords($this->controlador) . ".php");
        //Crea la instancia de la clase del controlador y la reasigna a $this->controlador como objeto
        $this->controlador = new $this->controlador;
                 
        //** Método */
        //valida si el segundo elemento [1] de $url, está definido y no es NULL
        if (isset($url[1])) {
            //valida si en el objeto $this->controlador existe el método con nombre igual
            //al valor del segundo elemento [1] del arreglo $url
            if (method_exists($this->controlador, $url[1])) {
                //asigna a $this->metodo el valor del elemento [1] de $url.
                //metodo tiene asignado "caratula", por defecto, por si viene vacio
                $this->metodo = $url[1];
                //elimina el valor del segundo elemento del arreglo $url
                unset($url[1]);
            }
        }

        //** Parámetros */
        //valida si el arreglo $url todavia tiene elementos ? asigna los valores a $this->parametros,
        //de lo contrario : le asigna un arreglo vacio []
        $this->parametros = $url ? array_values($url) : [];
        
        //** Call back que llama a la fución en $this-metodo, de la class en $this->controlador*/
        //** Por defecto, el controlador es "LoginControlador" y el método "cartula" */
        //La función php, requiere en un arreglo donde se indica el [archivo y la función] y 
        //los parámetros si los hay. Retorna el resultado de la función o False
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