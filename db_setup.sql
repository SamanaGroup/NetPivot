SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE SCHEMA IF NOT EXISTS `NetPivot` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci ;
USE `NetPivot` ;

-- -----------------------------------------------------
-- Table `NetPivot`.`users`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `NetPivot`.`users` ;

CREATE TABLE IF NOT EXISTS `NetPivot`.`users` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `password` VARCHAR(60) NULL,
  `type` VARCHAR(45) NULL,
  `max_files` INT NULL,
  `max_conversions` INT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `name_UNIQUE` (`name` ASC))
ENGINE = InnoDB;

INSERT INTO users(id,name,password,type,max_files,max_conversions) VALUES (1,`admin`,`$2y$10$XEAw/cVMGTy4H8flaMjpLesrkZVlRo1ZVC0fm6FjHlGTWul5vh2Ae`,`Administrator`,100,100);


-- -----------------------------------------------------
-- Table `NetPivot`.`files`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `NetPivot`.`files` ;

CREATE TABLE IF NOT EXISTS `NetPivot`.`files` (
  `uuid` VARCHAR(36) NOT NULL,
  `filename` VARCHAR(45) NULL,
  `upload_time` DATETIME NULL,
  `users_id` INT NOT NULL,
  PRIMARY KEY (`uuid`),
  UNIQUE INDEX `uuid_UNIQUE` (`uuid` ASC),
  INDEX `fk_files_users_idx` (`users_id` ASC),
  CONSTRAINT `fk_files_users`
    FOREIGN KEY (`users_id`)
    REFERENCES `NetPivot`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `NetPivot`.`conversions`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `NetPivot`.`conversions` ;

CREATE TABLE IF NOT EXISTS `NetPivot`.`conversions` (
  `id_conversions` INT NOT NULL AUTO_INCREMENT,
  `users_id` INT NOT NULL,
  `time_conversion` DATETIME NOT NULL,
  `files_uuid` VARCHAR(36) NOT NULL,
  `converted_file` VARCHAR(60) NOT NULL,
  PRIMARY KEY (`id_conversions`),
  INDEX `fk_conversions_users1_idx` (`users_id` ASC),
  UNIQUE INDEX `id_conversions_UNIQUE` (`id_conversions` ASC),
  INDEX `fk_conversions_files1_idx` (`files_uuid` ASC),
  CONSTRAINT `fk_conversions_users1`
    FOREIGN KEY (`users_id`)
    REFERENCES `NetPivot`.`users` (`id`)
    ON DELETE CASCADE
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_conversions_files1`
    FOREIGN KEY (`files_uuid`)
    REFERENCES `NetPivot`.`files` (`uuid`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `NetPivot`.`settings`
-- -----------------------------------------------------
DROP TABLE IF EXISTS `NetPivot`.`settings` ;

CREATE TABLE IF NOT EXISTS `NetPivot`.`settings` (
  `host_name` INT NOT NULL,
  `timezone` VARCHAR(45) NULL,
  `files_path` VARCHAR(45) NULL,
  PRIMARY KEY (`host_name`))
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;

USE mysql;
INSERT INTO user (Host,User,Password) VALUES('localhost','demonio',PASSWORD('password'));
FLUSH PRIVILEGES;

INSERT INTO db (Host,Db,User,Select_priv,Insert_priv,Update_priv,Delete_priv,Create_priv,Drop_priv) VALUES ('localhost','NetPivot','demonio','Y','Y','Y','Y','Y','N');
FLUSH PRIVILEGES;