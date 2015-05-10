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

