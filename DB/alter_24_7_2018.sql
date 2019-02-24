UPDATE `user_locations` SET `is_primary` = '0' WHERE `user_locations`.`id` = 6;
UPDATE `user_details` SET `last_name` = '' WHERE `user_details`.`id` = 2;
UPDATE `user_details` SET `first_name` = 'Debdas Bakshi' WHERE `user_details`.`id` = 2;
UPDATE `user_details` SET `last_name` = '' WHERE `user_details`.`id` = 3;
UPDATE `user_details` SET `first_name` = 'Ram Roy' WHERE `user_details`.`id` = 3;
UPDATE `user_details` SET `last_name` = '' WHERE `user_details`.`id` = 4;
UPDATE `user_details` SET `first_name` = 'Steve Brown' WHERE `user_details`.`id` = 4;

INSERT INTO `user_profiles` (`id`, `profile`, `description`) VALUES (NULL, 'Fitness Buddy', 'If user Fitness Level between 1 -3, then they are a Fitness Buddy');