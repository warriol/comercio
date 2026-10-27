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
     * @apiVersion 1.0.0
     * @apiDescription Crea un nuevo producto
     *
     * @apiBody {String} nombre Nombre del producto
     * @apiBody {File} imagen Imagen del producto
     * @apiBody {Number} precio Precio del producto
     * @apiBody {Number} precioEsp Precio especial del producto
     * @apiBody {String} tipo Tipo del producto
     *
     * @apiSuccess {String} message Producto creado correctamente.
     *
     * @apiError (400) {String} message Faltan campos obligatorios.
     * @apiError (401) {String} message Falta o es inválido el encabezado Authorization.
     *
     * @apiUse AuthHeader
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
     * @apiVersion 1.0.0
     * @apiDescription Lista todos los productos
     *
     * @apiParam {String} [nombre] Filtra por nombre.
     * @apiParam {String} [tipo] Filtra por tipo.
     *
     * @apiSuccess {String} JSON con los productos
     *
     * @apiError {String} Error: {mensaje de error}
     *
     * @apiUse AuthHeader
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

    /**
     * @api {get} /productos/listar.php Filtrar productos
     * @apiName listar_producto_filtro
     * @apiGroup Productos
     * @apiVersion 1.0.0
     * @apiDescription Lista productos que coinciden con nombre o tipo.
     * @apiParam {String} [nombre] Nombre parcial del producto.
     * @apiParam {String} [tipo] Tipo del producto.
     * @apiSuccess {Object[]} productos Productos coincidentes.
     * @apiError (401) {String} message Falta o es inválido el encabezado Authorization.
     * @apiUse AuthHeader
     * @apiSampleRequest /productos/listar.php
     */
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

    /**
     * @api {delete} /productos/delete.php?idProducto=1 Eliminar producto
     * @apiName delete_producto
     * @apiGroup Productos
     * @apiVersion 1.0.0
     * @apiDescription Desactiva un producto.
     * @apiParam (Query) {Number} [idProducto] ID del producto (obligatorio).
     * @apiSuccess {String} message Producto eliminado correctamente.
     * @apiError (401) {String} message Falta o es inválido el encabezado Authorization.
     * @apiUse AuthHeader
     * @apiSampleRequest /productos/delete.php
     */
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

    /**
     * @api {get} /productos/getById.php?idProducto=1 Obtener producto
     * @apiName get_producto
     * @apiGroup Productos
     * @apiVersion 1.0.0
     * @apiDescription Obtiene un producto por su ID.
     * @apiParam (Query) {Number} [idProducto] ID del producto (obligatorio).
     * @apiSuccess {Object} producto Producto encontrado.
     * @apiError (401) {String} message Falta o es inválido el encabezado Authorization.
     * @apiUse AuthHeader
     * @apiSampleRequest /productos/getById.php
     */
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

    /**
     * @api {post} /productos/update.php Actualizar producto
     * @apiName update_producto
     * @apiGroup Productos
     * @apiVersion 1.0.0
     * @apiDescription Actualiza los datos de un producto y opcionalmente su imagen.
     * @apiBody {Number} idProducto ID del producto.
     * @apiBody {String} nombre Nombre del producto.
     * @apiBody {File} [imagen] Nueva imagen del producto.
     * @apiBody {Number} precio Precio del producto.
     * @apiBody {Number} precioEsp Precio especial del producto.
     * @apiBody {String} tipo Tipo del producto.
     * @apiSuccess {String} message Producto actualizado correctamente.
     * @apiError (400) {String} message ID de producto no proporcionado.
     * @apiError (401) {String} message Falta o es inválido el encabezado Authorization.
     * @apiUse AuthHeader
     * @apiSampleRequest /productos/update.php
     */
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
