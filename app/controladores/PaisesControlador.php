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
                            "PaisesControlador",
                            "success"
                        );
                    // si el método alta() no ha retornado true  
                    } else {
                        //llama al método mensaje de Controlador, enviando argumentos de error
                        $this->mensaje(
                            "Error Alta País",
                            "Error al agregar un nuevo País",
                            "Error al agregar el nuevo pais ".$pais,
                            "PaisesControlador",
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
                            "PaisesControlador",
                            "success"
                        );
                    
                    //si modificar() retorna false
                    } else {
                        //llama método para mensaje de error
                        $this->mensaje(
                            "Modificar País",
                            "Modificar nombre de País",
                            "Error al modificó el pais: ".$pais,
                            "PaisesControlador",
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
    public function bajaLogica($id='')
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
                    "PaisesControlador",
                    "success"
                );

            // si el método bajaLogica() de modelo retorna false
            } else {
                //llama mensaje de error
                $this->mensaje(
                    "Eliminar País",
                    "Eliminar el País",
                    "Hubo un error al 'eliminar' el pais",
                    "PaisesControlador",
                    "danger"
                );
            }
        }
    }

    //Borrado lógico, asignando el estado de baja al registro pais, según su id.
    public function eliminar($id="")
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
            "baja" => true
        ];

        //llama método vista para mostrar el registro obtenido
        $this->vista("paisesAltaVista", $datos);
    }

    //muestra carátula (tablero o dashboard) de Paises
    public function caratula($pag='')
    {
        //obtiene la info de la tabla paises
        $data = $this->modelo->getTabla();

        //arreglo con datos para enviar a la vista, una vez obtenida la $data de la BD
        $datos = [
            "titulo" => "Países",
            "subtitulo" => "Países",
            "usuario" => $this->usuario,
            "activo" => "paises",
            "admon" => true,
            "data" => $data,
            "menu" => true
        ];

        //llam método enviando el nombre del archivo y los datos 
        $this->vista("paisesCaratulaVista", $datos);
    }

    //modificar el país por su id
    public function modificar($id)
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
            "data" => $data
        ];

        //llema método vista() enviando atributos
        $this->vista("paisesAltaVista", $datos);
    }
}
?>