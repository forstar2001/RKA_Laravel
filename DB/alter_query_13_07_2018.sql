ALTER TABLE `user_details` ADD `profile_picture` INT NOT NULL AFTER `video_link`;

ALTER TABLE `user_details` CHANGE `profile_picture` `profile_picture` VARCHAR(255) NOT NULL;