<?php

class ProveedoresControlador extends Controlador 
{
    protected $proveedor = "";
    protected $modelo = "";
    private $sesion;
    
    function __construct()
    {
        //Crea sesión
        $this->sesion = new Sesion();

        //si getLogin() retorna true
        if ($this->sesion->getLogin()) {   
            //obtiene el modelo ProveedoresModelo y lo asigna a modelo
            $this->modelo = $this->modelo("ProveedoresModelo");
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

            //aplica método cadena() a los valores obtenidos del POST, para sanitizar,
            //por seguridad, antes de guardarlos en las tablas de la BD
            $nombre = Helper::cadena($_POST['nombre'] ?? "");
            $web = Helper::cadena($_POST['web'] ?? "");
            $pais = Helper::cadena($_POST['pais'] ?? "");
            
            //obtiene la pagina de POST o si viene vacio, le asigna "1"
            $pagina = $_POST['pagina'] ?? "1";

            //valida que no venga vacios los campos obligarorios del formulario
            if (empty($nombre)) {
                array_push($errores, "El nombre del Proveedor es obligatorio");
            }
            if ($pais == "void") {
                array_push($errores, "El País del Proveedor es obligatorio");
            }

            //valida si no hay errores de validación
            if (empty($errores)) {
                //genera arreglo $data con la info del form
                $data = [
                    "id" =>$id,
                    "nombre" => $nombre,
                    "idPais" => $pais,
                    "web" => $web,
                ];

                //limpia los espacios en blanco de $id y valida si el valor de $id
                //es una cadena vacia "", significa que el id no existe y podemos dar un alta nueva.
                if (trim($id)==="") {

                    //envia $data al método alta() del modelo y si retorna true:
                    if ($this->modelo->alta($data)) {

                        //llama al método mensaje de Controlador, enviando arguementos, éxito
                        $this->mensaje(
                            "Alta Proveedor",
                            "Alta de nuevo Proveedor",
                            "Se agregó correctamente el Proveedor: ".$nombre,
                            "ProveedoresControlador/".$pagina,
                            "success"
                        );

                    // si el método alta() no ha retornado true  
                    } else {
                        //llama al método mensaje de Controlador, enviando argumentos de error
                        $this->mensaje(
                            "Error Alta Proveedor",
                            "Error al agregar un nuevo Proveedor",
                            "Error al agregar el Proveedor: ".$nombre,
                            "ProveedoresControlador/".$pagina,
                            "danger"
                        );
                    }
                
                //si el valor de $id no es una cadena vacia "",
                //significa que el $id existe y viene de modificar
                } else {

                    //llama modificar() de modelo y si retorna true
                    if ($this->modelo->modificar($data)) {

                        //llama método para mensaje de exito
                        $this->mensaje(
                            "Modificar Proveedor",
                            "Modificar el Proveedor",
                            "Se modificó correctamente el Proveedor: ".$nombre,
                            "ProveedoresControlador/".$pagina,
                            "success"
                        );
                    
                    //si modificar() retorna false
                    } else {
                        //llama método para mensaje de error
                        $this->mensaje(
                            "Modificar Proveedor",
                            "Modificar el Proveedor",
                            "Error al modificar el Proveedor: ".$nombre,
                            "UsuariosControlador/".$pagina,
                            "danger"
                        );
                    }
                }
            }
        }

        //valida si $errores NO está vacio o el método NO ha sido tipo POST
        if (!empty($errores) || $_SERVER['REQUEST_METHOD'] != "POST") {
            //Vista Alta Proveedores
            //obtine valores de las tablas (catálogos) relacionadas con proveedores,
            //para mostrarlos en los select del form alta proveedor
            $paises = $this->modelo->getPaises();

            //define arreglo $datos para la vista
            $datos = [
                "titulo" => "Alta Proveeor",
                "subtitulo" => "Alta de nuevo Proveedor",
                "activo" => "proveedores",
                "menu" => true,
                "admon" => true,
                "errores" => $errores,
                "paises" => $paises,
                "data" => $data
            ];

            //llama a vista() enviando nom archivo.php y data
            $this->vista("proveedoresAltaVista", $datos);
        }
    }

    //activa la columna baja del registro proveedor, según el id
    public function bajaLogica($id='', $pagina="1")
    {
        //valida si el id está definido no es NULL y no está vacio
        if (isset($id) && $id!='') {
            //llama al método bajaLogica() de modelo y si retorna true
            if ($this->modelo->bajaLogica($id)) {
                //llama mensaje de exito
                $this->mensaje(
                    "Eliminar Proveedor",
                    "Eliminar el Proveedor",
                    "Se eliminó correctamente el Proveedor: ".$id,
                    "ProveedoresControlador/".$pagina,
                    "success"
                );

            // si el método bajaLogica() de modelo retorna false
            } else {
                //llama mensaje de error
                $this->mensaje(
                    "Eliminar Proveedor",
                    "Eliminar el Proveedor",
                    "Hubo un error al eliminar el Proveedor".$id,
                    "ProveedoresControlador/".$pagina,
                    "danger"
                );
            }
        }
    }

    //muestra carátula (tablero o dashboard) de Paises
    public function caratula($pagina='1')
    {
        //obtiene la cantidad de registros de alta, de la tabla proveedores
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
            "titulo" => "Proveedores",
            "subtitulo" => "Proveedores",
            "proveedor" => $this->proveedor,
            "activo" => "proveedores",
            "admon" => true,
            "menu" => true,
            "data" => $data,
            "pag" => [
                "totalPaginas" => $totalPaginas,
                "regresa" => "ProveedoresControlador",
                "pagina" => $pagina
            ]
        ];

        //llam método enviando el nombre del archivo y los datos 
        $this->vista("proveedoresCaratulaVista", $datos);
    }

    //Borrado lógico, asignando el estado de baja al registro pais, según su id.
    public function eliminar($id="", $pagina="1")
    {
        //obtinene el registro del proveedor, según su id
        $data = $this->modelo->getId($id);

        //obtine valores de la tabla (catálogo) paises relacionada con proveedores,
        //para mostrarlos en los secet del form alta/modificarion de usuario
        $paises = $this->modelo->getPaises();

        //arreglo con datos para enviar a la vista, una vez obtenida la $data de la BD
        $datos = [
            "titulo" => "Eliminar Proveedor",
            "subtitulo" => "Eliminar el Proveedor",
            "activo" => "proveedores",
            "admon" => true,
            "menu" => true,
            "errores" => [],
            "pagina" => $pagina,
            "paises" => $paises,
            "data" => $data,
            "baja" => true
        ];

        //llama método vista para mostrar el registro obtenido
        $this->vista("proveedoresAltaVista", $datos);
    }

    //modificar el país por su id
    public function modificar($id, $pagina="1")
    {
        //obtener registro de la tabla por su id con el método getId() en modelo
        $data = $this->modelo->getId($id);

        //obtine valores de las tablas relacionadas con proveedores,
        //para mostrarlos en el select del form alta/modificarion de proveedores
        $paises = $this->modelo->getPaises();
        
        //arreglo con datos para enviar a la vista, una vez obtenida la $data de la BD
        $datos = [
            "titulo" => "Modificar Proveedor",
            "subtitulo" => "Modificar un Proveedor",
            "activo" => "proveedores",
            "admon" => true,
            "menu" => true,
            "pagina" => $pagina,
            "paises" => $paises,
            "data" => $data
        ];

        //llema método vista() enviando atributos
        $this->vista("proveedoresAltaVista", $datos);
    }
}
?>