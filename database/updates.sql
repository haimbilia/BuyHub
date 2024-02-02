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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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

CREATE TABLE `tbl_rfq_offers` (
  `offer_id` int NOT NULL,
  `offer_primary_offer_id` INT NOT NULL,
  `offer_rfq_id` int NOT NULL,
  `offer_user_id` int NOT NULL COMMENT 'Primary Seller or Buyer Id',
  `offer_user_type` int NOT NULL,
  `offer_counter_offer_id` int NOT NULL,
  `offer_quantity` int NOT NULL,
  `offer_cost` float(10,2) NOT NULL,
  `offer_price` float(10,2) NOT NULL,
  `offer_shiprate_id` int NOT NULL,
  `offer_negotiable` tinyint NOT NULL,
  `offer_status` int NOT NULL,
  `offer_comments` text NOT NULL,
  `offer_expired_on` datetime NOT NULL,
  `offer_added_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `offer_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tbl_rfq_offers`
  ADD PRIMARY KEY (`offer_id`),
  ADD UNIQUE KEY `offer` (`offer_rfq_id`,`offer_user_id`,`offer_counter_offer_id`,`offer_quantity`);

ALTER TABLE `tbl_rfq_offers`
  MODIFY `offer_id` int NOT NULL AUTO_INCREMENT;


CREATE TABLE `tbl_rfq_latest_offers` (
  `rlo_primary_offer_id` int NOT NULL,
  `rlo_rfq_id` int NOT NULL,
  `rlo_seller_user_id` int NOT NULL,
  `rlo_seller_offer_id` int NOT NULL,
  `rlo_buyer_offer_id` int NOT NULL,
  `rlo_selprod_id` int NOT NULL,
  `rlo_shipping_charges` decimal(10,2) NOT NULL,
  `rlo_accepted_offer_id` int NOT NULL,
  `rlo_status` int NOT NULL,
  `rlo_deleted` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tbl_rfq_latest_offers`
ADD PRIMARY KEY (`rlo_primary_offer_id`);


CREATE TABLE `tbl_rfq_offer_messages` (
  `rom_id` int NOT NULL,
  `rom_primary_offer_id` int NOT NULL,
  `rom_user_type` tinyint NOT NULL,
  `rom_message` text NOT NULL,
  `rom_buyer_access` tinyint NOT NULL DEFAULT '1',
  `rom_added_on` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tbl_rfq_offer_messages`
ADD PRIMARY KEY (`rom_id`);

ALTER TABLE `tbl_rfq_offer_messages`
MODIFY `rom_id` int NOT NULL AUTO_INCREMENT;

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('NEW_RFQ_OFFER', '1', 'New RFQ Offer', 'New RFQ Offer', '<table width="600px" cellspacing="0" cellpadding="0" style="margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)">
    <tbody>
        <tr>
            <td style="background:#fff;padding:20px 0 10px; text-align:center;">
                <h4
                    style="font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;">
                </h4>
                <h2 style="margin:0; font-size:34px; padding:0;">New RFQ Offer</h2>
            </td>
        </tr>
        <tr>
            <td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="padding:20px 0 30px;"><strong style="font-size:18px;color:#333;">Dear {user_name}
                                </strong><br />
                                A new offer received from {shop_name}.
                                <br />
                                Please find the RFQ offer information below.</td>
                        </tr>
                        <tr>
                            <td style="padding:0 0 30px;">{offer_table}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>', '{shop_name} Seller`s Shop<br>\r\n{user_name} Buyer Name<br>\r\n{offer_table} Offer Information Table<br>\r\n{rfq_table} RFQ information table<br>\r\n{website_name} Name of our website<br>\r\n{website_url} URL of our website<br>\r\n{social_media_icons} <br>\r\n{contact_us_url} <br>\r\n', '1')
ON DUPLICATE KEY UPDATE etpl_subject = VALUES(etpl_subject), etpl_body = VALUES(etpl_body);

INSERT INTO `tbl_sms_templates` (`stpl_code`, `stpl_lang_id`, `stpl_name`, `stpl_body`, `stpl_replacements`, `stpl_status`) VALUES 
('NEW_RFQ_OFFER',1,'New RFQ Offer','Dear {user_name},\r\nA new offer on {rfq_number} received from {shop_name}.\r\nOffer Amount {offer_price} with Quantity {qty} \r\n\r\n{SITE_NAME} Team','[{\"title\":\"Seller`s Shop\", \"variable\":\"{shop_name}\"},{\"title\":\"Buyer/Seller Name\", \"variable\":\"{user_name}\"},{\"title\":\"Offer Amount\", \"variable\":\"{offer_price}\"}, {\"title\":\"Quantity\", \"variable\":\"{qty}\"}, {\"title\":\"Website Name\", \"variable\":\"{SITE_NAME}\"}]',1)
ON DUPLICATE KEY UPDATE stpl_body = VALUES(stpl_body), stpl_replacements = VALUES(stpl_replacements);

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('COUNTER_RFQ_OFFER_SELLER', '1', 'Counter RFQ Offer From Seller', 'Counter RFQ Offer From Seller', '<table width="600px" cellspacing="0" cellpadding="0" style="margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)">
    <tbody>
        <tr>
            <td style="background:#fff;padding:20px 0 10px; text-align:center;">
                <h4
                    style="font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;">
                </h4>
                <h2 style="margin:0; font-size:34px; padding:0;">Counter RFQ Offer Received From Seller</h2>
            </td>
        </tr>
        <tr>
            <td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="padding:20px 0 30px;"><strong style="font-size:18px;color:#333;">Dear {user_name}
                                </strong><br />
                                Counter offer received from {shop_name}.
                                <br />
                                Please find the RFQ offer information below.</td>
                        </tr>
                        <tr>
                            <td style="padding:0 0 30px;">{offer_table}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>', '{shop_name} Seller`s Shop<br>\r\n{user_name} Buyer Name<br>\r\n{offer_table} Offer Information Table<br>\r\n{rfq_table} RFQ information table<br>\r\n{website_name} Name of our website<br>\r\n{website_url} URL of our website<br>\r\n{social_media_icons} <br>\r\n{contact_us_url} <br>\r\n', '1')
ON DUPLICATE KEY UPDATE etpl_subject = VALUES(etpl_subject), etpl_body = VALUES(etpl_body);

INSERT INTO `tbl_sms_templates` (`stpl_code`, `stpl_lang_id`, `stpl_name`, `stpl_body`, `stpl_replacements`, `stpl_status`) VALUES 
('COUNTER_RFQ_OFFER_SELLER',1,'Counter RFQ Offer From Seller','Dear {user_name},\r\nCounter offer on {rfq_number} received from {shop_name}.\r\nOffer Amount {offer_price} with Quantity {qty} \r\n\r\n{SITE_NAME} Team','[{\"title\":\"Seller`s Shop\", \"variable\":\"{shop_name}\"},{\"title\":\"Buyer Name\", \"variable\":\"{user_name}\"},{\"title\":\"Offer Amount\", \"variable\":\"{offer_price}\"}, {\"title\":\"Quantity\", \"variable\":\"{qty}\"}, {\"title\":\"Website Name\", \"variable\":\"{SITE_NAME}\"}]',1)
ON DUPLICATE KEY UPDATE stpl_body = VALUES(stpl_body), stpl_replacements = VALUES(stpl_replacements);

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('COUNTER_RFQ_OFFER_BUYER', '1', 'Counter RFQ Offer From Buyer', 'Counter RFQ Offer From Buyer', '<table width="600px" cellspacing="0" cellpadding="0" style="margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)">
    <tbody>
        <tr>
            <td style="background:#fff;padding:20px 0 10px; text-align:center;">
                <h4
                    style="font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;">
                </h4>
                <h2 style="margin:0; font-size:34px; padding:0;">Counter RFQ Offer Received From Buyer</h2>
            </td>
        </tr>
        <tr>
            <td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="padding:20px 0 30px;"><strong style="font-size:18px;color:#333;">Dear {shop_name} Seller,
                                </strong><br />
                                Counter offer received from {user_name}.
                                <br />
                                Please find the RFQ offer information below.</td>
                        </tr>
                        <tr>
                            <td style="padding:0 0 30px;">{offer_table}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>', '{shop_name} Seller`s Shop<br>\r\n{user_name} Buyer Name<br>\r\n{offer_table} Offer Information Table<br>\r\n{rfq_table} RFQ information table<br>\r\n{website_name} Name of our website<br>\r\n{website_url} URL of our website<br>\r\n{social_media_icons} <br>\r\n{contact_us_url} <br>\r\n', '1')
ON DUPLICATE KEY UPDATE etpl_subject = VALUES(etpl_subject), etpl_body = VALUES(etpl_body);

INSERT INTO `tbl_sms_templates` (`stpl_code`, `stpl_lang_id`, `stpl_name`, `stpl_body`, `stpl_replacements`, `stpl_status`) VALUES 
('COUNTER_RFQ_OFFER_BUYER',1,'Counter RFQ Offer From Buyer','Dear {shop_name} Seller,\r\nCounter offer on {rfq_number} received from {user_name}.\r\nOffer Amount {offer_price} with Quantity {qty} \r\n\r\n{SITE_NAME} Team','[{\"title\":\"Seller`s Shop\", \"variable\":\"{shop_name}\"},{\"title\":\"Buyer Name\", \"variable\":\"{user_name}\"},{\"title\":\"Offer Amount\", \"variable\":\"{offer_price}\"}, {\"title\":\"Quantity\", \"variable\":\"{qty}\"}, {\"title\":\"Website Name\", \"variable\":\"{SITE_NAME}\"}]',1)
ON DUPLICATE KEY UPDATE stpl_body = VALUES(stpl_body), stpl_replacements = VALUES(stpl_replacements);

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('RFQ_OFFER_ACTION_SELLER', '1', 'RFQ Offer Action By Seller', 'RFQ Offer {offer_status} By Seller', '<table width="600px" cellspacing="0" cellpadding="0" style="margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)">
    <tbody>
        <tr>
            <td style="background:#fff;padding:20px 0 10px; text-align:center;">
                <h4
                    style="font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;">
                </h4>
                <h2 style="margin:0; font-size:34px; padding:0;">RFQ Offer {offer_status} By Seller</h2>
            </td>
        </tr>
        <tr>
            <td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="padding:20px 0 30px;"><strong style="font-size:18px;color:#333;">Dear {user_name},
                                </strong><br />
                                RFQ Offer {offer_status} By {shop_name} Seller
                                <br />
                                Please find the RFQ {offer_status} offer information below.</td>
                        </tr>
                        <tr>
                            <td style="padding:0 0 30px;">{offer_table}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>', '{offer_status} Offer Status<br>\r\n{shop_name} Seller`s Shop<br>\r\n{user_name} Buyer Name<br>\r\n{offer_table} Offer Information Table<br>\r\n{rfq_table} RFQ information table<br>\r\n{website_name} Name of our website<br>\r\n{website_url} URL of our website<br>\r\n{social_media_icons} <br>\r\n{contact_us_url} <br>\r\n', '1')
ON DUPLICATE KEY UPDATE etpl_subject = VALUES(etpl_subject), etpl_body = VALUES(etpl_body);

INSERT INTO `tbl_sms_templates` (`stpl_code`, `stpl_lang_id`, `stpl_name`, `stpl_body`, `stpl_replacements`, `stpl_status`) VALUES 
('RFQ_OFFER_ACTION_SELLER',1,'RFQ Offer Action By Seller','Dear {user_name},\r\n{shop_name} seller has {offer_status} your offer for {rfq_number}.\r\nOffer Amount {offer_price} with Quantity {qty} \r\n\r\n{SITE_NAME} Team','[{\"title\":\"Offer Status\", \"variable\":\"{offer_status}\"},{\"title\":\"Seller`s Shop\", \"variable\":\"{shop_name}\"},{\"title\":\"Buyer Name\", \"variable\":\"{user_name}\"},{\"title\":\"Offer Amount\", \"variable\":\"{offer_price}\"}, {\"title\":\"Quantity\", \"variable\":\"{qty}\"}, {\"title\":\"Website Name\", \"variable\":\"{SITE_NAME}\"}]',1)
ON DUPLICATE KEY UPDATE stpl_body = VALUES(stpl_body), stpl_replacements = VALUES(stpl_replacements);

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('RFQ_OFFER_ACTION_BUYER', '1', 'RFQ Offer Action By Buyer', 'RFQ Offer {offer_status} By Buyer', '<table width="600px" cellspacing="0" cellpadding="0" style="margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)">
    <tbody>
        <tr>
            <td style="background:#fff;padding:20px 0 10px; text-align:center;">
                <h4
                    style="font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;">
                </h4>
                <h2 style="margin:0; font-size:34px; padding:0;">RFQ Offer {offer_status} By Buyer</h2>
            </td>
        </tr>
        <tr>
            <td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="padding:20px 0 30px;"><strong style="font-size:18px;color:#333;">Dear {shop_name} Seller,
                                </strong><br />
                                RFQ Offer {offer_status} By {user_name}
                                <br />
                                Please find the RFQ {offer_status} offer information below.</td>
                        </tr>
                        <tr>
                            <td style="padding:0 0 30px;">{offer_table}</td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>', '{offer_status} Offer Status<br>\r\n{shop_name} Seller`s Shop<br>\r\n{user_name} Buyer Name<br>\r\n{offer_table} Offer Information Table<br>\r\n{rfq_table} RFQ information table<br>\r\n{website_name} Name of our website<br>\r\n{website_url} URL of our website<br>\r\n{social_media_icons} <br>\r\n{contact_us_url} <br>\r\n', '1')
ON DUPLICATE KEY UPDATE etpl_subject = VALUES(etpl_subject), etpl_body = VALUES(etpl_body);

INSERT INTO `tbl_sms_templates` (`stpl_code`, `stpl_lang_id`, `stpl_name`, `stpl_body`, `stpl_replacements`, `stpl_status`) VALUES 
('RFQ_OFFER_ACTION_BUYER',1,'RFQ Offer Action By Buyer','Dear {shop_name} Seller,\r\n{user_name} has {offer_status} your offer for {rfq_number}.\r\nOffer Amount {offer_price} with Quantity {qty} \r\n\r\n{SITE_NAME} Team','[{\"title\":\"Offer Status\", \"variable\":\"{offer_status}\"},{\"title\":\"Seller`s Shop\", \"variable\":\"{shop_name}\"},{\"title\":\"Buyer Name\", \"variable\":\"{user_name}\"},{\"title\":\"Offer Amount\", \"variable\":\"{offer_price}\"}, {\"title\":\"Quantity\", \"variable\":\"{qty}\"}, {\"title\":\"Website Name\", \"variable\":\"{SITE_NAME}\"}]',1)
ON DUPLICATE KEY UPDATE stpl_body = VALUES(stpl_body), stpl_replacements = VALUES(stpl_replacements);
ALTER TABLE `tbl_shops` ADD `shop_has_valid_subscription` TINYINT(4) NOT NULL AFTER `shop_total_reviews`;

ALTER TABLE `tbl_order_products` ADD `op_offer_id` INT NOT NULL AFTER `op_order_id`;
ALTER TABLE `tbl_shops` ADD `shop_rfq_enabled` TINYINT NOT NULL AFTER `shop_has_valid_subscription`;

/* GIFT CARDS */
CREATE TABLE `tbl_order_gift_cards` ( 
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

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_priority`, `etpl_status`) VALUES ('user-redeem-gift-card', '1', 'Redeem Gift Card', 'Redeem Gift Card', '<table width=\"600px\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;\">\r\n                <table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                    <tbody>\r\n                        <tr>\r\n                            <td style=\"background:#fff;padding:20px 0 10px; text-align:center;\">\r\n                                <h4 style=\"font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;\">The gift card has been redeemed</h4>\r\n\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td style=\"padding:20px 0 30px;\"><strong style=\"font-size:18px;color:#333;\">Dear {user_full_name}</strong><br /> We would like to inform you that the gift card you shared with Josiane Brown has been successfully redeemed.</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td style=\"padding:20px 0 30px;\"><strong style=\"font-size:18px;color:#333;\">Gift card code: </strong> &nbsp;&nbsp; {redeemed_code}</td>\r\n                        </tr>\r\n\r\n                    </tbody>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>', '{user_full_name} Sender Name<br/>\r\n{redeemed_code} Redeem Code <br/>', '5', '1');

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_priority`, `etpl_status`) VALUES ('receiver-gift-card', '1', 'Gift Card Order Placed', 'A new gift card order was placed', '<table width=\"600px\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;\">\r\n                <table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                    <tbody>\r\n                        <tr>\r\n                            <td style=\"background:#fff;padding:20px 0 10px; text-align:center;\">\r\n                                <h4 style=\"font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;\">Gift Card</h4>\r\n\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td style=\"padding:20px 0 30px;\"><strong style=\"font-size:18px;color:#333;\">Dear {recipient_name}</strong><br /> A new gift card order was placed. Below are the details::</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <table style=\"border:1px solid #ddd; border-collapse:collapse;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n                                <tbody>\r\n                                    <tr>\r\n                                        <td style=\"padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;\" width=\"153\">Sender Name</td>\r\n                                        <td style=\"padding:10px;font-size:13px; color:#333;border:1px solid #ddd;\" width=\"620\">{sender_name}</td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td style=\"padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;\" width=\"153\">Receiver Name<span class=\"Apple-tab-span\" style=\"white-space:pre\"></span></td>\r\n                                        <td style=\"padding:10px;font-size:13px; color:#333;border:1px solid #ddd;\" width=\"620\">{recipient_name}</td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td style=\"padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;\" width=\"153\">Code</td>\r\n                                        <td style=\"padding:10px;font-size:13px; color:#333;border:1px solid #ddd;\" width=\"620\">{giftcard_code}</td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td style=\"padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;\" width=\"153\">Contact Detail</td>\r\n                                        <td style=\"padding:10px;font-size:13px; color:#333;border:1px solid #ddd;\" width=\"620\">{contact_us_email}</td>\r\n                                    </tr>\r\n                                </tbody>\r\n                            </table>\r\n                        </tr>\r\n\r\n                    </tbody>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>', '{recipient_name} Receiver Name<br/> {contact_us_email} Contact Detail <br/> {giftcard_code} Redeem Code <br/> {sender_name} Sender Name <br/>', '5', '1');

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_priority`, `etpl_status`) VALUES ('admin-gift-card', '1', 'Gift Card Order Placed', 'A new gift card order was placed', '<table width=\"600px\" cellspacing=\"0\" cellpadding=\"0\" style=\"margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)\">\r\n    <tbody>\r\n        <tr>\r\n            <td style=\"background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;\">\r\n                <table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                    <tbody>\r\n                        <tr>\r\n                            <td style=\"background:#fff;padding:20px 0 10px; text-align:center;\">\r\n                                <h4 style=\"font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;\">Gift Card</h4>\r\n\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td style=\"padding:20px 0 30px;\"><strong style=\"font-size:18px;color:#333;\">Dear Admin</strong><br /> A new gift card order was placed. Below are the details::</td>\r\n                        </tr>\r\n                        <tr>\r\n                            <table style=\"border:1px solid #ddd; border-collapse:collapse;\" cellspacing=\"0\" cellpadding=\"0\" border=\"0\">\r\n                                <tbody>\r\n                                    <tr>\r\n                                        <td style=\"padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;\" width=\"153\">Sender Name</td>\r\n                                        <td style=\"padding:10px;font-size:13px; color:#333;border:1px solid #ddd;\" width=\"620\">{sender_name}</td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td style=\"padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;\" width=\"153\">Receiver Name<span class=\"Apple-tab-span\" style=\"white-space:pre\"></span></td>\r\n                                        <td style=\"padding:10px;font-size:13px; color:#333;border:1px solid #ddd;\" width=\"620\">{recipient_name}</td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td style=\"padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;\" width=\"153\">Receiver Email</td>\r\n                                        <td style=\"padding:10px;font-size:13px; color:#333;border:1px solid #ddd;\" width=\"620\">{recipient_email}</td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td style=\"padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;\" width=\"153\">Amount</td>\r\n                                        <td style=\"padding:10px;font-size:13px; color:#333;border:1px solid #ddd;\" width=\"620\">{giftcard_amount}</td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td style=\"padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;\" width=\"153\">Code</td>\r\n                                        <td style=\"padding:10px;font-size:13px; color:#333;border:1px solid #ddd;\" width=\"620\">{giftcard_code}</td>\r\n                                    </tr>\r\n                                </tbody>\r\n                            </table>\r\n                        </tr>\r\n\r\n                    </tbody>\r\n                </table>\r\n            </td>\r\n        </tr>\r\n    </tbody>\r\n</table>', '\r\n{recipient_email} Receiver Email<br/> {recipient_name} Receiver Name<br/> {giftcard_code} Redeem Code <br/> {sender_name} Sender Name <br/> {giftcard_amount} Total Amount <br/>', '5', '1');
/* GIFT CARDS */

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
ALTER TABLE `tbl_seller_products` ADD `selprod_rfq_enabled` TINYINT(4) NOT NULL AFTER `selprod_urlrewrite_id`;

('APP_LONG_MSG', 1, 'Your message is too long', 2),
('APP_EDIT_CHARACTERS', 1, 'Please edit it down to %s characters', 2)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption), label_type = VALUES(label_type);

