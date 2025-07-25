<?php

class ProductosControlador extends Controlador 
{
    private $usuario = "";
    protected $modelo = "";
    private $sesion;
    
    function __construct()
    {
        //Crea sesión
        $this->sesion = new Sesion();

        //si getLogin() retorna true
        if ($this->sesion->getLogin()) {   
            //obtiene el modelo CategoriasModelo y lo asigna a modelo
            $this->modelo = $this->modelo("ProductosModelo");
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

            //Sanitiza, con los métodos cadena() y numero(), los valores obtenidos del POST, 
            //por seguridad, antes de guardarlos en las tablas de la BD
            $idCategoria = Helper::cadena($_POST['idCategoria'] ?? "void");
            $nombre = Helper::cadena($_POST['nombre'] ?? "");
            $descripcion = Helper::cadena($_POST['descripcion'] ?? "");
            $precio = Helper::numero(Helper::cadena($_POST['precio'] ?? ""));
            $ubicacion = Helper::cadena($_POST['ubicacion'] ?? "");
            $iva = Helper::numero(Helper::cadena($_POST['iva'] ?? ""));
            $maximo = Helper::numero(Helper::cadena($_POST['maximo'] ?? ""));
            $minimo = Helper::numero(Helper::cadena($_POST['minimo'] ?? ""));
            $comentario = Helper::cadena($_POST['comentario'] ?? "");
            $idProveedor = Helper::cadena($_POST['idProveedor'] ?? "void");
            
            //obtiene la pagina de POST o si viene vacio, le asigna "1"
            $pagina = $_POST['pagina'] ?? "1";

            //valida que no venga vacios los campos obligarorios del formulario
            if ($idCategoria == "void") {
                array_push($errores, "La categoría del Producto es Obligatoria");
            }
            if (empty($nombre)) {
                array_push($errores, "El nombre del Producto es obligatorio");
            }
            if (empty($descripcion)) {
                array_push($errores, "La descripción del Producto es obligatoria");
            }
            if (empty($precio)) {
                array_push($errores, "El precio del Producto es obligatorio");
            }
            if ($idProveedor == "void") {
                array_push($errores, "El proveedor del producto es obligatorio");
            }

            //valida si no hay errores de validación
            if (empty($errores)) {
                //genera arreglo $data con la info del form
                $data = [
                    "id" => $id,
                    "nombre" => $nombre,
                    "descripcion" => $descripcion,
                    "precio" => $precio,
                    "foto" => "",
                    "ubicacion" => $ubicacion,
                    "iva" => $iva,
                    "maximo" => $maximo,
                    "minimo" => $minimo,
                    "stock" => 0,
                    "comentario" => $comentario,
                    "idProveedor" => $idProveedor,
                    "idCategoria" => $idCategoria,
                ];
                //limpia los espacios en blanco de $id y valida si el valor de $id
                //es una cadena vacia "", significa que el id no existe y podemos dar un alta nueva.
                if (trim($id)==="") {

                    //el método alta() retorna el registro del último id insertado o "", a $id
                    $id = $this->modelo->alta($data);
                    
                    //valida si el $id resultado de alta(), NO está vacio de info
                    if ($id != "") {
                        //define array con los tipos de archivos que puede subir por el form
                        $tipos_array = ["image/jpg", "image/jpeg", "image/gif", "image/png"];
                        
                        //valida si en el array super glob $_FILES, contiene el arreglo [`fotos`]
                        //(si no se ha subido foto el arreglo ['fotos'] viene pero vacio)
                        if ($_FILES['fotos']) {
                            //define var con el nombre de la carpeta a crear para las fotos de productos,
                            //el nombre es fotos/el id del último registro insertado/
                            $carpeta = 'fotos/'.$id.'/';
                            //valida si NO existe la carpeta 
                            if (!file_exists($carpeta)) {
                                //crea la carpeta, 0777 (todos los permisos), true (modificable) 
                                mkdir($carpeta, 0777, true);
                            }

                            //define un arreglo temporal de trabajo
                            $archivos_array = [];
                            //El array super glob $_FILES contiene el arreglo asoc ['fotos'] que a su vez contiene,
                            //varios arreglos indexados (['name'], ['type'], etc), con la info de cada archivo subido.
                            //Cuenta cuantos nombres de archivos hay en el arreglo name
                            $archivos_num = count($_FILES['fotos']['name']);
                            //obtiene las llaves (arreglos) del arrelgo asoc 'fotos'. (['name'], ['type'], ['size'], etc)
                            $archivos_keys = array_keys($_FILES['fotos']);
                            
                            //ciclo for que se ejecuta tantas veces como cantidad de archivos subidos
                            for ($i=0; $i<$archivos_num; $i++) {
                                //itera las llaves (arreglos) del arreglo 'fotos' y por cada llave $key
                                foreach ($archivos_keys as $key) {
                                    //obtiene el elemento de cada indice $i, de cada llave $key, del arreglo 'fotos' y
                                    //lo asigna el elemento a la llave $key de un arreglo asoc,
                                    //dentro del un arreglo index por cada archivo $i
                                    $archivos_array[$i][$key] = $_FILES['fotos'][$key][$i];
                                }
                            }
                            
                            // debuguear($archivos_array);
                            //itera el nuevo arreglo $archivos_array y por cada $archivo
                            foreach ($archivos_array as $archivo) {
                                //obtiene y sanitiza, limpia el 'name' de cada archivo, para php
                                $nombre = Helper::archivo($archivo['name']);
                                //obtiene la extensión de cada archivo
                                $extension = $archivo['type'];
                                //valida si el tamaño de cada archivo es menor de 40Mb
                                if ($archivo['size'] < 40*1024*1024) {
                                    //valida si la extensión del archivo subido, está entre las definidas en $tipos_array
                                    if (in_array($extension, $tipos_array)) {
                                        //php guarda temporalmente el archivo subido, con un nombre temporal en ['tmp_name] de $_FILES,
                                        //hasta que se confirme su copiado a una carpeta.
                                        //Valida si el nombre temporal del archivo, está en la zona temporal
                                        if (is_uploaded_file($archivo['tmp_name'])) {
                                            //copia el archivo temporal, a la carpeta final y con el nombre final
                                            copy($archivo['tmp_name'], $carpeta.$nombre);
                                        }
                                    //si la extensión no es valida
                                    } else {
                                        array_push($errores, "Tipo de extension " .$extension. " no válida<br>");
                                    } 
                                //si el tamaño del archivo es superior a 40Mb
                                } else {
                                    array_push($errores, "Tamaño del archivo " .$nombre. "demasiado grande<br>");
                                }
                            }
                        } 

                        //valida si no hay errores en el arreglo $errores, tras la comprobación de los archivos
                        if (count($errores) == 0) {
                            $this->mensaje(
                                "Agregar Producto",
                                "Agregar un nuevo Producto",
                                "Se agregó el Producto: ".$nombre,
                                "ProductosControlador/".$pagina,
                                "success"
                            );
                        }

                    //el $id, resultado de alta(), está vacio de info
                    } else {
                        //llama al método mensaje de Controlador, enviando argumentos de error
                        $this->mensaje(
                            "Error Alta Producto",
                            "Error al agregar un nuevo Producto",
                            "Error al agregar el Producto: ".$nombre,
                            "ProductosControlador/".$pagina,
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
                            "Modificar Producto",
                            "Modificar el Producto",
                            "Se modificó correctamente el Producto: ".$nombre,
                            "ProductosControlador/".$pagina,
                            "success"
                        );
                    
                    //si modificar() retorna false
                    } else {
                        //llama método para mensaje de error
                        $this->mensaje(
                            "Modificar Producto",
                            "Modificar el Producto",
                            "Error al modificar el Producto: ".$nombre,
                            "ProductosControlador/".$pagina,
                            "danger"
                        );
                    }
                }
            }
        }

        //** Vista alta, modificación y baja */
        //valida si $errores NO está vacio o el método NO ha sido tipo POST
        if (!empty($errores) || $_SERVER['REQUEST_METHOD'] != "POST") {
            //obtine valores de las tablas (catalogos) relacionadas con productos,
            //para ofrecerlos en los secet del form alta usuario
            $proveedores = $this->modelo->getProveedores();
            $categorias = $this->modelo->getCategorias(); 

            //valida si existe la tabla proveedores está vacia
            if (count($proveedores) == 0) {
                //llama al método mensaje de Controlador, enviando argumentos de error
                $this->mensaje(
                    "Error Alta Producto",
                    "Error al agregar un nuevo Producto",
                    "Debes crear, al menos, un Proveedor",
                    "ProductosControlador/".$pagina,
                    "danger"
                );
            
            //valida si la tabla categorias está vacia
            } else if (count($categorias) == 0) {
                //llama al método mensaje de Controlador, enviando argumentos de error
                $this->mensaje(
                    "Error Alta Producto",
                    "Error al agregar un nuevo Producto",
                    "Debes crear, al menos, una Categoría",
                    "ProductosControlador/".$pagina,
                    "danger"
                );

            //como tanto proveedores como categorias no estan vacias
            } else {
                //define arreglo $datos para la vista
                $datos = [
                    "titulo" => "Alta  Producto",
                    "subtitulo" => "Alta nuevo Producto",
                    "activo" => "productos",
                    "menu" => true,
                    "admon" => true,
                    "errores" => $errores,
                    "proveedores" => $proveedores,
                    "categorias" => $categorias,
                    "data" => $data
                ];

                //llama a vista() enviando nom archivo.php y data
                $this->vista("productosAltaVista", $datos);
            } 
        }
    }

    //activa la columna baja del registro producto, según el id
    public function bajaLogica($id='', $pagina="1")
    {
        //valida si el id está definido no es NULL y no está vacio
        if (isset($id) && $id!='') {
            //llama al método bajaLogica() de modelo y si retorna true
            if ($this->modelo->bajaLogica($id)) {
                //llama mensaje de exito
                $this->mensaje(
                    "Eliminar Producto",
                    "Eliminar el Producto",
                    "Se eliminó correctamente el Producto: ".$id,
                    "ProductosControlador/".$pagina,
                    "success"
                );

            // si el método bajaLogica() de modelo retorna false
            } else {
                //llama mensaje de error
                $this->mensaje(
                    "Eliminar Producto",
                    "Eliminar el Producto",
                    "Hubo un error al 'eliminar' el Producto".$id,
                    "ProductosControlador/".$pagina,
                    "danger"
                );
            }
        }
    }

    //recibe id del producto, el índice del arreglo del nombre del archivo (foto) y la página
    public function borrarImagen($id="",$i="",$pagina="1")
    {
        //define la url relativa (php) de la carpeta donde están los archivos (fotos)
        $carpeta = "fotos/".$id."/";
        //define var $foto
        $foto = "";
        //valida si la carpeta existe
        if (file_exists($carpeta)) {
            //obtiene un array indexado con los directorios relativos (php) hasta la carpeta en $carpeta y
            //los archivos que contiene ([0]=>"." [1]=>".." [2]=>"nom_archivo1" [3]=>"nom_archivo2" etc)
            $archivos_array = scandir($carpeta);
            //define el directorio y el nombre del archivo (foto) a borrar
            $foto = $carpeta.$archivos_array[$i];
        } else {
            $archivos_array = [];
        }
        //llama método mensaje() einviando parámetros
        $this->mensaje(
            "Eliminar Imagen",
            "Eliminar foto de Producto",
            "Una vez eliminada la foto '".$archivos_array[$i]."' no podrá ser recuperada",
            "ProductosControlador/".$pagina,
            "danger",
            "ProductosControlador/borrarArchivo/".$id."/".$i."/".$pagina,
            "danger",
            "Borrar"
        );
    }

    public function borrarArchivo($id,$i,$pagina)
    {
        //define la url relativa (php) de la carpeta donde están los archivos (fotos)
        $carpeta = "fotos/".$id."/";
        //define var $foto
        $foto = "";
        $salida = false;
         //valida si la carpeta existe
        if (file_exists($carpeta)) {
            //obtiene un array indexado con los directorios relativos (php) hasta la carpeta en $carpeta y
            //los archivos que contiene ([0]=>"." [1]=>".." [2]=>"nom_archivo1" [3]=>"nom_archivo2" etc)
            $archivos_array = scandir($carpeta);
            //define el directorio y el nombre del archivo (foto) a borrar
            $foto = $carpeta.$archivos_array[$i];
            //valida si existe el archivo foto
            if (file_exists($foto)){
                //elimina el archivo (foto)
                //unlink($foto)
                $salida = true;
            }
        }

        //si $salida es true, se ha borrado el archivo (foto)
        if ($salida) {
            //llama método mensaje()
            $this->mensaje(
                "Borrar imagen",
                "Borrar una imagen de producto",
                "Se borró correctamente la imagen: ".$foto,
                "ProductosControlador/".$pagina,
                "success"
            );
        } else {
           //llama método mensaje()
            $this->mensaje(
                "Borrar imagen",
                "Borrar una imagen de producto",
                "Error al borrar la imagen: ".$foto,
                "ProductosControlador/".$pagina,
                "danger"
            );
        }
    }

    //muestra carátula (tablero o dashboard) de Paises
    public function caratula($pagina='1')
    {
        //obtiene la cantidad de registros de alta, de la tabla productos
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
            "titulo" => "Productos",
            "subtitulo" => "Productos",
            "usuario" => $this->usuario,
            "activo" => "productos",
            "admon" => true,
            "data" => $data,
            "menu" => true,
            "pag" => [
                "totalPaginas" => $totalPaginas,
                "regresa" => "ProductosControlador",
                "pagina" => $pagina
            ]
        ];

        //llam método enviando el nombre del archivo y los datos 
        $this->vista("productosCaratulaVista", $datos);
    }


    //Borrado lógico, asignando el estado de baja al registro producto, según su id.
    public function eliminar($id="", $pagina="1")
    {
        //obtinene el registro usuario, según su id
        $data = $this->modelo->getId($id);

        //obtine valores de las tablas relacionadas con productos,
        //para imprimirlor en los secet del form procductosAltaVista de productos
        $proveedores = $this->modelo->getProveedores();
        $categorias = $this->modelo->getCategorias(); 

        //arreglo con datos para enviar a la vista, una vez obtenida la $data de la BD
        $datos = [
            "titulo" => "Eliminar Producto",
            "subtitulo" => "Eliminar un Producto",
            "activo" => "productos",
            "admon" => true,
            "menu" => true,
            "errores" => [],
            "pagina" => $pagina,
            "proveedores" => $proveedores,
            "categorias" => $categorias,
            "data" => $data,
            "baja" => true
        ];

        //llama método vista para mostrar el registro obtenido
        $this->vista("productosAltaVista", $datos);
    }

    //modificar el producto por su id
    public function modificar($id, $pagina="1")
    {
        //obtener registro de la tabla por su id con el método getId() en modelo
        $data = $this->modelo->getId($id);

        //obtine valores de las tablas (catalogos) relacionadas con productos,
        //para ofrecerlos en los secet del form alta usuario
        $proveedores = $this->modelo->getProveedores();
        $categorias = $this->modelo->getCategorias(); 

        //arreglo con datos para enviar a la vista, una vez obtenida la $data de la BD
        $datos = [
            "titulo" => "Modificar Producto",
            "subtitulo" => "Modificar un Producto",
            "activo" => "productos",
            "admon" => true,
            "menu" => true,
            "errores" => [],
            "pagina" => $pagina,
            "proveedores" => $proveedores,
            "categorias" => $categorias,
            "data" => $data
        ];

        //llema método vista() enviando atributos
        $this->vista("productosAltaVista", $datos);
    }

    //obtiene la imagen y la envia a la vista para eliminar
    public function modificarImagenes($id, $pagina="1")
    {
        //obtener registro de la tabla por su id con el método getId() en modelo
        $data = $this->modelo->getId($id);

        //define la url relativa, de la carpeta con las fotos del producto por su $id
        $carpeta = "fotos/".$id."/";

        //valida si existe la carpeta o directorio
        if (file_exists($carpeta)) {
            //obtine en un arreglo indexaso, los niveles de directorios relativos (desde la carpeta public),
            //hasta la carpeta donde estan los archivos (fotos) de cada producto (. ..) (/fotos/01/) y
            //los nombres de los archivos (fotos) de la carpeta, de cada producto.
            //Cada nivel de directorio y cada archivo se almacena en un indice del arreglo indexado $archivos_array
            //[0]=>"." [1]=>".." [2]=>"nom_foto1" [3]=>"nom_foto2" etc
            $archivos_array = scandir($carpeta);
            
        //si NO existe la carpeta fotos/...
        } else {
            //asigna arreglo vacio al arreglo archivos_array
            $archivos_array = [];
        }

        //arreglo con datos para enviar a la vista, una vez obtenida la $data de la BD
        $datos = [
            "titulo" => "Editar Foto",
            "subtitulo" => "Editar foto del producto: ".$data['nombre'],
            "activo" => "productos",
            "admon" => true,
            "menu" => true,
            "pagina" => $pagina,
            "archivos" => $archivos_array,
            "data" => $data
        ];

        //llema método vista() enviando atributos
        $this->vista("productosArchivosVista", $datos);
    }
}
?>