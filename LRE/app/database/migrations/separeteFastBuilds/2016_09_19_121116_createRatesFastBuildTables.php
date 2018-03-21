<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatesFastBuildTables extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

            $sql = "
               

CREATE TABLE IF NOT EXISTS `fastbuild_regions` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `ts_id` bigint(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `parent_id` bigint(12) NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 ;

CREATE TABLE IF NOT EXISTS `fastbuild_contracts` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;


CREATE TABLE IF NOT EXISTS `fastbuild_contract_periods` (
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
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;


CREATE TABLE IF NOT EXISTS `fastbuild_prices` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `priceable_id` bigint(12) NOT NULL,
  `priceable_type` varchar(255) NOT NULL,
  `season_period_id` bigint(12) NOT NULL,
  `service_id` bigint(12) NOT NULL,
  `currency_id` bigint(13) NOT NULL,
  `meal_plan_id` bigint(13) NOT NULL,
  `buy_price` decimal(10,2) NOT NULL,
  `sell_price` decimal(10,2) NOT NULL,
  `margin` decimal(10,4) NOT NULL,
  `has_details` tinyint(1) DEFAULT '0',
  `season_period_start` date NOT NULL,
  `season_period_end` date NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `price` (`service_id`,`priceable_id`,`priceable_type`,`season_period_id`,`buy_price`,`sell_price`),
  KEY `season_period_id` (`season_period_id`),
  KEY `prices_ibfk_3` (`currency_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;


CREATE TABLE IF NOT EXISTS `fastbuild_seasons` (
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



CREATE TABLE IF NOT EXISTS `fastbuild_season_periods` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `season_id` bigint(12) NOT NULL,
  `start` date NOT NULL,
  `end` date NOT NULL,
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `name` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `season_id` (`season_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;


CREATE TABLE IF NOT EXISTS `fastbuild_services` (
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


CREATE TABLE IF NOT EXISTS `fastbuild_service_extras` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `ts_id` bigint(12) NOT NULL,
  `service_id` bigint(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `mandatory` tinyint(1) DEFAULT '0',
  `is_default` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;



CREATE TABLE IF NOT EXISTS `fastbuild_service_options` (
  `id` bigint(12) NOT NULL AUTO_INCREMENT,
  `ts_id` bigint(12) NOT NULL,
  `service_id` bigint(12) NOT NULL,
  `occupancy_id` bigint(12) NOT NULL,
  `name` varchar(255) NOT NULL,
  `service_extra_id` bigint(12) DEFAULT NULL,
  `is_default` enum('YES','NO') NOT NULL DEFAULT 'NO',
  `status` tinyint(1) DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `is_default_updated_outofCSV` int(11) NOT NULL DEFAULT '0',
  `multiple_service_extra_id` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `service_id` (`service_id`),
  KEY `service_extra_id` (`service_extra_id`),
  KEY `occupancy_id` (`occupancy_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8  ;



CREATE TABLE IF NOT EXISTS `fastbuild_service_policies` (
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



CREATE TABLE IF NOT EXISTS `fastbuild_suppliers` (
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


ALTER TABLE `fastbuild_contracts`
  ADD CONSTRAINT `fastbuild_contracts_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `fastbuild_services` (`id`);


ALTER TABLE `fastbuild_contract_periods`
  ADD CONSTRAINT `fastbuild_contract_periods_ibfk_1` FOREIGN KEY (`contract_id`) REFERENCES `fastbuild_contracts` (`id`);


ALTER TABLE `fastbuild_prices`
  ADD CONSTRAINT `fastbuild_prices_ibfk_1` FOREIGN KEY (`season_period_id`) REFERENCES `fastbuild_season_periods` (`id`),
  ADD CONSTRAINT `fastbuild_prices_ibfk_2` FOREIGN KEY (`service_id`) REFERENCES `fastbuild_services` (`id`),
  ADD CONSTRAINT `fastbuild_prices_ibfk_3` FOREIGN KEY (`currency_id`) REFERENCES `currencies` (`id`);


ALTER TABLE `fastbuild_seasons`
  ADD CONSTRAINT `fastbuild_seasons_ibfk_1` FOREIGN KEY (`contract_period_id`) REFERENCES `fastbuild_contract_periods` (`id`);


ALTER TABLE `fastbuild_season_periods`
  ADD CONSTRAINT `fastbuild_season_periods_ibfk_1` FOREIGN KEY (`season_id`) REFERENCES `fastbuild_seasons` (`id`);


ALTER TABLE `fastbuild_services`
  ADD CONSTRAINT `fastbuild_services_ibfk_1` FOREIGN KEY (`service_type_id`) REFERENCES `service_types` (`id`),
  ADD CONSTRAINT `fastbuild_services_ibfk_2` FOREIGN KEY (`region_id`) REFERENCES `fastbuild_regions` (`id`),
  ADD CONSTRAINT `fastbuild_services_ibfk_3` FOREIGN KEY (`supplier_id`) REFERENCES `fastbuild_suppliers` (`id`);


ALTER TABLE `fastbuild_service_extras`
  ADD CONSTRAINT `fastbuild_service_extras_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `fastbuild_services` (`id`);


ALTER TABLE `fastbuild_service_options`
  ADD CONSTRAINT `fastbuild_service_options_ibfk_1` FOREIGN KEY (`service_id`) REFERENCES `fastbuild_services` (`id`),
  ADD CONSTRAINT `fastbuild_service_options_ibfk_2` FOREIGN KEY (`service_extra_id`) REFERENCES `fastbuild_service_extras` (`id`),
  ADD CONSTRAINT `fastbuild_service_options_ibfk_3` FOREIGN KEY (`occupancy_id`) REFERENCES `occupancies` (`id`);


ALTER TABLE `fastbuild_service_policies`
  ADD CONSTRAINT `fastbuild_service_policies_ibfk_1` FOREIGN KEY (`price_id`) REFERENCES `fastbuild_prices` (`id`),
  ADD CONSTRAINT `fastbuild_service_policies_ibfk_2` FOREIGN KEY (`charging_policy_id`) REFERENCES `charging_policies` (`id`);


ALTER TABLE `fastbuild_suppliers`
  ADD CONSTRAINT `fastbuild_suppliers_ibfk_1` FOREIGN KEY (`region_id`) REFERENCES `fastbuild_regions` (`id`);



            ";
            
            DB::statement($sql);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{           
            Schema::drop('fastbuild_regions');
            Schema::drop('fastbuild_contracts');
            Schema::drop('fastbuild_contract_periods');
            Schema::drop('fastbuild_prices');
            Schema::drop('fastbuild_seasons');
            Schema::drop('season_periods');
            Schema::drop('fastbuild_services');            
            Schema::drop('fastbuild_service_extras');
            Schema::drop('fastbuild_service_options');
            Schema::drop('fastbuild_service_policies');
            Schema::drop('fastbuild_suppliers');
	}

}
