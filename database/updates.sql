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

INSERT INTO `tbl_language_labels` ( `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES 
('FRM_SELECTING_THIS_FEATURE_WILL_UPDATE_PAYOUT_SETTINGS_FOR_ALL_PREVIOUS_CONNECTED_ACCOUNTS.',1,'When activated, all the payout settings will be updated for every previously connected account. This setting will not remain enabled after saving.',1)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption);

INSERT INTO `tbl_language_labels` ( `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES 
('LBL_PLEASE_FOLLOW_{STEPS}_TO_GET_FIREBASE_SERVICE_ACCOUNT_JSON_KEY',1,'Please follow {STEPS} to get firebase service account JSON Key',1)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption);

INSERT INTO `tbl_extra_pages` (`epage_identifier`, `epage_type`, `epage_content_for`, `epage_active`, `epage_default`, `epage_default_content`) VALUES ('Firebase Service Account Private Key JSON File', '86', '0', '1', '0', '<p><strong>To generate a private key file for your service account:</strong></p><ol>\r\n<li><p>In the Firebase console, open\r\n<strong>Settings &gt; <a href=\"https://console.firebase.google.com/project/_/settings/serviceaccounts/adminsdk?_gl=1*182wjdk*_ga*MTYyNzY5ODczMS4xNzE5MzEzNDc5*_ga_CW55HF8NVT*MTcxOTMxMzQ3OC4xLjEuMTcxOTMxMzUyNi4xMi4wLjA.\">Service Accounts</a></strong>.</p></li>\r\n<li><p>Click <strong>Generate New Private Key</strong>, then confirm by clicking <strong>Generate Key</strong>.</p></li>\r\n<li><p>Securely store the JSON file containing the key.</p></li>\r\n</ol>')
ON DUPLICATE KEY UPDATE epage_identifier = VALUES(epage_identifier), epage_default_content = VALUES(epage_default_content);