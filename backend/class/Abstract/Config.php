<?php
    abstract class Config {
        protected readonly string $key;
        protected readonly string $secretKey;
        private $debug = true;
        private $DB_Host;
        private $DB_User;
        private $DB_Pass;
        private $DB_Name;
        private $conexion;
        private $rutaEnv = '../.env';

        public function __construct() {
            $this->debug("INICIO", "------------------------------------------------------//////");
            $this->debug("Config", "Constructor de Config");
            $this->key = 'clave_secreta';
            $this->loadEnv();
            $this->dbConnect();
        }

        // Cargar las variables del archivo .env
        private function loadEnv(): void {
            $filePath = $this->rutaEnv;

            $this->debug("Config", "Cargando variables de entorno");

            if (!file_exists($filePath)) {
                throw new Exception(".env no encontrado.");
            }

            $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($lines as $line) {

                if (strpos(trim($line), '#') === 0) {
                    continue;
                }

                list($name, $value) = explode('=', $line, 2);

                $this->setEnvVariable(trim($name), trim($value));
            }
        }

        private function setEnvVariable($name, $value): void {
            switch ($name) {
                case 'DB_HOST':
                    $this->DB_Host = $this->desencriptarTexto($value);
                    break;
                case 'DB_USER':
                    $this->DB_User = $this->desencriptarTexto($value);
                    break;
                case 'DB_PASS':
                    $this->DB_Pass = $this->desencriptarTexto($value);
                    break;
                case 'DB_NAME':
                    $this->DB_Name = $this->desencriptarTexto($value);
                    break;
                case 'SECRET_KEY':
                    $this->secretKey = $this->desencriptarTexto($value);
                    break;
            }
        }
        private function desencriptarTexto($textoEncriptado): string {

            // Decodificar el texto encriptado y el IV en base64
            $datos = base64_decode($textoEncriptado);

            // Extraer el IV del principio del texto
            $iv = substr($datos, 0, openssl_cipher_iv_length('aes-256-cbc'));

            // Extraer el texto encriptado después del IV
            $textoEncriptado = substr($datos, openssl_cipher_iv_length('aes-256-cbc'));

            // Desencriptar el texto
            return openssl_decrypt($textoEncriptado, 'aes-256-cbc', $this->key, 0, $iv);
        }
        private function encriptarTexto($texto): string {
            // Generar un IV (vector de inicialización) aleatorio
            $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));

            // Encriptar el texto
            $textoEncriptado = openssl_encrypt($texto, 'aes-256-cbc', $this->key, 0, $iv);

            // Codificar el IV y el texto encriptado en base64 para que se puedan almacenar y mostrar
            return base64_encode($iv . $textoEncriptado);
        }

        // conectar a la base de datos
        private function dbConnect(): void
        {
            $this->debug("Config", "Conectando a la base de datos");
            try	{
                $this->conexion = new \PDO("mysql:host=".$this->DB_Host.";dbname=".$this->DB_Name."",$this->DB_User,$this->DB_Pass);
                $this->conexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $this->conexion->exec("SET CHARACTER SET utf8");
                $this->debug("Config", "Conexión exitosa a la base de datos");
            } catch (\PDOException $e) {
                $msj = $e->getMessage();
                die("Connection failed: " . $msj);
            }
        }

        public function getConnection() {
            return $this->conexion;
        }

        public function estaAutenticado(): void {
            $headers = apache_request_headers();
            if (!isset($headers['Authorization'])) {
                http_response_code(401);
                echo json_encode(["message" => "Unauthorized"]);
                exit;
            }

            $authToken = $headers['Authorization'];
            $validToken = $this->secretKey;

            if ($authToken !== $validToken) {
                http_response_code(401);
                echo json_encode(["message" => "Unauthorized"]);
                exit;
            }
        }

        // debug
        public function debug($var, $val = '-'): void{
            if ($this->debug) {
                $file = fopen("../debug.log", "a") or die("Error creando archivo");
                $texto = '[' . date("Y-m-d H:i:s") . ']::[' . $var . ']:-> [' . $val . ']';
                fwrite($file, $texto . PHP_EOL) or die("Error escribiendo en el archivo");
                fclose($file);
            }
        }
    }