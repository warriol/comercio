<?php
namespace class;

use http\Header;

class Vendedor extends \Config
{
    private $conn;
    public function __construct()
    {
        parent::__construct();
        $this->conn = parent::getConnection();
    }

    /**
     * @api {post} /vendedores/create.php Crear vendedor
     * @apiName create_vendedor
     * @apiGroup Vendedores
     * @apiVersion 0.1.0
     * @apiDescription Crea un nuevo vendedor
     *
     * @apiBody {String} nombre Nombre del vendedor
     * @apiBody {String} telefono Teléfono del vendedor
     *
     * @apiSuccess {String} header HTTP/1.1 201 Vendedor creado correctamente
     * @apiSuccess {String} message Vendedor {nombre} creado
     *
     * @apiError {String} header HTTP/1.1 401 Error en la consulta
     * @apiError {String} message Error: {mensaje de error}
     *
     * @apiSampleRequest /vendedores/create.php
     */
    public function create_vendedor(mixed $nombre, mixed $telefono)
    {
        $retorno = [
            'header' => 'HTTP/1.1 201 Vendedor creado correctamente',
            'message' => 'Vendedor ' . $nombre . ' creado'
        ];
        try {
            $stmt = $this->conn->prepare('INSERT INTO vendedores (nombre, telefono) VALUES (:nombre, :telefono)');
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':telefono', $telefono);
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
     * @api {get} /vendedores/listar.php Listar vendedores
     * @apiName listar_vendedor
     * @apiGroup Vendedores
     * @apiVersion 0.1.0
     * @apiDescription Lista todos los vendedores o filtra por nombre o teléfono
     *
     * @apiParam {String} [nombre] Nombre del vendedor
     * @apiParam {String} [telefono] Teléfono del vendedor
     *
     * @apiSuccess {String} header HTTP/1.1 200 OK
     * @apiSuccess {String} message Lista de vendedores
     *
     * @apiError {String} header HTTP/1.1 401 Error en la consulta
     * @apiError {String} message Error: {mensaje de error}
     *
     * @apiSampleRequest /vendedores/listar.php
     */
    public function listar_vendedor_todos()
    {
        $stmt = $this->conn->prepare('SELECT * FROM vendedores');
        $stmt->execute();
        $resultados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return json_encode($resultados);
    }

    /**
     * @api {get} /vendedores/listar.php Listar vendedores
     * @apiName listar_vendedor
     * @apiGroup Vendedores
     * @apiVersion 0.1.0
     * @apiDescription Lista todos los vendedores o filtra por nombre o teléfono
     *
     * @apiParam {String} [nombre] Nombre del vendedor
     * @apiParam {String} [telefono] Teléfono del vendedor
     *
     * @apiSuccess {String} header HTTP/1.1 200 OK
     * @apiSuccess {String} message Lista de vendedores
     *
     * @apiError {String} header HTTP/1.1 401 Error en la consulta
     * @apiError {String} message Error: {mensaje de error}
     *
     * @apiSampleRequest /vendedores/listar.php
     */
    public function listar_vendedor_filtro(mixed $nombre, mixed $telefono)
    {
        $stmt = $this->conn->prepare('SELECT * FROM vendedores WHERE nombre = :nombre OR telefono = :telefono');
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->execute();
        $resultados = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return json_encode($resultados);
    }

    public function getById(mixed $idVendedor)
    {
        try {
            $stmt = $this->conn->prepare('SELECT * FROM vendedores WHERE idVendedor = :idVendedor');
            $stmt->bindParam(':idVendedor', $idVendedor);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);
            return json_encode($result);
        } catch (\PDOException $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function update_vendedor(mixed $idVendedor, mixed $nombre, mixed $telefono)
    {
        $retorno = [
            'header' => 'HTTP/1.1 200 Vendedor actualizado correctamente',
            'message' => 'Vendedor actualizado correctamente'
        ];
        try {
            $stmt = $this->conn->prepare('UPDATE vendedores SET nombre = :nombre, telefono = :telefono WHERE idVendedor = :idVendedor');
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':telefono', $telefono);
            $stmt->bindParam(':idVendedor', $idVendedor);
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