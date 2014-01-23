-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 23, 2014 at 08:42 AM
-- Server version: 5.5.34
-- PHP Version: 5.3.10-1ubuntu3.9

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `wwwbunny_masto`
--

-- --------------------------------------------------------

--
-- Table structure for table `actividades`
--

CREATE TABLE IF NOT EXISTS `actividades` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) NOT NULL,
  `costo` float(6,2) NOT NULL,
  `horario` enum('mañana','tarde','mañana y tarde') DEFAULT NULL,
  `md_news_letter_group_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `md_news_letter_group_id_idx` (`md_news_letter_group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `billetera`
--

CREATE TABLE IF NOT EXISTS `billetera` (
  `id` int(11) NOT NULL DEFAULT '0',
  `credito` bigint(20) DEFAULT NULL,
  `deuda` bigint(20) DEFAULT NULL,
  `impuesto` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cobro`
--

CREATE TABLE IF NOT EXISTS `cobro` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cuenta_id` int(11) NOT NULL,
  `fecha` date NOT NULL,
  `monto` float(12,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cuenta_id_idx` (`cuenta_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `costos`
--

CREATE TABLE IF NOT EXISTS `costos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `matricula` float(6,2) NOT NULL,
  `matutino` float(6,2) NOT NULL,
  `vespertino` float(6,2) NOT NULL,
  `doble_horario` float(6,2) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cuenta`
--

CREATE TABLE IF NOT EXISTS `cuenta` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `cuentapadre`
--

CREATE TABLE IF NOT EXISTS `cuentapadre` (
  `cuenta_id` int(11) NOT NULL DEFAULT '0',
  `progenitor_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cuenta_id`,`progenitor_id`),
  KEY `cuentapadre_progenitor_id_progenitor_id` (`progenitor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cuentausuario`
--

CREATE TABLE IF NOT EXISTS `cuentausuario` (
  `cuenta_id` int(11) NOT NULL DEFAULT '0',
  `usuario_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cuenta_id`,`usuario_id`),
  KEY `cuentausuario_usuario_id_usuario_id` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `descuentos`
--

CREATE TABLE IF NOT EXISTS `descuentos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `cantidad_de_hermanos` bigint(20) NOT NULL,
  `porcentaje` bigint(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cantidad_de_hermanos` (`cantidad_de_hermanos`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `emails`
--

CREATE TABLE IF NOT EXISTS `emails` (
  `id` int(11) NOT NULL DEFAULT '0',
  `type` varchar(32) NOT NULL,
  `from_name` varchar(64) NOT NULL,
  `from_mail` varchar(64) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `type_index_idx` (`type`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `exoneracion`
--

CREATE TABLE IF NOT EXISTS `exoneracion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `mes` enum('1','2','3','4','5','6','7','8','9','10','11','12') DEFAULT NULL,
  `fecha` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `usuario_id_idx` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `factura`
--

CREATE TABLE IF NOT EXISTS `factura` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `costo_turno` float(12,2) NOT NULL DEFAULT '0.00',
  `costo_actividad` float(12,2) NOT NULL DEFAULT '0.00',
  `costo_matricula` float(12,2) NOT NULL DEFAULT '0.00',
  `descuento_hermano` float(12,2) NOT NULL DEFAULT '0.00',
  `descuento_alumno` float(12,2) NOT NULL DEFAULT '0.00',
  `total` float(12,2) NOT NULL DEFAULT '0.00',
  `month` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `recargo_atraso` float(12,2) NOT NULL DEFAULT '0.00',
  `porcentaje_atraso` float(6,2) NOT NULL DEFAULT '0.00',
  `pago` tinyint(4) NOT NULL DEFAULT '0',
  `cancelado` tinyint(4) NOT NULL DEFAULT '0',
  `cuenta_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `cuenta_id_idx` (`cuenta_id`),
  KEY `usuario_id_idx` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `hermanos`
--

CREATE TABLE IF NOT EXISTS `hermanos` (
  `usuario_from` int(11) NOT NULL DEFAULT '0',
  `usuario_to` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usuario_from`,`usuario_to`),
  KEY `hermanos_usuario_to_usuario_id` (`usuario_to`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `md_blocked_users`
--

CREATE TABLE IF NOT EXISTS `md_blocked_users` (
  `md_user_id` int(11) NOT NULL DEFAULT '0',
  `reason` varchar(128) DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`md_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `md_content`
--

CREATE TABLE IF NOT EXISTS `md_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `md_user_id` int(11) NOT NULL,
  `object_class` varchar(128) NOT NULL,
  `object_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `md_user_id_idx` (`md_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_content_relation`
--

CREATE TABLE IF NOT EXISTS `md_content_relation` (
  `md_content_id_first` int(11) NOT NULL DEFAULT '0',
  `md_content_id_second` int(11) NOT NULL DEFAULT '0',
  `object_class_name` varchar(128) NOT NULL,
  `profile_name` varchar(128) DEFAULT NULL,
  PRIMARY KEY (`md_content_id_first`,`md_content_id_second`),
  KEY `md_content_relation_md_content_id_second_md_content_id` (`md_content_id_second`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `md_galeria`
--

CREATE TABLE IF NOT EXISTS `md_galeria` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `curso_verde` tinyint(1) DEFAULT '0',
  `curso_rojo` tinyint(1) DEFAULT '0',
  `curso_amarillo` tinyint(1) DEFAULT '0',
  `position` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md_galeria_position_sortable_idx` (`position`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_galeria_translation`
--

CREATE TABLE IF NOT EXISTS `md_galeria_translation` (
  `id` int(11) NOT NULL DEFAULT '0',
  `titulo` varchar(128) DEFAULT NULL,
  `descripcion` text NOT NULL,
  `lang` char(2) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`,`lang`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `md_i18_n_manage_classes`
--

CREATE TABLE IF NOT EXISTS `md_i18_n_manage_classes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `class_name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_media`
--

CREATE TABLE IF NOT EXISTS `md_media` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_class_name` varchar(128) NOT NULL,
  `object_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md_media_index_idx` (`object_class_name`,`object_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_media_album`
--

CREATE TABLE IF NOT EXISTS `md_media_album` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `md_media_id` int(11) DEFAULT NULL,
  `title` varchar(64) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `type` enum('Image','Video','File','Mixed') DEFAULT 'Mixed',
  `deleteallowed` tinyint(1) NOT NULL,
  `md_media_content_id` int(11) DEFAULT NULL,
  `counter_content` bigint(20) DEFAULT '0',
  PRIMARY KEY (`id`),
  UNIQUE KEY `md_media_album_title_index_idx` (`md_media_id`,`title`),
  KEY `md_media_content_id_idx` (`md_media_content_id`),
  KEY `md_media_id_idx` (`md_media_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_media_album_content`
--

CREATE TABLE IF NOT EXISTS `md_media_album_content` (
  `md_media_album_id` int(11) NOT NULL DEFAULT '0',
  `md_media_content_id` int(11) NOT NULL DEFAULT '0',
  `object_class_name` varchar(128) NOT NULL,
  `priority` bigint(20) NOT NULL,
  PRIMARY KEY (`md_media_album_id`,`md_media_content_id`),
  KEY `md_media_album_content_index_idx` (`priority`),
  KEY `md_media_album_content_md_media_content_id_md_media_content_id` (`md_media_content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `md_media_content`
--

CREATE TABLE IF NOT EXISTS `md_media_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `object_class_name` varchar(128) NOT NULL,
  `object_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `md_media_content_index_idx` (`object_class_name`,`object_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_media_file`
--

CREATE TABLE IF NOT EXISTS `md_media_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `filename` varchar(64) NOT NULL,
  `filetype` varchar(64) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_media_image`
--

CREATE TABLE IF NOT EXISTS `md_media_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `filename` varchar(64) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_media_issuu_video`
--

CREATE TABLE IF NOT EXISTS `md_media_issuu_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `documentid` text NOT NULL,
  `embed_code` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_media_video`
--

CREATE TABLE IF NOT EXISTS `md_media_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `filename` varchar(64) NOT NULL,
  `duration` varchar(64) NOT NULL,
  `type` varchar(64) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_media_vimeo_video`
--

CREATE TABLE IF NOT EXISTS `md_media_vimeo_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `vimeo_url` varchar(64) NOT NULL,
  `title` varchar(255) NOT NULL,
  `src` varchar(255) NOT NULL,
  `duration` varchar(64) NOT NULL,
  `description` text,
  `avatar` varchar(255) DEFAULT NULL,
  `avatar_width` tinyint(4) DEFAULT NULL,
  `avatar_height` tinyint(4) DEFAULT NULL,
  `author_name` varchar(255) DEFAULT NULL,
  `author_url` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_media_youtube_video`
--

CREATE TABLE IF NOT EXISTS `md_media_youtube_video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(64) NOT NULL,
  `src` varchar(255) NOT NULL,
  `code` varchar(64) NOT NULL,
  `duration` varchar(64) NOT NULL,
  `description` varchar(255) DEFAULT NULL,
  `path` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_newsletter_content`
--

CREATE TABLE IF NOT EXISTS `md_newsletter_content` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` text NOT NULL,
  `body` longblob NOT NULL,
  `send_counter` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_newsletter_content_sended`
--

CREATE TABLE IF NOT EXISTS `md_newsletter_content_sended` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `subject` text NOT NULL,
  `body` longblob NOT NULL,
  `send_counter` int(11) NOT NULL,
  `sending_date` datetime DEFAULT NULL,
  `sended` tinyint(1) DEFAULT '0',
  `for_status` smallint(6) DEFAULT '0',
  `md_newsletter_content_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `md_newsletter_content_id_idx` (`md_newsletter_content_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_newsletter_send`
--

CREATE TABLE IF NOT EXISTS `md_newsletter_send` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `md_news_letter_user_id` int(11) NOT NULL,
  `md_newsletter_content_sended_id` int(11) NOT NULL,
  `sending_date` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `md_news_letter_user_id_idx` (`md_news_letter_user_id`),
  KEY `md_newsletter_content_sended_id_idx` (`md_newsletter_content_sended_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_news_letter_group`
--

CREATE TABLE IF NOT EXISTS `md_news_letter_group` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_news_letter_group_sended`
--

CREATE TABLE IF NOT EXISTS `md_news_letter_group_sended` (
  `md_newsletter_group_id` int(11) NOT NULL DEFAULT '0',
  `md_newsletter_contend_sended_id` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`md_newsletter_group_id`,`md_newsletter_contend_sended_id`),
  KEY `mmmi_1` (`md_newsletter_contend_sended_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `md_news_letter_group_user`
--

CREATE TABLE IF NOT EXISTS `md_news_letter_group_user` (
  `md_newsletter_group_id` int(11) NOT NULL DEFAULT '0',
  `md_newsletter_user_id` int(11) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`md_newsletter_group_id`,`md_newsletter_user_id`),
  KEY `mmmi_3` (`md_newsletter_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `md_news_letter_user`
--

CREATE TABLE IF NOT EXISTS `md_news_letter_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `md_user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `md_user_id_idx` (`md_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_passport`
--

CREATE TABLE IF NOT EXISTS `md_passport` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `md_user_id` int(11) NOT NULL,
  `username` varchar(128) NOT NULL,
  `password` varchar(128) NOT NULL,
  `account_active` tinyint(4) NOT NULL DEFAULT '0',
  `account_blocked` tinyint(4) NOT NULL DEFAULT '0',
  `last_login` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `md_user_id_idx` (`md_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_passport_remember_key`
--

CREATE TABLE IF NOT EXISTS `md_passport_remember_key` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `md_passport_id` int(11) DEFAULT NULL,
  `remember_key` varchar(32) DEFAULT NULL,
  `ip_address` varchar(50) NOT NULL DEFAULT '',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`,`ip_address`),
  KEY `md_passport_id_idx` (`md_passport_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_user`
--

CREATE TABLE IF NOT EXISTS `md_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(128) NOT NULL,
  `super_admin` tinyint(4) NOT NULL DEFAULT '0',
  `culture` varchar(2) DEFAULT NULL,
  `deleted_at` datetime DEFAULT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_user_profile`
--

CREATE TABLE IF NOT EXISTS `md_user_profile` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(128) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `city` varchar(128) DEFAULT NULL,
  `country_code` varchar(2) DEFAULT 'UY',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `md_user_search`
--

CREATE TABLE IF NOT EXISTS `md_user_search` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `md_user_id` int(11) NOT NULL,
  `email` varchar(128) DEFAULT NULL,
  `username` varchar(128) DEFAULT NULL,
  `name` varchar(128) DEFAULT NULL,
  `last_name` varchar(128) DEFAULT NULL,
  `country_code` varchar(2) DEFAULT NULL,
  `avatar_src` text,
  `active` tinyint(1) DEFAULT '0',
  `blocked` tinyint(1) DEFAULT '0',
  `admin` tinyint(1) DEFAULT '0',
  `show_email` tinyint(1) DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  PRIMARY KEY (`id`),
  KEY `username_index_idx` (`username`),
  KEY `email_index_idx` (`email`),
  KEY `last_name_index_idx` (`last_name`),
  KEY `name_index_idx` (`name`),
  KEY `md_user_id_idx` (`md_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `pagos`
--

CREATE TABLE IF NOT EXISTS `pagos` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `price` bigint(20) NOT NULL,
  `mes` enum('1','2','3','4','5','6','7','8','9','10','11','12') DEFAULT NULL,
  `fecha` datetime NOT NULL,
  `out_of_date` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `usuario_id_idx` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `progenitor`
--

CREATE TABLE IF NOT EXISTS `progenitor` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) DEFAULT NULL,
  `direccion` varchar(128) DEFAULT NULL,
  `telefono` varchar(128) DEFAULT NULL,
  `celular` varchar(64) DEFAULT NULL,
  `mail` varchar(64) DEFAULT NULL,
  `clave` varchar(64) DEFAULT NULL,
  `md_user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `mail_index_idx` (`mail`),
  KEY `md_user_id_idx` (`md_user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usuario`
--

CREATE TABLE IF NOT EXISTS `usuario` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(64) NOT NULL,
  `apellido` varchar(64) NOT NULL,
  `fecha_nacimiento` datetime DEFAULT NULL,
  `anio_ingreso` bigint(20) DEFAULT NULL,
  `sociedad` varchar(64) DEFAULT NULL,
  `referencia_bancaria` varchar(64) NOT NULL,
  `emergencia_medica` varchar(64) DEFAULT NULL,
  `horario` enum('matutino','vespertino','doble_horario') DEFAULT NULL,
  `futuro_colegio` varchar(64) DEFAULT NULL,
  `descuento` bigint(20) DEFAULT NULL,
  `clase` enum('verde','amarillo','rojo') DEFAULT NULL,
  `egresado` tinyint(1) DEFAULT '0',
  `billetera_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `billetera_id_idx` (`billetera_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Table structure for table `usuario_actividades`
--

CREATE TABLE IF NOT EXISTS `usuario_actividades` (
  `usuario_id` int(11) NOT NULL DEFAULT '0',
  `actividad_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usuario_id`,`actividad_id`),
  KEY `usuario_actividades_actividad_id_actividades_id` (`actividad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `usuario_progenitor`
--

CREATE TABLE IF NOT EXISTS `usuario_progenitor` (
  `usuario_id` int(11) NOT NULL DEFAULT '0',
  `progenitor_id` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usuario_id`,`progenitor_id`),
  KEY `usuario_progenitor_progenitor_id_progenitor_id` (`progenitor_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `actividades`
--
ALTER TABLE `actividades`
  ADD CONSTRAINT `actividades_md_news_letter_group_id_md_news_letter_group_id` FOREIGN KEY (`md_news_letter_group_id`) REFERENCES `md_news_letter_group` (`id`);

--
-- Constraints for table `cobro`
--
ALTER TABLE `cobro`
  ADD CONSTRAINT `cobro_cuenta_id_cuenta_id` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cuentapadre`
--
ALTER TABLE `cuentapadre`
  ADD CONSTRAINT `cuentapadre_cuenta_id_cuenta_id` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cuentapadre_progenitor_id_progenitor_id` FOREIGN KEY (`progenitor_id`) REFERENCES `progenitor` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `cuentausuario`
--
ALTER TABLE `cuentausuario`
  ADD CONSTRAINT `cuentausuario_cuenta_id_cuenta_id` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `cuentausuario_usuario_id_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `exoneracion`
--
ALTER TABLE `exoneracion`
  ADD CONSTRAINT `exoneracion_usuario_id_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_cuenta_id_cuenta_id` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `factura_usuario_id_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `hermanos`
--
ALTER TABLE `hermanos`
  ADD CONSTRAINT `hermanos_usuario_from_usuario_id` FOREIGN KEY (`usuario_from`) REFERENCES `usuario` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `hermanos_usuario_to_usuario_id` FOREIGN KEY (`usuario_to`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `md_content`
--
ALTER TABLE `md_content`
  ADD CONSTRAINT `md_content_md_user_id_md_user_id` FOREIGN KEY (`md_user_id`) REFERENCES `md_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `md_content_relation`
--
ALTER TABLE `md_content_relation`
  ADD CONSTRAINT `md_content_relation_md_content_id_first_md_content_id` FOREIGN KEY (`md_content_id_first`) REFERENCES `md_content` (`id`),
  ADD CONSTRAINT `md_content_relation_md_content_id_second_md_content_id` FOREIGN KEY (`md_content_id_second`) REFERENCES `md_content` (`id`);

--
-- Constraints for table `md_galeria_translation`
--
ALTER TABLE `md_galeria_translation`
  ADD CONSTRAINT `md_galeria_translation_id_md_galeria_id` FOREIGN KEY (`id`) REFERENCES `md_galeria` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `md_media_album`
--
ALTER TABLE `md_media_album`
  ADD CONSTRAINT `md_media_album_md_media_content_id_md_media_content_id` FOREIGN KEY (`md_media_content_id`) REFERENCES `md_media_content` (`id`),
  ADD CONSTRAINT `md_media_album_md_media_id_md_media_id` FOREIGN KEY (`md_media_id`) REFERENCES `md_media` (`id`);

--
-- Constraints for table `md_media_album_content`
--
ALTER TABLE `md_media_album_content`
  ADD CONSTRAINT `md_media_album_content_md_media_album_id_md_media_album_id` FOREIGN KEY (`md_media_album_id`) REFERENCES `md_media_album` (`id`),
  ADD CONSTRAINT `md_media_album_content_md_media_content_id_md_media_content_id` FOREIGN KEY (`md_media_content_id`) REFERENCES `md_media_content` (`id`);

--
-- Constraints for table `md_newsletter_content_sended`
--
ALTER TABLE `md_newsletter_content_sended`
  ADD CONSTRAINT `mmmi_4` FOREIGN KEY (`md_newsletter_content_id`) REFERENCES `md_newsletter_content` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `md_newsletter_send`
--
ALTER TABLE `md_newsletter_send`
  ADD CONSTRAINT `md_newsletter_send_md_news_letter_user_id_md_news_letter_user_id` FOREIGN KEY (`md_news_letter_user_id`) REFERENCES `md_news_letter_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mmmi_5` FOREIGN KEY (`md_newsletter_content_sended_id`) REFERENCES `md_newsletter_content_sended` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `md_news_letter_group_sended`
--
ALTER TABLE `md_news_letter_group_sended`
  ADD CONSTRAINT `mmmi` FOREIGN KEY (`md_newsletter_group_id`) REFERENCES `md_news_letter_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mmmi_1` FOREIGN KEY (`md_newsletter_contend_sended_id`) REFERENCES `md_newsletter_content_sended` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `md_news_letter_group_user`
--
ALTER TABLE `md_news_letter_group_user`
  ADD CONSTRAINT `mmmi_2` FOREIGN KEY (`md_newsletter_group_id`) REFERENCES `md_news_letter_group` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `mmmi_3` FOREIGN KEY (`md_newsletter_user_id`) REFERENCES `md_news_letter_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `md_news_letter_user`
--
ALTER TABLE `md_news_letter_user`
  ADD CONSTRAINT `md_news_letter_user_md_user_id_md_user_id` FOREIGN KEY (`md_user_id`) REFERENCES `md_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `md_passport`
--
ALTER TABLE `md_passport`
  ADD CONSTRAINT `md_passport_md_user_id_md_user_id` FOREIGN KEY (`md_user_id`) REFERENCES `md_user` (`id`);

--
-- Constraints for table `md_passport_remember_key`
--
ALTER TABLE `md_passport_remember_key`
  ADD CONSTRAINT `md_passport_remember_key_md_passport_id_md_passport_id` FOREIGN KEY (`md_passport_id`) REFERENCES `md_passport` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `md_user_search`
--
ALTER TABLE `md_user_search`
  ADD CONSTRAINT `md_user_search_md_user_id_md_user_id` FOREIGN KEY (`md_user_id`) REFERENCES `md_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `pagos`
--
ALTER TABLE `pagos`
  ADD CONSTRAINT `pagos_usuario_id_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `progenitor`
--
ALTER TABLE `progenitor`
  ADD CONSTRAINT `progenitor_md_user_id_md_user_id` FOREIGN KEY (`md_user_id`) REFERENCES `md_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usuario`
--
ALTER TABLE `usuario`
  ADD CONSTRAINT `usuario_billetera_id_billetera_id` FOREIGN KEY (`billetera_id`) REFERENCES `billetera` (`id`);

--
-- Constraints for table `usuario_actividades`
--
ALTER TABLE `usuario_actividades`
  ADD CONSTRAINT `usuario_actividades_actividad_id_actividades_id` FOREIGN KEY (`actividad_id`) REFERENCES `actividades` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuario_actividades_usuario_id_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `usuario_progenitor`
--
ALTER TABLE `usuario_progenitor`
  ADD CONSTRAINT `usuario_progenitor_progenitor_id_progenitor_id` FOREIGN KEY (`progenitor_id`) REFERENCES `progenitor` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `usuario_progenitor_usuario_id_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
