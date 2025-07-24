<?php

class ProductosModelo
{
    private $db = "";

    function __construct()
    {
        //instancia conexión BD
        $this->db = new MySQLdb();
    }

    //agrega nuevo registro categoria a la tabla categorias de la BD
    public function alta($data='')
    {
        //definición de sentencia SQL para insertar un nuevo usuario
        $sql = "INSERT INTO productos VALUES(0,";       //1. id
        $sql.= "'".$data['nombre']."', ";               //2. nombre
        $sql.= "'".$data['descripcion']."', ";          //3. descripcion
        $sql.= "'".$data['precio']."', ";               //4. precio
        $sql.= "'".$data['foto']."', ";                 //5. foto
        $sql.= "'".$data['ubicacion']."', ";             //6. ubicacion
        $sql.= "'".$data['iva']."', ";                  //7. iva       
        $sql.= "'".$data['maximo']."', ";               //8. maximo
        $sql.= "'".$data['minimo']."', ";               //9. minimo
        $sql.= "'0', ";                                 //10. stock
        $sql.= "'".$data['comentario']."', ";          //11. comentario
        $sql.= "'".$data['idProveedor']."', ";          //12. idProveedor
        $sql.= "'".$data['idCategoria']."', ";          //13. idCategoria
        $sql.= "0, ";                                 //14. baja
        $sql.= "NOW(), ";                             //15. fecha alta
        $sql.= "'', ";                                //16. fecha baja
        $sql.= "'')";                                 //17. fecha cambio

        //valida si el alta del producto en la DB ha sido correcta, no false
        if ($this->db->queryNoSelect($sql)) {

            //define instrucción SQL para obtener el registro del último id insertado
            $sql= "SELECT LAST_INSERT_ID()";
            //realiza la consulta sql y asigna el registro del último id insetado, a $id 
            $id = $this->db->query($sql);
            //retorna el id del último registro insertado
            return $id["LAST_INSERT_ID()"];

        //como el alta() del producto NO ha sido correcta, asigna "" a $id
        } else {
            $id = "";
        }
        
        //retorna el valor de $id
        return $id;
    }

    //actualiza la columna baja y baja_dt del registro pais, según su id
    public function bajaLogica($id) {

        $salida = true;
        //define la sentencia SQL para el query
        $sql = "UPDATE productos SET baja=1, baja_dt=(NOW()) WHERE id=".$id;
        //llama metodo query en db, enviando la sql
        $salida = $this->db->queryNoSelect($sql);
        return $salida;
    }

    //obtinene la cantidad de registros, de alta, de la tabla productos
    public function getNumRegistros()
    {
        //define la instrucción SQL, que cuenta la cantida de registros
        $sql = "SELECT COUNT(*) FROM productos WHERE baja=0";
        
        //ejecuta la consulta query()
        $salida = $this->db->query($sql);

        //retorna solo la cantidad de la consulta
        return $salida["COUNT(*)"];
    }

    //obtiene los datos de las tablas productos y proveedor, requiere: el registro inicio,
    //a partir del cual obtener y la cantidad de registros a obtener
    public function getTabla($inicio=1, $tamano=0)
    {
        //define la intrucción SQL, selecciona y combina registros de dos tablas,
        //obtiene los productos de alta, cuyo idProveedor coincida con id de la tabla proveedor
        $sql = "SELECT pr.id, pr.nombre, pr.idProveedor, pro.nombre as proveedor ";
        $sql.= "FROM productos as pr, proveedores as pro ";
        $sql.= "WHERE pr.baja=0 AND ";
        $sql.= "pr.idProveedor=pro.id ";

        //si la cantidad de registros a mostra $tamano > 0
        if ($tamano > 0) {
            //limita los registros consultados desde $inicio a $tamano
            $sql.= " LIMIT " . $inicio . ", " . $tamano;
        }

        //hace la consulta sql con el método querySelect() y retorna el resultado
        return $this->db->querySelect($sql);
    }

    //obtiene los campos del registro de la tabla productos, por us id,
    //retorna un arreglo idexado y asoc, con los campos
    public function getId($id='')
    {
        if (empty($id)) return false;
        //define la sentencia SQL para el query
        $sql = "SELECT id, nombre, descripcion, precio, foto, ubicacion, iva, maximo, minimo, stock, comentario, idProveedor, idCategoria FROM productos WHERE id='".$id."' AND baja=0";
        //hace la consulta query a la db y retorna a PDOStatement object, or FALSE si falla.
        return $this->db->query($sql);
    }

    //obtiene las categorias de productos de la tabla categorias
    public function getCategorias()
    {
        $sql = "SELECT id, categoria FROM categorias WHERE baja=0 ORDER BY categoria";
        return $this->db->querySelect($sql);
    }

    //obtiene los proveedores de la tabla proveedores
    public function getProveedores()
    {
        $sql = "SELECT id, nombre FROM proveedores WHERE baja=0 ORDER BY nombre";
        return $this->db->querySelect($sql);
    }

    public function modificar($data)
    {
        $salida = false;
        //valida si el id NO esta vacio
        if (!empty($data["id"])) {
            //define la instrucción SQL que enviará al query
            $sql = "UPDATE productos SET ";
            $sql.= "nombre='".$data['nombre']."', ";
            $sql.= "descripcion='".$data['descripcion']."', ";
            $sql.= "precio='".$data['precio']."', ";
            $sql.= "foto='".$data['foto']."', ";
            $sql.= "ubicacion='".$data['ubicacion']."', ";
            $sql.= "iva='".$data['iva']."', ";
            $sql.= "maximo='".$data['maximo']."', ";
            $sql.= "minimo='".$data['minimo']."', ";
            $sql.= "comentario='".$data['comentario']."', ";
            $sql.= "idProveedor='".$data['idProveedor']."', ";
            $sql.= "idCategoria='".$data['idCategoria']."', ";
            $sql.= "cambio_dt=(NOW()) ";
            $sql.= "WHERE id=".$data['id'];

            //llama metodo queryNoSelect() enviando $sql y asigna el result a $salida
            $salida = $this->db->queryNoSelect($sql);
        }
        //retorna $salida con el resultado del query o false
        return $salida;
    }
}
?>