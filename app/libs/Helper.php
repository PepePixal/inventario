<?php

class Helper
{

    //sanitiza y limpia el nombre de un archivo, para php antes grabarlo en la DB
    public static function archivo($cadena) {
        $buscar =      array(' ', '*','!', '@', '?', 'á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'ñ', 'Ñ', 'ü', 'Ü', '¿', '¡');
        $reemplazar =  array('-', '', '', '', '', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'n', 'N', 'u', 'U', '', '');
        $cadena = str_replace($buscar, $reemplazar, $cadena);
        return $cadena;
    }

    //revisa y sanitiza una cadena de texto, antes de agregarla a la BD
    public static function cadena($cadena)
    {
        //define array con algunos términos peligrosos a buscar
        $buscar = array('^', 'delete', 'drop', 'truncate', 'exec', 'system');
        //define array con los terminos para reemplazar a los peligrosos
        $reemplazar = array('-', 'dele*te', 'dr*op', 'trunca*te', 'ex*ec', 'syst*er');
        //str_replac() busca y reemplaza las cadenas de la $cadena recibida) y
        //trim() elimina espacios en blanco al inicio y al final de la cadena
        $cadena = trim(str_replace($buscar, $reemplazar, $cadena));
        //htmlentities() convierte caracteres especiales HTML en sus correspondientes entidades HTML. 
        //addslashes() escapa comillas simples ('), comillas dobles ("), barras invertidas (\) y caracteres NUL
        //añadiendo una barra invertida antes de estos caracteres.(\') (\")(\\)
        $cadena = addslashes(htmlentities($cadena));
        //retorna la cadena sanetizada
        return $cadena;
    }

    //filtra y valida el contenido del parámetro recibido,
    //retorna el valor filtrado o FALSE, si no pasa la validación
    public static function correo($correo='')
    {
        return filter_var($correo, FILTER_VALIDATE_EMAIL);
    }


    //** encriptación básica y desencriptación */

    public static function encriptar($data)
    {
        //retorna un string encriptado,
        //a partir del estring formado por las LLAVES y $data
        return base64_encode(LLAVE1.$data.LLAVE2);
    }

    public static function desencriptar($data) :string
    {
        //decodifica todo el string en $data y lo asigna a $cadena
        $cadena = base64_decode($data);
        //para asegurar que el string decodificado, original, no ha sido manipulado
        //verifica si el string decodificado original, contiene nuestra const LLAVE1
        if (str_contains($cadena, LLAVE1)) {
            //elimina la parte LLAVE1 de $cadena y lo reasigna a $cadena
            $cadena = str_replace(LLAVE1,"",$cadena);
            //para asegurar que el string decodificado, original, no ha sido manipulado
            //verifica si el string decodificado original, contiene nuestra const LLAVE2
            if (str_contains($cadena, LLAVE2)) {
                //elimina la parte LLAVE2 de $cadena y retorna el resultado
                $cadena = str_replace(LLAVE2,"",$cadena);
            } else {
                $cadena = "error";
            }
        } else {
            $cadena = "error";
        }

        //retorna la cadena original antes de codificar
        return $cadena;
    }

    //gernera clave aleatoria, requiere longitud deseada, retorna string
    public static function generarClave($lon)
    {
        $llave = "";
        $cadena = "1234567890ABCDEFGHIJKLMNOPQRSTUVXYZabcdefghijklmnopqrstuvxyz+*-_";
        $max = strlen($cadena)-1;
        for ($i = 0; $i < $lon; $i++) {
            //en cada ciclo del for: mt_rand() genera un número entero aleatorio, con longitud entre 0 y $max,
            //substr() retorna un trozo del string ($cadena), a partir de la posición indicada por el valor de mt_rand()
            //y con una longitud indicada en el parámetro 1, .= para concatenar las condiciones de substr()
            $llave .= substr($cadena, mt_rand(0, $max), 1);
        }
        return $llave;
    }

    //con static podemos llamar la función (nom_class::nom_funcion()),
    //sin necesidad de crear una nueva instancia de su class.
    // Requiere argumentos  
    public static function mostrar($data = '', $detener = true)
    {
        print "<pre>";
        //muestra la información, estructurada, de la variable
        var_dump($data);
        print "<pre>";
        if ($detener) {
            exit;
        }
    }

    //limpia un número string, eliminando espacios, símbolos $, €, y . de millares
    public static function numero($cadena) 
    {
        //define los signos a buscar y con los que reemplazar
        $buscar = array(' ', '$', '€','.');
        $reemplazar = array('', '', '','');
        //reemplaza los carácteres de $buscar por los de $reemplazar, en la $cadena recibida
        $numero = str_replace($buscar, $reemplazar, $cadena);
        return $numero;
    }

    //convierte los bytes recibidos en TB o GB o MB o Kb
    public static function medidaSize($bytes) 
    {
        //convierte el valor recibido en $bytes en decimal 
        $bytes = floatval($bytes);
        //crea arreglo indexado y en cada indice crea un array asoc con nombre de la unidad y su valor en bytes
        $bytes_array = array(
            0 => array(
                "UNIT" => "TB",
                //pow() exponencial
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            )
        );
        //itera el array y por cada elemento $item
        foreach ($bytes_array as $item) {
           //si la cantidad de bytes recibida en $tytes, es >= que el valor de $item["VALUE"]
           if ($bytes >= $item["VALUE"]) {
                //calcula los bytes y los asigna a $salida
                $salida = $bytes / $item["VALUE"];
                //redondea a 2 decimales, lo convierte en string y lo concatena a su valor UNIT
                $salida = strval(round($salida, 2))." ".$item["UNIT"];
                //para el código y sale del foreach
                break;
           }
        }
        //ratorna el string con los bytes y la unidad correspondiente
        return $salida;

    }

}

function debuguear($data = '', $detener = true)
{
    print "<pre>";
        //muestra la información, estructurada, de la variable
        var_dump($data);
        print "<pre>";
        if ($detener) {
            exit;
        }
}


