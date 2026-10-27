<?php

namespace class;

use http\Header;

class User extends \Config
{
    private $conn;
    public function __construct()
    {
        parent::__construct();
        $this->conn = parent::getConnection();
    }

    /**
     * @api {post} /usuarios/login.php Iniciar sesión
     * @apiName login
     * @apiGroup Usuarios
     * @apiVersion 1.0.0
     * @apiDescription Valida las credenciales de un usuario.
     * @apiBody {String} email Correo del usuario.
     * @apiBody {String} password Contraseña del usuario.
     * @apiSuccess {String} message Login successful.
     * @apiSuccess {String} token Token para enviarlo como encabezado Authorization en las demás peticiones.
     * @apiError (400) {String} message Faltan credenciales.
     * @apiError (401) {String} error Credenciales inválidas.
     * @apiSampleRequest /usuarios/login.php
     */
    public function login($email, $password): array
    {
        $retorno = [];
        try {
            $stmt = $this->conn->prepare('SELECT * FROM usuarios WHERE email = :correo AND password = :password');
            $stmt->bindParam(':correo', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            $user = $stmt->fetch();
            if ($user) {
                $retorno = ['error' => false, 'token' => $this->getAuthToken()];
            } else {
                $retorno = ['error' => 'Invalid email or password'];
            }
        } catch (\PDOException $e) {
            $retorno = ['error' => $e->getMessage()];
        }
        return $retorno;
    }

    public function getAuthToken(): string
    {
        return $this->secretKey;
    }
}