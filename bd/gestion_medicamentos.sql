-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-09-2025 a las 19:40:56
-- Versión del servidor: 10.4.32-MariaDB
-- Versión de PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `gestion_medicamentos`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `productos`
--

CREATE TABLE `productos` (
  `id` int(11) NOT NULL,
  `codigo` varchar(50) NOT NULL,
  `nombre` varchar(150) NOT NULL,
  `descripcion` text DEFAULT NULL,
  `estado` enum('Activo','Inactivo') NOT NULL DEFAULT 'Activo',
  `laboratorio` varchar(100) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `productos`
--

INSERT INTO `productos` (`id`, `codigo`, `nombre`, `descripcion`, `estado`, `laboratorio`, `fecha_registro`) VALUES
(1, 'P001', 'Paracetamol 500mg', 'Analgésico y antipirético', 'Activo', 'Genfar', '2025-09-15 16:26:30'),
(2, 'P002', 'Ibuprofeno 400mg', 'Antiinflamatorio no esteroideo', 'Activo', 'Tecnoquímicas', '2025-09-15 16:31:09'),
(3, 'P003', 'Amoxicilina 500mg', 'Antibiótico de amplio espectro', 'Activo', 'Pfizer', '2025-09-15 16:32:45'),
(4, 'P004', 'Omeprazol 20mg', 'Inhibidor de la bomba de protones', 'Activo', 'Bayer', '2025-09-15 16:49:10'),
(5, 'P005', 'Loratadina 10mg', 'Antihistamínico', 'Activo', 'MK', '2025-09-15 16:50:23'),
(6, 'P006', 'Metformina 850mg', 'Antidiabético oral', 'Activo', 'Sanofi', '2025-09-15 16:51:25'),
(7, 'P007', 'Enalapril 10mg', 'Antihipertensivo', 'Activo', 'Roche', '2025-09-15 16:52:54'),
(8, 'P008', 'Salbutamol Inhalador', 'Broncodilatador', 'Activo', 'GlaxoSmithKline', '2025-09-15 16:54:02'),
(9, 'P009', 'Diclofenaco 50mg', 'Analgésico y antiinflamatorio', 'Activo', 'Siegfried', '2025-09-15 16:55:07'),
(10, 'P010', 'Atorvastatina 20mg', 'Reductor de colesterol', 'Activo', 'Novartis', '2025-09-15 16:57:09');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `proveedores`
--

CREATE TABLE `proveedores` (
  `id` int(11) NOT NULL,
  `tipo_identificacion` enum('CC','NIT','CE','NIT_EXT') NOT NULL,
  `numero_identificacion` varchar(50) NOT NULL,
  `razon_social` varchar(150) NOT NULL,
  `direccion` varchar(200) NOT NULL,
  `nombre_contacto` varchar(100) NOT NULL,
  `celular` varchar(20) NOT NULL,
  `actividad_economica` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `proveedores`
--

INSERT INTO `proveedores` (`id`, `tipo_identificacion`, `numero_identificacion`, `razon_social`, `direccion`, `nombre_contacto`, `celular`, `actividad_economica`) VALUES
(1, 'NIT', '900123456', 'Droguería Central', 'Cra 10 #20-30', 'Carlos Gómez', '3001234567', '4645'),
(2, 'NIT', '900987654', 'Farmacéutica del Norte', 'Calle 45 #12-15', 'Ana Rodríguez', '3012345678', '4645'),
(3, 'CC', '901234567', 'Medicamentos del Sur', 'Av. Siempre Viva #100', 'Pedro López', '3023456789', '4645'),
(4, 'CE', '901112223', 'Laboratorios Unidos', 'Calle 9 #8-77', 'Laura Martínez', '3034567890', '2100'),
(5, 'NIT_EXT', '902334455', 'Distribuidora Pharma', 'Transversal 25 #40-60', 'Jorge Ramírez', '3045678901', '4645');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recepciones`
--

CREATE TABLE `recepciones` (
  `id` int(11) NOT NULL,
  `fecha_hora` timestamp NOT NULL DEFAULT current_timestamp(),
  `numero_factura` varchar(50) NOT NULL,
  `cantidad` int(11) NOT NULL,
  `lote` varchar(50) NOT NULL,
  `registro_invima` varchar(50) NOT NULL,
  `fecha_vencimiento` date NOT NULL,
  `descripcion_estado_producto` varchar(255) NOT NULL,
  `id_producto` int(11) NOT NULL,
  `id_proveedor` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `recepciones`
--

INSERT INTO `recepciones` (`id`, `fecha_hora`, `numero_factura`, `cantidad`, `lote`, `registro_invima`, `fecha_vencimiento`, `descripcion_estado_producto`, `id_producto`, `id_proveedor`) VALUES
(1, '2025-09-15 17:30:55', 'F001', 50, 'L001', 'INV001', '2026-10-15', 'Buen estado', 1, 1),
(2, '2025-09-15 17:32:09', 'F002', 130, 'L002', 'INV002', '2027-04-22', 'Buen estado', 2, 2),
(3, '2025-09-15 17:33:04', 'F003', 70, 'L003', 'INV003', '2025-12-07', 'Buen estado', 3, 3),
(4, '2025-09-15 17:34:06', 'F004', 250, 'L004', 'INV004', '2028-06-18', 'Buen estado', 4, 4),
(5, '2025-09-15 17:35:11', 'F005', 500, 'L005', 'INV005', '2027-01-01', 'Buen estado', 5, 5),
(6, '2025-09-15 17:36:10', 'F006', 40, 'L006', 'INV006', '2028-05-03', 'Buen estado', 6, 1),
(7, '2025-09-15 17:37:06', 'F007', 325, 'L007', 'INV007', '2026-11-24', 'Buen estado', 7, 2),
(8, '2025-09-15 17:38:04', 'F008', 180, 'L008', 'INV008', '2025-11-17', 'Buen estado', 8, 3),
(9, '2025-09-15 17:39:02', 'F009', 35, 'L009', 'INV009', '2026-02-05', 'Buen estado', 9, 4),
(10, '2025-09-15 17:39:55', 'F010', 456, 'L010', 'INV010', '2029-07-12', 'Buen estado', 10, 5);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `username`, `password_hash`) VALUES
(1, 'admin', '$2y$10$Kw6EuqW/JdIhKDpy1s3nbeT5KCaSgw8zOeKzRKhVLQxLTRZ3G9RsS');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `productos`
--
ALTER TABLE `productos`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `codigo_UNIQUE` (`codigo`);

--
-- Indices de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `numero_identificacion_UNIQUE` (`numero_identificacion`);

--
-- Indices de la tabla `recepciones`
--
ALTER TABLE `recepciones`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_recepcion_producto_idx` (`id_producto`),
  ADD KEY `fk_recepcion_proveedor_idx` (`id_proveedor`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_UNIQUE` (`username`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `productos`
--
ALTER TABLE `productos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `proveedores`
--
ALTER TABLE `proveedores`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `recepciones`
--
ALTER TABLE `recepciones`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `recepciones`
--
ALTER TABLE `recepciones`
  ADD CONSTRAINT `fk_recepcion_producto` FOREIGN KEY (`id_producto`) REFERENCES `productos` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_recepcion_proveedor` FOREIGN KEY (`id_proveedor`) REFERENCES `proveedores` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
