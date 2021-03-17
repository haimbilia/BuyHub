ALTER TABLE `tbl_shop_specifics` ADD `shop_pickup_interval` TINYINT(1) NOT NULL COMMENT 'In Hours' AFTER `shop_invoice_codes`;
INSERT INTO `tbl_configurations` (`conf_name`, `conf_val`, `conf_common`) VALUES
("CONF_LOADER", 1, 1) ON DUPLICATE KEY UPDATE conf_common = 1;
DELETE FROM tbl_language_labels WHERE label_key = "LBL_ADD_WALLET_CREDITS_[$]";

delete from tbl_extra_pages where epage_id = 44;
delete from tbl_extra_pages_lang where epagelang_epage_id = 44;


/* Bind all phone number fields with flag field. */
ALTER TABLE `tbl_addresses` CHANGE `addr_phone` `addr_phone` BIGINT NOT NULL;
ALTER TABLE `tbl_addresses` ADD `addr_phone_dcode` VARCHAR(50) NOT NULL AFTER `addr_country_id`;

ALTER TABLE `tbl_blog_contributions` CHANGE `bcontributions_author_phone` `bcontributions_author_phone` BIGINT NOT NULL;
ALTER TABLE `tbl_blog_contributions` ADD `bcontributions_author_phone_dcode` VARCHAR(50) NOT NULL AFTER `bcontributions_author_email`;

ALTER TABLE `tbl_order_products` CHANGE `op_shop_owner_phone` `op_shop_owner_phone` BIGINT NOT NULL;
ALTER TABLE `tbl_order_products` ADD `op_shop_owner_phone_dcode` VARCHAR(50) NOT NULL AFTER `op_shop_owner_email`;

ALTER TABLE `tbl_order_user_address` CHANGE `oua_phone` `oua_phone` BIGINT NOT NULL;
ALTER TABLE `tbl_order_user_address` ADD `oua_phone_dcode` VARCHAR(50) NOT NULL AFTER `oua_country_code_alpha3`;

ALTER TABLE `tbl_shops` CHANGE `shop_phone` `shop_phone` BIGINT NOT NULL;
ALTER TABLE `tbl_shops` ADD `shop_phone_dcode` VARCHAR(50) NOT NULL AFTER `shop_state_id`;

ALTER TABLE `tbl_users` CHANGE `user_phone` `user_phone` BIGINT NULL DEFAULT NULL;
ALTER TABLE `tbl_users` CHANGE `user_dial_code` `user_phone_dcode` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `tbl_user_return_address` CHANGE `ura_phone` `ura_phone` BIGINT NOT NULL;
ALTER TABLE `tbl_user_return_address` ADD `ura_phone_dcode` VARCHAR(50) NOT NULL AFTER `ura_zip`;

ALTER TABLE `tbl_user_phone_verification` CHANGE `upv_phone` `upv_phone` BIGINT NOT NULL;
ALTER TABLE `tbl_user_phone_verification` CHANGE `upv_dial_code` `upv_phone_dcode` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `tbl_user_phone_verification` DROP `upv_country_iso`;
/* Bind all phone number fields with flag field. */