-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 25-11-2024 a las 17:05:02
-- Versión del servidor: 10.4.25-MariaDB
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `pladeco`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `asignaciones`
--

CREATE TABLE `asignaciones` (
  `id_asignacion` int(255) NOT NULL,
  `id_usuario` int(11) NOT NULL,
  `id_iniciativa` int(11) NOT NULL,
  `id_lineamiento` int(11) NOT NULL,
  `fecha_asignacion` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `asignaciones`
--

INSERT INTO `asignaciones` (`id_asignacion`, `id_usuario`, `id_iniciativa`, `id_lineamiento`, `fecha_asignacion`) VALUES
(5, 5, 3, 2, '2024-10-20 19:12:00'),
(6, 5, 3, 2, '2024-10-20 19:15:29'),
(7, 5, 3, 2, '2024-10-20 19:24:47'),
(8, 5, 3, 2, '2024-10-20 19:36:01'),
(9, 5, 3, 2, '2024-10-20 19:37:18'),
(10, 5, 3, 2, '2024-10-20 19:37:58'),
(11, 5, 3, 2, '2024-10-20 19:41:11'),
(12, 5, 3, 2, '2024-10-20 19:41:39'),
(13, 5, 3, 2, '2024-10-20 19:42:56'),
(14, 5, 3, 2, '2024-10-20 20:53:42'),
(15, 5, 3, 2, '2024-10-20 20:54:04'),
(16, 5, 3, 2, '2024-10-20 20:54:17'),
(17, 5, 3, 2, '2024-10-20 20:54:34'),
(18, 5, 3, 2, '2024-10-20 20:54:46'),
(21, 5, 3, 2, '2024-11-06 15:23:47'),
(22, 5, 3, 2, '2024-11-06 15:51:06'),
(24, 5, 3, 2, '2024-11-06 15:56:02'),
(28, 7, 3, 2, '2024-11-13 15:23:59'),
(34, 7, 2, 1, '2024-11-13 18:02:45'),
(39, 7, 2, 1, '2024-11-18 21:24:37'),
(41, 8, 7, 6, '2024-11-21 00:56:21'),
(42, 7, 3, 2, '2024-11-21 10:17:27'),
(43, 7, 3, 2, '2024-11-21 11:42:13'),
(44, 8, 3, 2, '2024-11-21 22:08:10'),
(45, 7, 2, 1, '2024-11-22 17:41:06');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `iniciativas`
--

CREATE TABLE `iniciativas` (
  `id_iniciativa` int(255) NOT NULL,
  `id_lineamiento` int(255) NOT NULL,
  `nombre_iniciativa` varchar(520) DEFAULT NULL,
  `descripcion_iniciativa` varchar(520) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `iniciativas`
--

INSERT INTO `iniciativas` (`id_iniciativa`, `id_lineamiento`, `nombre_iniciativa`, `descripcion_iniciativa`, `fecha_creacion`, `fyh_actualizacion`) VALUES
(2, 1, 'Iniciativa Calle Segura', 'Iniciativa de Calle Segura, donde cuidaremos nuestras calles.', '2024-10-20 16:25:23', '2024-11-20 11:17:14'),
(3, 2, 'Ciudadanía Saludable', 'Plan de Ciudadanía Saludable dentro de la comuna', '2024-10-20 16:56:34', '2024-11-20 11:17:34'),
(7, 6, 'Manuales de Usuario', 'Elaboración de Manuales de usuario', '2024-11-21 00:37:16', NULL);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `lineamiento`
--

CREATE TABLE `lineamiento` (
  `id_lineamiento` int(255) NOT NULL,
  `nombre_lineamiento` varchar(520) DEFAULT NULL,
  `descripcion_lineamiento` varchar(520) DEFAULT NULL,
  `fecha_creacion` datetime DEFAULT NULL,
  `umr` varchar(520) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `lineamiento`
--

INSERT INTO `lineamiento` (`id_lineamiento`, `nombre_lineamiento`, `descripcion_lineamiento`, `fecha_creacion`, `umr`) VALUES
(1, 'Seguridad', 'Lineamiento de Seguridad de la Comuna N°1.', '2024-11-21 04:17:59', 'SECPLA'),
(2, 'Ciudadania', 'Lineamiento de Ciudadanía N°1.', '2024-11-21 04:18:14', 'SECPLA'),
(6, 'Diseño', 'Diseño y Creación de Planos, Manuales, entre otros.', '2024-11-21 04:36:18', 'PRAXIS');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tareas`
--

CREATE TABLE `tareas` (
  `id_tarea` int(255) NOT NULL,
  `id_iniciativa` int(255) NOT NULL,
  `nombre_tarea` varchar(255) NOT NULL,
  `descripcion_tarea` varchar(255) NOT NULL,
  `fecha_inicio` varchar(255) NOT NULL,
  `fecha_fin` varchar(255) NOT NULL,
  `estado_tarea` varchar(255) NOT NULL,
  `id_asignacion` int(255) NOT NULL,
  `costo` int(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `tareas`
--

INSERT INTO `tareas` (`id_tarea`, `id_iniciativa`, `nombre_tarea`, `descripcion_tarea`, `fecha_inicio`, `fecha_fin`, `estado_tarea`, `id_asignacion`, `costo`) VALUES
(10, 3, 'Entrega de Planos', 'Adjuntar planos para sección Numero 3.1.2 de el PLADECO.', '2024-11-18', '2024-12-09', 'pendiente', 28, 12),
(21, 2, 'Tarea de Seguridad Calle Segura', 'La tarea consiste en la creación del plan de seguridad de la comuna en las áreas número 1 y 5. Se deberán entregar como medio de verificación el PDF e imágenes de los mapas marcados.', '2024-11-04', '2024-12-30', 'pendiente', 39, 300000),
(23, 7, 'sdaas', 'asddsa', '2024-11-21 00:56:00', '2024-11-30 00:56:00', 'pendiente', 41, 1),
(24, 3, 'Tarea de Prueba', 'Descripcion de la Prueba', '2024-11-11 10:17:00', '2024-11-25 10:17:00', 'pendiente', 42, 20000),
(25, 3, '12', '3121', '2024-11-11 11:42:00', '2003-02-23 21:23:00', 'pendiente', 43, 1),
(26, 3, 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2024-11-19 22:07:00', '2024-11-18 22:08:00', 'pendiente', 44, 1),
(27, 2, 'Tarea', 'Descripcion', '2024-11-04 17:40:00', '2024-11-18 17:40:00', 'pendiente', 45, 20000),
(28, 2, 'Tarea 2', 'Tarea 2 Descripcion', '2024-11-18 17:40:00', '2024-11-25 17:40:00', 'pendiente', 45, 1000);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuarios`
--

CREATE TABLE `usuarios` (
  `id` int(255) NOT NULL,
  `nombre` varchar(512) DEFAULT NULL,
  `apellido` varchar(512) DEFAULT NULL,
  `email` varchar(512) DEFAULT NULL,
  `password` varchar(512) DEFAULT NULL,
  `token` varchar(512) DEFAULT NULL,
  `cargo` varchar(512) DEFAULT NULL,
  `cargo_pladeco` varchar(512) DEFAULT NULL,
  `departamento` varchar(512) DEFAULT NULL,
  `user_creacion` varchar(512) DEFAULT NULL,
  `user_actualizacion` varchar(512) DEFAULT NULL,
  `user_eliminacion` varchar(512) DEFAULT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `fyh_eliminacion` datetime DEFAULT NULL,
  `estado` varchar(512) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuarios`
--

INSERT INTO `usuarios` (`id`, `nombre`, `apellido`, `email`, `password`, `token`, `cargo`, `cargo_pladeco`, `departamento`, `user_creacion`, `user_actualizacion`, `user_eliminacion`, `fyh_creacion`, `fyh_actualizacion`, `fyh_eliminacion`, `estado`) VALUES
(1, 'admin', 'admin', 'admin@admin.cl', '123', NULL, 'ADMINISTRADOR', 'admin', 'Admin', NULL, NULL, NULL, NULL, '2024-10-20 10:12:08', NULL, '1'),
(2, 'Antonia ', 'Galaz', 'antonia@ad.cl', '123', NULL, 'ADMINISTRADOR', 'Admin', 'Informatica', NULL, NULL, NULL, '2024-08-30 09:05:34', '2024-10-20 10:12:16', '2024-10-20 10:14:08', '0'),
(3, 'aa', 'aa', '123@gmail.com', '123', NULL, 'ADMINISTRADOR', 'aa', 'aa', NULL, NULL, NULL, '2024-10-20 10:14:45', NULL, '2024-10-20 10:14:52', '0'),
(5, 'usuario', 'usuario', 'usuario@admin.cl', '123', NULL, 'Usuario', 'usuario', '1', NULL, NULL, NULL, '2024-10-20 10:37:49', NULL, NULL, '2'),
(7, 'Antonia', 'Galaz', 'agalazleon@gmail.com', '123', NULL, 'Usuario', 'Desarollador', 'PRAXIS', NULL, NULL, NULL, '2024-11-13 02:17:25', '2024-11-20 11:34:38', NULL, '2'),
(8, 'Sebastián', 'Escanilla', 'c32169as@gmail.com', '123', NULL, 'Usuario', 'Diseñador Gráfico', 'PRAXIS', NULL, NULL, NULL, '2024-11-20 11:34:17', NULL, NULL, '2');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuariostareas`
--

CREATE TABLE `usuariostareas` (
  `id` int(255) NOT NULL,
  `email` varchar(512) DEFAULT NULL,
  `estado_tarea` varchar(512) DEFAULT NULL,
  `cargo` varchar(512) DEFAULT NULL,
  `nombre` varchar(512) DEFAULT NULL,
  `apellido` varchar(512) DEFAULT NULL,
  `user_creacion` varchar(512) DEFAULT NULL,
  `user_actualizacion` varchar(512) DEFAULT NULL,
  `user_eliminacion` varchar(512) DEFAULT NULL,
  `fyh_creacion` datetime DEFAULT NULL,
  `fyh_actualizacion` datetime DEFAULT NULL,
  `fyh_eliminacion` datetime DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `usuariostareas`
--

INSERT INTO `usuariostareas` (`id`, `email`, `estado_tarea`, `cargo`, `nombre`, `apellido`, `user_creacion`, `user_actualizacion`, `user_eliminacion`, `fyh_creacion`, `fyh_actualizacion`, `fyh_eliminacion`, `estado`) VALUES
(1, 'antonia@ad.cl', 'SIN TAREAS', 'ADMINISTRADOR', 'Antonia  Galaz ', NULL, NULL, NULL, NULL, '2024-08-30 09:05:34', NULL, NULL, '1'),
(2, '123@gmail.com', 'SIN TAREAS', 'ADMINISTRADOR', 'aa aa ', NULL, NULL, NULL, NULL, '2024-10-20 10:14:45', NULL, NULL, '1'),
(3, '123123@gmail.com', 'SIN TAREAS', 'ADMINISTRADOR', '1323 3123 ', NULL, NULL, NULL, NULL, '2024-10-20 10:17:23', NULL, NULL, '1'),
(4, 'usuario@admin.cl', 'SIN TAREAS', 'Usuario', 'usuario usuario ', NULL, NULL, NULL, NULL, '2024-10-20 10:37:49', NULL, NULL, '2'),
(5, 'nuevousuario@admin.cl', 'SIN TAREAS', 'Usuario', 'usuarionuevo 12 ', NULL, NULL, NULL, NULL, '2024-10-20 10:58:25', NULL, NULL, '2'),
(6, 'agalazleon@gmail.com', 'SIN TAREAS', 'Usuario', 'Antonia Galaz ', NULL, NULL, NULL, NULL, '2024-11-13 02:17:25', NULL, NULL, '2'),
(7, 'c32169as@gmail.com', 'SIN TAREAS', 'Usuario', 'Sebastián Escanilla ', NULL, NULL, NULL, NULL, '2024-11-20 11:34:17', NULL, NULL, '2'),
(8, '123@admin.cl', 'SIN TAREAS', 'ADMINISTRADOR', 'aaaaaaaaaaaaaaaaaaaaaaaaaaa aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa ', NULL, NULL, NULL, NULL, '2024-11-21 09:17:50', NULL, NULL, '1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `verificacion_tareas`
--

CREATE TABLE `verificacion_tareas` (
  `id_verificacion` int(11) NOT NULL,
  `id_tarea` int(11) DEFAULT NULL,
  `medio_verificacion` varchar(255) DEFAULT NULL,
  `fecha_verificacion` datetime DEFAULT NULL,
  `verificado` enum('SI','NO') DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `comentarios_usuario` text DEFAULT NULL,
  `comentarios_admin` text DEFAULT NULL,
  `estado_respuesta` enum('SIN_RESPUESTA','RESPONDIDO') DEFAULT 'SIN_RESPUESTA'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Volcado de datos para la tabla `verificacion_tareas`
--

INSERT INTO `verificacion_tareas` (`id_verificacion`, `id_tarea`, `medio_verificacion`, `fecha_verificacion`, `verificado`, `id_usuario`, `comentarios_usuario`, `comentarios_admin`, `estado_respuesta`) VALUES
(12, 10, '../../uploads/verificaciones/verificacion_10.zip', '2024-11-13 15:24:47', 'SI', 7, '4 archivos probanmdo zip', 'verificado', 'SIN_RESPUESTA'),
(16, 24, '../../uploads/verificaciones/verificacion_24.zip', '2024-11-21 11:41:40', 'SI', 7, 'Envío de verificacion', '', 'SIN_RESPUESTA'),
(18, 25, '../../uploads/verificaciones/_manualdeadministrador (1).pdf', '2024-11-21 11:43:32', 'SI', 7, 'fsdf', '', 'SIN_RESPUESTA'),
(19, 26, '../../uploads/verificaciones/2.0 Documento de Épicas e Historias de Usuario.docx', '2024-11-21 22:24:57', 'SI', 8, 'asd', '', 'SIN_RESPUESTA'),
(20, 23, '../../uploads/verificaciones/2.0 Documento de Épicas e Historias de Usuario.docx', '2024-11-22 17:41:50', 'SI', 8, '', 'Estás verificado', 'SIN_RESPUESTA'),
(21, 21, '', '2024-11-22 17:43:31', 'NO', 7, 'Envío mi tarea nuevamente a modificar ', 'Revisa nuevamente', 'RESPONDIDO'),
(22, 21, '../../uploads/verificaciones/manualdeusuario (2).pdf', '2024-11-22 17:55:48', NULL, 7, 'Envio mi tarea', NULL, 'RESPONDIDO');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD PRIMARY KEY (`id_asignacion`),
  ADD KEY `fk_asignaciones_usuarios` (`id_usuario`),
  ADD KEY `fk_asignaciones_iniciativas` (`id_iniciativa`),
  ADD KEY `fk_asignaciones_lineamiento` (`id_lineamiento`);

--
-- Indices de la tabla `iniciativas`
--
ALTER TABLE `iniciativas`
  ADD PRIMARY KEY (`id_iniciativa`),
  ADD KEY `fk_iniciativas_lineamiento` (`id_lineamiento`);

--
-- Indices de la tabla `lineamiento`
--
ALTER TABLE `lineamiento`
  ADD PRIMARY KEY (`id_lineamiento`);

--
-- Indices de la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD PRIMARY KEY (`id_tarea`),
  ADD KEY `id_tarea` (`id_tarea`),
  ADD KEY `fk_tareas_iniciativas` (`id_iniciativa`),
  ADD KEY `fk_asignacion` (`id_asignacion`);

--
-- Indices de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuariostareas`
--
ALTER TABLE `usuariostareas`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `verificacion_tareas`
--
ALTER TABLE `verificacion_tareas`
  ADD PRIMARY KEY (`id_verificacion`),
  ADD KEY `fk_id_usuario` (`id_usuario`),
  ADD KEY `verificacion_tareas_ibfk_1` (`id_tarea`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  MODIFY `id_asignacion` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT de la tabla `iniciativas`
--
ALTER TABLE `iniciativas`
  MODIFY `id_iniciativa` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `lineamiento`
--
ALTER TABLE `lineamiento`
  MODIFY `id_lineamiento` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT de la tabla `tareas`
--
ALTER TABLE `tareas`
  MODIFY `id_tarea` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `usuarios`
--
ALTER TABLE `usuarios`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `usuariostareas`
--
ALTER TABLE `usuariostareas`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT de la tabla `verificacion_tareas`
--
ALTER TABLE `verificacion_tareas`
  MODIFY `id_verificacion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `asignaciones`
--
ALTER TABLE `asignaciones`
  ADD CONSTRAINT `fk_asignaciones_iniciativas` FOREIGN KEY (`id_iniciativa`) REFERENCES `iniciativas` (`id_iniciativa`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_asignaciones_lineamiento` FOREIGN KEY (`id_lineamiento`) REFERENCES `lineamiento` (`id_lineamiento`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_asignaciones_usuarios` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `iniciativas`
--
ALTER TABLE `iniciativas`
  ADD CONSTRAINT `fk_iniciativas_lineamiento` FOREIGN KEY (`id_lineamiento`) REFERENCES `lineamiento` (`id_lineamiento`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `tareas`
--
ALTER TABLE `tareas`
  ADD CONSTRAINT `fk_asignacion` FOREIGN KEY (`id_asignacion`) REFERENCES `asignaciones` (`id_asignacion`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_tareas_iniciativas` FOREIGN KEY (`id_iniciativa`) REFERENCES `iniciativas` (`id_iniciativa`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `verificacion_tareas`
--
ALTER TABLE `verificacion_tareas`
  ADD CONSTRAINT `fk_id_usuario` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id`),
  ADD CONSTRAINT `verificacion_tareas_ibfk_1` FOREIGN KEY (`id_tarea`) REFERENCES `tareas` (`id_tarea`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
