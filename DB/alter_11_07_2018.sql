UPDATE `user_profiles` SET `profile` = 'Repair Recovery Specalist' WHERE `user_profiles`.`id` = 4;

#########_Sauvik_11_07_2018_2:12_PM_Start_##########


CREATE TABLE `group_workout_info_locations` (
  `id` int(11) NOT NULL,
  `tag_title` varchar(255) DEFAULT NULL,
  `tag_desc` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `gym_memberships` (
  `id` int(11) NOT NULL,
  `tag_title` varchar(255) DEFAULT NULL,
  `tag_desc` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `outdoor_workout_locations` (
  `id` int(11) NOT NULL,
  `tag_title` varchar(255) DEFAULT NULL,
  `tag_desc` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `scheduled_races` (
  `id` int(11) NOT NULL,
  `tag_title` varchar(255) DEFAULT NULL,
  `tag_desc` longtext
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

ALTER TABLE `group_workout_info_locations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `gym_memberships`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `outdoor_workout_locations`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `scheduled_races`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `group_workout_info_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `gym_memberships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `outdoor_workout_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `scheduled_races`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;


  #########_Sauvik_11_07_2018_2:24_PM_End_##########



