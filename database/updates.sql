INSERT IGNORE INTO `tbl_language_labels` ( `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES 
('APP_ASK_A_QUESTIONS', 1, 'Ask a question', 2),
('APP_ASK_QUESTIONS', 1, 'Ask a question', 2)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption);
ALTER TABLE `tbl_product_digital_data_relation` ADD `pddr_updated_on` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `pddr_type`;