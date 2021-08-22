-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema cursos_upa
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema cursos_upa
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `cursos_upa` DEFAULT CHARACTER SET utf8 ;
USE `cursos_upa` ;

-- -----------------------------------------------------
-- Table `cursos_upa`.`Cursos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cursos_upa`.`Cursos` (
  `idCurso` INT NOT NULL AUTO_INCREMENT,
  `curso` VARCHAR(96) NOT NULL,
  `objetivo` TEXT(256) NOT NULL,
  `tipo` TINYINT NOT NULL,
  `instructor` VARCHAR(45) NOT NULL,
  `aula` VARCHAR(45) NOT NULL,
  `modalidad` TINYINT NOT NULL,
  `temario` TEXT(512) NULL,
  `flyer` VARCHAR(45) NOT NULL,
  `banner` VARCHAR(45) NOT NULL,
  `reg_inicio` DATE NOT NULL,
  `reg_fin` DATE NOT NULL,
  `fec_inicio` DATE NOT NULL,
  `fec_fin` DATE NOT NULL,
  `dia` VARCHAR(10) NOT NULL,
  `hora_inicio` TIME NOT NULL,
  `hora_fin` TIME NOT NULL,
  `cupo` INT NOT NULL,
  `precio` DOUBLE(10,2) NOT NULL,
  `desc` INT NOT NULL DEFAULT 0,
  PRIMARY KEY (`idCurso`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cursos_upa`.`Participantes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cursos_upa`.`Participantes` (
  `idParticipante` INT NOT NULL AUTO_INCREMENT,
  `correo` VARCHAR(45) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `direc` VARCHAR(80) NOT NULL,
  `telefono` VARCHAR(10) NOT NULL,
  `curp` VARCHAR(20) NOT NULL,
  `sexo` CHAR(1) NULL,
  `est_civil` VARCHAR(15) NULL,
  `subs` TINYINT NOT NULL,
  `idCurso` INT NOT NULL,
  PRIMARY KEY (`idParticipante`),
  CONSTRAINT `fk_Inscritos_Cursos`
    FOREIGN KEY (`idCurso`)
    REFERENCES `cursos_upa`.`Cursos` (`idCurso`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cursos_upa`.`Admins`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cursos_upa`.`Admins` (
  `correo` VARCHAR(45) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `depto` VARCHAR(25) NOT NULL,
  `pwd` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`correo`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cursos_upa`.`Facturas`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cursos_upa`.`Facturas` (
  `idParticipante` INT NOT NULL,
  `rfc` VARCHAR(15) NOT NULL,
  `cfdi` TINYINT(1) NOT NULL,
  `obs` TEXT(255) NULL,
  PRIMARY KEY (`idParticipante`),
  CONSTRAINT `fk_Facturas_Participantes1`
    FOREIGN KEY (`idParticipante`)
    REFERENCES `cursos_upa`.`Participantes` (`idParticipante`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cursos_upa`.`Pagos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cursos_upa`.`Pagos` (
  `idPago` INT NOT NULL AUTO_INCREMENT,
  `comprobante` VARCHAR(45) NULL,
  `pago` DECIMAL(10,2) NOT NULL,
  `desc` INT NOT NULL,
  `r1` VARCHAR(45) NOT NULL DEFAULT 0,
  `r2` VARCHAR(45) NOT NULL DEFAULT 0,
  `fec_r1` DATE NULL,
  `fec_r2` DATE NULL,
  `idParticipante` INT NOT NULL,
  PRIMARY KEY (`idPago`),
  CONSTRAINT `fk_Pagos_Participantes1`
    FOREIGN KEY (`idParticipante`)
    REFERENCES `cursos_upa`.`Participantes` (`idParticipante`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `cursos_upa`.`Alumnos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cursos_upa`.`Alumnos` (
  `curp` VARCHAR(20) NOT NULL,
  `tipo` VARCHAR(20) NOT NULL,
  PRIMARY KEY (`curp`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
