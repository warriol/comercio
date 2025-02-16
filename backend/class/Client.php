<?php
namespace class;

use http\Header;

class Client extends \Config
{
    private $conn;
    public function __construct()
    {
        parent::__construct();
        $this->conn = parent::getConnection();
    }

    /**
     * @api {post} /clientes/create.php Crear cliente
     * @apiName create_cliente
     * @apiGroup Clientes
     * @apiVersion 0.1.0
     * @apiDescription Crea un nuevo cliente
     *
     * @apiBody {String} nombre Nombre del cliente
     * @apiBody {String} apellido Apellido del cliente
     * @apiBody {String} telefono Teléfono del cliente
     * @apiBody {String} correo Correo del cliente
     *
     * @apiSuccess {String} header HTTP/1.1 201 Cliente creado correctamente
     * @apiSuccess {String} message Cliente {nombre} {apellido} creado
     *
     * @apiError {String} header HTTP/1.1 401 Error en la consulta
     * @apiError {String} message Error: {mensaje de error}
     *
     * @apiSampleRequest /clientes/create.php
     */
    public function create_cliente($nombre, $apellido, $telefono, $correo): array
    {
        $retorno = [
            'header' => 'HTTP/1.1 201 Cliente creado correctamente',
            'message' => 'Cliente ' . $nombre . ' ' . $apellido . ' creado'
        ];
        try {
            $stmt = $this->conn->prepare('INSERT INTO clientes (nombre, apellido, telefono, correo) VALUES (:nombre, :apellido, :telefono, :correo)');
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':correo', $correo);
            $stmt->execute();
        } catch (\PDOException $e) {
            $retorno = [
                'header' => 'HTTP/1.1 401 Error en la consulta',
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
        return $retorno;
    }

    /**
     * @api {get} /clientes/listar.php Listar clientes
     * @apiName listar_cliente
     * @apiGroup Clientes
     * @apiVersion 0.1.0
     * @apiDescription Lista los clientes
     *
     * @apiParam {String} [nombre] Nombre del cliente
     * @apiParam {String} [apellido] Apellido del cliente
     * @apiParam {String} [telefono] Teléfono del cliente
     * @apiParam {String} [correo] Correo del cliente
     *
     * @apiSuccess {String} header HTTP/1.1 200 OK
     * @apiSuccess {String} message Listado de clientes
     *
     * @apiError {String} header HTTP/1.1 401 Error en la consulta
     * @apiError {String} message Error: {mensaje de error}
     *
     * @apiSampleRequest /clientes/listar.php
     */
    public function listar_cliente_filtro(mixed $nombre, mixed $apellido, mixed $telefono, mixed $correo)
    {
        parent::debug("nombre", $nombre);
        parent::debug("apellido", $apellido);
        parent::debug("telefono", $telefono);
        parent::debug("correo", $correo);

        $stmt = $this->conn->prepare('SELECT * FROM clientes WHERE nombre LIKE :nombre OR apellido LIKE :apellido OR telefono LIKE :telefono OR correo LIKE :correo');
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':correo', $correo);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return json_encode($result);
    }

    /**
     * @api {get} /clientes/listar.php Listar todos los clientes
     * @apiName listar_cliente_todos
     * @apiGroup Clientes
     * @apiVersion 0.1.0
     * @apiDescription Lista todos los clientes
     *
     * @apiSuccess {String} header HTTP/1.1 200 OK
     * @apiSuccess {String} message Listado de clientes
     *
     * @apiError {String} header HTTP/1.1 401 Error en la consulta
     * @apiError {String} message Error: {mensaje de error}
     *
     * @apiSampleRequest /clientes/listar.php
     */
    public function listar_cliente_todos()
    {
        $stmt = $this->conn->prepare('SELECT * FROM clientes');
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return json_encode($result);
    }

    /**
     * @api {get} /clientes/getById.php Obtener
     * @apiName getById
     * @apiGroup Clientes
     * @apiVersion 0.1.0
     * @apiDescription Obtiene un cliente por su ID
     *
     * @apiParam {Number} idCliente ID del cliente
     *
     * @apiSuccess {String} header HTTP/1.1 200 OK
     * @apiSuccess {String} message Cliente encontrado
     *
     * @apiError {String} header HTTP/1.1 401 Error en la consulta
     * @apiError {String} message Error: {mensaje de error}
     *
     * @apiSampleRequest /clientes/getById.php
     */
    public function getById (mixed $idCliente)
    {
        $stmt = $this->conn->prepare('SELECT * FROM clientes WHERE idCliente = :idCliente');
        $stmt->bindParam(':idCliente', $idCliente);
        $stmt->execute();
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return json_encode($result);
    }

    /**
     * @api {put} /clientes/update.php Actualizar cliente
     * @apiName update_cliente
     * @apiGroup Clientes
     * @apiVersion 0.1.0
     * @apiDescription Actualiza un cliente
     *
     * @apiParam {Number} idCliente ID del cliente
     * @apiBody {String} nombre Nombre del cliente
     * @apiBody {String} apellido Apellido del cliente
     * @apiBody {String} telefono Teléfono del cliente
     * @apiBody {String} correo Correo del cliente
     *
     * @apiSuccess {String} header HTTP/1.1 200 Cliente actualizado correctamente
     * @apiSuccess {String} message Cliente actualizado correctamente
     *
     * @apiError {String} header HTTP/1.1 401 Cliente no actualizado
     * @apiError {String} message Cliente no actualizado
     *
     * @apiSampleRequest /clientes/update.php
     */
    public function update_cliente(mixed $idCliente, mixed $nombre, mixed $apellido, mixed $telefono, mixed $correo)
    {
        $stmt = $this->conn->prepare('UPDATE clientes SET nombre = :nombre, apellido = :apellido, telefono = :telefono, correo = :correo WHERE idCliente = :idCliente');
        $stmt->bindParam(':idCliente', $idCliente);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':apellido', $apellido);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->bindParam(':correo', $correo);
        if ($stmt->execute()) {
            header('HTTP/1.1 200 Cliente actualizado correctamente');
        } else {
            header('HTTP/1.1 401 Cliente no actualizado');
        }
    }

    /**
     * @api {delete} /clientes/delete.php Eliminar cliente
     * @apiName delete_cliente
     * @apiGroup Clientes
     * @apiVersion 0.1.0
     * @apiDescription Elimina un cliente
     *
     * @apiParam {Number} idCliente ID del cliente
     *
     * @apiSuccess {String} header HTTP/1.1 200 Cliente eliminado correctamente
     * @apiSuccess {String} message Cliente eliminado correctamente
     *
     * @apiError {String} header HTTP/1.1 401 Cliente no eliminado
     * @apiError {String} message Cliente no eliminado
     *
     * @apiSampleRequest /clientes/delete.php
     */
    public function delete(mixed $idCliente)
    {
        try {
            $stmt = $this->conn->prepare('UPDATE clientes SET activo = 0 WHERE idCliente = :idCliente');
            $stmt->bindParam(':idCliente', $idCliente);
            $stmt->execute();
            return 'Cliente eliminado correctamente';
        } catch (\PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

}