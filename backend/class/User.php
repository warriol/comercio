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
                $retorno = ['error' => false];
            } else {
                $retorno = ['error' => 'Invalid email or password'];
            }
        } catch (\PDOException $e) {
            $retorno = ['error' => $e->getMessage()];
        }
        return $retorno;
    }
}