<?php

class UsuariosControlador extends Controlador 
{
    protected $usuario = "";
    protected $modelo = "";
    private $sesion;
    
    function __construct()
    {
        //Crea sesión
        $this->sesion = new Sesion();

        //si getLogin() retorna true
        if ($this->sesion->getLogin()) {   
            //obtiene el modelo CategoriasModelo y lo asigna a modelo
            $this->modelo = $this->modelo("UsuariosModelo");
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
            $tipoUsuario = Helper::cadena($_POST['tipoUsuario'] ?? "");
            $nombres = Helper::cadena($_POST['nombres'] ?? "");
            $apellidos = Helper::cadena($_POST['apellidos'] ?? "");
            $direccion = Helper::cadena($_POST['direccion'] ?? "");
            $telefono = Helper::cadena($_POST['telefono'] ?? "");
            $correo = Helper::cadena($_POST['correo'] ?? "");
            $genero = Helper::cadena($_POST['genero'] ?? "");
            
            //obtiene la pagina de POST o si viene vacio, le asigna "1"
            $pagina = $_POST['pagina'] ?? "1";

            //valida que no venga vacios los campos obligarorios del formulario
            if ($tipoUsuario == "void") {
                array_push($errores, "El tipo de Usuario es obligatorio");
            }
            if (empty($nombres)) {
                array_push($errores, "El nombre del Usuario es obligatorio");
            }
            if (empty($apellidos)) {
                array_push($errores, "El apellido del Usuario es obligatorio");
            }
            if (empty($correo)) {
                array_push($errores, "El email del Usuario es obligatorio");
            }

            //valida si el correo NO tiene un formato válido
            if (Helper::correo($correo) == false) {
                array_push($errores, "Formato de correo no válido");
            
            //si el correo SI tiene un formato válido,
            //busca el correo en la DB y si el resultado NO es false,
            //significa que el correo ya existe en la DB
            } else if ($this->modelo->getCorreo($correo) !=false) {
                array_push($errores, "El Correo ya existe en la BD");
            }

            if ($genero == "void") {
                array_push($errores, "Selecciona un género para el Usuario");
            }

            //valida si no hay errores de validación
            if (empty($errores)) {
                //genera arreglo $data con la info del form
                $data = [
                    "id" =>$id,
                    "tipoUsuario" => $tipoUsuario,
                    "nombres" => $nombres,
                    "apellidos" => $apellidos,
                    "direccion" => $direccion,
                    "telefono" => $telefono,
                    "correo" => $correo,
                    "clave" => Helper::generarClave(10),
                    "genero" => $genero,
                    "estadoUsuario" => USUARIO_INACTIVO,
                ];

                //limpia los espacios en blanco de $id y valida si el valor de $id
                //es una cadena vacia "", significa que el id no existe y podemos dar un alta nueva.
                if (trim($id)==="") {

                    //envia $data al método alta() del modelo y si retorna true:
                    if ($this->modelo->alta($data)) {
                        //envia correo al usuario y si retorna true:
                        if ($this->enviarCorreo($data["correo"])) {
                            //llama al método mensaje de Controlador, enviando arguementos, éxito
                            $this->mensaje(
                                "Alta Usuario",
                                "Alta de nuevo Usuario",
                                "Se agregó correctamente el Usuario/a: ".$nombres." ".$apellidos,
                                "UsuariosControlador/".$pagina,
                                "success"
                            );

                        } else {
                            //llama al método mensaje de Controlador, enviando argumentos de error
                            $this->mensaje(
                            "Error envio correo al Usuario",
                            "Error al enviar el correo al Usuario",
                            "Error al enviar el correo de confirmación al Usuario/a: ".$nombres." ".$apellidos,
                            "UsuariosControlador/".$pagina,
                            "danger"
                            );
                        }

                    // si el método alta() no ha retornado true  
                    } else {
                        //llama al método mensaje de Controlador, enviando argumentos de error
                        $this->mensaje(
                            "Error Alta Usuario",
                            "Error al agregar un nuevo Usuario",
                            "Error al agregar el Usuario/a: ".$nombres." ".$apellidos,
                            "UsuariosControlador/".$pagina,
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
                            "Modificar Categoría",
                            "Modificar nombre de la Categoría",
                            "Se modificó orrectamente la Categoría: ".$categoria,
                            "CategoriasControlador/".$pagina,
                            "success"
                        );
                    
                    //si modificar() retorna false
                    } else {
                        //llama método para mensaje de error
                        $this->mensaje(
                            "Modificar Categoría",
                            "Modificar nombre de la Categoría",
                            "Error al modificar la Categoría: ".$categoria,
                            "CategoriasControlador/".$pagina,
                            "danger"
                        );
                    }
                }
            }
        }

        //valida si $errores NO está vacio o el método NO ha sido tipo POST
        if (!empty($errores) || $_SERVER['REQUEST_METHOD'] != "POST") {
            //Vista Alta Usuario
            //obtine valores de las tablas relacionadas con usuario,
            //para ofrecerlos en los secet del form alta usuario
            $tiposUsuarios = $this->modelo->getTiposUsuarios();
            $generos = $this->modelo->getGeneros();
            $estadosUsuarios = $this->modelo->getEstadosUsuarios(); 

            //define arreglo $datos para la vista
            $datos = [
                "titulo" => "Alta  Usuarios",
                "subtitulo" => "Alta de nuevo Usuarios",
                "activo" => "usuarios",
                "menu" => true,
                "admon" => true,
                "errores" => $errores,
                "tiposUsuarios" => $tiposUsuarios,
                "estadosUsuarios" => $estadosUsuarios,
                "generos" => $generos,
                "data" => $data
            ];

            //llama a vista() enviando nom archivo.php y data
            $this->vista("usuariosAltaVista", $datos);
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
                    "Eliminar la Categoría",
                    "Eliminar la Categoría",
                    "Se eliminó correctamente la categoría",
                    "CategoriasControlador/".$pagina,
                    "success"
                );

            // si el método bajaLogica() de modelo retorna false
            } else {
                //llama mensaje de error
                $this->mensaje(
                    "Eliminar Categoría",
                    "Eliminar la Categoría",
                    "Hubo un error al 'eliminar' la Categoría",
                    "CategoriasControlador/".$pagina,
                    "danger"
                );
            }
        }
    }

    //muestra carátula (tablero o dashboard) de Paises
    public function caratula($pagina='1')
    {
        //obtiene la cantidad de registros de alta, de la tabla categorias
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
            "titulo" => "Usuarios",
            "subtitulo" => "Usuarios",
            "usuario" => $this->usuario,
            "activo" => "usuarios",
            "admon" => true,
            "data" => $data,
            "menu" => true,
            "pag" => [
                "totalPaginas" => $totalPaginas,
                "regresa" => "UsuariosControlador",
                "pagina" => $pagina
            ]
        ];

        //llam método enviando el nombre del archivo y los datos 
        $this->vista("usuariosCaratulaVista", $datos);
    }


    //Borrado lógico, asignando el estado de baja al registro pais, según su id.
    public function eliminar($id="", $pagina="1")
    {
        //obtinene el registro pais, según su id
        $data = $this->modelo->getId($id);

        //arreglo con datos para enviar a la vista, una vez obtenida la $data de la BD
        $datos = [
            "titulo" => "Eliminar Categoría",
            "subtitulo" => "Eliminar la Categoría",
            "activo" => "categorias",
            "admon" => true,
            "menu" => true,
            "errores" => [],
            "data" => $data,
            "pagina" => $pagina,
            "baja" => true
        ];

        //llama método vista para mostrar el registro obtenido
        $this->vista("categoriasAltaVista", $datos);
    }

    //modificar el país por su id
    public function modificar($id, $pagina="1")
    {
        //obtener registro de la tabla por su id con el método getId() en modelo
        $data = $this->modelo->getId($id);

        //arreglo con datos para enviar a la vista, una vez obtenida la $data de la BD
        $datos = [
            "titulo" => "Modificar Categoría",
            "subtitulo" => "Modificar Categoría",
            "activo" => "categorias",
            "admon" => true,
            "menu" => true,
            "pagina" => $pagina,
            "data" => $data
        ];

        //llema método vista() enviando atributos
        $this->vista("categoriasAltaVista", $datos);
    }
}
?>