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

/* RFQ */
CREATE TABLE `tbl_rfq` (
  `rfq_id` int NOT NULL,
  `rfq_number` varchar(15) NOT NULL,
  `rfq_product_id` int NOT NULL,
  `rfq_selprod_id` int NOT NULL,
  `rfq_selprod_code` varchar(100) NOT NULL,
  `rfq_title` varchar(150) NOT NULL,
  `rfq_user_id` int NOT NULL,
  `rfq_type` tinyint NOT NULL,
  `rfq_quantity` int NOT NULL,
  `rfq_quantity_unit` tinyint NOT NULL,
  `rfq_delivery_date` date NOT NULL,
  `rfq_description` text NOT NULL,
  `rfq_addr_id` int NOT NULL COMMENT 'delivery address ID',
  `rfq_lang_id` int NOT NULL,
  `rfq_status` int NOT NULL,
  `rfq_approved` tinyint NOT NULL,
  `rfq_added_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `rfq_updated_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `rfq_deleted` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tbl_rfq`
  ADD PRIMARY KEY (`rfq_id`),
  ADD UNIQUE KEY `rfq_number` (`rfq_number`);

ALTER TABLE `tbl_rfq`
  MODIFY `rfq_id` int NOT NULL AUTO_INCREMENT;


CREATE TABLE `tbl_rfq_to_sellers` (
  `rfqts_rfq_id` int NOT NULL,
  `rfqts_user_id` int NOT NULL COMMENT 'seller id',
  `rfqts_selprod_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4_general_ci;

ALTER TABLE `tbl_rfq_to_sellers`
  ADD PRIMARY KEY (`rfqts_rfq_id`,`rfqts_user_id`);

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('NEW_RFQ', '1', 'Request for New Quotation', 'Request for New Quotation', '<table width="600px" cellspacing="0" cellpadding="0" style="margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)">
    <tbody>
        <tr>
            <td style="background:#fff;padding:20px 0 10px; text-align:center;">
                <h4
                    style="font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;">
                </h4>
                <h2 style="margin:0; font-size:34px; padding:0;">Request for New Quotation</h2>
            </td>
        </tr>
        <tr>
            <td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="padding:20px 0 30px;"><strong style="font-size:18px;color:#333;">Dear Admin
                                </strong><br />
                                A new request for quotation received on your site <a href="{website_url}">{website_name}</a>
                                <br />
                                Please find the RFQ information below.</td>
                        </tr>
                        <tr>
                            <td style="padding:0 0 30px;">{rfq_table}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>', '{rfq_table} RFQ information table<br>\r\n{website_name} Name of our website<br>\r\n{website_url} URL of our website<br>\r\n{social_media_icons} <br>\r\n{contact_us_url} <br>\r\n', '1')
ON DUPLICATE KEY UPDATE etpl_subject = VALUES(etpl_subject), etpl_body = VALUES(etpl_body);

INSERT INTO `tbl_sms_templates` (`stpl_code`, `stpl_lang_id`, `stpl_name`, `stpl_body`, `stpl_replacements`, `stpl_status`) VALUES 
('NEW_RFQ',1,'Request for New Quotation','Hello Admin,\r\nA new RFQ is received for {rfq_title} ({rfq_number}) with quantity {qty}.\r\n\r\n{SITE_NAME} Team','[{\"title\":\"RFQ Title\", \"variable\":\"{rfq_title}\"}, {\"title\":\"Quantity\", \"variable\":\"{qty}\"}, {\"title\":\"Website Name\", \"variable\":\"{SITE_NAME}\"}]',1)
ON DUPLICATE KEY UPDATE stpl_body = VALUES(stpl_body), stpl_replacements = VALUES(stpl_replacements);

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('RFQ_APPROVAL', '1', 'Request for Quote Approval', 'Request for Quote Approval', '<table width="600px" cellspacing="0" cellpadding="0" style="margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)">
    <tbody>
        <tr>
            <td style="background:#fff;padding:20px 0 10px; text-align:center;">
                <h4
                    style="font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;">
                </h4>
                <h2 style="margin:0; font-size:34px; padding:0;">Request for Quote Appoval</h2>
            </td>
        </tr>
        <tr>
            <td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="padding:20px 0 30px;"><strong style="font-size:18px;color:#333;">Dear {user_name}
                                </strong><br />
                                A request for quote has been {approval_status} by the site <a href="{website_url}">{website_name}</a> Admin.
                                <br />
                                Please find the RFQ information below.</td>
                        </tr>
                        <tr>
                            <td style="padding:0 0 30px;">{rfq_table}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>', '{user_name} Buyer/Seller Name<br>\r\n{approval_status} RFQ approval status<br>\r\n{rfq_table} RFQ information table<br>\r\n{website_name} Name of our website<br>\r\n{website_url} URL of our website<br>\r\n{social_media_icons} <br>\r\n{contact_us_url} <br>\r\n', '1')
ON DUPLICATE KEY UPDATE etpl_subject = VALUES(etpl_subject), etpl_body = VALUES(etpl_body);

INSERT INTO `tbl_sms_templates` (`stpl_code`, `stpl_lang_id`, `stpl_name`, `stpl_body`, `stpl_replacements`, `stpl_status`) VALUES 
('RFQ_APPROVAL',1,'Request for Quote Approval','Dear {user_name},\r\nRFQ was received for {rfq_title} ({rfq_number}) with quantity {qty} has been {approval_status} by the Admin.\r\n\r\n{SITE_NAME} Team','[{\"title\":\"Buyer/Seller Name\", \"variable\":\"{user_name}\"},{\"title\":\"RFQ Title\", \"variable\":\"{rfq_title}\"}, {\"title\":\"Quantity\", \"variable\":\"{qty}\"}, {\"title\":\"Website Name\", \"variable\":\"{SITE_NAME}\"}]',1)
ON DUPLICATE KEY UPDATE stpl_body = VALUES(stpl_body), stpl_replacements = VALUES(stpl_replacements);


ALTER TABLE `tbl_addresses` ADD `addr_session_id` VARCHAR(150) NOT NULL AFTER `addr_record_id`;

INSERT INTO `tbl_configurations` (`conf_name`, `conf_val`) VALUES 
('CONF_RFQ_MODULE_TYPE', 1),
('CONF_ENABLE_ADMIN_APPROVAL_ON_NEW_RFQ', 1)
ON DUPLICATE KEY UPDATE conf_val = VALUES(conf_val);