<?php
namespace class;

use http\Header;

class Product extends \Config
{
    private $conn;

    public function __construct()
    {
        parent::__construct();
        $this->conn = parent::getConnection();
    }

    /**
     * @api {post} /productos/create.php Crear producto
     * @apiName create_producto
     * @apiGroup Productos
     * @apiVersion 0.1.0
     * @apiDescription Crea un nuevo producto
     *
     * @apiBody {String} nombre Nombre del producto
     * @apiBody {String} imagen Imagen del producto
     * @apiBody {Number} precio Precio del producto
     * @apiBody {Number} precioEsp Precio especial del producto
     * @apiBody {String} tipo Tipo del producto
     *
     * @apiSuccess {String} Producto {nombre} creado
     *
     * @apiError {String} Error: {mensaje de error}
     *
     * @apiSampleRequest /productos/create.php
     */
    public function create_producto(mixed $nombre, mixed $imagen, mixed $precio, mixed $precioEsp, mixed $tipo)
    {
        try {
            $stmt = $this->conn->prepare('INSERT INTO productos (nombre, imagen, precio, precioEsp, tipo) VALUES (:nombre, :imagen, :precio, :precioEsp, :tipo)');
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':imagen', $imagen);
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':precioEsp', $precioEsp);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->execute();

            return 'Producto ' . $nombre . ' creado'; // Solo devuelve el mensaje de éxito
        } catch (\PDOException $e) {
            return 'Error: ' . $e->getMessage(); // Solo devuelve el mensaje de error
        }
    }

    /**
     * @api {get} /productos/listar.php Listar productos
     * @apiName listar_producto
     * @apiGroup Productos
     * @apiVersion 0.1.0
     * @apiDescription Lista todos los productos
     *
     * @apiSuccess {String} JSON con los productos
     *
     * @apiError {String} Error: {mensaje de error}
     *
     * @apiSampleRequest /productos/listar.php
     */
    public function listar_producto_todos()
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM productos');
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return json_encode($result);
        } catch (\PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function listar_producto_filtro(mixed $nombre, mixed $tipo)
    {
        // $stmt = $this->conn->prepare('SELECT * FROM productos WHERE nombre LIKE CONCAT(\'%\', :nombre, \'%\') OR tipo LIKE CONCAT(\'%\', :tipo, \'%\')');
        $sql = "SELECT * FROM productos WHERE nombre LIKE CONCAT('%', :nombre, '%') OR tipo LIKE CONCAT('%', :tipo, '%')";
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->execute();
            $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

            return json_encode($result);
        } catch (\PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function delete(mixed $idProducto)
    {
        try {
            $stmt = $this->conn->prepare('UPDATE productos SET activo = 0 WHERE idProducto = :idProducto');
            $stmt->bindParam(':idProducto', $idProducto);
            $stmt->execute();

            return 'Producto eliminado correctamente';
        } catch (\PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function getById(mixed $idProducto)
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM productos WHERE idProducto = :idProducto');
            $stmt->bindParam(':idProducto', $idProducto);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            return json_encode($result);
        } catch (\PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function update_producto(mixed $idProducto, mixed $nombre, string $imagen, mixed $precio, mixed $precioEsp, mixed $tipo)
    {
        $retorno = [
            'header' => 'HTTP/1.1 200 Producto actualizado correctamente',
            'message' => 'Producto ' . $nombre . ' actualizado correctamente'
        ];
        try {
            $query = 'UPDATE productos SET nombre = :nombre, precio = :precio, precioEsp = :precioEsp, tipo = :tipo';
            if ($imagen !== '') {
                $query .= ', imagen = :imagen';
            }
            $query .= ' WHERE idProducto = :idProducto';

            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':idProducto', $idProducto);
            $stmt->bindParam(':nombre', $nombre);
            if ($imagen !== '') {
                $stmt->bindParam(':imagen', $imagen);
            }
            $stmt->bindParam(':precio', $precio);
            $stmt->bindParam(':precioEsp', $precioEsp);
            $stmt->bindParam(':tipo', $tipo);
            $stmt->execute();
        } catch (\PDOException $e) {
            $retorno = [
                'header' => 'HTTP/1.1 401 Error en la consulta',
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
        return $retorno;
    }

}