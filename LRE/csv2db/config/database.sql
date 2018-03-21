CREATE TABLE IF NOT EXISTS `charging_policies` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `ts_id` bigint(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `charging_duration` varchar(255) DEFAULT NULL,
  `day_duration` varchar(255) DEFAULT NULL,
  `room_based` tinyint(1) DEFAULT NULL,
  `day_overlap` tinyint(1) DEFAULT NULL,
  `capacity` varchar(255) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `ts_id` (`ts_id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `contracts` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `ts_id` bigint(12) NOT NULL,
  `service_id` bigint(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`service_id`),
  KEY `service_id` (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;


CREATE TABLE IF NOT EXISTS `contract_periods` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `ts_id` bigint(12) NOT NULL,
  `contract_id` bigint(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `contract_id` (`contract_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `currencies` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `code` varchar(12) NOT NULL,
  `name` varchar(25) NOT NULL,
  `symbol` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `code` (`code`),
  UNIQUE KEY `name` (`name`),
  UNIQUE KEY `symbol` (`symbol`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;



CREATE TABLE IF NOT EXISTS `exchange_rates` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `from_currency` varchar(12) NOT NULL,
  `to_currency` varchar(12) NOT NULL,
  `rate` float NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;


CREATE TABLE IF NOT EXISTS `meals` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;


CREATE TABLE IF NOT EXISTS `meal_options` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `service_option_id` bigint(12) NOT NULL,
  `meal_id` bigint(12) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_option_id` (`service_option_id`),
  KEY `meal_id` (`meal_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;


CREATE TABLE IF NOT EXISTS `migrations` (
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;


CREATE TABLE IF NOT EXISTS `occupancies` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `name` varchar(25) NOT NULL,
  `max_adults` int(12) NOT NULL,
  `max_children` int(12) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;


CREATE TABLE IF NOT EXISTS `policy_price_bands` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `service_policy_id` bigint(12) NOT NULL,
  `price_band_id` bigint(12) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_policy_id` (`service_policy_id`),
  KEY `price_band_id` (`price_band_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;


CREATE TABLE IF NOT EXISTS `prices` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `priceable_id` bigint(12) NOT NULL,
  `priceable_type` varchar(255) NOT NULL,
  `season_period_id` bigint(12) NOT NULL,
  `service_id` bigint(12) NOT NULL,
  `buy_price` decimal(10,2) NOT NULL,
  `sell_price` decimal(10,2) NOT NULL,
  `has_details` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `price` (`service_id`,`priceable_id`,`priceable_type`,`season_period_id`,`buy_price`,`sell_price`),
  KEY `season_period_id` (`season_period_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;


CREATE TABLE IF NOT EXISTS `price_bands` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `min` int(10) DEFAULT '0',
  `max` int(10) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;


CREATE TABLE IF NOT EXISTS `regions` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `ts_id` bigint(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` bigint(12) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;



CREATE TABLE IF NOT EXISTS `seasons` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `ts_id` bigint(12) NOT NULL,
  `contract_period_id` bigint(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`,`contract_period_id`),
  KEY `contract_period_id` (`contract_period_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;



CREATE TABLE IF NOT EXISTS `season_periods` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `season_id` bigint(12) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `season_id` (`season_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;



CREATE TABLE IF NOT EXISTS `services` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `ts_id` bigint(12) NOT NULL,
  `short_name` varchar(25) DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `service_type_id` bigint(12) NOT NULL,
  `region_id` bigint(12) NOT NULL,
  `supplier_id` bigint(12) NOT NULL,
  `currency_id` bigint(12) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_type_id` (`service_type_id`),
  KEY `region_id` (`region_id`),
  KEY `supplier_id` (`supplier_id`),
  KEY `currency_id` (`currency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;



CREATE TABLE IF NOT EXISTS `service_extras` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `ts_id` bigint(12) NOT NULL,
  `service_id` bigint(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mandatory` tinyint(1) DEFAULT '0',
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;



CREATE TABLE IF NOT EXISTS `service_options` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `ts_id` bigint(12) NOT NULL,
  `service_id` bigint(12) NOT NULL,
  `occupancy_id` bigint(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `service_extra_id` bigint(12) DEFAULT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`),
  KEY `service_extra_id` (`service_extra_id`),
  KEY `occupancy_id` (`occupancy_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;



CREATE TABLE IF NOT EXISTS `service_policies` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `price_id` bigint(12) NOT NULL,
  `charging_policy_id` bigint(12) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `price_id` (`price_id`),
  KEY `charging_policy_id` (`charging_policy_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;



CREATE TABLE IF NOT EXISTS `service_types` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `ts_id` bigint(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;



CREATE TABLE IF NOT EXISTS `suppliers` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `ts_id` bigint(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text,
  `region_id` bigint(12) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `name_1` (`name`,`region_id`),
  KEY `region_id` (`region_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;



CREATE TABLE IF NOT EXISTS `week_prices` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `price_id` bigint(12) NOT NULL,
  `monday` tinyint(1) DEFAULT '0',
  `tuesday` tinyint(1) DEFAULT '0',
  `wednesday` tinyint(1) DEFAULT '0',
  `thursday` tinyint(1) DEFAULT '0',
  `friday` tinyint(1) DEFAULT '0',
  `saturday` tinyint(1) DEFAULT '0',
  `sunday` tinyint(1) DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `price_id` (`price_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;


ALTER TABLE `contracts`
  ADD CONSTRAINT `contracts_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);


ALTER TABLE `contract_periods`
  ADD CONSTRAINT `contract_periods_ibfk_1` FOREIGN KEY (`contract_id`) REFERENCES `contracts` (`id`);


ALTER TABLE `meal_options`
  ADD CONSTRAINT `meal_options_ibfk_1` FOREIGN KEY (`service_option_id`) REFERENCES `service_options` (`id`),
  ADD CONSTRAINT `meal_options_ibfk_2` FOREIGN KEY (`meal_id`) REFERENCES `meals` (`id`);


ALTER TABLE `prices`
  ADD CONSTRAINT `prices_ibfk_1` FOREIGN KEY (`season_period_id`) REFERENCES `season_periods` (`id`),
  ADD CONSTRAINT `prices_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);


ALTER TABLE `seasons`
  ADD CONSTRAINT `seasons_ibfk_1` FOREIGN KEY (`contract_period_id`) REFERENCES `contract_periods` (`id`);


ALTER TABLE `season_periods`
  ADD CONSTRAINT `season_periods_ibfk_1` FOREIGN KEY (`season_id`) REFERENCES `seasons` (`id`);


ALTER TABLE `services`
  ADD CONSTRAINT `services_ibfk_1` FOREIGN KEY (`service_type_id`) REFERENCES `service_types` (`id`),
  ADD CONSTRAINT `services_ibfk_2` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`),
  ADD CONSTRAINT `services_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `suppliers` (`id`),
  ADD CONSTRAINT `services_ibfk_4` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`);


ALTER TABLE `service_extras`
  ADD CONSTRAINT `service_extras_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`);


ALTER TABLE `service_options`
  ADD CONSTRAINT `service_options_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `services` (`id`),
  ADD CONSTRAINT `service_options_ibfk_2` FOREIGN KEY (`service_extra_id`) REFERENCES `service_extras` (`id`),
  ADD CONSTRAINT `service_options_ibfk_3` FOREIGN KEY (`occupancy_id`) REFERENCES `occupancies` (`id`);


ALTER TABLE `service_policies`
  ADD CONSTRAINT `service_policies_ibfk_1` FOREIGN KEY (`price_id`) REFERENCES `prices` (`id`),
  ADD CONSTRAINT `service_policies_ibfk_2` FOREIGN KEY (`charging_policy_id`) REFERENCES `charging_policies` (`id`);


ALTER TABLE `service_price_bands`
  ADD CONSTRAINT `service_price_bands_ibfk_1` FOREIGN KEY (`price_id`) REFERENCES `prices` (`id`),
  ADD CONSTRAINT `service_price_bands_ibfk_2` FOREIGN KEY (`price_band_id`) REFERENCES `price_bands` (`id`);


ALTER TABLE `suppliers`
  ADD CONSTRAINT `suppliers_ibfk_1` FOREIGN KEY (`region_id`) REFERENCES `regions` (`id`);

# ========================
ALTER TABLE `service_options` ADD `is_default` ENUM( 'YES', 'NO' ) NOT NULL DEFAULT 'NO' AFTER `service_extra_id` ;
ALTER TABLE `service_extras` ADD `is_default` ENUM( 'YES', 'NO' ) NOT NULL DEFAULT 'NO' AFTER `mandatory` ;

ALTER TABLE `meal_options` ADD `season_period_id` BIGINT( 12 ) NOT NULL AFTER `meal_id` ;

ALTER TABLE `prices` ADD `margin` DECIMAL( 10, 4 ) NOT NULL AFTER `sell_price` ;

ALTER TABLE `service_options` ADD `is_default_updated_outofCSV` INT( 0 ) NOT NULL DEFAULT '0';

ALTER TABLE `season_periods` ADD `name` VARCHAR( 255 ) NOT NULL ;

INSERT INTO `charging_policies` ( `id` , `ts_id` , `name` , `charging_duration` , `day_duration` , `room_based` , `day_overlap` , `capacity` , `status` , `created_at` , `updated_at` )
VALUES (
'38', '', 'Fast Build', NULL , '1', '1', '', NULL , '1', NULL , NULL
);

ALTER TABLE `prices` ADD `currency_id` BIGINT( 13 ) NOT NULL AFTER `service_id` ;
ALTER TABLE `prices` ADD `meal_plan_id` BIGINT( 13 ) NOT NULL AFTER `currency_id` ;

ALTER TABLE `prices` ADD `season_period_start` DATE NOT NULL AFTER `has_details` ,
ADD `season_period_end` DATE NOT NULL AFTER `season_period_start` ;




ALTER TABLE `services` drop foreign key services_ibfk_4;

ALTER TABLE `prices`
  ADD CONSTRAINT `prices_ibfk_3` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`);

ALTER TABLE `week_prices` ADD `status` INT( 1 ) NOT NULL DEFAULT '1' AFTER `sunday` ;
ALTER TABLE `service_options` ADD `multiple_service_extra_id` VARCHAR( 255 ) NOT NULL ;
UPDATE `service_options` SET `status` = '0' WHERE `service_options`.`ts_id` =22291;


CREATE TABLE IF NOT EXISTS `margins` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `service_id` bigint(12) NOT NULL,
  `season_period_id` BIGINT(11) DEFAULT '0',
  `currency_id` BIGINT( 11 ) NOT NULL,
  `margin` DECIMAL( 10, 4 ) NOT NULL,  
  `premium` DECIMAL( 10, 4 ) NOT NULL,  
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;


/************** Missing regions from rates but present in TMB - start ***************/
/*
insert into regions (ts_id, name, parent_id) values('6825','Kalahari Desert','11450');
insert into regions (ts_id, name, parent_id) values('6896','Mauritius','11596');
insert into regions (ts_id, name, parent_id) values('7014','Self Organised Africa','11351');
insert into regions (ts_id, name, parent_id) values('7016','Self Organised South America','10984');
insert into regions (ts_id, name, parent_id) values('7015','Self Organised Asia','10985');
insert into regions (ts_id, name, parent_id) values('7012','Self Organised India','10983');
insert into regions (ts_id, name, parent_id) values('7020','Lago Viedma','10996');
insert into regions (ts_id, name, parent_id) values('7019','Glaciar Upsala','10996');
insert into regions (ts_id, name, parent_id) values('7021','JosÃ© Ignacio','11000');
insert into regions (ts_id, name, parent_id) values('7022','Nong Khiaw','10988');
insert into regions (ts_id, name, parent_id) values('7023','Hin Boun','10988');
insert into regions (ts_id, name, parent_id) values('7024','Thakek','10988');
insert into regions (ts_id, name, parent_id) values('7025','Savannakhet','10988');
insert into regions (ts_id, name, parent_id) values('7026','Pali','10983');
insert into regions (ts_id, name, parent_id) values('500243','Hotel Aditya','10983');
insert into regions (ts_id, name, parent_id) values('500431','wqeqweq','10996');
insert into regions (ts_id, name, parent_id) values('500438','City Name','10983');
insert into regions (ts_id, name, parent_id) values('500467','City name New French','10983');
insert into regions (ts_id, name, parent_id) values('500475','asdsad','10983');
insert into regions (ts_id, name, parent_id) values('500505','Bas','10983');
insert into regions (ts_id, name, parent_id) values('500506','Bas','10983');
insert into regions (ts_id, name, parent_id) values('500507','Bas','10983');
insert into regions (ts_id, name, parent_id) values('500508','Bas','10983');
insert into regions (ts_id, name, parent_id) values('500509','Bas','10983');
insert into regions (ts_id, name, parent_id) values('500510','Bas','10983');
insert into regions (ts_id, name, parent_id) values('500513','Bas','10983');
insert into regions (ts_id, name, parent_id) values('500519','Bas','10983');
insert into regions (ts_id, name, parent_id) values('500520','Test OCt','10996');
insert into regions (ts_id, name, parent_id) values('500521','Bas','10983');
insert into regions (ts_id, name, parent_id) values('500531','Dong Hoi','10995');
insert into regions (ts_id, name, parent_id) values('500532','Bas','10983');
insert into regions (ts_id, name, parent_id) values('500534','Bas','10983');
insert into regions (ts_id, name, parent_id) values('500535','Bas','10983');
insert into regions (ts_id, name, parent_id) values('500536','Bas','10983');
insert into regions (ts_id, name, parent_id) values('500587','Bangalore','10996');
insert into regions (ts_id, name, parent_id) values('500588','Mauritius test 1','10996');
insert into regions (ts_id, name, parent_id) values('500589','Mauritius *','10996');

/// code start
private function getSeasonIdForNewSeasonPeriod($seasonPeriod) {
       $regions = DB::table('regions_rates')->get();
       foreach($regions as $region) {
          $array1[] = $region->ts_id; 
       }
       $regions_tmb = DB::table('regions_tmb')->get();
       foreach($regions_tmb as $region) {
          $array2[] = $region->region_tsid; 
       }
       
       $arr = array_diff($array2, $array1);
       
       foreach($arr as $reg) {
           $regions_tmb = DB::table('regions_tmb')->where('region_tsid', '=', $reg )->get();
           $regions = DB::table('regions_rates')->where('ts_id', '=', $regions_tmb[0]->region_parent_id )->get();
            echo "insert into regions (ts_id, name, parent_id) values('".$regions_tmb[0]->region_tsid."','".trim($regions_tmb[0]->region_name)."','".$regions[0]->id."');<br>";
           
       }
}
/// code end
*/
/************** Missing regions from rates but present in TMB - start ***************/