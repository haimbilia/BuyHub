ALTER TABLE `tbl_shop_specifics` ADD `shop_pickup_interval` TINYINT(1) NOT NULL COMMENT 'In Hours' AFTER `shop_invoice_codes`;
INSERT INTO `tbl_configurations` (`conf_name`, `conf_val`, `conf_common`) VALUES
("CONF_LOADER", 1, 1) ON DUPLICATE KEY UPDATE conf_common = 1;
DELETE FROM tbl_language_labels WHERE label_key = "LBL_ADD_WALLET_CREDITS_[$]";

delete from tbl_extra_pages where epage_id = 44;
delete from tbl_extra_pages_lang where epagelang_epage_id = 44;


/* Bind all phone number fields with flag field. */
ALTER TABLE `tbl_users` CHANGE `user_phone` `user_phone` VARCHAR(50) NULL DEFAULT NULL;
UPDATE tbl_users SET user_phone = CONCAT(user_dial_code, user_phone);
ALTER TABLE `tbl_users` DROP INDEX `user_dial_code`;
ALTER TABLE `tbl_users` DROP `user_dial_code`;
ALTER TABLE `tbl_users` ADD UNIQUE KEY `user_phone` (`user_phone`);
ALTER TABLE `tbl_user_phone_verification`
  DROP `upv_country_iso`,
  DROP `upv_dial_code`;
/* Bind all phone number fields with flag field. */