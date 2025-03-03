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

# Base de datos: micomercio

``` MYSQL
-- Crear la base de datos
CREATE DATABASE micomercio;
USE micomercio;

-- Tabla Cliente
CREATE TABLE Clientes (
    idCliente INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(255) NOT NULL,
    apellido VARCHAR(255) NOT NULL,
    telefono VARCHAR(20),
    correo VARCHAR(255),
    activo BOOLEAN NOT NULL DEFAULT TRUE
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
    tipo ENUM('por kilo', 'por unidad', 'oferta', 'paquete', '100', 'grande', 'chico', 'mediano', '28cm') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
    precioEsp DECIMAL(10, 2) NOT NULL,
    activo TINYINT(1) NOT NULL DEFAULT '1'
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


ALTER TABLE `clientes` CHANGE `telefono` `telefono` VARCHAR(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;
ALTER TABLE `clientes` CHANGE `apellido` `apellido` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL;  

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `email`, `password`, `nombre`) VALUES
(0, 'warriol@gmail.com', 'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3eab1d80b931dd472634dfac71cd34ebc35d16ab7fb8a90c81f975113d6c7538dc69dd8de9077ec', 'Wilson Denis');
INSERT INTO `vendedores` (`idVendedor`, `nombre`, `telefono`) VALUES
(1, 'Delba Arriola', '098701910');

--
-- Volcado de datos para la tabla `clientes`
--

INSERT INTO `clientes` (`nombre`, `apellido`, `telefono`) VALUES
('Joana', '', '095311256'),
('nicol', '', '093840491'),
('Gabriela', 'garay', '096135310'),
('maria', 'yeyson', '095668268'),
('Luis', '', '095639253'),
('mathias', '', '094521581'),
('vivi', 'juarez', '093913868'),
('melina', '', '92119707'),
('Silvia 3', '', '97300143'),
('vale', '', '94320905'),
('carmencita', 'palacios', '098171505'),
('Rossana', 'guidobono', '092240085'),
('lorena', '', '096922565'),
('valeeria', 'clienta', '097005286'),
('tathiana', '', '094786758'),
('eduarno y vane', '', '099230799'),
('Beatriz', '', '093878605'),
('mercadito', 'charys', '095410547'),
('Andrea', 'p-Alcira', '092365958'),
('Javier', 'almacen', '095186472'),
('Angela', 'pirezz', '095796348'),
('isamel', 'Vicente', '093926374'),
('krishna', '', '092864853'),
('Andrea', 'arzaguet', '091470840'),
('Jessy', '', '094108722'),
('freddy', '', '095635821'),
('Rossana', '', '095498184'),
('siamii', 'alonso', '095852707'),
('Jorge', 'ramirez', '091099028'),
('miriam', 'almacen', '097298685'),
('eli', '', '095031633'),
('jonathan', '', '097951792'),
('caren', 'larrosa', '095086129'),
('carola', '', '099676861'),
('cristina', 'silva', '097518258'),
('maria', 'juan', '097757210'),
('zarza', '', '097553692'),
('julio', 'alvez', '095001040'),
('carol', '', '094801329'),
('estefani', 'vecina', '097977866'),
('andrea', '', '095923396'),
('fabian', 'lopez', '095186113'),
('isabel', 'ramirez', '091248954'),
('noble', 'oronio', '096216404'),
('alcira', '', '096976252'),
('mariloy', '', '091266042'),
('miguel angel', '', '096224733'),
('nancy', '', '096609963'),
('cecilia', '', '092615710'),
('jorge', 'martinez', '099112972'),
('ramon', '', '093762767'),
('nicolas', '', '097873644'),
('Elizabet', '', '095536222'),
('Vicente', '', '095371812'),
('facu', '', '094382055'),
('pablo', '', '095557420'),
('mika', '', '099015025'),
('leo', '', '097226485'),
('sole', '', '097153045'),
('Tatiana', 'bazar', '093730952'),
('Valeria', 'embarazada', '097056133'),
('nati', '', '094722474'),
('erika', 'grosso', '092303927'),
('ana', 'alonso', '096581973'),
('vilma', '', '097575068'),
('camila', '', '097641044'),
('lucia', '', '096238523'),
('gloria', '', '094898576'),
('antonela', '', '092893978'),
('belen', 'flor', '095923944'),
('caro', '', '097356040'),
('Silvia', 'sastre', '091805238'),
('gloria 2', '', '097789677'),
('silvana', '', '092796602'),
('Elizabeth', 'castro', '093774955'),
('katerin', '', '094174917'),
('claudia', 'Vidal', '094031317'),
('genesis y marcelo', '', '096555401'),
('rosa', 'alonso', '094031479'),
('noe', '', '091750604'),
('silvana', 'escobar', '094067915'),
('leonardo', '', '099572796'),
('Juancho', '', '094677191'),
('maja', 'eventos', '095682885'),
('Paty y dani', '', '097307378'),
('Laura', '', '097938203'),
('agus', '', '093772800'),
('veronica', 'etchechury', '096385941'),
('patricia', '', '093497824'),
('iris', 'alvaro', '092158074'),
('iris', 'amiga', '098912607'),
('Andreina', '', '095317557'),
('Alicia', 'silva', '094494129'),
('lusmila', '', '097575025'),
('Karen', '', '097737209'),
('Silvia 2', '', '098421330'),
('daiana', '', '099684013'),
('lauti', 'romero', '094119583'),
('gissel', '', '092259519'),
('ataquefinal2', '', '091474415'),
('agustin', 'oxley', '093451616'),
('juan', 'vecino', '095328276'),
('Javier', '', '094030013'),
('bloquero', '', '099248656'),
('raul', 'sastre', '096114579'),
('tania', '', '096379059'),
('maria Esther', 'ribeiro', '097550610'),
('Fernanda', 'silva', '096145864'),
('Luis', 'frigorifico', '094889753'),
('nadia', 'noble', '099049994'),
('Sharon', 'gerez', '094068821'),
('Carlos', '', '094382569'),
('lu', 'prima de erika', '095826947'),
('braian', '', '095451433'),
('maria', 'escobar y pando', '097700972'),
('lucia', '', '092366230'),
('valentina', '', '092607734'),
('gustavo', '', '096367932'),
('yeyson', 'rodriguez', '094754586'),
('soledad', '', '092103752'),
('juan', 'Carlos', '092221395'),
('Richard', 'acosta', '091885749'),
('maria', 'barrera', '093402927'),
('ailen', 'martinez', '096164246'),
('caro', '', '092854804');
```