<?php
//verifica si "pag" está definida y no es NULL
if (isset($datos["pag"])) {
    //pasa los valores del arreglo original a variables
    $totalPaginas = $datos["pag"]["totalPaginas"];
    $pagina = $datos["pag"]["pagina"];
    $regresa = $datos["pag"]["regresa"];

    //valida si el total de páginas es > 1, 
    //para mostrar los botones de paginación
    if ($totalPaginas > 1) {
        //gener botones de paginación, según bootstrap
        print '<nav>';
        print ' <ul class="pagination justify-content-end">';
        //valida si el total de páginas calcualdo es > al número máximo
        //de números de páginas a mostrar, en el paginador
        if($totalPaginas > PAGINAS_MAXIMAS) {

            //valida si el número de la página actual, es la última
            if ($pagina==$totalPaginas) {
                //reasigna paginas inicio y fin
                $inicio = $pagina-PAGINAS_MAXIMAS;
                $fin = $totalPaginas;

            //si el número de la página actual, NO es la última
            } else {
                //reasigna paginas inicio y fin
                $inicio = $pagina;
                $fin = $inicio-1 + PAGINAS_MAXIMAS;
            }

            //valida si el número de la página fin es > al totalPaginas
            if ($fin>$totalPaginas) {
                //reasigna numero de pagina incio y fin
                $inicio = $totalPaginas - PAGINAS_MAXIMAS +1;
                $fin = $totalPaginas;
            }

            //valida si el número de página incio es diferente de 1
            if ($inicio!=1) {
                //musetra flecha < atras con su enlace a la pagina anterior, en un <li>
                print '<li class="page-item">';
                print ' <a class="page-link" href="'.RUTA.$regresa.'/'.($pagina-1);
                print '" tabindex="-1">&laquo;</a>';
                print '</li>';
            }
            
        //si el total de páginas calcualdo NO es > al máximo de páginas a mostrar
        } else {
            //define página de inicio, para la primera paginación
            $inicio = 1;
            $fin = $totalPaginas;
        }

        //mientras la página en $inicio sea < o = al total de páginas
        for($i=$inicio; $i<=$fin; $i++) {
            //imprime un elemento li con el número de página, en la ul,
            //si cumple la condición
            print '<li ';
                //si el valor del indice $i es == al valor de $pagina
                if($i == $pagina) {
                    //agrega class con active, al li con el número de página
                    print 'class="page-item active"';
                
                //de lo contrario
                } else {
                    print 'class="page-item"';
                }
            print '>';
                //agrega enlace a la RUTA/controlador/pag y muestra num pag $i
                print '<a class="page-link" href="'.RUTA.$regresa.'/'.$i.'">'.$i.'</a>';
            print '</li>';
        }

        //valida si el total de páginas necesarias es > PAGINAS_MAXIMAS y 
        //el número de pagina actual + PAGINAS_MAXIMAS <= al número total de paginas necesarias
        if ($totalPaginas > PAGINAS_MAXIMAS && ($pagina+PAGINAS_MAXIMAS) <= $totalPaginas) {
            //musetra flecha > siguiente con su enlace a la pagina siguiente, en un <li>
            print '<li class="page-item">';
            print '  <a class="page-link" href="'.RUTA.$regresa.'/'.($pagina+1).'"
                tabindex="-1">&raquo;</a>';
            print '</li>';
        }

        print '</ul>';
        print '</nav>';
    }
}
?>