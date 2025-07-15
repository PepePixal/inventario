<?php

class PaisesControlador extends Controlador 
{
    private $usuario = "";
    private $modelo = "";
    private $sesion;
    
    function __construct()
    {
        //Crea sesión
        $this->sesion = new Sesion();

        //si getLogin() retorna true
        if ($this->sesion->getLogin()) {   
            //obtiene el modelo PaisesModelo y lo asigna a modelo
            $this->modelo = $this->modelo("PaisesModelo");
            //obtiene el arreglo usuario de la sesión y lo asigna a usuario
            $this->usuario = $this->sesion->getUsuario();

        //si NO se ha obtenido el usuario logueado
        } else {
            //redirige al inicio (inventario)
            header("location:".RUTA);
        }
    }

    public function alta()
    {
        //define arreglos
        $data = array();
        $errores = array();

        //valida si el SERVER ha llamado a la función, con el método POST
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            //obtiene el id de POST o si viene vacio, le asigna ""
            $id = $_POST['id'] ?? "";
            //obtiene la pagina de POST o si viene vacio, le asigna "1"
            $pagina = $_POST['pagina'] ?? "1";

            //aplica método cadena() a pais del POST, para sanitizar, por seguridad, 
            //antes de guardarlo en la tabla de la BD
            $pais = Helper::cadena($_POST['pais'] ?? "");

            //valida que $pais no venga vacio del formulario
            if (empty($pais)) {
                array_push($errores, "El nombre del Pais es necesario");
            }

            //valida si no hay errores de validación
            if (empty($errores)) {
                //genera arreglo $data con la info del form
                $data = [
                    "id" =>$id,
                    "pais" => $pais
                ];

                //limpia los espacios en blanco de $id y valida si el valor de $id
                //es una cadena vacia "", significa que el id no existe y podemos dar un alta nueva.
                if (trim($id)==="") {

                    //envia $data al método alta() del modelo y si retorna true
                    if ($this->modelo->alta($data)) {
                        //llama al método mensaje de Controlador, enviando arguementos, exito
                        $this->mensaje(
                            "Alta País",
                            "Alta de un nuevo País",
                            "Se agregó correctamente el pais: ".$pais,
                            "PaisesControlador/".$pagina,
                            "success"
                        );
                    // si el método alta() no ha retornado true  
                    } else {
                        //llama al método mensaje de Controlador, enviando argumentos de error
                        $this->mensaje(
                            "Error Alta País",
                            "Error al agregar un nuevo País",
                            "Error al agregar el nuevo pais ".$pais,
                            "PaisesControlador/".$pagina,
                            "danger"
                        );
                    }
                
                //si el valor de $id no es una cadena vacia "",
                //significa que el $id existe y será para modificar
                } else {
                    //llama modificar() de modelo y si retorna true
                    if ($this->modelo->modificar($data)) {
                        //llama método para mensaje de exito
                        $this->mensaje(
                            "Modificar País",
                            "Modificar nombre de País",
                            "Se modificó orrectamente el pais: ".$pais,
                            "PaisesControlador/".$pagina,
                            "success"
                        );
                    
                    //si modificar() retorna false
                    } else {
                        //llama método para mensaje de error
                        $this->mensaje(
                            "Modificar País",
                            "Modificar nombre de País",
                            "Error al modificó el pais: ".$pais,
                            "PaisesControlador/".$pagina,
                            "danger"
                        );
                    }
                }
            }
        }

        //valida si $errores NO está vacio o el método NO ha sido tipo POST
        if (!empty($errores) || $_SERVER['REQUEST_METHOD'] != "POST") {
            //define arreglo $datos para la vista
            $datos = [
                "titulo" => "Alta País",
                "subtitulo" => "Alta de nuevo País",
                "activo" => "paises",
                "menu" => true,
                "admon" => true,
                "errores" => $errores,
                "data" => $data
            ];

            //llama a vista() enviando nom archivo.php y data
            $this->vista("paisesAltaVista", $datos);
        }
    }


    //activa la columna baja del registro pais, según el id
    public function bajaLogica($id='', $pagina="1")
    {
        //valida si el id está definido no es NULL y no está vacio
        if (isset($id) && $id!='') {
            //llama al método bajaLogica() de modelo y si retorna true
            if ($this->modelo->bajaLogica($id)) {
                //llama mensaje de exito
                $this->mensaje(
                    "Eliminar País",
                    "Eliminar el País",
                    "Se 'eliminó' correctamente el pais",
                    "PaisesControlador/".$pagina,
                    "success"
                );

            // si el método bajaLogica() de modelo retorna false
            } else {
                //llama mensaje de error
                $this->mensaje(
                    "Eliminar País",
                    "Eliminar el País",
                    "Hubo un error al 'eliminar' el pais",
                    "PaisesControlador/".$pagina,
                    "danger"
                );
            }
        }
    }

    //muestra carátula (tablero o dashboard) de Paises
    public function caratula($pagina='1')
    {
        //obtiene la cantidad de registros de alta, de la tabla paises
        $num = $this->modelo->getNumRegistros();

        //obtiene el registro inicial, a parti del cual mostrar
        $inicio = ($pagina-1)*TAMANO_PAGINA;

        //obtiene el total de páginas a mostrar, según la cantidad total de registros y
        //el número de registros por página.
        //ceil() redondea el resultado de la división, al alza
        $totalPaginas = ceil($num/TAMANO_PAGINA);

        //obtiene los registros de la tabla, a partir de registro inicial $inicio y
        //según la cantidad de registros a mostrar, por página
        $data = $this->modelo->getTabla($inicio, TAMANO_PAGINA);

        //arreglo con datos para enviar a la vista, una vez obtenida la $data de la BD
        $datos = [
            "titulo" => "Países",
            "subtitulo" => "Países",
            "usuario" => $this->usuario,
            "activo" => "paises",
            "admon" => true,
            "data" => $data,
            "menu" => true,
            "pag" => [
                "totalPaginas" => $totalPaginas,
                "regresa" => "PaisesControlador",
                "pagina" => $pagina
            ]
        ];

        //llam método enviando el nombre del archivo y los datos 
        $this->vista("paisesCaratulaVista", $datos);
    }


    //Borrado lógico, asignando el estado de baja al registro pais, según su id.
    public function eliminar($id="", $pagina="1")
    {
        //obtinene el registro pais, según su id
        $data = $this->modelo->getId($id);

        //arreglo con datos para enviar a la vista, una vez obtenida la $data de la BD
        $datos = [
            "titulo" => "País Eliminar",
            "subtitulo" => "Eliminar el País",
            "activo" => "paises",
            "admon" => true,
            "menu" => true,
            "errores" => [],
            "data" => $data,
            "pagina" => $pagina,
            "baja" => true
        ];

        //llama método vista para mostrar el registro obtenido
        $this->vista("paisesAltaVista", $datos);
    }

    //modificar el país por su id
    public function modificar($id, $pagina="1")
    {
        //obtener registro de la tabla por su id con el método getId() en modelo
        $data = $this->modelo->getId($id);

        //arreglo con datos para enviar a la vista, una vez obtenida la $data de la BD
        $datos = [
            "titulo" => "Modificar País",
            "subtitulo" => "Modificar País",
            "activo" => "paises",
            "admon" => true,
            "menu" => true,
            "pagina" => $pagina,
            "data" => $data
        ];

        //llema método vista() enviando atributos
        $this->vista("paisesAltaVista", $datos);
    }
}
?>