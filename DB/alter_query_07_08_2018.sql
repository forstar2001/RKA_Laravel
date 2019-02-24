
ALTER TABLE `user_credentials` ADD `email_status` INT(11) NOT NULL DEFAULT '0' AFTER `otp`;
UPDATE `user_credentials` SET `email_status`= 1