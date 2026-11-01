<?php
    abstract class Config {
            /**
             * @apiDefine AuthHeader
             * @apiHeader {String} Authorization Token devuelto por `/usuarios/login.php`.
             */
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
                $this->conexion = new \PDO(
                    "mysql:host=".$this->DB_Host.";dbname=".$this->DB_Name.";connect_timeout=5",
                    $this->DB_User,
                    $this->DB_Pass,
                    [\PDO::ATTR_TIMEOUT => 5]
                );
                $this->conexion->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                $this->conexion->exec("SET CHARACTER SET utf8");
                $this->debug("Config", "Conexión exitosa a la base de datos");
            } catch (\PDOException $e) {
                \Debug::exception('Config.database_error', $e);
                http_response_code(500);
                header('Content-Type: application/json');
                echo json_encode(['error' => 'No se pudo conectar con la base de datos.']);
                exit;
            }
        }

        public function getConnection() {
            return $this->conexion;
        }

        public function estaAutenticado(): array {
            $authToken = $_SERVER['HTTP_AUTHORIZATION']
                ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION']
                ?? $_SERVER['HTTP_X_AUTH_TOKEN']
                ?? $_SERVER['REDIRECT_HTTP_X_AUTH_TOKEN']
                ?? null;
            if ($authToken === null && function_exists('apache_request_headers')) {
                foreach (apache_request_headers() as $name => $value) {
                    if (strcasecmp($name, 'Authorization') === 0 || strcasecmp($name, 'X-Auth-Token') === 0) {
                        $authToken = $value;
                        break;
                    }
                }
            }

            if ($authToken === null) {
                http_response_code(401);
                echo json_encode(["message" => "Unauthorized"]);
                exit;
            }

            if (preg_match('/^Bearer\s+(.+)$/i', $authToken, $matches)) {
                $authToken = $matches[1];
            }

            if (!$this->validarToken($authToken)) {
                http_response_code(401);
                echo json_encode(["message" => "Unauthorized"]);
                exit;
            }

            return $this->obtenerClaims($authToken);
        }

        public function exigirAdministrador(): array
        {
            $claims = $this->estaAutenticado();
            if ((int) ($claims['isAdmin'] ?? 0) !== 1) {
                http_response_code(403);
                echo json_encode(["message" => "Forbidden"]);
                exit;
            }

            return $claims;
        }

        protected function generarToken(array $claims, int $ttl = 3600): string
        {
            $issuedAt = time();
            $header = $this->base64UrlEncode(json_encode([
                'typ' => 'JWT',
                'alg' => 'HS256'
            ], JSON_THROW_ON_ERROR));
            $payload = $this->base64UrlEncode(json_encode(array_merge($claims, [
                'iat' => $issuedAt,
                'exp' => $issuedAt + $ttl
            ]), JSON_THROW_ON_ERROR));
            $unsignedToken = $header . '.' . $payload;
            $signature = hash_hmac('sha256', $unsignedToken, $this->secretKey, true);

            return $unsignedToken . '.' . $this->base64UrlEncode($signature);
        }

        private function validarToken(string $token): bool
        {
            return $this->obtenerClaims($token) !== [];
        }

        private function obtenerClaims(string $token): array
        {
            $parts = explode('.', $token);
            if (count($parts) !== 3) {
                return [];
            }

            [$encodedHeader, $encodedPayload, $encodedSignature] = $parts;
            $headerJson = $this->base64UrlDecode($encodedHeader);
            $payloadJson = $this->base64UrlDecode($encodedPayload);
            $signature = $this->base64UrlDecode($encodedSignature);
            if ($headerJson === false || $payloadJson === false || $signature === false) {
                return [];
            }

            $header = json_decode($headerJson, true);
            $payload = json_decode($payloadJson, true);
            if (!is_array($header) || !is_array($payload)) {
                return [];
            }
            if (($header['typ'] ?? null) !== 'JWT' || ($header['alg'] ?? null) !== 'HS256') {
                return [];
            }
            if (!isset($payload['exp']) || !is_numeric($payload['exp']) || (int) $payload['exp'] < time()) {
                return [];
            }

            $expectedSignature = hash_hmac(
                'sha256',
                $encodedHeader . '.' . $encodedPayload,
                $this->secretKey,
                true
            );

            return hash_equals($expectedSignature, $signature) ? $payload : [];
        }

        private function base64UrlEncode(string $value): string
        {
            return rtrim(strtr(base64_encode($value), '+/', '-_'), '=');
        }

        private function base64UrlDecode(string $value): string|false
        {
            $padding = strlen($value) % 4;
            if ($padding > 0) {
                $value .= str_repeat('=', 4 - $padding);
            }

            return base64_decode(strtr($value, '-_', '+/'), true);
        }

        // debug
        public function debug($var, $val = '-'): void{
            if ($this->debug) {
                \Debug::log((string) $var, $val);
            }
        }
    }