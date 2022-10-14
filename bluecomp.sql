-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 24-02-2022 a las 19:57:06
-- Versión del servidor: 10.4.6-MariaDB
-- Versión de PHP: 7.3.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `bluecomp`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `categoria`
--

CREATE TABLE `categoria` (
  `idcategoria` int(11) NOT NULL,
  `nombreCategoria` varchar(50) DEFAULT NULL,
  `descripcionCategoria` text DEFAULT NULL,
  `fechaCategoria` timestamp NULL DEFAULT NULL,
  `estadoCategoria` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `categoria`
--

INSERT INTO `categoria` (`idcategoria`, `nombreCategoria`, `descripcionCategoria`, `fechaCategoria`, `estadoCategoria`) VALUES
(1, 'Carnes', 'son las carnes mas deliciosas de Arica', '2021-09-02 19:54:41', 1),
(2, 'Lacteos	        ', 'son los yogures mas ricos de chile', '2021-09-02 19:54:41', 1),
(3, 'Frutas', 'son las frutas mas dulces de todo chile', '2021-09-02 19:54:41', 1),
(4, 'Verduras', 'son las verduras mas saludables de chile', '2021-09-02 19:54:41', 1),
(5, 'Enjuagues', 'Son Para Mantener La Boca En Buen Estado De Limpieza Total', '2021-09-02 19:54:41', 1),
(6, 'Pastas     ', 'son las pastas mas ricas de todo chile', '2021-09-02 19:54:41', 1),
(7, 'Refrigerios', 'son los refrigerios mas ricos', '2021-09-02 19:54:41', 1),
(8, 'Frituras', 'Sera una categoría para la comida grasosa', '2021-09-02 19:54:41', 0),
(9, 'Alcohol', 'serán la marca mas útil de todo chile', '2021-09-02 19:54:41', 0),
(10, 'Cupones', 'sera la categoria para los cupones de registrar', '2021-09-21 16:52:01', 1),
(11, 'Granos', 'Gfdfgdf', NULL, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `comuna`
--

CREATE TABLE `comuna` (
  `idComuna` int(11) NOT NULL,
  `nombreComuna` varchar(45) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `comuna`
--

INSERT INTO `comuna` (`idComuna`, `nombreComuna`) VALUES
(1, 'Arica y Parinacota'),
(2, 'Tarapacá'),
(3, 'Antofagasta'),
(4, 'Atacama'),
(5, 'Coquimbo'),
(6, 'Valparaiso'),
(7, 'Metropolitana de Santiago'),
(8, 'Libertador General Bernardo O\'Higgins'),
(9, 'Maule'),
(10, 'Ñuble'),
(11, 'Biobío'),
(12, 'La Araucanía'),
(13, 'Los Ríos'),
(14, 'Los Lagos'),
(15, 'Aysén del General Carlos Ibáñez del Campo'),
(16, 'Magallanes y de la Antártica Chilena');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallecargocliente`
--

CREATE TABLE `detallecargocliente` (
  `id_detalleCargoCliente` int(11) NOT NULL,
  `negocio_idDetalle` int(11) NOT NULL,
  `perdona_idDetalle` int(11) NOT NULL,
  `descripcionCargo` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detallecargocliente`
--

INSERT INTO `detallecargocliente` (`id_detalleCargoCliente`, `negocio_idDetalle`, `perdona_idDetalle`, `descripcionCargo`) VALUES
(2, 3, 5, 'tiene un cargo en el terminal\n'),
(7, 5, 6, ''),
(8, 5, 7, ''),
(10, 5, 8, NULL),
(14, 5, 12, ''),
(15, 5, 11, ''),
(16, 5, 10, NULL),
(17, 5, 9, NULL),
(18, 5, 13, ''),
(19, 5, 14, ''),
(20, 2, 15, 'tiene un cargo de cajera'),
(21, 5, 16, ''),
(22, 5, 17, ''),
(23, 5, 18, ''),
(24, 5, 19, ''),
(25, 5, 20, ''),
(26, 5, 21, '');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallepedido`
--

CREATE TABLE `detallepedido` (
  `id_detallePedido` int(11) NOT NULL,
  `pedidoIdDetalle` int(11) NOT NULL,
  `productoIdDetalle` int(11) NOT NULL,
  `precioDetalle` decimal(11,2) NOT NULL,
  `cantidadDetalle` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detallepedido`
--

INSERT INTO `detallepedido` (`id_detallePedido`, `pedidoIdDetalle`, `productoIdDetalle`, `precioDetalle`, `cantidadDetalle`) VALUES
(5, 5, 4, '400.00', 2),
(6, 5, 5, '450.00', 1),
(7, 5, 47, '450.00', 1),
(8, 5, 3, '680.00', 2),
(9, 6, 5, '450.00', 3),
(10, 6, 47, '450.00', 2),
(11, 6, 4, '400.00', 2),
(12, 7, 4, '400.00', 1),
(13, 7, 5, '450.00', 1),
(14, 7, 47, '450.00', 1),
(15, 7, 3, '680.00', 1),
(16, 8, 47, '450.00', 2),
(17, 8, 48, '25.00', 1),
(18, 8, 3, '680.00', 2),
(19, 9, 2, '245.00', 3),
(20, 9, 48, '25.00', 1),
(21, 10, 4, '400.00', 1),
(22, 10, 5, '450.00', 2),
(23, 10, 3, '680.00', 3),
(24, 11, 3, '680.00', 2),
(25, 11, 48, '25.00', 1),
(26, 11, 4, '400.00', 1),
(27, 11, 2, '245.00', 4),
(28, 11, 47, '450.00', 3),
(29, 12, 1, '2400.00', 2),
(30, 12, 3, '680.00', 2),
(31, 12, 48, '25.00', 1),
(32, 13, 2, '245.00', 2),
(33, 13, 5, '450.00', 2),
(34, 13, 50, '500.00', 1),
(35, 13, 48, '25.00', 1),
(36, 14, 5, '450.00', 2),
(37, 14, 47, '450.00', 3),
(38, 14, 50, '500.00', 2),
(39, 14, 48, '25.00', 1),
(40, 15, 3, '680.00', 2),
(41, 15, 4, '400.00', 1),
(42, 15, 50, '500.00', 1),
(43, 15, 56, '30.00', 1),
(44, 15, 52, '2200.00', 3),
(45, 15, 51, '3200.00', 2),
(46, 16, 4, '400.00', 1),
(47, 16, 5, '450.00', 2),
(48, 17, 50, '500.00', 2),
(49, 17, 51, '3200.00', 1),
(50, 17, 48, '25.00', 1),
(51, 18, 51, '3200.00', 1),
(52, 18, 4, '400.00', 1),
(53, 18, 5, '450.00', 2),
(54, 18, 48, '25.00', 1),
(55, 19, 61, '2300.00', 2),
(56, 19, 54, '450.00', 2),
(57, 19, 48, '25.00', 1),
(58, 20, 52, '2200.00', 1),
(59, 20, 54, '450.00', 1),
(60, 20, 62, '20.00', 1),
(61, 21, 1, '2400.00', 1),
(62, 21, 51, '3200.00', 2),
(63, 22, 53, '550.00', 2),
(64, 22, 50, '500.00', 1),
(65, 22, 48, '25.00', 1),
(66, 23, 52, '2200.00', 1),
(67, 23, 54, '450.00', 1),
(68, 23, 61, '2300.00', 2),
(69, 23, 50, '500.00', 1),
(70, 23, 48, '25.00', 1),
(71, 24, 52, '2200.00', 1),
(72, 24, 51, '3200.00', 1),
(73, 24, 5, '450.00', 1),
(74, 24, 4, '400.00', 1),
(75, 24, 62, '20.00', 1),
(76, 25, 54, '450.00', 1),
(77, 25, 52, '2200.00', 2),
(78, 25, 4, '400.00', 2),
(79, 25, 5, '450.00', 3),
(80, 25, 62, '20.00', 1),
(81, 26, 53, '550.00', 2),
(82, 26, 60, '890.00', 3),
(83, 26, 49, '28.00', 1),
(84, 27, 63, '1300.00', 2),
(85, 27, 4, '400.00', 2),
(86, 27, 5, '450.00', 1),
(87, 27, 49, '28.00', 1),
(88, 28, 51, '3200.00', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `detallesuscripcion`
--

CREATE TABLE `detallesuscripcion` (
  `idDetalleSuscripcion` int(11) NOT NULL,
  `suscripcionDetalle` int(11) NOT NULL,
  `productoSuscrito` int(11) NOT NULL,
  `cantidadProSuscrito` int(11) NOT NULL,
  `precioProSuscrito` decimal(11,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `detallesuscripcion`
--

INSERT INTO `detallesuscripcion` (`idDetalleSuscripcion`, `suscripcionDetalle`, `productoSuscrito`, `cantidadProSuscrito`, `precioProSuscrito`) VALUES
(83, 3, 60, 3, '890.00'),
(85, 2, 5, 2, '450.00');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `direccion`
--

CREATE TABLE `direccion` (
  `idDireccion` int(11) NOT NULL,
  `nombreDireccion` varchar(45) NOT NULL,
  `comunaIdDireccion` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `direccion`
--

INSERT INTO `direccion` (`idDireccion`, `nombreDireccion`, `comunaIdDireccion`) VALUES
(1, 'Pedro Aguirre Cerda', 1),
(2, 'Juan Antonio Rios', 1),
(3, '21 de mayo', 1),
(4, 'Las petunias', 1),
(5, 'Alonso SantoBeña', 2),
(6, 'avenida siempre Viva', 3),
(7, 'Calle Queen\'s', 3),
(8, 'arturo Pratt 34', 1),
(9, 'pasaje San bernardo', 1),
(10, 'Pedro con quillaes', 1),
(11, '1 de mayo ', 1),
(12, 'Las cucarachas', 4),
(13, 'juan antonio', 4),
(14, 'metropolis 1554', 4);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `imagen`
--

CREATE TABLE `imagen` (
  `idImagen` int(11) NOT NULL,
  `img` varchar(100) DEFAULT NULL,
  `productoIDImg` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `imagen`
--

INSERT INTO `imagen` (`idImagen`, `img`, `productoIDImg`) VALUES
(1, 'pro_39f0b415cd261fee4a45fda15cd17cfb.jpg', 1),
(2, 'pro_79256693029447b6b094925c1cacc1a1.jpg', 1),
(3, 'pro_03837b143a71a4960dda8264d60c989d.jpg', 1),
(4, 'pro_4388d253b00d488c9e6a1b004454b681.jpg', 2),
(5, 'pro_ce514773b70deff0fff0da5aa713410c.jpg', 2),
(6, 'pro_f29e27abfb5db270018ef31b70243aa8.jpg', 3),
(7, 'pro_61bff86ccf5dd09faa6a8621c2d9416c.jpg', 3),
(8, 'pro_f26121b18ff992fc16e1bef4d9b53d42.jpg', 3),
(9, 'pro_58851aafd231a5bf84dd675ef28fa699.jpg', 4),
(10, 'pro_e21d063779429c5fca796da6f90bd281.jpg', 4),
(11, 'pro_71f56efff45c938c8e7f1bac82271088.jpg', 4),
(12, 'pro_44ef37ee6724e3036e88501c8253cded.jpg', 5),
(13, 'pro_d4469cbc4770799516657d0122cb5f0d.jpg', 5),
(14, 'pro_bb370803f5d2451e27f66a52b7508dc8.jpg', 5),
(50, 'pro_2a28b3920689c98a714d6d0ef6377912.jpg', 47),
(58, 'pro_9f340df9647561371cdf32a129be0efd.jpg', 52),
(59, 'pro_acbc31d5f92d728de73e65c789dfb2dc.jpg', 52),
(60, 'pro_d023797df97474746cdbf0ae30fa832f.jpg', 52),
(61, 'pro_f70a1b29a104bfbddb2575b2e3268172.jpg', 53),
(63, 'pro_8df915223eda4bd7b15926136ebf9ecb.jpg', 53),
(65, 'pro_f8d2b216cd36e406e4a27e1f483e2035.jpg', 54),
(66, 'pro_7357bc22e1fae16432ab6ced136d2603.jpg', 54),
(67, 'pro_307491cc5ced6d5908d05bd468eb72cc.jpg', 50),
(68, 'pro_395ec67c2862a50543bf7eea1bd6e9dd.jpg', 50),
(69, 'pro_1c7fa93bdea9824624e730c3b35b299f.jpg', 50),
(70, 'pro_bba3b4fd6b9408e4e8a9460ef899ff81.jpg', 51),
(71, 'pro_5b052f2ebfca2e3b979cc74037d36ccc.jpg', 51),
(72, 'pro_d030e8b2d0444ef792245909e4899d2e.jpg', 51),
(73, 'pro_16a599c9c380d68f23a2afbcfaa68446.jpg', 47),
(74, 'pro_5e8b9ac49f4f1152ee5b32c419b59a95.jpg', 59),
(75, 'pro_0ac63d152f5d412d974f27dd949668d9.jpg', 59),
(77, 'pro_4ecf35e460d42ebb7e7b91fae94b666c.jpg', 59),
(78, 'pro_66abef1c5e4f0987275002736694b5bb.jpg', 60),
(79, 'pro_8a5bed84d8f8386e5bd719b3cf596698.jpg', 60),
(80, 'pro_4791f1917d4eb5f6547081065e0eaa32.jpg', 60),
(81, 'pro_bae1cd04f8e950e4efbe58db24fcb288.jpg', 61),
(82, 'pro_0f3c4fd2865d3bb6dc62179674f0dde9.jpg', 61),
(83, 'pro_0f3c4fd2865d3bb6dc62179674f0dde9.jpg', 61),
(84, 'pro_3885a07bdae041b86f031b8d06b10632.jpg', 63),
(85, 'pro_8caceb9503ceaf339fedb2ac08d2ef80.jpg', 63);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `negocio`
--

CREATE TABLE `negocio` (
  `idNegocio` int(11) NOT NULL,
  `negocioNombre` varchar(45) NOT NULL,
  `negocioDescripcion` text DEFAULT NULL,
  `estadoNegocio` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `negocio`
--

INSERT INTO `negocio` (`idNegocio`, `negocioNombre`, `negocioDescripcion`, `estadoNegocio`) VALUES
(1, 'Abarroteria', NULL, 1),
(2, 'Supermercado', 'Este será el cargo para los supermercados que estén', 1),
(3, 'Local de pescados', 'es el local mas amplio', 1),
(4, 'Negocio agricola', 'Este será para los negocios agrícolas del pais', 1),
(5, 'Sin negocio Fijo', NULL, 1),
(6, 'Negocio perico', 'Sera este un cargo de negocio para peri', 0);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `pedido`
--

CREATE TABLE `pedido` (
  `idPedido` int(11) NOT NULL,
  `personaIdPedido` int(11) NOT NULL,
  `fechaPedido` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `tipopagoPedido` int(11) NOT NULL,
  `costoEnvioPedido` decimal(10,2) DEFAULT NULL,
  `subtotalPedido` decimal(10,2) NOT NULL,
  `montoTotalPedido` decimal(11,2) NOT NULL,
  `statusPedido` text NOT NULL,
  `direccionPedido` int(11) NOT NULL,
  `estadoPedido` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `pedido`
--

INSERT INTO `pedido` (`idPedido`, `personaIdPedido`, `fechaPedido`, `tipopagoPedido`, `costoEnvioPedido`, `subtotalPedido`, `montoTotalPedido`, `statusPedido`, `direccionPedido`, `estadoPedido`) VALUES
(5, 5, '2021-11-08 17:18:56', 1, '1500.00', '3060.00', '4560.00', 'Cancelado', 4, 0),
(6, 5, '2021-11-08 17:19:00', 3, '1500.00', '3050.00', '4550.00', 'Cancelado', 8, 0),
(7, 7, '2021-09-29 05:07:08', 4, '1500.00', '1980.00', '3480.00', 'Pendiente', 2, 1),
(8, 5, '2021-10-28 00:31:45', 4, '1500.00', '1695.00', '3195.00', 'Cancelado', 3, 0),
(9, 6, '2021-10-03 00:31:06', 1, '1500.00', '551.25', '2051.25', 'Pendiente', 3, 1),
(10, 6, '2021-10-09 20:51:00', 1, '1500.00', '3340.00', '4840.00', 'Pendiente', 3, 1),
(11, 5, '2021-10-09 21:06:22', 3, '1500.00', '3067.50', '4567.50', 'Pendiente', 4, 1),
(12, 5, '2021-10-09 23:46:12', 3, '1500.00', '4620.00', '6120.00', 'Pendiente', 3, 1),
(13, 5, '2021-11-08 17:15:26', 2, '1500.00', '1417.50', '2917.50', 'Cancelado', 2, 0),
(14, 5, '2021-11-05 01:26:40', 3, '1500.00', '2437.50', '3937.50', 'Pendiente', 3, 1),
(15, 5, '2021-11-08 17:17:43', 2, '1500.00', '10682.00', '12182.00', 'Pendiente', 4, 1),
(16, 7, '2021-11-08 01:48:56', 2, '1500.00', '1300.00', '2800.00', 'Cancelado', 6, 0),
(17, 6, '2021-11-03 01:55:41', 3, '1500.00', '3150.00', '4650.00', 'Pendiente', 12, 1),
(18, 6, '2021-11-06 23:20:41', 1, '1500.00', '3375.00', '4875.00', 'Pendiente', 3, 1),
(19, 5, '2021-11-15 02:53:22', 2, '1500.00', '4125.00', '5625.00', 'Pendiente', 2, 1),
(20, 13, '2021-11-17 22:26:58', 4, '1500.00', '2120.00', '3620.00', 'Pendiente', 4, 1),
(21, 14, '2021-11-24 22:37:57', 2, '1500.00', '8800.00', '10300.00', 'Cancelado', 3, 0),
(22, 5, '2021-11-30 15:53:37', 1, '1500.00', '1200.00', '2700.00', 'Cancelado', 3, 0),
(23, 5, '2021-12-06 00:49:51', 2, '1500.00', '5812.50', '7312.50', 'Pendiente', 6, 1),
(24, 5, '2021-12-06 00:52:32', 1, '1500.00', '5000.00', '6500.00', 'Pendiente', 4, 1),
(25, 6, '2021-12-06 00:53:56', 4, '1500.00', '5600.00', '7100.00', 'Pendiente', 9, 1),
(26, 6, '2021-12-13 00:26:56', 2, '1500.00', '2714.40', '4214.40', 'Pendiente', 4, 1),
(27, 5, '2021-12-26 23:00:01', 2, '1500.00', '2772.00', '4272.00', 'Pendiente', 4, 1),
(28, 5, '2021-12-29 22:44:16', 1, '1500.00', '12800.00', '14300.00', 'Pendiente', 4, 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `persona`
--

CREATE TABLE `persona` (
  `idPersona` int(11) NOT NULL,
  `nombrePersona` varchar(80) NOT NULL,
  `apellidoPersona` varchar(45) NOT NULL,
  `rolPersona` int(11) NOT NULL,
  `telefonoPersona` varchar(20) DEFAULT NULL,
  `emailPersona` varchar(100) NOT NULL,
  `passwordPersona` varchar(45) NOT NULL,
  `fechaPersona` datetime DEFAULT NULL,
  `comentarioPersona` text DEFAULT NULL,
  `estadoPersona` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `persona`
--

INSERT INTO `persona` (`idPersona`, `nombrePersona`, `apellidoPersona`, `rolPersona`, `telefonoPersona`, `emailPersona`, `passwordPersona`, `fechaPersona`, `comentarioPersona`, `estadoPersona`) VALUES
(1, 'Julia', 'Navarro', 1, '+56954354363', 'Julia45@gmail.com', '27e8a1e6d60814e4372c7f901551f8fc', '2021-09-02 00:40:23', 'este será su cargo de jefa', 1),
(2, 'Sergio', 'Juares', 2, '+56975767688', 'Sergio35@gmail.com', '8a95beddeee01be7f167dc0cab9e5089', '2021-09-02 00:40:23', '', 1),
(3, 'Iván ', 'Ñavez', 3, NULL, 'Ivan34@gmail.com', '2344521e389d6897ae7af9abf16e7ccc', '2021-09-02 00:40:23', '', 1),
(4, 'Marcela', 'Dañez', 4, '+56965546457', 'Marcela45@gmail.com', '2344521e389d6897ae7af9abf16e7ccc', '2021-09-02 00:40:23', '', 1),
(5, 'Mario', 'Baltazar', 5, '+56975745575', 'Mbaltazarlanchipa@gmail.com', '671809fc411ab7898b89e27b23ed674a', '2021-09-03 20:53:23', 'sera este el primer cliente de hoy', 2),
(6, 'Pepe', 'Juarez', 5, '+56997586759', 'Pepe45@gmail.com', '671809fc411ab7898b89e27b23ed674a', '2021-08-12 21:42:10', 'tengo mi puesto final', 1),
(7, 'Juanita', 'Cortez', 5, '+56987364523', 'Juanita45bel@gmail.com', 'e31d6053a54c9adc495dc6808a848a90', '2021-09-29 01:40:46', 'me gustaria conocer sus productos', 1),
(8, 'Menma', 'Juarez', 5, '+56965467547', 'Menma45@gmail.com', 'be8e3a4f79400f2257581e1905840642', '2021-10-27 00:59:06', '', 1),
(9, 'Pepa', 'Pig', 5, '+56945346456', 'PepePig46@gmail.com', 'be8e3a4f79400f2257581e1905840642', '2021-10-27 01:19:13', '', 1),
(10, 'Julian', 'Chavez', 5, '+56945464575', 'JulianC46@gmail.com', '8bcb00b44fb33d256ab12b7352c6f401', '2021-10-27 01:20:48', '', 1),
(11, 'Juan', 'Ñavez', 5, '+56946575675', 'Juan47@gmail.com', '3cdf2793802760775a092d8ef53013be', '2021-10-27 01:26:44', '', 0),
(12, 'Juaquin', 'Alvarez', 5, '+56965457567', 'Juaquin45@gmail.com', 'be8e3a4f79400f2257581e1905840642', '2021-10-27 01:41:41', '', 1),
(13, 'Pericos', 'Palotes', 5, '+56965757676', 'periquin35@gmail.com', '62b0f3d72486b13d97c6d0e425e49484', '2021-11-17 19:25:09', '', 1),
(14, 'Tino', 'Juanpa', 5, '+56946546457', 'juanpa45@gmail.com', '62b0f3d72486b13d97c6d0e425e49484', '2021-11-21 00:59:53', '', 1),
(15, 'Emmy', 'Juarez', 5, '+56953465464', 'emmy50r@gmail.com', '829010f40da15fc2e5309d3eb08656b7', '2021-11-21 01:31:29', '', 2),
(16, 'Yulia', 'Perez', 5, '+56953346456', 'yulia34@gmail.com', 'adb9e8c5b6a2280928083c25a33ce955', '2021-11-21 01:49:43', '', 1),
(17, 'Julio', 'ñavez', 5, '56954364564', 'JulioN46@gmail.com', 'b9fa0fa1ac2fe049ed2c649baaf6cd98', '2021-11-21 02:08:25', '', 1),
(18, 'Chill', 'Falconi', 5, '+56954356456', 'chil34@gmail.com', 'be8e3a4f79400f2257581e1905840642', '2021-11-21 22:02:56', '', 1),
(19, 'Roman', 'Alexander', 5, '+56934254535', 'Alexander50@gmail.com', 'a338f0b851b3f39b728f50d19c8bf5bd', '2021-11-22 15:06:13', '', 1),
(20, 'Dylan', 'Bryan', 5, '+56946557657', 'dylan56@gmail.com', 'befcc01526f9299fd1a9eb3362584b23', '2021-11-22 15:16:57', '', 1),
(21, 'Petunias', 'Alvarez', 5, '+56998676767', 'petunias46@gmail.com', 'be8e3a4f79400f2257581e1905840642', '2021-11-24 19:19:11', 'hola, me encuentro recien en su tienda', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `preferencia`
--

CREATE TABLE `preferencia` (
  `idPreferencia` int(11) NOT NULL,
  `personaPreferencia` int(11) NOT NULL,
  `productoPreferencia` int(11) NOT NULL,
  `fechaPreferencias` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estadoPreferencia` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `preferencia`
--

INSERT INTO `preferencia` (`idPreferencia`, `personaPreferencia`, `productoPreferencia`, `fechaPreferencias`, `estadoPreferencia`) VALUES
(1, 5, 1, '2021-10-09 23:46:13', 2),
(2, 5, 2, '2021-10-18 22:53:12', 0),
(3, 6, 3, '2021-10-09 20:51:00', 2),
(4, 6, 4, '2021-11-06 23:20:41', 2),
(5, 6, 2, '2021-10-03 00:31:06', 2),
(6, 5, 3, '2021-10-28 23:52:51', 2),
(7, 5, 4, '2021-12-06 00:52:32', 2),
(8, 5, 5, '2021-12-06 00:52:32', 2),
(9, 5, 47, '2021-10-18 22:51:11', 0),
(10, 7, 4, '2021-09-29 05:07:08', 2),
(11, 7, 3, '2021-09-29 05:07:09', 2),
(12, 7, 5, '2021-09-29 05:07:09', 2),
(13, 7, 47, '2021-09-29 05:07:09', 2),
(14, 5, 48, '2021-10-01 23:03:39', 2),
(15, 6, 48, '2021-10-03 00:31:06', 2),
(16, 6, 5, '2021-11-06 23:20:41', 2),
(17, 5, 50, '2021-11-23 03:27:16', 2),
(18, 6, 47, '2021-10-16 23:12:43', 1),
(19, 6, 50, '2021-11-03 01:55:41', 2),
(21, 5, 56, '2021-10-28 23:52:51', 2),
(22, 5, 52, '2021-12-13 00:05:00', 1),
(23, 5, 51, '2021-10-28 23:52:51', 2),
(24, 6, 51, '2021-11-03 01:55:41', 2),
(25, 5, 61, '2021-11-15 02:53:22', 2),
(26, 5, 54, '2021-12-06 00:49:51', 2),
(27, 13, 52, '2021-11-17 22:26:59', 2),
(28, 13, 54, '2021-11-30 03:58:01', 2),
(29, 13, 62, '2021-11-17 22:26:59', 2),
(30, 13, 61, '2021-11-17 23:23:30', 1),
(31, 13, 51, '2021-11-17 23:24:04', 1),
(32, 14, 1, '2021-11-21 04:00:15', 2),
(33, 14, 51, '2021-11-21 04:00:15', 2),
(34, 14, 54, '2021-11-30 03:58:06', 2),
(35, 15, 51, '2021-11-21 04:40:51', 0),
(36, 15, 61, '2021-11-21 04:32:01', 1),
(37, 16, 51, '2021-11-21 05:04:57', 0),
(38, 16, 52, '2021-11-21 04:49:56', 1),
(39, 16, 54, '2021-11-21 04:55:17', 1),
(40, 16, 61, '2021-11-21 05:07:38', 0),
(41, 17, 51, '2021-11-21 05:08:29', 1),
(42, 17, 52, '2021-11-21 05:08:40', 1),
(43, 17, 54, '2021-11-21 05:13:11', 1),
(44, 18, 51, '2021-11-22 01:03:06', 1),
(45, 18, 54, '2021-11-22 01:09:13', 1),
(46, 19, 51, '2021-11-22 18:06:18', 1),
(47, 19, 52, '2021-11-22 18:06:57', 1),
(48, 20, 51, '2021-11-22 18:39:11', 1),
(49, 20, 52, '2021-11-22 18:39:14', 1),
(50, 20, 54, '2021-11-22 18:20:00', 0),
(51, 20, 61, '2021-11-22 18:22:12', 0),
(52, 5, 53, '2021-12-13 00:20:50', 0),
(53, 6, 53, '2021-12-13 00:26:56', 2),
(54, 6, 52, '2021-12-06 00:53:56', 2),
(55, 5, 52, '2021-12-06 00:49:51', 2),
(56, 5, 62, '2021-12-06 00:52:32', 2),
(57, 6, 54, '2021-12-06 00:53:56', 2),
(58, 6, 62, '2021-12-06 00:53:57', 2),
(59, 6, 60, '2021-12-13 00:26:56', 2),
(60, 6, 49, '2021-12-13 00:26:56', 2),
(61, 5, 63, '2021-12-26 23:00:01', 2),
(62, 5, 49, '2021-12-26 23:00:01', 2);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `producto`
--

CREATE TABLE `producto` (
  `idproducto` int(11) NOT NULL,
  `nombrePro` varchar(100) NOT NULL,
  `descripcionPro` text NOT NULL,
  `precioPro` decimal(11,2) NOT NULL,
  `stockPro` int(11) DEFAULT NULL,
  `fechaPro` datetime DEFAULT NULL,
  `rutaPro` varchar(100) DEFAULT NULL,
  `estadoPro` int(11) DEFAULT NULL,
  `categoriaPro` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `producto`
--

INSERT INTO `producto` (`idproducto`, `nombrePro`, `descripcionPro`, `precioPro`, `stockPro`, `fechaPro`, `rutaPro`, `estadoPro`, `categoriaPro`) VALUES
(1, 'Filetitos', 'Tenemos Los Filetitos De Pollo Mas Ricos Del Pais', '2400.00', 9, '2021-09-03 23:49:21', 'filetitos', 1, 1),
(2, 'Free Frutilla', 'Contemple los yogures free de sabor frutilla', '245.00', 15, '2021-09-04 21:22:13', 'free-frutilla', 1, 2),
(3, 'Tricolor Carozzi', 'Sera una de las marcas de fideos mas ricos del pais', '680.00', 10, '2021-09-04 21:27:58', 'tricolor-carozzi', 1, 6),
(4, 'Manzanas', 'tenemos las manzanas mas ricas del Pais !!', '400.00', 5, '2021-09-06 01:08:27', 'manzanas', 1, 3),
(5, 'Platanos', 'tenemos los mejores plátanos de la comuna', '450.00', 3, '2021-09-14 00:44:06', 'platanos', 1, 3),
(47, 'Leche Cholotada', 'Sera La Marca Principal De Chocolatadas', '450.00', 11, '2021-09-21 20:42:44', 'leche-cholotada', 1, 2),
(48, 'ADGF', '', '25.00', 7, '2021-09-30 01:19:07', 'adgf', 2, 10),
(49, 'YOGU45', '', '28.00', 13, '2021-10-03 21:06:47', 'yogu45', 2, 10),
(50, 'Uvas Morada', 'Se Tendrán A Las Uvas Mas Ricas Del Pis', '500.00', 14, '2021-10-03 22:10:43', 'uvas-morada', 1, 3),
(51, 'Super-Pollo', 'Sera esta la marca principal de los pollos a vender', '3200.00', 7, '2021-10-03 22:13:49', 'super-pollo', 1, 1),
(52, 'Tiritas-Pollo', 'tenemos las tiritas de pollo mas ricas del pais', '2200.00', 12, '2021-10-03 22:18:22', 'tiritas-pollo', 1, 1),
(53, 'Pepinos', 'serán los pepinos mas aguados y ricos del pais', '550.00', 13, '2021-10-03 22:22:27', 'pepinos', 1, 4),
(54, 'Peras', 'Serán estas las peras mas jugosas del pais', '450.00', 18, '2021-10-03 22:27:19', 'peras', 1, 3),
(55, 'YOGU67', '', '25.00', 23, '2021-10-12 19:31:28', 'yogu67', 1, 10),
(56, 'MIAU', '', '30.00', 17, '2021-10-16 20:15:56', 'miau', 1, 10),
(57, 'RFTE', '', '20.00', 12, '2021-10-16 20:17:37', 'rfte', 1, 10),
(58, 'DFDF', '', '12.00', 12, '2021-10-16 20:18:02', 'dfdf', 1, 10),
(59, 'Piña', 'será esta las piñas mas jugosas del pais', '2000.00', 15, '2021-11-04 18:50:09', 'pina', 1, 3),
(60, 'Coliflor', 'Sera Esta Una De Las Verduras Mas Sanas', '890.00', 15, '2021-11-08 13:58:29', 'coliflor', 1, 4),
(61, 'Enguaje Bucal', 'Será Esta Marca Para Los Enjuagues Bocales', '2300.00', 15, '2021-11-08 14:06:06', 'enguaje-bucal', 1, 5),
(62, 'PERIQUIN', '', '20.00', 10, '2021-11-17 19:21:46', 'periquin', 2, 10),
(63, 'Galletas Selz', 'Sera Las Galletas Mas Ricas Del Pais', '1300.00', 10, '2021-11-24 19:50:47', 'galletas-selz', 1, 7),
(64, 'TPS43', '', '15.00', 17, '2021-11-24 19:55:05', 'tps43', 1, 10);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rol`
--

CREATE TABLE `rol` (
  `idRol` int(11) NOT NULL,
  `nombreRol` varchar(45) NOT NULL,
  `estadoRol` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `rol`
--

INSERT INTO `rol` (`idRol`, `nombreRol`, `estadoRol`) VALUES
(1, 'Jefa', 1),
(2, 'Contador Auditor', 1),
(3, 'Analista-financiero', 1),
(4, 'Administrador de Empresas', 1),
(5, 'Cliente', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `suscripcion`
--

CREATE TABLE `suscripcion` (
  `idSuscripcion` int(11) NOT NULL,
  `personaSuscripcion` int(11) NOT NULL,
  `fechaSuscripcion` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `estadoSuscripcion` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `suscripcion`
--

INSERT INTO `suscripcion` (`idSuscripcion`, `personaSuscripcion`, `fechaSuscripcion`, `estadoSuscripcion`) VALUES
(2, 5, '2021-10-27 00:34:54', 2),
(3, 6, '2021-11-24 22:29:36', 2),
(4, 7, '2021-11-04 22:20:09', 1),
(5, 18, '2021-11-22 01:11:04', 1);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `tipopago`
--

CREATE TABLE `tipopago` (
  `idTipoPago` int(11) NOT NULL,
  `nombrePago` varchar(45) NOT NULL,
  `estadoTipoPago` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `tipopago`
--

INSERT INTO `tipopago` (`idTipoPago`, `nombrePago`, `estadoTipoPago`) VALUES
(1, 'Efectivo', 1),
(2, 'Cheque', 1),
(3, 'Deposito Bancario', 1),
(4, 'Tarjeta', 1);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `categoria`
--
ALTER TABLE `categoria`
  ADD PRIMARY KEY (`idcategoria`);

--
-- Indices de la tabla `comuna`
--
ALTER TABLE `comuna`
  ADD PRIMARY KEY (`idComuna`);

--
-- Indices de la tabla `detallecargocliente`
--
ALTER TABLE `detallecargocliente`
  ADD PRIMARY KEY (`id_detalleCargoCliente`),
  ADD KEY `fk_DetalleCargoCliente_Negocio1_idx` (`negocio_idDetalle`),
  ADD KEY `fk_DetalleCargoCliente_Persona1_idx` (`perdona_idDetalle`);

--
-- Indices de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD PRIMARY KEY (`id_detallePedido`),
  ADD KEY `fk_DetallePedido_Pedido1_idx` (`pedidoIdDetalle`),
  ADD KEY `fk_DetallePedido_producto1_idx` (`productoIdDetalle`);

--
-- Indices de la tabla `detallesuscripcion`
--
ALTER TABLE `detallesuscripcion`
  ADD PRIMARY KEY (`idDetalleSuscripcion`),
  ADD KEY `fk_DetalleSuscripcion_Suscripcion1_idx` (`suscripcionDetalle`),
  ADD KEY `fk_DetalleSuscripcion_producto1_idx` (`productoSuscrito`);

--
-- Indices de la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD PRIMARY KEY (`idDireccion`),
  ADD KEY `fk_Direccion_Comuna1_idx` (`comunaIdDireccion`);

--
-- Indices de la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD PRIMARY KEY (`idImagen`),
  ADD KEY `fk_Imagen_Producto1_idx` (`productoIDImg`);

--
-- Indices de la tabla `negocio`
--
ALTER TABLE `negocio`
  ADD PRIMARY KEY (`idNegocio`);

--
-- Indices de la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`idPedido`),
  ADD KEY `fk_Pedido_TipoPago1_idx` (`tipopagoPedido`),
  ADD KEY `fk_Pedido_Persona1_idx` (`personaIdPedido`),
  ADD KEY `fk_Pedido_Direccion1_idx` (`direccionPedido`);

--
-- Indices de la tabla `persona`
--
ALTER TABLE `persona`
  ADD PRIMARY KEY (`idPersona`),
  ADD KEY `fk_Persona_Rol1_idx` (`rolPersona`);

--
-- Indices de la tabla `preferencia`
--
ALTER TABLE `preferencia`
  ADD PRIMARY KEY (`idPreferencia`),
  ADD KEY `fk_Preferencias_Persona1_idx` (`personaPreferencia`),
  ADD KEY `fk_Preferencias_producto1_idx` (`productoPreferencia`);

--
-- Indices de la tabla `producto`
--
ALTER TABLE `producto`
  ADD PRIMARY KEY (`idproducto`),
  ADD KEY `fk_Producto_Categoria_idx` (`categoriaPro`);

--
-- Indices de la tabla `rol`
--
ALTER TABLE `rol`
  ADD PRIMARY KEY (`idRol`);

--
-- Indices de la tabla `suscripcion`
--
ALTER TABLE `suscripcion`
  ADD PRIMARY KEY (`idSuscripcion`),
  ADD KEY `fk_Suscripcion_Persona1_idx` (`personaSuscripcion`);

--
-- Indices de la tabla `tipopago`
--
ALTER TABLE `tipopago`
  ADD PRIMARY KEY (`idTipoPago`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `categoria`
--
ALTER TABLE `categoria`
  MODIFY `idcategoria` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT de la tabla `comuna`
--
ALTER TABLE `comuna`
  MODIFY `idComuna` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT de la tabla `detallecargocliente`
--
ALTER TABLE `detallecargocliente`
  MODIFY `id_detalleCargoCliente` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT de la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  MODIFY `id_detallePedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=89;

--
-- AUTO_INCREMENT de la tabla `detallesuscripcion`
--
ALTER TABLE `detallesuscripcion`
  MODIFY `idDetalleSuscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT de la tabla `direccion`
--
ALTER TABLE `direccion`
  MODIFY `idDireccion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT de la tabla `imagen`
--
ALTER TABLE `imagen`
  MODIFY `idImagen` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=86;

--
-- AUTO_INCREMENT de la tabla `negocio`
--
ALTER TABLE `negocio`
  MODIFY `idNegocio` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT de la tabla `pedido`
--
ALTER TABLE `pedido`
  MODIFY `idPedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT de la tabla `persona`
--
ALTER TABLE `persona`
  MODIFY `idPersona` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT de la tabla `preferencia`
--
ALTER TABLE `preferencia`
  MODIFY `idPreferencia` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT de la tabla `producto`
--
ALTER TABLE `producto`
  MODIFY `idproducto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT de la tabla `rol`
--
ALTER TABLE `rol`
  MODIFY `idRol` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `suscripcion`
--
ALTER TABLE `suscripcion`
  MODIFY `idSuscripcion` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de la tabla `tipopago`
--
ALTER TABLE `tipopago`
  MODIFY `idTipoPago` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `detallecargocliente`
--
ALTER TABLE `detallecargocliente`
  ADD CONSTRAINT `fk_DetalleCargoCliente_Negocio1` FOREIGN KEY (`negocio_idDetalle`) REFERENCES `negocio` (`idNegocio`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_DetalleCargoCliente_Persona1` FOREIGN KEY (`perdona_idDetalle`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detallepedido`
--
ALTER TABLE `detallepedido`
  ADD CONSTRAINT `fk_DetallePedido_Pedido1` FOREIGN KEY (`pedidoIdDetalle`) REFERENCES `pedido` (`idPedido`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_DetallePedido_producto1` FOREIGN KEY (`productoIdDetalle`) REFERENCES `producto` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `detallesuscripcion`
--
ALTER TABLE `detallesuscripcion`
  ADD CONSTRAINT `fk_DetalleSuscripcion_Suscripcion1` FOREIGN KEY (`suscripcionDetalle`) REFERENCES `suscripcion` (`idSuscripcion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_DetalleSuscripcion_producto1` FOREIGN KEY (`productoSuscrito`) REFERENCES `producto` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `direccion`
--
ALTER TABLE `direccion`
  ADD CONSTRAINT `fk_Direccion_Comuna1` FOREIGN KEY (`comunaIdDireccion`) REFERENCES `comuna` (`idComuna`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `imagen`
--
ALTER TABLE `imagen`
  ADD CONSTRAINT `fk_Imagen_Producto1` FOREIGN KEY (`productoIDImg`) REFERENCES `producto` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `fk_Pedido_Direccion1` FOREIGN KEY (`direccionPedido`) REFERENCES `direccion` (`idDireccion`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Pedido_Persona1` FOREIGN KEY (`personaIdPedido`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Pedido_TipoPago1` FOREIGN KEY (`tipopagoPedido`) REFERENCES `tipopago` (`idTipoPago`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `persona`
--
ALTER TABLE `persona`
  ADD CONSTRAINT `fk_Persona_Rol1` FOREIGN KEY (`rolPersona`) REFERENCES `rol` (`idRol`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `preferencia`
--
ALTER TABLE `preferencia`
  ADD CONSTRAINT `fk_Preferencias_Persona1` FOREIGN KEY (`personaPreferencia`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_Preferencias_producto1` FOREIGN KEY (`productoPreferencia`) REFERENCES `producto` (`idproducto`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `producto`
--
ALTER TABLE `producto`
  ADD CONSTRAINT `fk_Producto_Categoria` FOREIGN KEY (`categoriaPro`) REFERENCES `categoria` (`idcategoria`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Filtros para la tabla `suscripcion`
--
ALTER TABLE `suscripcion`
  ADD CONSTRAINT `fk_Suscripcion_Persona1` FOREIGN KEY (`personaSuscripcion`) REFERENCES `persona` (`idPersona`) ON DELETE NO ACTION ON UPDATE NO ACTION;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
