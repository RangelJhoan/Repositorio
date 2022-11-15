-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 15-11-2022 a las 03:28:56
-- Versión del servidor: 10.4.22-MariaDB
-- Versión de PHP: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `repositorio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo`
--

CREATE TABLE `archivo` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `tamano` decimal(4,2) NOT NULL,
  `ruta` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `formato` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `id_recurso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_programa`
--

CREATE TABLE `curso_programa` (
  `id` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_recurso`
--

CREATE TABLE `curso_recurso` (
  `id` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_recurso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente_curso`
--

CREATE TABLE `docente_curso` (
  `id` int(11) DEFAULT NULL,
  `id_docente` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiqueta`
--

CREATE TABLE `etiqueta` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(50) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiqueta_recurso`
--

CREATE TABLE `etiqueta_recurso` (
  `id` int(11) NOT NULL,
  `id_etiqueta` int(11) NOT NULL,
  `id_recurso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `tipo_documento` varchar(5) COLLATE utf8_spanish2_ci NOT NULL,
  `documento` varchar(15) COLLATE utf8_spanish2_ci NOT NULL,
  `nombre` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `apellido` varchar(30) COLLATE utf8_spanish2_ci NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa`
--

CREATE TABLE `programa` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntuacion_recurso`
--

CREATE TABLE `puntuacion_recurso` (
  `id` int(11) NOT NULL,
  `tipo_voto` tinyint(1) NOT NULL,
  `id_recurso` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso`
--

CREATE TABLE `recurso` (
  `id` int(11) NOT NULL,
  `titulo` varchar(150) COLLATE utf8_spanish2_ci NOT NULL,
  `autor` varchar(100) COLLATE utf8_spanish2_ci NOT NULL,
  `fecha_publicacion_profesor` timestamp NOT NULL DEFAULT current_timestamp(),
  `fecha_publicacion_recurso` date NOT NULL,
  `resumen` varchar(255) COLLATE utf8_spanish2_ci NOT NULL,
  `puntos_positivos` int(11) NOT NULL,
  `puntos_negativos` int(11) NOT NULL,
  `editorial` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `isbn` varchar(20) COLLATE utf8_spanish2_ci NOT NULL,
  `id_docente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(13) COLLATE utf8_spanish2_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Volcado de datos para la tabla `tipo_usuario`
--

INSERT INTO `tipo_usuario` (`id`, `descripcion`) VALUES
(1, 'Administrador'),
(2, 'Docente'),
(3, 'Estudiante');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `usuario`
--

CREATE TABLE `usuario` (
  `id` int(11) NOT NULL,
  `correo` varchar(60) COLLATE utf8_spanish2_ci NOT NULL,
  `clave` varchar(80) COLLATE utf8_spanish2_ci NOT NULL,
  `estado` tinyint(1) NOT NULL,
  `id_tipo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_spanish2_ci;

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `archivo`
--
ALTER TABLE `archivo`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_archivo_recurso` (`id_recurso`);

--
-- Indices de la tabla `curso`
--
ALTER TABLE `curso`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `curso_programa`
--
ALTER TABLE `curso_programa`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_curso_programa` (`id_curso`),
  ADD KEY `fk_programa_curso` (`id_programa`);

--
-- Indices de la tabla `curso_recurso`
--
ALTER TABLE `curso_recurso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_curso_recurso` (`id_curso`),
  ADD KEY `fk_recurso_curso` (`id_recurso`);

--
-- Indices de la tabla `docente_curso`
--
ALTER TABLE `docente_curso`
  ADD KEY `fk_docente_curso` (`id_docente`),
  ADD KEY `fk_curso_docente` (`id_curso`);

--
-- Indices de la tabla `etiqueta`
--
ALTER TABLE `etiqueta`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `etiqueta_recurso`
--
ALTER TABLE `etiqueta_recurso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_etiqueta_recurso` (`id_etiqueta`),
  ADD KEY `fk_recurso_etiqueta` (`id_recurso`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_persona_usuario` (`id_usuario`);

--
-- Indices de la tabla `programa`
--
ALTER TABLE `programa`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `puntuacion_recurso`
--
ALTER TABLE `puntuacion_recurso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_puntuacion_recurso` (`id_recurso`),
  ADD KEY `fk_puntuacion_estudiante` (`id_estudiante`);

--
-- Indices de la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_recurso_docente` (`id_docente`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_usuario_tipo_usuario` (`id_tipo_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivo`
--
ALTER TABLE `archivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de la tabla `curso_programa`
--
ALTER TABLE `curso_programa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `curso_recurso`
--
ALTER TABLE `curso_recurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `etiqueta`
--
ALTER TABLE `etiqueta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `etiqueta_recurso`
--
ALTER TABLE `etiqueta_recurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `programa`
--
ALTER TABLE `programa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `puntuacion_recurso`
--
ALTER TABLE `puntuacion_recurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `recurso`
--
ALTER TABLE `recurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivo`
--
ALTER TABLE `archivo`
  ADD CONSTRAINT `archivo_ibfk_1` FOREIGN KEY (`id_recurso`) REFERENCES `recurso` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `curso_programa`
--
ALTER TABLE `curso_programa`
  ADD CONSTRAINT `curso_programa_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `curso_programa_ibfk_2` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `curso_recurso`
--
ALTER TABLE `curso_recurso`
  ADD CONSTRAINT `curso_recurso_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `curso_recurso_ibfk_2` FOREIGN KEY (`id_recurso`) REFERENCES `recurso` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `docente_curso`
--
ALTER TABLE `docente_curso`
  ADD CONSTRAINT `docente_curso_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `docente_curso_ibfk_3` FOREIGN KEY (`id_docente`) REFERENCES `persona` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `etiqueta_recurso`
--
ALTER TABLE `etiqueta_recurso`
  ADD CONSTRAINT `etiqueta_recurso_ibfk_1` FOREIGN KEY (`id_recurso`) REFERENCES `recurso` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `etiqueta_recurso_ibfk_2` FOREIGN KEY (`id_etiqueta`) REFERENCES `etiqueta` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `puntuacion_recurso`
--
ALTER TABLE `puntuacion_recurso`
  ADD CONSTRAINT `puntuacion_recurso_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `persona` (`id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `puntuacion_recurso_ibfk_2` FOREIGN KEY (`id_recurso`) REFERENCES `recurso` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD CONSTRAINT `recurso_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `persona` (`id`) ON UPDATE CASCADE;

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id`) ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
