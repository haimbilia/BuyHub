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

ALTER TABLE `tbl_collections` CHANGE `collection_identifier` `collection_identifier` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

INSERT INTO `tbl_collections` (`collection_identifier`, `collection_type`, `collection_criteria`, `collection_primary_records`, `collection_child_records`, `collection_display_order`, `collection_active`, `collection_deleted`, `collection_link_url`, `collection_layout_type`, `collection_display_media_only`, `collection_for_web`, `collection_for_app`) VALUES
('Content Block 1', 11, 0, 0, 0, 3, 1, 0, '', 16, 0, 1, 1),
('Content Block 2', 11, 0, 0, 0, 2, 1, 0, '', 31, 0, 1, 1)
ON DUPLICATE KEY UPDATE collection_identifier = VALUES(collection_identifier);

INSERT INTO `tbl_collections_lang` (`collectionlang_lang_id`, `collection_name`, `collection_description`, `collection_link_caption`) VALUES
(1, 'Content Block 1', '\r\n<section class=\"section security-floor\" data-collection=\"collection-cms\" style=\"background-image:url(\'/images/bg/security.png\')\">    \r\n	<div class=\"container\">        \r\n		<div class=\"section-head\">            \r\n			<div class=\"section-heading\">                \r\n				<h2>Trade with confidence from production quality to purchase protection</h2>            </div>        </div>        \r\n		<div class=\"section-body\">            \r\n			<div class=\"row\">                \r\n				<div class=\"col-lg-6\">                    \r\n					<div class=\"security-floor-card\">                        <span class=\"security-floor-tag\"> Ensure production quality with</span>                      <img class=\"security-floor-icon\" src=\"/images/verified-supplier.png\" alt=\"\" width=\"\" height=\"\" />                        \r\n						<p class=\"security-floor-desc\">Connect with a variety of suppliers with third-party-verified\r\n                            credentials and\r\n                            capabilities. Look for the \"Verified\" logo to begin sourcing with experienced suppliers\r\n                            your business could rely on.</p>                        <a class=\"btn btn-outline-white\" href=\"\">Learn more</a>                    </div>                </div>                \r\n				<div class=\"col-lg-6\">                    \r\n					<div class=\"security-floor-card\">                        <span class=\"security-floor-tag\">Protect your purchase with\r\n                        </span>                      <img class=\"security-floor-icon\" src=\"/images/trade-assurance.png\" alt=\"\" width=\"\" height=\"\" />                        \r\n						<p class=\"security-floor-desc\"> Source confidently with access to secure payment options,\r\n                            protection against product or\r\n                            shipping issues, and mediation support for any purchase-related concerns when you order\r\n                            and pay on Yokart.com.\r\n                        </p>                        <a class=\"btn btn-outline-white\" href=\"#\">Learn more</a>                    </div>                </div>            </div>        </div>    </div></section> ', ''),
(1, 'Content Block 2', '\r\n<section class=\"section\" data-collection=\"collection-cms\">    \r\n	<div class=\"container\">        \r\n		<div class=\"section-head section-head-space\">            \r\n			<div class=\"section-heading\">                \r\n				<h2>                    Explore millions of offerings tailored to your business needs</h2>            </div>            \r\n			<div class=\"section-action\">                \r\n				<div class=\"category-number\">                    \r\n					<div class=\"category-number-item\">                        <span class=\"number\">200M+</span>                        \r\n						<p>products</p>                    </div>                    \r\n					<div class=\"category-number-item\"><span class=\"number\">200K+</span>                        \r\n						<p>suppliers</p>                    </div>                    \r\n					<div class=\"category-number-item\"><span class=\"number\">5,900</span>                        \r\n						<p>product categories\r\n                        </p>                    </div>                    \r\n					<div class=\"category-number-item\"><span class=\"number\">200+</span>                        \r\n						<p>countries and regions</p>                    </div>                </div>            </div>        </div>    </div></section> ', '')
ON DUPLICATE KEY UPDATE collection_name = VALUES(collection_name), collection_description = VALUES(collection_description);