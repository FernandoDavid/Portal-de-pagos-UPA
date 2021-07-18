DROP DATABASE IF EXISTS `cursos_upa`;
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema cursos_upa
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `cursos_upa` DEFAULT CHARACTER SET utf8 ;
USE `cursos_upa` ;

-- -----------------------------------------------------
-- Table `cursos_upa`.`Inscritos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cursos_upa`.`Inscritos` (
  `idInscrito` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(45) NOT NULL,
  `correo` VARCHAR(45) NOT NULL,
  `telefono` VARCHAR(10) NOT NULL,
  `direc` VARCHAR(80) NOT NULL,
  `curp` VARCHAR(20) NOT NULL,
  `rfc` VARCHAR(15) NOT NULL,
  `sexo` CHAR(1) NULL,
  `est_civil` VARCHAR(15) NULL,
  `subs` TINYINT NULL,
  `pago` VARCHAR(45) NULL,
  `rev1` TINYINT NULL,
  `rev2` TINYINT NULL,
  `idCurso` INT NOT NULL,
  PRIMARY KEY (`idInscrito`),
  CONSTRAINT `fk_Inscritos_Cursos1`
    FOREIGN KEY (`idCurso`)
    REFERENCES `cursos_upa`.`Cursos` (`idCurso`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `cursos_upa`.`Cursos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cursos_upa`.`Cursos` (
  `idCurso` INT NOT NULL AUTO_INCREMENT,
  `curso` VARCHAR(60) NOT NULL,
  `desc` TEXT(255) NULL,
  `instructor` VARCHAR(45) NOT NULL,
  `fec_inicio` DATE NOT NULL,
  `fec_fin` DATE NOT NULL,
  `hora_inicio` TIME NOT NULL,
  `hora_fin` TIME NOT NULL,
  `cupo` INT NOT NULL,
  `status` TINYINT NOT NULL,
  `precio` DECIMAL(12,2) NOT NULL,
  `lugar` VARCHAR(45) NOT NULL,
  `descto` INT NOT NULL,
  PRIMARY KEY (`idCurso`)
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `cursos_upa`.`Admins`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cursos_upa`.`Admins` (
  `correo` VARCHAR(45) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  `depto` VARCHAR(45) NOT NULL,
  `telefono` VARCHAR(10) NOT NULL,
  `pwd` VARCHAR(25) NOT NULL,
  PRIMARY KEY (`correo`)
)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `cursos_upa`.`Alumnos`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `cursos_upa`.`Alumnos` (
  `curp` VARCHAR(45) NOT NULL,
  `matricula` VARCHAR(45) NOT NULL,
  `nombre` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`curp`)
)
ENGINE = InnoDB;

SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

DROP USER IF EXISTS 'Cursos-upa'@'localhost';
CREATE USER 'Cursos-upa'@'localhost' IDENTIFIED BY '123456';
GRANT ALL PRIVILEGES ON cursos_upa.* TO 'Cursos-upa'@'localhost';