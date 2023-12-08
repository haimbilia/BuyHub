INSERT IGNORE INTO `tbl_language_labels` ( `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES 
('APP_ASK_A_QUESTIONS', 1, 'Ask a question', 2),
('APP_ASK_QUESTIONS', 1, 'Ask a question', 2)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption);

ALTER TABLE `tbl_users` ADD `user_has_valid_subscription` TINYINT(1) NOT NULL COMMENT 'For sellers.' AFTER `user_order_tracking_url`;
INSERT INTO `tbl_cron_schedules` (`cron_name`, `cron_command`, `cron_duration`, `cron_active`)
VALUES ('Update Valid Subscription User Flag', 'Cronjob/updateValidSubscription', 1440, 1)
ON DUPLICATE KEY UPDATE cron_duration = VALUES(cron_duration), cron_active = 1;
INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES
('LBL_COPYRIGHT_TEXT', 1, 'Copyright {YEAR} {PRODUCT}', 3)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption);
ALTER TABLE `tbl_upc_codes` ADD INDEX(`upc_code`);
ALTER TABLE `tbl_upc_codes` ADD INDEX(`upc_product_id`);


CREATE TABLE `yokart-procurenet`.`tbl_order_gift_cards` ( 
    `ogcards_id` INT NOT NULL AUTO_INCREMENT,
    `ogcards_order_id` INT NOT NULL,
    `ogcards_code` VARCHAR(20) NOT NULL,
    `ogcards_sender_id` INT NOT NULL,
    `ogcards_receiver_id` INT NOT NULL,
    `ogcards_receiver_name` VARCHAR(50) NOT NULL,
    `ogcards_receiver_email` VARCHAR(50) NOT NULL,
    `ogcards_status` TINYINT NOT NULL,
    `ogcards_created_on` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `ogcards_usedon` DATETIME NOT NULL,
     PRIMARY KEY (`ogcards_id`)
     ) ENGINE = InnoDB;

ALTER TABLE `tbl_order_gift_cards` ADD `ogcards_updated_on` DATETIME NOT NULL AFTER `ogcards_created_on`; 