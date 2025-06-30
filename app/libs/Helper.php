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
}
