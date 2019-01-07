ALTER TABLE `#__grph_cities`
  ADD `is_capital` TINYINT NOT NULL DEFAULT '0' COMMENT 'Это столица региона' AFTER `region_id` ,
  ADD INDEX (`is_capital`);