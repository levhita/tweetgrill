-- MySQL Workbench Synchronization
-- Generated: 2015-07-29 03:49
-- Model: New Model
-- Version: 1.0
-- Project: Name of the project
-- Author: levhita

SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;
SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;
SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='TRADITIONAL,ALLOW_INVALID_DATES';

CREATE TABLE IF NOT EXISTS `tweetgrill`.`grill` (
  `id_grill` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(45) NOT NULL,
  `unique_id` VARCHAR(10) NOT NULL,
  `secret` VARCHAR(25) NOT NULL,
  `enabled` ENUM('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id_grill`) )
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;

CREATE TABLE IF NOT EXISTS `tweetgrill`.`tweet` (
  `id_tweet` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
  `text` VARCHAR(255) NOT NULL ,
  `enabled` ENUM('0', '1') NOT NULL DEFAULT '1',
  `id_grill` INT(10) UNSIGNED NOT NULL,
  PRIMARY KEY (`id_tweet`) ,
  INDEX `fk_tweet_grill_idx` (`id_grill` ASC),
  CONSTRAINT `fk_tweet_grill`
    FOREIGN KEY (`id_grill`)
    REFERENCES `tweetgrill`.`grill` (`id_grill`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8
COLLATE = utf8_general_ci;


SET SQL_MODE=@OLD_SQL_MODE;
SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;
SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;
