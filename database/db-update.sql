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
ALTER TABLE `tbl_tax_rule_locations` CHANGE `taxruleloc_country_id` `taxruleloc_from_country_id` INT NOT NULL, CHANGE `taxruleloc_state_id` `taxruleloc_from_state_id` INT NOT NULL;
ALTER TABLE `tbl_tax_rule_locations` ADD `taxruleloc_to_country_id` INT NOT NULL AFTER `taxruleloc_from_state_id`, ADD `taxruleloc_to_state_id` INT NOT NULL AFTER `taxruleloc_to_country_id`;
ALTER TABLE `tbl_tax_rule_locations` DROP INDEX `taxruleloc_taxcat_id`;
ALTER TABLE `tbl_tax_rule_locations` ADD UNIQUE( `taxruleloc_taxcat_id`, `taxruleloc_from_country_id`, `taxruleloc_from_state_id`, `taxruleloc_to_country_id`, `taxruleloc_to_state_id`, `taxruleloc_type`, `taxruleloc_unique`);
-- --- Tax Module Update--- --