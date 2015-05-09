# Date: 7th May
ALTER TABLE `user` ADD `password` VARCHAR( 100 ) NOT NULL AFTER `name` ;


ALTER TABLE `user` CHANGE `data_of_birth` `data_of_birth` DATE NULL, CHANGE `skype_id` `skype_id` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `facebook_id` `facebook_id` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL, CHANGE `twitter_id` `twitter_id` VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NULL;
