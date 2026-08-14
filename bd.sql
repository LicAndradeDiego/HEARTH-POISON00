-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema proyetocuba
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema proyetocuba
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `proyetocuba` DEFAULT CHARACTER SET utf8 ;
-- -----------------------------------------------------
-- Schema proyetocuba
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema proyetocuba
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `proyetocuba` DEFAULT CHARACTER SET utf8 ;
USE `proyetocuba` ;

-- -----------------------------------------------------
-- Table `proyetocuba`.`pedidos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proyetocuba`.`pedidos` (
  `id` INT(45) NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `fecha` DATE NULL DEFAULT NULL,
  `estado` VARCHAR(45) NULL DEFAULT NULL,
  `nombre_vendedor` VARCHAR(45) NULL DEFAULT NULL,
  `Direccion` VARCHAR(45) NULL,
  `Telefono` INT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `proyetocuba`.`ventas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proyetocuba`.`ventas` (
  `pedidos_id` INT NOT NULL,
  `costoTotal` INT NULL,
  `estado` VARCHAR(45) NULL,
  `metodo` VARCHAR(45) NULL,
  INDEX `fk_ventas_pedidos_idx` (`pedidos_id` ASC) ,
  CONSTRAINT `fk_ventas_pedidos`
    FOREIGN KEY (`pedidos_id`)
    REFERENCES `proyetocuba`.`pedidos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

USE `proyetocuba` ;

-- -----------------------------------------------------
-- Table `proyetocuba`.`usuario`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proyetocuba`.`usuario` (
  `CI` INT NOT NULL,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `direccion` VARCHAR(45) NULL DEFAULT NULL,
  `celular` VARCHAR(45) NULL DEFAULT NULL,
  `rol` VARCHAR(45) NULL DEFAULT NULL,
  `estado` VARCHAR(45) NULL DEFAULT NULL,
  PRIMARY KEY (`CI`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `proyetocuba`.`productos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proyetocuba`.`productos` (
  `codigo` INT NOT NULL,
  `nombre` VARCHAR(45) NULL DEFAULT NULL,
  `precio` INT NULL DEFAULT NULL,
  `descripcion` VARCHAR(100) NULL DEFAULT NULL,
  `stock` INT NULL DEFAULT NULL,
  `costo` INT NULL DEFAULT NULL,
  PRIMARY KEY (`codigo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `proyetocuba`.`carrito`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `proyetocuba`.`carrito` (
  `productos_codigo` INT NOT NULL,
  `pedidos_id` INT NOT NULL,
  `cantidad` INT NULL DEFAULT NULL,
  `costototal` INT NULL DEFAULT NULL,
  PRIMARY KEY (`productos_codigo`, `pedidos_id`),
  INDEX `fk_carrito_pedidos_idx` (`pedidos_id` ASC) ,
  INDEX `fk_carrito_productos_idx` (`productos_codigo` ASC) ,
  CONSTRAINT `fk_carrito_productos`
    FOREIGN KEY (`productos_codigo`)
    REFERENCES `proyetocuba`.`productos` (`codigo`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_carrito_pedidos`
    FOREIGN KEY (`pedidos_id`)
    REFERENCES `proyetocuba`.`pedidos` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;