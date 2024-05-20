INSERT IGNORE INTO `tbl_language_labels` ( `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES 
('APP_ASK_A_QUESTIONS', 1, 'Ask a question', 2),
('APP_ASK_QUESTIONS', 1, 'Ask a question', 2)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption);

ALTER TABLE `tbl_users` ADD `user_has_valid_subscription` TINYINT(1) NOT NULL COMMENT 'For sellers.' AFTER `user_order_tracking_url`;
INSERT INTO `tbl_cron_schedules` (`cron_name`, `cron_command`, `cron_duration`, `cron_active`)
VALUES ('Update Valid Subscription User Flag', 'Cronjob/updateValidSubscription', 1440, 1)
ON DUPLICATE KEY UPDATE cron_duration = VALUES(cron_duration), cron_active = 1;
-- admin/PatchUpdate/updateValidSubscription------------
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES
('LBL_COPYRIGHT_TEXT', 1, 'Copyright {YEAR} {PRODUCT}', 3)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption);
ALTER TABLE `tbl_upc_codes` ADD INDEX(`upc_code`);
ALTER TABLE `tbl_upc_codes` ADD INDEX(`upc_product_id`);

ALTER TABLE `tbl_products` ADD `product_rating` FLOAT(10,2) NOT NULL AFTER `product_ship_package`, ADD `product_total_reviews` INT(11) NOT NULL AFTER `product_rating`;
-- admin/PatchUpdate/updateProductRating------------
ALTER TABLE `tbl_product_category_relations` ADD INDEX( `pcr_parent_id`);
ALTER TABLE `tbl_meta_tags` ADD INDEX( `meta_record_id`);
ALTER TABLE `tbl_meta_tags` ADD INDEX( `meta_subrecord_id`);
ALTER TABLE `tbl_url_rewrite` ADD INDEX( `urlrewrite_custom`);
ALTER TABLE `tbl_url_rewrite` ADD INDEX( `urlrewrite_original`);
ALTER TABLE `tbl_product_special_prices` ADD INDEX( `splprice_price`);
CREATE TABLE `tbl_calculative_data` (
    `cd_key` INT NOT NULL,
    `cd_type` INT NOT NULL,
    `cd_value` VARCHAR(150) NOT NULL,
    PRIMARY KEY (`cd_key`)
) ENGINE = InnoDB;

ALTER TABLE `tbl_order_products` ADD `op_comments` VARCHAR(250) NOT NULL AFTER `op_rounding_off`;
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES
('APP_COMMENTS', 1, 'Comments', 2)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption), label_type = VALUES(label_type);
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES
('APP_CART_EXISTING', 1, 'Do you want to replace existing shop items?', 2)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption), label_type = VALUES(label_type);
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES
('APP_WRITE_COMMENT', 1, 'Write your Comment', 2)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption), label_type = VALUES(label_type);
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES
('APP_LONG_MSG', 1, 'Your message is too long', 2),
('APP_EDIT_CHARACTERS', 1, 'Please edit it down to %s characters', 2)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption), label_type = VALUES(label_type);

INSERT IGNORE INTO `tbl_language_labels` ( `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES 
('FRM_AVAILABLE_FOR_CASH_ON_DELIVERY_(COD)', 1, 'Available for Cash on Delivery (COD) and Pay at Store', 1),
('FRM_PRODUCT_AVAILABLE_FOR_CASH_ON_DELIVERY', 1, 'Activate this if the product is available for COD and Pay at Store.
COD will work only if the fulfillment method is Shipping.
Pay at Store will work only if the fulfillment method is Pickup.', 1)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption);

INSERT IGNORE INTO `tbl_language_labels` ( `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES 
('ERR_PACKAGE_SUPPORT_MAXIMUM_UP_TO_{PROD-CNT}_PRODUCTS_AND_{INV-CNT}_INVENTORIES._MARK_ALL_THE_INVENTORIES_INACTIVE', 1, 'This package support maximum up to 5 products and 10 inventories. Please mark all the inventories as inactive before buying a plan. Then you can re-activate them again.', 1)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption);