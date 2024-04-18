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

INSERT IGNORE INTO `tbl_language_labels` ( `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES 
('FRM_AVAILABLE_FOR_CASH_ON_DELIVERY_(COD)', 1, 'Available for Cash on Delivery (COD) and Pay at Store', 1),
('FRM_PRODUCT_AVAILABLE_FOR_CASH_ON_DELIVERY', 1, 'Activate this if the product is available for COD and Pay at Store.
COD will work only if the fulfillment method is Shipping.
Pay at Store will work only if the fulfillment method is Pickup.', 1)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption);