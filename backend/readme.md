# VARIABLES GLOBALES

- Se definen en el archivo .env, este archivo no se sube al repositorio, por tanto se dbee crear también en el servidor de producción.

# DESINTALAR NODEJS
```bash
winget uninstall --id OpenJS.NodeJS
winget list | findstr "Node"
winget uninstall --id OpenJS.NodeJS.LTS
```
# Reinstalar la Versión Correcta de Node.js
Ahora puedes descargar e instalar la versión LTS recomendada desde nodejs.org.

# VERIFICAR INSTALACION
```bash
node -v
npm -v
```
# cambiar politicas de ejecucion de powershell
```bash
Set-ExecutionPolicy Unrestricted -Scope CurrentUser -Force
```

# INSTALAR APIdoc
```bash
npm install apidoc -g
```
# GENERAR DOCUMENTACION
Crear archivo apidoc.json en la raiz del proyecto
```json
{
  "name": "Comercio API",
  "version": "1.0.0",
  "description": "Documentación de la API",
  "title": "Documentación de la API",
  "url": "http://localhost/comercio",
  "sampleUrl": false,
  "template": {
    "withCompare": false,
    "withGenerator": false
  },
  "input": "./backend/class",
  "output": "./apidoc"
}

```
```bash
apidoc -i backend -o apidoc
```

# END POINTS
Ver documentación de la API en la ruta /apidoc

# Base de datos

``` MYSQL
-- Tabla Cliente
CREATE TABLE Clientes (
    idCliente INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    correo VARCHAR(255)
);

-- Tabla Vendedor
CREATE TABLE Vendedores (
    idVendedor INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    telefono VARCHAR(20)
);

-- Tabla Producto
CREATE TABLE Productos (
    idProducto INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    imagen VARCHAR(255),
    precio DECIMAL(10, 2) NOT NULL,
    tipo ENUM('por kilo', 'por unidad') NOT NULL
);

-- Tabla Venta
CREATE TABLE Ventas (
    idVenta INT PRIMARY KEY AUTO_INCREMENT,
    idCliente INT NOT NULL,
    idVendedor INT NOT NULL,
    fechaVenta DATE NOT NULL,
    fechaEntrega DATE,
    tipoVenta ENUM('contado', 'credito') NOT NULL,
    comentario VARCHAR(70),
    FOREIGN KEY (idCliente) REFERENCES Clientes(idCliente),
    FOREIGN KEY (idVendedor) REFERENCES Vendedores(idVendedor)
);

-- Tabla DetalleVentas
CREATE TABLE DetalleVentas (
    idDetalleVenta INT PRIMARY KEY AUTO_INCREMENT,
    idVenta INT NOT NULL,
    idProducto INT NOT NULL,
    cantidad DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (idVenta) REFERENCES Ventas(idVenta),
    FOREIGN KEY (idProducto) REFERENCES Productos(idProducto)
);

-- Tabla Pedidos
CREATE TABLE Pedidos (
    idPedido INT PRIMARY KEY AUTO_INCREMENT,
    idCliente INT NOT NULL,
    idVendedor INT NOT NULL,
    fechaRealizado DATE NOT NULL,
    fechaEntrega DATE,
    tipoPedido ENUM('contado', 'credito') NOT NULL,
    comentario VARCHAR(70),
    entregado BOOLEAN NOT NULL DEFAULT FALSE, -- Valor por defecto: no entregado
    FOREIGN KEY (idCliente) REFERENCES Clientes(idCliente),
    FOREIGN KEY (idVendedor) REFERENCES Vendedores(idVendedor)
);

-- Tabla DetallePedidos
CREATE TABLE DetallePedidos (
    idDetallePedido INT PRIMARY KEY AUTO_INCREMENT,
    idPedido INT NOT NULL,
    idProducto INT NOT NULL,
    cantidad DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (idPedido) REFERENCES Pedidos(idPedido),
    FOREIGN KEY (idProducto) REFERENCES Productos(idProducto)
);

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `email` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL COMMENT 'Nombre de usuario para iniciar sesion.',
  `password` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL,
  `nombre` varchar(200) CHARACTER SET utf8 COLLATE utf8_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `nombre`) VALUES
(0, 'warriol@gmail.com', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 'Wilson Denis');


--
-- Actualización de tabla
--

ALTER TABLE `clientes` ADD `activo` BOOLEAN NOT NULL DEFAULT TRUE AFTER `correo`;
ALTER TABLE `productos` CHANGE `tipo` `tipo` ENUM('por kilo','por unidad', 'oferta', 'paquete', '100','grande','chico','mediano','28cm') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE `productos` ADD `precioEsp` DECIMAL(10,2) NOT NULL AFTER `precio`;
ALTER TABLE `productos` ADD `activo` TINYINT(1) NOT NULL DEFAULT '1' AFTER `tipo`;    
```