-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema proyetocuba
-- -----------------------------------------------------

CREATE SCHEMA IF NOT EXISTS `proyetocuba` DEFAULT CHARACTER SET utf8;
USE `proyetocuba`;

-- -----------------------------------------------------
-- Table usuario
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `usuario` (
  `CI` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `direccion` VARCHAR(45) NULL,
  `celular` VARCHAR(45) NULL,
  `rol` VARCHAR(45) NULL,
  `estado` VARCHAR(45) NULL,
  PRIMARY KEY (`CI`)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table productos
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `productos` (
  `codigo` INT NOT NULL,
  `nombre` VARCHAR(45) NULL,
  `precio` INT NULL,
  `descripcion` VARCHAR(100) NULL,
  `stock` INT NULL,
  `costo` INT NULL,
  PRIMARY KEY (`codigo`)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table pedidos
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `pedidos` (
`id` INT(45) NOT NULL AUTO_INCREMENT,  `nombre` VARCHAR(45) NULL,
  `fecha` DATE NULL,
  `estado` VARCHAR(45) NULL,
  `nombre_vendedor` VARCHAR(45) NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB;

-- -----------------------------------------------------
-- Table carrito
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `carrito` (
  `productos_codigo` INT NOT NULL,
  `pedidos_id` INT NOT NULL,
  `cantidad` INT NULL,
  `costototal` INT NULL,

  PRIMARY KEY (`productos_codigo`, `pedidos_id`),

  INDEX `fk_carrito_pedidos_idx` (`pedidos_id` ASC),
  INDEX `fk_carrito_productos_idx` (`productos_codigo` ASC),

  CONSTRAINT `fk_carrito_productos`
    FOREIGN KEY (`productos_codigo`)
    REFERENCES `productos` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,

  CONSTRAINT `fk_carrito_pedidos`
    FOREIGN KEY (`pedidos_id`)
    REFERENCES `pedidos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION

) ENGINE=InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;