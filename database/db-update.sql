/* Renaming DPO payment gateway to Paygate. */
UPDATE `tbl_plugins` SET `plugin_identifier`='Paygate', `plugin_code`='Paygate' WHERE plugin_code = 'Dpo';
/* Renaming DPO payment gateway to Paygate. */

-- --- Dpo Payment Gateway--- --
INSERT IGNORE INTO `tbl_plugins` (`plugin_identifier`, `plugin_type`, `plugin_code`, `plugin_active`, `plugin_display_order`) VALUES ('Dpo', '13', 'Dpo', '0', '23');
-- --- Dpo Payment Gateway--- --

-- --- Easypost Shipping API--- --
INSERT IGNORE INTO `tbl_plugins` (`plugin_identifier`, `plugin_type`, `plugin_code`, `plugin_active`, `plugin_display_order`) VALUES ('EasyPost', '8', 'EasyPost', '0', '2');
-- --- Easypost Shipping API--- --


-- --- Tax Module Update --- --
ALTER TABLE `tbl_tax_rule_locations` CHANGE `taxruleloc_country_id` `taxruleloc_to_country_id` INT NOT NULL, CHANGE `taxruleloc_state_id` `taxruleloc_to_state_id` INT NOT NULL;
ALTER TABLE `tbl_tax_rule_locations` ADD `taxruleloc_from_country_id` INT NOT NULL AFTER `taxruleloc_taxcat_id`, ADD `taxruleloc_from_state_id` INT NOT NULL AFTER `taxruleloc_from_country_id`;
ALTER TABLE `tbl_tax_rule_locations` DROP INDEX `taxruleloc_taxcat_id`;
ALTER TABLE `tbl_tax_rule_locations` ADD UNIQUE( `taxruleloc_taxcat_id`, `taxruleloc_from_country_id`, `taxruleloc_from_state_id`, `taxruleloc_to_country_id`, `taxruleloc_to_state_id`, `taxruleloc_type`, `taxruleloc_unique`);
UPDATE `tbl_tax_rule_locations` SET `taxruleloc_from_country_id` = '-1'  and `taxruleloc_from_state_id` = '-1';

CREATE TABLE `tbl_tax_rule_rates` (
  `trr_taxrule_id` int NOT NULL,
  `trr_rate` decimal(10,2) NOT NULL,
  `trr_user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tbl_tax_rule_rates`
  ADD PRIMARY KEY (`trr_taxrule_id`,`trr_user_id`);

INSERT INTO tbl_tax_rule_rates (trr_taxrule_id, trr_rate ,trr_user_id) SELECT taxrule_id, taxrule_rate,0 FROM tbl_tax_rules;
ALTER TABLE tbl_tax_rules DROP taxrule_rate;
ALTER TABLE `tbl_tax_rule_details` ADD `taxruledet_user_id` INT NOT NULL AFTER `taxruledet_rate`;
ALTER TABLE `tbl_tax_rule_details` ADD UNIQUE( `taxruledet_taxrule_id`, `taxruledet_taxstr_id`, `taxruledet_user_id`);
ALTER TABLE `tbl_tax_rule_details` DROP `taxruledet_id`;
SELECT * FROM `tbl_language_labels` WHERE `label_key` LIKE 'LBL_Invalid_Combination_of_Country,_Type,_State'
-- --- Tax Module Update--- --