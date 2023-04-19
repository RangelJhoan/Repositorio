-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 19-04-2023 a las 09:01:30
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
-- Base de datos: `bd_repositorio`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `archivo`
--

CREATE TABLE `archivo` (
  `id` int(11) NOT NULL,
  `ruta` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  `tamano` bigint(20) NOT NULL,
  `nombre` varchar(150) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_recurso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `archivo`
--

INSERT INTO `archivo` (`id`, `ruta`, `tamano`, `nombre`, `estado`, `fecha_creacion`, `id_recurso`) VALUES
(1, 'recursos/1098801212/16042023151719_LisAriana_1996_herramientadidactica.pdf', 74750, 'LisAriana_1996_herramientadidactica.pdf', 1, '2023-04-16 20:17:19', 3),
(2, 'recursos/1098801212/16042023152034_LineamientosCreacionVPNRedPrivadaVirtual.pdf', 2779970, 'LineamientosCreacionVPNRedPrivadaVirtual.pdf', 1, '2023-04-16 20:20:34', 4),
(3, 'recursos/1098801999/16042023152517_SistemaOperativoLinuxControlTraficoRedes.pdf', 4966446, 'SistemaOperativoLinuxControlTraficoRedes.pdf', 1, '2023-04-16 20:25:17', 5),
(4, 'recursos/1098801999/16042023162625_cliente-servidor-architecture.png', 114337, 'cliente-servidor-architecture.png', 1, '2023-04-16 21:26:25', 9),
(5, 'recursos/1005777644/16042023165146_Cuanto COBRA un ingeniero INFORMATICO _ El podcast de DUO.mp4', 11939510, 'Cuanto COBRA un ingeniero INFORMATICO _ El podcast de DUO.mp4', 1, '2023-04-16 21:51:46', 10),
(6, 'recursos/1005777644/16042023165757_SISTEMA DE ARCHIVOS DISTRIBUIDOS.pdf', 4702009, 'SISTEMA DE ARCHIVOS DISTRIBUIDOS.pdf', 1, '2023-04-16 21:57:57', 12),
(7, 'recursos/1005777644/16042023170806_WPOSS-main.zip', 14360, 'WPOSS-main.zip', 1, '2023-04-16 22:08:06', 13),
(8, 'recursos/1098801999/16042023175452_Modelo Relacional.drawio', 15322, 'Modelo Relacional.drawio', 1, '2023-04-16 22:54:52', 14),
(9, 'recursos/1098801999/16042023175851_TorresJuan_2022_AutomatizacionRedScripts.pdf', 479198, 'TorresJuan_2022_AutomatizacionRedScripts.pdf', 1, '2023-04-16 22:58:51', 15),
(10, 'recursos/1005777644/18042023132751_DiazJuan_2022_ImplementacionSistemaWeb.pdf', 3860523, 'DiazJuan_2022_ImplementacionSistemaWeb.pdf', 1, '2023-04-18 18:27:51', 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autor`
--

CREATE TABLE `autor` (
  `id` int(11) NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellido` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_docente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `autor`
--

INSERT INTO `autor` (`id`, `nombre`, `apellido`, `estado`, `fecha_creacion`, `id_docente`) VALUES
(1, 'Carlos Josefo', 'Villabuena', 1, '2023-04-16 17:36:43', 6),
(2, 'Christian', 'Alvarez', 1, '2023-04-16 17:42:59', 6),
(3, 'James', 'Gosling', 1, '2023-04-16 17:47:44', 6),
(4, 'Grady', 'Booch', 1, '2023-04-16 17:47:54', 6),
(5, 'Kent', 'Beck', 1, '2023-04-16 17:48:04', 6),
(6, 'Bjarne', 'Stroustrup', 1, '2023-04-16 17:48:13', 6),
(7, 'Robert', 'Sedgewick', 1, '2023-04-16 17:48:28', 6),
(8, 'Douglas', 'Crockford', 1, '2023-04-16 17:48:37', 6),
(9, 'Andrew', 'Tanenbaum', 1, '2023-04-16 17:48:54', 6),
(10, 'Robert', 'Martin', 1, '2023-04-16 17:49:07', 6),
(11, 'Michael', 'Eckel', 1, '2023-04-16 17:49:24', 6),
(12, 'Juan Alberto', 'Diaz', 1, '2023-04-16 19:34:39', 9),
(13, 'Camilo Andres', 'Mora', 1, '2023-04-16 19:34:55', 9),
(14, 'Ariana', 'Lopez', 1, '2023-04-16 19:35:05', 9),
(15, 'Vianney', 'Villarreal', 1, '2023-04-16 19:47:22', 2),
(16, 'Lis Katherine', 'Rodriguez Carrillo', 1, '2023-04-16 19:47:38', 2),
(17, 'Fabián', 'Rodríguez', 1, '2023-04-16 19:47:49', 2),
(18, 'Jose', 'Pérez González', 1, '2023-04-16 19:48:06', 2),
(19, 'Juan David', 'Torres García', 1, '2023-04-16 19:48:18', 2),
(20, 'Isabel', 'Hernández García', 1, '2023-04-16 19:48:29', 2),
(21, 'Maria', 'López Castañeda', 1, '2023-04-16 19:48:42', 2),
(22, 'Janeth', 'Silva Pinzón', 1, '2023-04-16 19:48:50', 2),
(23, 'Jose de Jesús', 'Valencia Rivero', 1, '2023-04-16 19:48:59', 2),
(24, 'Alejandra', 'Aceros Calderón', 1, '2023-04-16 19:49:08', 2),
(25, 'Will', 'Smith', 1, '2023-04-16 19:49:15', 2),
(26, 'Blanca Nubia', 'Calderón Delgado', 1, '2023-04-16 19:49:37', 2),
(27, 'Paula', 'Morono Ruiz', 1, '2023-04-16 19:49:53', 2),
(28, 'Diego', 'Hernandez Manrique', 1, '2023-04-16 19:50:02', 2),
(29, 'Plataforma', 'Platzi', 1, '2023-04-16 20:39:52', 6),
(30, 'Plataforma', 'CodigoFacilito', 1, '2023-04-16 20:40:02', 6),
(31, 'Plataforma', 'Udemy', 1, '2023-04-16 20:40:09', 6),
(32, 'Youtube Channel', 'El podcast de DUO', 3, '2023-04-18 16:17:58', 9),
(33, 'Juan Camilo', 'Valencia Silva', 1, '2023-04-16 21:58:09', 9),
(34, 'Laura Juliana', 'Lozano Calderón', 1, '2023-04-16 22:52:55', 6),
(35, 'Jorge', 'Muñoz Gama', 1, '2023-04-16 23:06:23', 6),
(36, 'Mar', 'Pérez Sanagustín', 1, '2023-04-16 23:06:33', 6),
(37, 'Cristian', 'Ruiz', 1, '2023-04-16 23:06:39', 6),
(38, 'Valeria', 'Herskovic', 1, '2023-04-16 23:06:48', 6),
(39, 'Alexander', 'Beltrán Acosta', 1, '2023-04-17 15:36:32', 9),
(40, 'Youtube Channel', 'SoyDalto', 1, '2023-04-17 15:39:43', 9),
(41, 'Yina Paola', 'Lozano Calderón', 3, '2023-04-18 16:01:04', 9),
(42, 'dacjkhbadj', 'sdkjvbdajv', 3, '2023-04-18 15:40:34', 9),
(43, 'sdvdsvds', 'sacas', 3, '2023-04-18 15:35:35', 9),
(44, 'sdvsdvsdvsdvd', 'efwefewvwevwsvw', 3, '2023-04-18 15:35:39', 9),
(45, 'gINANAQEHQ', 'HJWKNWJKE', 3, '2023-04-18 15:43:47', 9),
(46, 'wfewfwe', 'wefwefewfewfwe', 3, '2023-04-18 15:38:21', 9),
(47, 'wefwefewfwec', 'dscdcd', 3, '2023-04-18 15:38:16', 9),
(48, 'Yina Paola', 'Lozano Calderón', 3, '2023-04-18 16:17:02', 9),
(49, 'Gabriel', 'García Márquez', 1, '2023-04-18 16:39:17', 2),
(50, 'Pablo', 'Neruda', 1, '2023-04-18 18:25:43', 2),
(51, 'kfhuifew', 'dsvsdvdsv', 3, '2023-04-18 19:58:47', 9),
(52, 'Carlos Alberto', 'Rodríguez', 1, '2023-04-18 22:26:33', 6),
(53, 'Juan', 'Kimberly', 1, '2023-04-18 22:26:44', 6);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `autor_recurso`
--

CREATE TABLE `autor_recurso` (
  `id` int(11) NOT NULL,
  `id_autor` int(11) NOT NULL,
  `id_recurso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `autor_recurso`
--

INSERT INTO `autor_recurso` (`id`, `id_autor`, `id_recurso`) VALUES
(1, 24, 1),
(2, 14, 2),
(3, 26, 2),
(4, 14, 3),
(5, 16, 3),
(6, 22, 4),
(7, 5, 4),
(8, 14, 5),
(9, 2, 5),
(10, 17, 5),
(11, 12, 5),
(12, 21, 5),
(13, 30, 6),
(14, 29, 7),
(15, 2, 8),
(16, 15, 8),
(18, 29, 11),
(19, 32, 10),
(21, 33, 12),
(22, 33, 13),
(23, 33, 14),
(24, 19, 15),
(25, 37, 16),
(26, 35, 16),
(27, 36, 16),
(28, 38, 16),
(29, 29, 17),
(31, 40, 18),
(32, 40, 19),
(33, 40, 20),
(34, 40, 22),
(35, 40, 23),
(36, 40, 21),
(37, 12, 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso`
--

CREATE TABLE `curso` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `curso`
--

INSERT INTO `curso` (`id`, `nombre`, `descripcion`, `estado`, `fecha_creacion`) VALUES
(1, 'Minería de Datos', 'Descripción del programa de Minería de Datos...', 1, '2023-04-16 17:35:42'),
(2, 'Ingeniería de Software', 'Descripción...', 1, '2023-04-16 19:30:25'),
(3, 'Matemáticas I', 'Descripción curso matemáticas I', 1, '2023-04-16 20:04:11'),
(4, 'Redes I', 'Descripción Redes I', 1, '2023-04-16 20:04:36'),
(5, 'Electiva Profesional V', 'Descripción electiva', 1, '2023-04-16 20:05:01'),
(6, 'Sistemas Operativos', 'Descripción SO', 1, '2023-04-16 21:05:32'),
(7, 'Desarrollo Web', 'Curso desarrollo', 1, '2023-04-16 21:05:49'),
(8, 'Telemática I', 'Descripción de telematica', 1, '2023-04-16 22:51:49'),
(9, 'Bases de Datos', 'Descripción curso bases de datos', 1, '2023-04-17 15:40:17');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_programa`
--

CREATE TABLE `curso_programa` (
  `id` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_programa` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `curso_programa`
--

INSERT INTO `curso_programa` (`id`, `id_curso`, `id_programa`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 3, 1),
(4, 4, 1),
(5, 5, 1),
(6, 6, 1),
(7, 7, 1),
(8, 8, 1),
(9, 9, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `curso_recurso`
--

CREATE TABLE `curso_recurso` (
  `id` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL,
  `id_recurso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `curso_recurso`
--

INSERT INTO `curso_recurso` (`id`, `id_curso`, `id_recurso`) VALUES
(1, 2, 1),
(2, 6, 2),
(3, 1, 3),
(4, 4, 4),
(5, 4, 5),
(6, 6, 5),
(7, 6, 6),
(8, 5, 7),
(10, 7, 8),
(11, 2, 9),
(12, 4, 9),
(13, 6, 9),
(14, 7, 10),
(15, 5, 10),
(16, 2, 10),
(17, 1, 10),
(18, 4, 10),
(19, 6, 10),
(20, 5, 11),
(21, 7, 12),
(22, 7, 13),
(23, 1, 14),
(24, 4, 15),
(25, 6, 15),
(26, 8, 15),
(27, 7, 16),
(28, 1, 17),
(29, 1, 18),
(30, 7, 19),
(31, 2, 19),
(32, 7, 20),
(33, 7, 21),
(34, 7, 22),
(35, 7, 23),
(36, 7, 24),
(37, 9, 24),
(38, 5, 24),
(39, 2, 24),
(43, 9, 27);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `docente_curso`
--

CREATE TABLE `docente_curso` (
  `id` int(11) NOT NULL,
  `id_docente` int(11) NOT NULL,
  `id_curso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `docente_curso`
--

INSERT INTO `docente_curso` (`id`, `id_docente`, `id_curso`) VALUES
(1, 6, 1),
(2, 6, 2),
(3, 9, 3),
(4, 6, 4),
(5, 9, 4),
(6, 2, 5),
(7, 6, 5),
(8, 2, 6),
(9, 9, 6),
(10, 2, 7),
(11, 6, 7),
(12, 9, 7),
(13, 9, 8),
(14, 2, 9),
(15, 9, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiqueta`
--

CREATE TABLE `etiqueta` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(60) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_docente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `etiqueta`
--

INSERT INTO `etiqueta` (`id`, `descripcion`, `estado`, `fecha_creacion`, `id_docente`) VALUES
(1, 'SQL', 1, '2023-04-16 17:36:52', 6),
(2, 'Programación orientada a objetos (POO)', 1, '2023-04-16 17:51:03', 6),
(3, 'PHP', 1, '2023-04-16 17:51:08', 6),
(4, 'C++', 1, '2023-04-16 17:51:14', 6),
(5, 'Java', 1, '2023-04-16 17:51:19', 6),
(6, 'Python', 1, '2023-04-16 17:51:24', 6),
(7, 'Desarrollo de software', 1, '2023-04-16 17:51:33', 6),
(8, 'Arquitectura de software', 1, '2023-04-16 17:51:41', 6),
(9, 'Cisco', 1, '2023-04-16 17:51:46', 6),
(10, 'Oracle', 1, '2023-04-16 17:51:50', 6),
(11, 'PHPMyAdmin', 1, '2023-04-16 17:51:58', 6),
(12, 'XAMPP', 1, '2023-04-16 17:52:02', 6),
(13, 'MySQL', 1, '2023-04-16 17:52:07', 6),
(14, 'Redes de computadoras', 1, '2023-04-16 17:52:15', 6),
(15, 'Sistemas operativos', 1, '2023-04-16 17:52:22', 6),
(16, 'Bases de datos', 1, '2023-04-16 17:52:28', 6),
(17, 'Análisis y diseño de sistemas', 1, '2023-04-16 17:52:36', 6),
(18, 'Programación Web', 1, '2023-04-16 17:52:43', 6),
(19, 'HTML', 1, '2023-04-18 17:54:21', 9),
(23, 'JavaScript', 1, '2023-04-16 19:40:24', 9),
(24, 'Inteligencia Artificial', 1, '2023-04-16 19:40:32', 9),
(25, 'IA', 1, '2023-04-16 19:40:36', 9),
(26, 'Sistemas operativos distribuidos', 1, '2023-04-16 19:40:44', 9),
(27, 'Data Warehouse', 1, '2023-04-16 19:40:50', 9),
(28, 'Big data', 1, '2023-04-16 19:40:54', 9),
(29, 'Internet de las cosas (IoT)', 1, '2023-04-16 19:41:37', 2),
(30, 'Seguridad informática', 1, '2023-04-16 19:41:45', 2),
(31, 'CSS', 1, '2023-04-16 21:06:01', 2),
(32, 'Virtualización', 1, '2023-04-16 19:41:59', 2),
(33, 'Cloud Computing', 1, '2023-04-16 19:42:07', 2),
(34, 'Tecnologías de la información (TI)', 1, '2023-04-16 19:42:13', 2),
(35, 'ITIL', 1, '2023-04-16 19:42:17', 2),
(36, 'Transofrmación digital', 1, '2023-04-16 19:42:24', 2),
(37, 'Algoritmos', 1, '2023-04-16 19:42:30', 2),
(38, 'Análisis numérico', 1, '2023-04-16 19:42:39', 2),
(39, 'Typescript', 1, '2023-04-16 19:42:50', 2),
(40, 'Criptografía', 1, '2023-04-16 21:06:24', 9),
(42, 'Modelado web', 1, '2023-04-16 21:10:27', 6),
(43, 'Seguridad de datos', 1, '2023-04-16 21:10:44', 6),
(44, 'VPN', 1, '2023-04-16 21:27:53', 9),
(45, 'Red LAN', 1, '2023-04-16 21:27:58', 9),
(46, 'VLAN', 1, '2023-04-16 21:28:02', 9),
(47, 'TCP/IP', 1, '2023-04-16 21:28:10', 9),
(48, 'Wireframe', 1, '2023-04-16 21:28:17', 9),
(49, 'NoSQL', 1, '2023-04-17 15:37:03', 9),
(50, 'Youtube', 1, '2023-04-17 15:37:12', 9),
(51, 'Desarrollo Backend', 1, '2023-04-17 15:49:42', 9),
(52, 'Backend', 1, '2023-04-17 15:49:52', 9),
(53, 'Desarrollo Frontend', 1, '2023-04-17 15:49:59', 9),
(54, 'Frontend', 1, '2023-04-17 15:50:06', 9),
(55, 'Bostrap', 3, '2023-04-18 17:55:09', 9),
(56, 'Bootstrap', 3, '2023-04-18 18:02:36', 9),
(57, 'Desarrollo Progresivo', 1, '2023-04-18 18:15:49', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `etiqueta_recurso`
--

CREATE TABLE `etiqueta_recurso` (
  `id` int(11) NOT NULL,
  `id_etiqueta` int(11) NOT NULL,
  `id_recurso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `etiqueta_recurso`
--

INSERT INTO `etiqueta_recurso` (`id`, `id_etiqueta`, `id_recurso`) VALUES
(1, 37, 1),
(2, 8, 2),
(3, 15, 2),
(4, 26, 2),
(5, 16, 3),
(6, 13, 3),
(7, 10, 3),
(8, 14, 4),
(9, 14, 5),
(10, 15, 5),
(11, 26, 5),
(12, 7, 6),
(13, 2, 6),
(14, 18, 6),
(15, 15, 6),
(16, 8, 7),
(17, 28, 7),
(18, 25, 7),
(19, 24, 7),
(20, 7, 8),
(21, 19, 8),
(22, 31, 8),
(23, 17, 9),
(24, 8, 9),
(25, 43, 9),
(26, 30, 9),
(27, 38, 11),
(28, 17, 11),
(29, 25, 11),
(30, 24, 11),
(31, 15, 12),
(32, 26, 12),
(33, 16, 13),
(34, 31, 13),
(35, 7, 13),
(36, 19, 13),
(37, 23, 13),
(38, 3, 13),
(39, 48, 13),
(40, 16, 14),
(41, 1, 14),
(42, 45, 15),
(43, 14, 15),
(44, 43, 15),
(45, 30, 15),
(46, 46, 15),
(47, 7, 16),
(48, 18, 16),
(49, 6, 16),
(50, 16, 17),
(51, 13, 17),
(52, 1, 17),
(53, 16, 18),
(54, 13, 18),
(55, 49, 18),
(56, 1, 18),
(57, 50, 18),
(58, 37, 19),
(59, 38, 19),
(60, 17, 19),
(61, 8, 19),
(62, 52, 19),
(63, 51, 19),
(64, 7, 19),
(65, 53, 19),
(66, 18, 19),
(67, 6, 19),
(68, 50, 19),
(69, 31, 20),
(70, 7, 20),
(71, 53, 20),
(72, 54, 20),
(73, 37, 21),
(74, 52, 21),
(75, 51, 21),
(76, 7, 21),
(77, 53, 21),
(78, 54, 21),
(79, 23, 21),
(80, 37, 22),
(81, 52, 22),
(82, 51, 22),
(83, 7, 22),
(84, 53, 22),
(85, 54, 22),
(86, 23, 22),
(87, 37, 23),
(88, 52, 23),
(89, 51, 23),
(90, 53, 23),
(91, 54, 23),
(92, 23, 23),
(93, 37, 24),
(94, 17, 24),
(95, 8, 24),
(96, 52, 24),
(97, 31, 24),
(98, 51, 24),
(99, 7, 24),
(100, 19, 24),
(101, 23, 24),
(102, 3, 24),
(103, 6, 24),
(104, 34, 24);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `id` int(11) NOT NULL,
  `documento` varchar(15) COLLATE utf8mb4_spanish_ci NOT NULL,
  `nombre` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `apellido` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_tipo_documento` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`id`, `documento`, `nombre`, `apellido`, `estado`, `fecha_creacion`, `id_tipo_documento`, `id_usuario`) VALUES
(1, '999999999', 'Pedro Pablo', 'Rincón Melendez', 1, '2023-04-16 17:17:46', 1, 1),
(2, '1098801212', 'Ana Sofia', 'Rueda Rueda', 1, '2023-04-16 16:58:26', 1, 2),
(3, '1005163899', 'Camilo', 'Valencia', 1, '2023-04-18 22:18:26', 1, 3),
(4, '13835755', 'Carlos Franciso', 'Suarez Rincón', 1, '2023-04-16 16:59:35', 1, 4),
(5, '10051677388', 'Laura Juliana', 'Lozano Calderón', 1, '2023-04-16 22:50:56', 1, 5),
(6, '1098801999', 'Juan Sebastián', 'Mantilla Perez', 1, '2023-04-16 17:01:41', 1, 6),
(7, '63444321', 'Nubia', 'Gonzalez Aceros', 1, '2023-04-16 17:03:18', 1, 7),
(8, '1098717272', 'Michael', 'Smith Lopez', 1, '2023-04-16 17:19:06', 1, 8),
(9, '1005777644', 'Pablo Fernando', 'Ferreiro Duarte', 1, '2023-04-18 20:56:33', 1, 9);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `programa`
--

CREATE TABLE `programa` (
  `id` int(11) NOT NULL,
  `nombre` varchar(100) COLLATE utf8mb4_spanish_ci NOT NULL,
  `descripcion` varchar(255) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `programa`
--

INSERT INTO `programa` (`id`, `nombre`, `descripcion`, `estado`, `fecha_creacion`) VALUES
(1, 'Ingeniería de Sistemas', 'Descripción del programa de Ingeniería de Sistemas ...', 1, '2023-04-16 17:35:23');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `puntuacion_recurso`
--

CREATE TABLE `puntuacion_recurso` (
  `id` int(11) NOT NULL,
  `tipo_voto` tinyint(4) NOT NULL,
  `id_recurso` int(11) NOT NULL,
  `id_estudiante` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `puntuacion_recurso`
--

INSERT INTO `puntuacion_recurso` (`id`, `tipo_voto`, `id_recurso`, `id_estudiante`) VALUES
(3, 0, 6, 9),
(4, 1, 14, 9),
(5, 1, 20, 9),
(6, 0, 22, 9),
(7, 1, 23, 9),
(9, 0, 16, 9),
(10, 0, 21, 9),
(11, 1, 17, 9),
(12, 1, 12, 9),
(13, 0, 15, 9),
(14, 0, 10, 9),
(15, 1, 13, 9),
(16, 1, 7, 9),
(17, 0, 19, 9),
(18, 0, 18, 9),
(19, 0, 11, 9),
(20, 0, 8, 9),
(21, 0, 9, 9),
(23, 0, 5, 9),
(24, 1, 3, 2),
(25, 1, 2, 2),
(26, 0, 6, 2),
(27, 0, 14, 2),
(28, 1, 20, 2),
(29, 1, 22, 2),
(30, 1, 23, 2),
(31, 0, 1, 2),
(32, 1, 16, 2),
(33, 1, 21, 2),
(34, 1, 17, 2),
(35, 1, 12, 2),
(36, 0, 15, 2),
(37, 1, 10, 2),
(38, 1, 13, 2),
(39, 1, 7, 2),
(40, 0, 19, 2),
(41, 1, 18, 2),
(42, 1, 11, 2),
(43, 1, 8, 2),
(44, 0, 9, 2),
(45, 1, 4, 2),
(46, 0, 5, 2),
(47, 1, 9, 6),
(48, 1, 15, 6),
(49, 0, 10, 6),
(50, 1, 20, 6),
(51, 0, 22, 6),
(52, 1, 21, 6),
(53, 0, 23, 6),
(54, 1, 19, 6),
(55, 1, 18, 6),
(56, 0, 1, 6),
(57, 1, 11, 6),
(58, 1, 16, 6),
(59, 1, 3, 6),
(60, 1, 4, 6),
(61, 0, 8, 6),
(62, 1, 17, 6),
(63, 1, 2, 6),
(64, 1, 14, 6),
(65, 0, 13, 6),
(66, 0, 5, 6),
(67, 1, 12, 6),
(68, 0, 6, 6),
(69, 1, 7, 6),
(70, 1, 3, 3),
(71, 1, 2, 3),
(72, 0, 6, 3),
(73, 1, 20, 3),
(74, 0, 14, 3),
(75, 1, 22, 3),
(76, 1, 23, 3),
(77, 0, 5, 3),
(78, 1, 4, 3),
(79, 0, 9, 3),
(80, 1, 11, 3),
(81, 1, 18, 3),
(82, 1, 19, 3),
(83, 1, 7, 3),
(84, 0, 13, 3),
(85, 0, 15, 3),
(86, 1, 1, 3),
(87, 1, 3, 5),
(88, 0, 2, 5),
(89, 0, 6, 5),
(90, 1, 14, 5),
(91, 1, 20, 5),
(92, 1, 22, 5),
(93, 1, 23, 5),
(94, 0, 1, 5),
(95, 1, 8, 5),
(96, 0, 5, 5),
(97, 1, 4, 5),
(98, 1, 21, 5),
(99, 0, 17, 5),
(100, 0, 10, 5),
(101, 1, 3, 9),
(102, 1, 10, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso`
--

CREATE TABLE `recurso` (
  `id` int(11) NOT NULL,
  `internal_id` varchar(24) COLLATE utf8mb4_spanish_ci NOT NULL,
  `titulo` varchar(250) COLLATE utf8mb4_spanish_ci NOT NULL,
  `fecha_publicacion_profesor` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `fecha_publicacion_recurso` varchar(4) COLLATE utf8mb4_spanish_ci NOT NULL,
  `resumen` varchar(1500) COLLATE utf8mb4_spanish_ci NOT NULL,
  `puntos_positivos` int(11) NOT NULL,
  `puntos_negativos` int(11) NOT NULL,
  `estado` tinytext COLLATE utf8mb4_spanish_ci NOT NULL,
  `enlace` varchar(300) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `isbn` varchar(20) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `editorial` varchar(80) COLLATE utf8mb4_spanish_ci DEFAULT NULL,
  `id_docente` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `recurso`
--

INSERT INTO `recurso` (`id`, `internal_id`, `titulo`, `fecha_publicacion_profesor`, `fecha_publicacion_recurso`, `resumen`, `puntos_positivos`, `puntos_negativos`, `estado`, `enlace`, `isbn`, `editorial`, `id_docente`) VALUES
(1, '7dfd919042023065225238', 'Diseño del proceso de gestión de la configuración bajo el marco de referencia ITIL para la compañía de financiamiento TUYA', '2023-04-19 06:58:22', '2020', 'Debido al cambio de personal y la falta de documentación de procesos manejados por estos en las empresas, la información asociada a ciertos procesos no se utiliza de la forma más adecuada. En la compañía de Financiamiento Tuya, se concluyó que toda la información debía estar correctamente documentada y de esta forma mantener registros detallados de servicios, bases de datos y sus respectivas relaciones sin que se vieran afectados por el cambio de personal. Durante el periodo de práctica académica, se encontraron casos de bases de datos de las cuales no se tenía certeza de su utilidad. Al emplear el proceso de gestión de la configuración, se pudieron documentar todos los elementos de configuración, apoyar los procesos y llevar registro y control de los ciclos de vida. Con el fin de generar un gran valor, el proceso fue llevado a cabo bajo el marco de referencia ITIL para proporcionar buenas prácticas, analizando las herramientas existentes en la empresa y proponiendo mejoras para lograr mejores resultados.', 2, 3, '1', 'https://bibliotecadigital.udea.edu.co/handle/10495/20738', '', '', 2),
(2, 'ffdc1190420230652255e5', 'Modelo de requisitos para sistema embebidos', '2023-04-19 06:58:40', '2008', 'En este artículo se presenta un modelo de requisitos como apoyo para la construcción de sistemas embebidos. En la actualidad, las metodologías de Ingeniería de', 4, 1, '1', 'https://bibliotecadigital.udea.edu.co/bitstream/10495/27254/1/PalacioLiliana_2008_ModeloSistemasEmbebidos.pdf', '', '', 2),
(3, 'e71a11904202306522587a', 'Las bases de datos como herramienta didáctica', '2023-04-19 06:58:45', '1996', 'RESUMEN: En este artículo se exploran, describen y analizan las posibilidades que ofrecen las bases de datos como herramientas de soporte para el desarrollo de algunas estrategias didácticas en las áreas de ciencias naturales y matemáticas.', 6, 0, '1', '', '', '', 2),
(4, '22f44190420230652250c9', 'Lineamientos para la creación de una VPN (virtual private network ) red privada virtual', '2023-04-19 06:58:52', 's.f', 'Los estudios de prospectivas en comunicaciones señalan que muchas empresas cuentan con oficinas y sucursales distribuidas en diferentes ubicaciones geográficas', 4, 1, '1', '', '', '', 2),
(5, 'e5ab519042023065225cb5', 'Sistema operativo linux y control de tráfico en redes de computadores', '2023-04-19 06:58:55', 's.f', 'RESUMEN: La amplia presencia redes de computadores, la necesidad de interconexión entre ellas para el intercambio de información y la exigencia de emplear eficientemente los recursos, llevan a considerar el empleo de aplicaciones de software libre', 0, 5, '1', '', '', '', 6),
(6, '1f08f19042023065225fe9', '¿Qué sistema operativo elegir para programar?', '2023-04-19 06:58:59', '2019', 'Código Facilito es una de las plataformas de aprendizaje online de programación más grandes de habla hispana. Desde el 2010 formamos programadores en toda América Latina y España enseñando. HTML, JavaScript, React, Python, Rails, Go y mucho más.', 0, 5, '1', 'https://www.youtube.com/watch?v=8-V5-xgWpJ4', '', '', 6),
(7, 'f87e619042023065225c88', '¿Qué es Prompt Engineering?', '2023-04-19 06:59:03', '2023', 'No generes contenido promedio. Aprende a profundidad cómo funcionan las instrucciones que le das a la IA para obtener resultados únicos.', 4, 0, '1', 'https://www.youtube.com/watch?v=7f5xF-I-S3c', '', '', 6),
(8, 'f4ff8190420230652251ec', 'LLEGÓ LA NUEVA FORMA DE ESCRIBIR CSS: CSS ANIDADO', '2023-04-19 06:59:07', '2023', 'Ya podemos hacer CSS Nestting o CSS anidado en las últimas versiones de Chome y aquí te voy a mostrar como usarlo', 2, 2, '1', 'https://www.youtube.com/watch?v=cBEpBKkD0VY', '', '', 6),
(9, '525171904202306522521a', 'Arquitectura Cliente-Servidor', '2023-04-19 06:59:11', 's.f', 'Se presenta un enlace junto a una imagen para que los usuarios puedan comprender la arquitectura de Cliente/Servidor en su esencia', 1, 3, '1', 'https://reactiveprogramming.io/blog/es/estilos-arquitectonicos/cliente-servidor', '', '', 6),
(10, 'd59b219042023065225afe', 'Cuanto COBRA un ingeniero INFORMATICO | El podcast de DUO', '2023-04-19 06:59:16', '2022', 'PODCAST en donde se habla de posibles rangos de sueldos para Ingenieros Informáticos', 2, 3, '1', 'https://www.youtube.com/watch?v=esHuBRDPnNs', '', '', 9),
(11, 'd74ac19042023065225b14', 'Google vs. Microsoft: la guerra por dominar el mercado de IA', '2023-04-19 06:59:19', '2023', 'Google lanza Bard y anuncia otras IA que llegarán en 2023. En este video Carlos te cuenta cómo competirá contra Microsoft para dominar el mercado de IA.', 3, 1, '1', 'https://www.youtube.com/watch?v=nQfSI5m6QUQ', '', '', 9),
(12, '1520619042023065225e04', 'Sistemas de Archivos Distribuidos', '2023-04-19 06:59:23', '2021', 'Presentación en diapositivas sobre los Sistemas de Archivos Distribuidos', 3, 0, '1', '', '', '', 9),
(13, 'ed27e19042023065225495', 'Prueba técnica en WPOSS', '2023-04-19 06:59:26', '2022', 'Se presentan los archivos necesarios para la realización de prueba para desarrollador web', 2, 2, '1', '', '', '', 9),
(14, 'ffa3d19042023065225ed1', 'Modelo Relacional: La importancia en las bases de datos', '2023-04-19 06:59:29', '2019', 'Diseño relacional de la base de datos para el trabajo de Bases de Datos', 3, 2, '1', '', '', '', 6),
(15, '28f691904202306522548c', 'Automatización de requerimientos y configuraciones en equipos de red del área de conectividad y seguridad perimetral de la empresa ARUS S.A. para mejora en eficiencia de tiempo mediante programación de scripts', '2023-04-19 06:59:32', '2022', 'RESUMEN : Dentro de las tareas que se realizan en el área de conectividad y seguridad perimetral de la compañía ARUS S.A se encuentra la implementación y configuración de equipos de red tales como switches, routers, controladoras inalámbricas, puntos de acceso inalámbricos, firewalls, etc. De diferentes marcas y donde en la mayoría de dispositivos la administración y/o configuración se hace a través de la línea de comandos o CLI (Command-Line Interface) mediante el protocolo de acceso remoto SSH (Secure SHell) donde los comandos (sentencias gramaticales del lenguaje de fabricante) usados son bien conocidos, de uso constante y repetitivo.', 1, 3, '1', '', '', '', 6),
(16, 'f4b8e190420230652250f5', 'Introducción a la Programación en Python', '2023-04-19 06:59:36', '2020', 'Este curso presenta los conceptos básicos de la programación en Python, desde la sintaxis hasta la resolución de problemas complejos. Se incluyen ejercicios prácticos para que los estudiantes pongan en práctica lo aprendido.', 2, 1, '1', 'https://www.coursera.org/learn/aprendiendo-programar-python', '', '', 6),
(17, '7e6e719042023065225e51', 'Lo básico de SQL', '2023-04-19 06:59:40', '2021', 'SQL es similar a un lenguaje de programación, el cual es usado para interactuar con sistemas de gestión de bases de datos relacionales o RDBMS por sus siglas ingles, y para tener control de la estructura de las bases y datos y como se  almacenan los datos.', 3, 1, '1', 'https://platzi.com/tutoriales/2059-practico-sql/8363-lo-basico-de-sql/', '', '', 6),
(18, '06bb01904202306522576a', 'Curso de SQL desde CERO (Completo)', '2023-04-19 06:59:43', '2023', 'Curso del canal de SoyDalto para aprender SQL. En este curso de SQL desde CERO Completo vas a aprender a manejar SQL, el lenguaje mas usado del mundo para bases de datos relacionales, un lenguaje requisito para cualquier perfil IT.', 3, 1, '1', 'https://www.youtube.com/watch?v=DFg1V-rO6Pg', '', '', 9),
(19, 'fc40d19042023065225317', 'Curso de PYTHON desde CERO (Completo)', '2023-04-19 06:59:46', '2023', 'Curso de Python desde cero de la plataforma de Youtube, creado por el creador de contenido SoyDalto, en donde se detalla el uso del lenguaje de programación de Python', 2, 2, '1', 'https://www.youtube.com/watch?v=nKPbfIU442g', '', '', 9),
(20, 'e1b6719042023065225617', 'Curso de CSS desde CERO (Completo)', '2023-04-19 06:59:49', '2020', '¿Queres hacer una página web con HTML, CSS y JavaScript? \r\nEste es el curso de CSS desde cero a experto que vas a terminar, te prometo que no te vas a aburrir durante el aprendizaje de este curso de CSS 3, vas a aprender CSS facil.', 5, 0, '1', 'https://www.youtube.com/watch?v=OWKXEJN67FE&list=PLE8uP447fYpgOwKgbypiCGSz7veY2MLGb&index=2', '', '', 9),
(21, '313d719042023065225f30', 'Curso de JAVASCRIPT desde CERO (Completo) - Nivel Master', '2023-04-19 06:59:53', '2021', '¿Queres aprender a programar en Javascript desde cero? \r\nEste es el curso de javascript desde cero a experto que vas a terminar, te prometo que no te vas a aburrir durante el aprendizaje de este curso de javascript, vas a aprender javascript fácil.', 3, 1, '1', 'https://www.youtube.com/watch?v=EbMi1Qj4rVE', '', '', 9),
(22, '8f277190420230652254e3', 'Curso de JAVASCRIPT desde CERO (Completo) - Nivel JUNIOR', '2023-04-19 06:59:56', '2020', '¿Queres aprender a programar en Javascript desde cero? \r\nEste es el curso de javascript desde cero a experto que vas a terminar, te prometo que no te vas a aburrir durante el aprendizaje de este curso de javascript, vas a aprender javascript fácil.', 3, 2, '1', 'https://www.youtube.com/watch?v=z95mZVUcJ-E&t=41s', '', '', 9),
(23, 'cd5d31904202306522554d', 'Curso de JAVASCRIPT desde CERO (Completo) - Nivel MID LEVEL', '2023-04-19 06:59:59', '2020', '¿Queres aprender a programar en Javascript desde cero? \r\nEste es el curso de javascript desde cero a experto que vas a terminar, te prometo que no te vas a aburrir durante el aprendizaje de este curso de javascript, vas a aprender javascript fácil.', 4, 1, '1', 'https://www.youtube.com/watch?v=xOinGb2MZSk', '', '', 9),
(24, 'b400d190420230652255e4', 'Implementación de un sistema web para la captura y análisis de movimiento en enfermedades neurodegenerativas en entornos de terapia soportados por tic', '2023-04-19 07:00:01', '2022', 'Los desarrollos informáticos que se han venido presentando en la actualidad, como la realidad aumentada y la realidad virtual, han abierto un abanico de posibilidades para tratar el deterioro cognitivo y funcional generado por la aparición de diferentes enfermedades neurodegenerativas. Poder generar en un paciente una inmersión total con un ambiente virtual a través de retos planteados que capturen la concentración e induzcan al ejercitamiento progresivo, presentan una forma interesante de descifrar nuevas perspectivas terapéuticas no farmacológicas [1]. Sin embargo, para que dichas terapias puedan tener el suficiente impacto, se requiere de un entorno o plataforma que muestre la información de las variables capturadas durante las sesiones de una manera organizada y personalizada, de tal manera que los expertos o cuidadores puedan monitorear los resultados y los relacionen directamente con las mejoras de condiciones de salud en los pacientes. Por tal motivo, se construyó Remember VR, un sitio web creado con tecnologías altamente escalables, como Flask-Python, en conjunto con herramientas convencionales en la creación de sitios web como: HTML, CSS, JS, PHP, las cuales interactúan en conjunto para capturar los datos enviados por el sistema de realidad virtual y se encarga de mostrarlos de una manera personalizada mediante tablas y reportes gráficos, permitiendo a los cuidadores sacar conclusiones respecto a mejoras en el paciente.', 0, 0, '3', '', '', '', 9),
(27, '6ff1819042023015717570', 'XD', '2023-04-19 06:57:17', 's.f', 'XD', 0, 0, '1', 'https://www.youtube.com/', '', '', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `recurso_favorito`
--

CREATE TABLE `recurso_favorito` (
  `id` int(11) NOT NULL,
  `id_persona` int(11) NOT NULL,
  `id_recurso` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `recurso_favorito`
--

INSERT INTO `recurso_favorito` (`id`, `id_persona`, `id_recurso`) VALUES
(1, 5, 3),
(2, 5, 2),
(3, 5, 14),
(4, 5, 20),
(5, 5, 23),
(6, 5, 8),
(7, 5, 5),
(8, 3, 23),
(10, 3, 3);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_documento`
--

CREATE TABLE `tipo_documento` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(30) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `tipo_documento`
--

INSERT INTO `tipo_documento` (`id`, `descripcion`) VALUES
(1, 'Cédula Ciudadanía'),
(3, 'Cédula Extranjería'),
(2, 'Tarjeta Identidad');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipo_usuario`
--

CREATE TABLE `tipo_usuario` (
  `id` int(11) NOT NULL,
  `descripcion` varchar(20) COLLATE utf8mb4_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

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
  `correo` varchar(60) COLLATE utf8mb4_spanish_ci NOT NULL,
  `clave` varchar(80) COLLATE utf8mb4_spanish_ci NOT NULL,
  `estado` tinyint(4) NOT NULL,
  `fecha_creacion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `id_tipo_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_spanish_ci;

--
-- Volcado de datos para la tabla `usuario`
--

INSERT INTO `usuario` (`id`, `correo`, `clave`, `estado`, `fecha_creacion`, `id_tipo_usuario`) VALUES
(1, 'sa.repositorioinstitucional@gmail.com', 'UU5FTTluWTBsZWVuY0hBaHBYN052dz09', 1, '2023-04-13 08:22:30', 1),
(2, 'test@gmail.com', 'UU5FTTluWTBsZWVuY0hBaHBYN052dz09', 1, '2023-04-14 03:23:14', 2),
(3, 'camilovalncias@gmail.com', 'UU5FTTluWTBsZWVuY0hBaHBYN052dz09', 1, '2023-04-18 21:05:50', 3),
(4, 'carlosuarez13@gmail.com', 'UU5FTTluWTBsZWVuY0hBaHBYN052dz09', 1, '2023-04-16 17:00:07', 1),
(5, 'llozano@udi.edu.co', 'UU5FTTluWTBsZWVuY0hBaHBYN052dz09', 1, '2023-04-16 17:00:56', 3),
(6, 'juanse1010@gmail.com', 'UU5FTTluWTBsZWVuY0hBaHBYN052dz09', 1, '2023-04-16 17:01:57', 2),
(7, 'nubiagonz@gmail.com', 'UU5FTTluWTBsZWVuY0hBaHBYN052dz09', 1, '2023-04-16 17:03:29', 1),
(8, 'msmith@gmail.com', 'UU5FTTluWTBsZWVuY0hBaHBYN052dz09', 1, '2023-04-16 17:19:17', 1),
(9, 'pablofer@gmail.com', 'UU5FTTluWTBsZWVuY0hBaHBYN052dz09', 1, '2023-04-16 19:33:21', 2);

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
-- Indices de la tabla `autor`
--
ALTER TABLE `autor`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_autor_docente` (`id_docente`);

--
-- Indices de la tabla `autor_recurso`
--
ALTER TABLE `autor_recurso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_autor_recurso_autor` (`id_autor`),
  ADD KEY `fk_autor_recurso_recurso` (`id_recurso`);

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
  ADD KEY `fk_curso_programa_curso` (`id_curso`),
  ADD KEY `fk_curso_programa_programa` (`id_programa`);

--
-- Indices de la tabla `curso_recurso`
--
ALTER TABLE `curso_recurso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_curso_recurso_curso` (`id_curso`),
  ADD KEY `fk_curso_recurso_recurso` (`id_recurso`);

--
-- Indices de la tabla `docente_curso`
--
ALTER TABLE `docente_curso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_docente_curso_docente` (`id_docente`),
  ADD KEY `fk_docente_curso_curso` (`id_curso`);

--
-- Indices de la tabla `etiqueta`
--
ALTER TABLE `etiqueta`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_etiqueta_docente` (`id_docente`);

--
-- Indices de la tabla `etiqueta_recurso`
--
ALTER TABLE `etiqueta_recurso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_etiqueta_recurso_etiqueta` (`id_etiqueta`),
  ADD KEY `fk_etiqueta_recurso_recurso` (`id_recurso`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `per_uniq_documento` (`documento`),
  ADD KEY `fk_persona_tipo_documento` (`id_tipo_documento`),
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
  ADD KEY `fk_puntuacion_recurso_recurso` (`id_recurso`),
  ADD KEY `fk_puntuacion_recurso_estudiante` (`id_estudiante`);

--
-- Indices de la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_recurso_docente` (`id_docente`);

--
-- Indices de la tabla `recurso_favorito`
--
ALTER TABLE `recurso_favorito`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_recurso_favorito_persona` (`id_persona`),
  ADD KEY `fk_recurso_favorito_recurso` (`id_recurso`);

--
-- Indices de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tdoc_uniq_descripcion` (`descripcion`);

--
-- Indices de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tusu_uniq_descripcion` (`descripcion`);

--
-- Indices de la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `usu_uniq_correo` (`correo`),
  ADD KEY `fk_usuario_tipo_usuario` (`id_tipo_usuario`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `archivo`
--
ALTER TABLE `archivo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `autor`
--
ALTER TABLE `autor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=54;

--
-- AUTO_INCREMENT de la tabla `autor_recurso`
--
ALTER TABLE `autor_recurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT de la tabla `curso`
--
ALTER TABLE `curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `curso_programa`
--
ALTER TABLE `curso_programa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `curso_recurso`
--
ALTER TABLE `curso_recurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=44;

--
-- AUTO_INCREMENT de la tabla `docente_curso`
--
ALTER TABLE `docente_curso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT de la tabla `etiqueta`
--
ALTER TABLE `etiqueta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=58;

--
-- AUTO_INCREMENT de la tabla `etiqueta_recurso`
--
ALTER TABLE `etiqueta_recurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=105;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de la tabla `programa`
--
ALTER TABLE `programa`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de la tabla `puntuacion_recurso`
--
ALTER TABLE `puntuacion_recurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=103;

--
-- AUTO_INCREMENT de la tabla `recurso`
--
ALTER TABLE `recurso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT de la tabla `recurso_favorito`
--
ALTER TABLE `recurso_favorito`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT de la tabla `tipo_documento`
--
ALTER TABLE `tipo_documento`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `tipo_usuario`
--
ALTER TABLE `tipo_usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `usuario`
--
ALTER TABLE `usuario`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `archivo`
--
ALTER TABLE `archivo`
  ADD CONSTRAINT `archivo_ibfk_2` FOREIGN KEY (`id_recurso`) REFERENCES `recurso` (`id`);

--
-- Filtros para la tabla `autor`
--
ALTER TABLE `autor`
  ADD CONSTRAINT `autor_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `persona` (`id`);

--
-- Filtros para la tabla `autor_recurso`
--
ALTER TABLE `autor_recurso`
  ADD CONSTRAINT `autor_recurso_ibfk_1` FOREIGN KEY (`id_autor`) REFERENCES `autor` (`id`),
  ADD CONSTRAINT `autor_recurso_ibfk_2` FOREIGN KEY (`id_recurso`) REFERENCES `recurso` (`id`);

--
-- Filtros para la tabla `curso_programa`
--
ALTER TABLE `curso_programa`
  ADD CONSTRAINT `curso_programa_ibfk_1` FOREIGN KEY (`id_programa`) REFERENCES `programa` (`id`),
  ADD CONSTRAINT `curso_programa_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id`);

--
-- Filtros para la tabla `curso_recurso`
--
ALTER TABLE `curso_recurso`
  ADD CONSTRAINT `curso_recurso_ibfk_1` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id`),
  ADD CONSTRAINT `curso_recurso_ibfk_2` FOREIGN KEY (`id_recurso`) REFERENCES `recurso` (`id`);

--
-- Filtros para la tabla `docente_curso`
--
ALTER TABLE `docente_curso`
  ADD CONSTRAINT `docente_curso_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `persona` (`id`),
  ADD CONSTRAINT `docente_curso_ibfk_2` FOREIGN KEY (`id_curso`) REFERENCES `curso` (`id`);

--
-- Filtros para la tabla `etiqueta`
--
ALTER TABLE `etiqueta`
  ADD CONSTRAINT `etiqueta_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `persona` (`id`);

--
-- Filtros para la tabla `etiqueta_recurso`
--
ALTER TABLE `etiqueta_recurso`
  ADD CONSTRAINT `etiqueta_recurso_ibfk_1` FOREIGN KEY (`id_etiqueta`) REFERENCES `etiqueta` (`id`),
  ADD CONSTRAINT `etiqueta_recurso_ibfk_2` FOREIGN KEY (`id_recurso`) REFERENCES `recurso` (`id`);

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `persona_ibfk_1` FOREIGN KEY (`id_tipo_documento`) REFERENCES `tipo_documento` (`id`),
  ADD CONSTRAINT `persona_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuario` (`id`);

--
-- Filtros para la tabla `puntuacion_recurso`
--
ALTER TABLE `puntuacion_recurso`
  ADD CONSTRAINT `puntuacion_recurso_ibfk_1` FOREIGN KEY (`id_estudiante`) REFERENCES `persona` (`id`),
  ADD CONSTRAINT `puntuacion_recurso_ibfk_2` FOREIGN KEY (`id_recurso`) REFERENCES `recurso` (`id`);

--
-- Filtros para la tabla `recurso`
--
ALTER TABLE `recurso`
  ADD CONSTRAINT `recurso_ibfk_1` FOREIGN KEY (`id_docente`) REFERENCES `persona` (`id`);

--
-- Filtros para la tabla `recurso_favorito`
--
ALTER TABLE `recurso_favorito`
  ADD CONSTRAINT `recurso_favorito_ibfk_1` FOREIGN KEY (`id_persona`) REFERENCES `persona` (`id`),
  ADD CONSTRAINT `recurso_favorito_ibfk_2` FOREIGN KEY (`id_recurso`) REFERENCES `recurso` (`id`);

--
-- Filtros para la tabla `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`id_tipo_usuario`) REFERENCES `tipo_usuario` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
