ALTER TABLE `user_details` ADD `recent_login_latlng` VARCHAR(255) NULL AFTER `recent_login_location`;
ALTER TABLE `user_details` CHANGE `recent_login_location` `recent_login_location` VARCHAR(255) NULL DEFAULT NULL;
UPDATE `user_details` SET `recent_login_location` = NULL