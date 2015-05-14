#14th May
ALTER TABLE `money_transfer` ADD `tranaction_id` INT NOT NULL AFTER `from_user_id`, ADD INDEX (`tranaction_id`) ;

ALTER TABLE `money_transfer` ADD FOREIGN KEY (`tranaction_id`) REFERENCES `transaction`(`id`) ON DELETE CASCADE ON UPDATE CASCADE;

ALTER TABLE `transaction` CHANGE `actual_amount` `actual_amount` FLOAT NOT NULL, CHANGE `paid_amount` `paid_amount` FLOAT NOT NULL, CHANGE `total_rp` `total_rp` FLOAT NOT NULL, CHANGE `used_rp` `used_rp` FLOAT NOT NULL;

# Date: 7th May
ALTER TABLE `user` ADD `password` VARCHAR( 100 ) NOT NULL AFTER `name` ;

ALTER TABLE `mail` DROP FOREIGN KEY `mail_ibfk_1` ;

ALTER TABLE `mail` ADD CONSTRAINT `mail_ibfk_1` FOREIGN KEY ( `to_user_id` ) REFERENCES `hkbase`.`user` (
`id`
) ON DELETE CASCADE ON UPDATE NO ACTION ;

ALTER TABLE `mail` DROP FOREIGN KEY `mail_ibfk_2` ;

ALTER TABLE `mail` ADD CONSTRAINT `mail_ibfk_2` FOREIGN KEY ( `from_user_id` ) REFERENCES `hkbase`.`user` (
`id`
) ON DELETE CASCADE ON UPDATE NO ACTION ;

ALTER TABLE `mail` ADD `subject` VARCHAR( 255 ) NOT NULL AFTER `from_user_id` ;

ALTER TABLE `mail` ADD `attachment` VARCHAR( 255 ) NOT NULL AFTER `message` ;

ALTER TABLE `user` CHANGE `data_of_birth` `data_of_birth` DATE NULL, CHANGE `skype_id` `skype_id` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `facebook_id` `facebook_id` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `twitter_id` `twitter_id` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;

# Date:12 May

ALTER TABLE `user` ADD `parent` INT(11) NOT NULL AFTER `position`;

ALTER TABLE `user` ADD `activation_key` VARCHAR(255) NOT NULL AFTER `status`;

ALTER TABLE `user` CHANGE `password` `password` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

ALTER TABLE `user` CHANGE `master_pin` `master_pin` VARCHAR(255) NOT NULL;

ALTER TABLE `user` ADD `forget_key` VARCHAR(255) NOT NULL AFTER `activation_key`, ADD `forget_status` INT(11) NOT NULL AFTER `forget_key`;

# Date : 13 May

ALTER TABLE `user` CHANGE `data_of_birth` `date_of_birth` DATE NULL DEFAULT NULL;   

# Date : 14 May  Suraj

ALTER TABLE `genealogy` CHANGE `placement` `parent` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

# Date : 14 May  Suraj

ALTER TABLE `user` CHANGE `parent` `user_sponsor_id` INT(11) NOT NULL;





