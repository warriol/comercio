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
        \Debug::log('login.request', [
            'email' => $email,
            'password_length' => is_string($password) ? strlen($password) : null
        ]);
        try {
            $stmt = $this->conn->prepare('SELECT * FROM usuarios WHERE email = :correo AND password = :password');
            $stmt->bindParam(':correo', $email);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            $user = $stmt->fetch();
            \Debug::log('login.sql', ['user' => $user]);
            if ($user) {
                \Debug::log('login.credentials_valid', ['email' => $email]);
                $retorno = [
                    'error' => false,
                    'token' => $this->generarToken([
                        'sub' => (string) $user['id'],
                        'email' => $user['email'],
                        'isAdmin' => (int) $user['isAdmin']
                    ])
                ];
            } else {
                \Debug::log('login.credentials_invalid', ['email' => $email]);
                $retorno = ['error' => 'Invalid email or password'];
            }
        } catch (\PDOException $e) {
            \Debug::exception('login.database_error', $e);
            $retorno = ['error' => $e->getMessage()];
        }
        return $retorno;
    }

    public function listarUsuarios(): array
    {
        $stmt = $this->conn->query('SELECT id, email, nombre, isAdmin FROM usuarios ORDER BY nombre, email');
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function crearUsuario(string $email, string $nombre, string $password, bool $isAdmin): void
    {
        $stmt = $this->conn->prepare(
            'INSERT INTO usuarios (email, password, nombre, isAdmin)
             VALUES (:email, :password, :nombre, :isAdmin)'
        );
        $stmt->execute([
            ':email' => $email,
            ':password' => hash('sha512', $password),
            ':nombre' => $nombre,
            ':isAdmin' => $isAdmin ? 1 : 0
        ]);
    }

    public function actualizarUsuario(int $id, string $email, string $nombre, ?string $password, bool $isAdmin): void
    {
        if ($password !== null && $password !== '') {
            $stmt = $this->conn->prepare(
                'UPDATE usuarios
                 SET email = :email, nombre = :nombre, password = :password, isAdmin = :isAdmin
                 WHERE id = :id'
            );
            $stmt->bindValue(':password', hash('sha512', $password));
        } else {
            $stmt = $this->conn->prepare(
                'UPDATE usuarios
                 SET email = :email, nombre = :nombre, isAdmin = :isAdmin
                 WHERE id = :id'
            );
        }
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':nombre', $nombre);
        $stmt->bindValue(':isAdmin', $isAdmin ? 1 : 0, \PDO::PARAM_INT);
        $stmt->bindValue(':id', $id, \PDO::PARAM_INT);
        $stmt->execute();
    }

}