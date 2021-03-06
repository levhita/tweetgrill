-- MySQL Script generated by MySQL Workbench
-- dom 28 feb 2016 00:10:05 CST
-- Model: New Model    Version: 1.0
-- MySQL Workbench Forward Engineering

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

-- -----------------------------------------------------
-- Schema bocety
-- -----------------------------------------------------

-- -----------------------------------------------------
-- Schema bocety
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `bocety` DEFAULT CHARACTER SET utf8 ;
USE `bocety` ;

-- -----------------------------------------------------
-- Table `bocety`.`user`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bocety`.`user` (
  `id_user` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `email` VARCHAR(255) NOT NULL COMMENT '',
  `password_hash` VARCHAR(45) NOT NULL DEFAULT '' COMMENT '',
  `confirmed` ENUM('0', '1') NOT NULL DEFAULT '0' COMMENT '',
  `confirmation_secret` VARCHAR(25) NULL COMMENT '',
  PRIMARY KEY (`id_user`)  COMMENT '')
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bocety`.`bocety`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bocety`.`bocety` (
  `id_bocety` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `id_user` INT(10) UNSIGNED NOT NULL COMMENT '',
  `unique_id` VARCHAR(10) NOT NULL COMMENT '',
  `name` VARCHAR(22) NOT NULL COMMENT '',
  `description` VARCHAR(255) NOT NULL COMMENT '',
  `on_review` ENUM('0', '1') NOT NULL DEFAULT '1' COMMENT '',
  `on_review_secret` VARCHAR(25) NOT NULL COMMENT '',
  `published` ENUM('0', '1') NOT NULL DEFAULT '0' COMMENT '',
  `published_secret` VARCHAR(25) NULL COMMENT '',
  PRIMARY KEY (`id_bocety`)  COMMENT '',
  INDEX `fk_bocety_user1_idx` (`id_user` ASC)  COMMENT '',
  CONSTRAINT `fk_bocety_user1`
    FOREIGN KEY (`id_user`)
    REFERENCES `bocety`.`user` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8;


-- -----------------------------------------------------
-- Table `bocety`.`social_account`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bocety`.`social_account` (
  `id_social_account` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `id_user` INT UNSIGNED NOT NULL COMMENT '',
  `network` ENUM('twitter', 'facebook_fanpage') NOT NULL DEFAULT 'twitter' COMMENT '',
  `account` VARCHAR(45) NULL COMMENT '',
  `avatar_url` VARCHAR(255) NULL COMMENT '',
  PRIMARY KEY (`id_social_account`)  COMMENT '',
  INDEX `fk_social_account_user1_idx` (`id_user` ASC)  COMMENT '',
  CONSTRAINT `fk_social_account_user1`
    FOREIGN KEY (`id_user`)
    REFERENCES `bocety`.`user` (`id_user`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bocety`.`content`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bocety`.`content` (
  `id_content` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `id_bocety` INT(10) UNSIGNED NOT NULL COMMENT '',
  `id_social_account` INT(10) UNSIGNED NOT NULL COMMENT '',
  `text` VARCHAR(500) NOT NULL COMMENT '',
  `order` INT NOT NULL DEFAULT 0 COMMENT '',
  `on_review` ENUM('0', '1') NOT NULL DEFAULT '1' COMMENT '',
  `published` ENUM('0', '1') NOT NULL DEFAULT '1' COMMENT '',
  `date` DATETIME NULL COMMENT '',
  PRIMARY KEY (`id_content`)  COMMENT '',
  INDEX `fk_content_social_account1_idx` (`id_social_account` ASC)  COMMENT '',
  INDEX `fk_content_bocety1_idx` (`id_bocety` ASC)  COMMENT '',
  CONSTRAINT `fk_content_social_account1`
    FOREIGN KEY (`id_social_account`)
    REFERENCES `bocety`.`social_account` (`id_social_account`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
  CONSTRAINT `fk_content_bocety1`
    FOREIGN KEY (`id_bocety`)
    REFERENCES `bocety`.`bocety` (`id_bocety`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bocety`.`comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bocety`.`comment` (
  `id_comment` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `id_content` INT(10) UNSIGNED NOT NULL COMMENT '',
  `text` VARCHAR(500) NOT NULL DEFAULT '' COMMENT '',
  `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `author` VARCHAR(45) NULL COMMENT '',
  `ip` VARCHAR(16) NOT NULL DEFAULT '0.0.0.0' COMMENT '',
  PRIMARY KEY (`id_comment`)  COMMENT '',
  INDEX `fk_comment_content1_idx` (`id_content` ASC)  COMMENT '',
  CONSTRAINT `fk_comment_content1`
    FOREIGN KEY (`id_content`)
    REFERENCES `bocety`.`content` (`id_content`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


-- -----------------------------------------------------
-- Table `bocety`.`comment`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `bocety`.`comment` (
  `id_comment` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '',
  `id_content` INT(10) UNSIGNED NOT NULL COMMENT '',
  `text` VARCHAR(500) NOT NULL DEFAULT '' COMMENT '',
  `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '',
  `author` VARCHAR(45) NULL COMMENT '',
  `ip` VARCHAR(16) NOT NULL DEFAULT '0.0.0.0' COMMENT '',
  PRIMARY KEY (`id_comment`)  COMMENT '',
  INDEX `fk_comment_content1_idx` (`id_content` ASC)  COMMENT '',
  CONSTRAINT `fk_comment_content1`
    FOREIGN KEY (`id_content`)
    REFERENCES `bocety`.`content` (`id_content`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
