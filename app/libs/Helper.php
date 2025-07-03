<?php
/** */

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

class Helper
{
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

}


