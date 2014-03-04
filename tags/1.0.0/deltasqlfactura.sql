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
-- Constraints for table `factura`
--
ALTER TABLE `factura`
  ADD CONSTRAINT `factura_cuenta_id_cuenta_id` FOREIGN KEY (`cuenta_id`) REFERENCES `cuenta` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `factura_usuario_id_usuario_id` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`id`) ON DELETE CASCADE;

