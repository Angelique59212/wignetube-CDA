-- MySQL Script generated by MySQL Workbench
-- lun. 21 nov. 2022 12:48:26
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';

-- -----------------------------------------------------
-- Schema wignetube
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema wignetube
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `wignetube` DEFAULT CHARACTER SET utf8 ;
USE `wignetube` ;

-- -----------------------------------------------------
-- Table `wignetube`.`mdf58_role`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wignetube`.`mdf58_role` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `role_name` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wignetube`.`mdf58_user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wignetube`.`mdf58_user` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `validation_key` VARCHAR(110) NOT NULL,
  `valid` TINYINT(1) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `firstname` VARCHAR(150) NOT NULL,
  `lastname` VARCHAR(150) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `mdf58_role_fk` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) ,
  INDEX `fk_mdf58_user_mdf58_role1_idx` (`mdf58_role_fk` ASC) ,
  CONSTRAINT `fk_mdf58_user_mdf58_role1`
    FOREIGN KEY (`mdf58_role_fk`)
    REFERENCES `wignetube`.`mdf58_role` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;

-- -----------------------------------------------------
-- Table `wignetube`.`mdf58_video`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wignetube`.`mdf58_video` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` VARCHAR(255) NOT NULL,
  `content` VARCHAR(155) NULL,
  `mdf58_user_fk` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_mdf58_video_mdf58_user1_idx` (`mdf58_user_fk` ASC) ,
  CONSTRAINT `fk_mdf58_video_mdf58_user1`
    FOREIGN KEY (`mdf58_user_fk`)
    REFERENCES `wignetube`.`mdf58_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wignetube`.`mdf58_commentary`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wignetube`.`mdf58_commentary` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `content` VARCHAR(255) NOT NULL,
  `mdf58_user_fk` INT UNSIGNED NOT NULL,
  `mdf58_video_fk` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `fk_mdf58_commentary_mdf58_user1_idx` (`mdf58_user_fk` ASC) ,
  INDEX `fk_mdf58_commentary_mdf58_video1_idx` (`mdf58_video_fk` ASC) ,
  CONSTRAINT `fk_mdf58_commentary_mdf58_user1`
    FOREIGN KEY (`mdf58_user_fk`)
    REFERENCES `wignetube`.`mdf58_user` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_mdf58_commentary_mdf58_video1`
    FOREIGN KEY (`mdf58_video_fk`)
    REFERENCES `wignetube`.`mdf58_video` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `wignetube`.`mdf58_resetpassword`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `wignetube`.`mdf58_resetpassword` (
  `id` INT NOT NULL,
  `email` VARCHAR(150) NULL,
  `token` VARCHAR(50) NULL,
  `date-add` DATETIME NULL)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
