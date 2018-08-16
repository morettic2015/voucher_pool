CREATE DATABASE `voucher_pool` /*!40100 DEFAULT CHARACTER SET latin1 */;

CREATE TABLE `recipient` (
  `id_recipient` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  PRIMARY KEY (`id_recipient`),
  UNIQUE KEY `email_UNIQUE` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


CREATE TABLE `special_offer` (
  `id_special_offer` bigint(20) NOT NULL AUTO_INCREMENT,
  `name` varchar(250) NOT NULL,
  `discount` float NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_special_offer`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `voucher_code` (
  `id_voucher_code` bigint(20) NOT NULL AUTO_INCREMENT,
  `token` varchar(16) NOT NULL,
  `expiration` datetime NOT NULL,
  `enabled` tinyint(4) NOT NULL DEFAULT '1',
  `activation_date` datetime DEFAULT NULL,
  `fk_recipient` bigint(20) DEFAULT NULL,
  `fk_special_offer` bigint(20) DEFAULT NULL,
  PRIMARY KEY (`id_voucher_code`),
  UNIQUE KEY `token_UNIQUE` (`token`),
  KEY `fk_recipient_id_key_idx` (`fk_recipient`),
  KEY `fk_offer_id_key_idx` (`fk_special_offer`),
  CONSTRAINT `fk_offer_id_key` FOREIGN KEY (`fk_special_offer`) REFERENCES `special_offer` (`id_special_offer`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_recipient_id_key` FOREIGN KEY (`fk_recipient`) REFERENCES `recipient` (`id_recipient`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

grant all on voucher_pool.* to 'voucher'@'%' identified by 'V@uch3rP00l_123';




