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

INSERT INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES
('APP_LONG_MSG', 1, 'Your message is too long', 2),
('APP_EDIT_CHARACTERS', 1, 'Please edit it down to %s characters', 2)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption), label_type = VALUES(label_type);

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('NEW_RFQ_ASSIGNED', '1', 'Request for New Quotation Assigned', 'Request for New Quotation Assigned', '<table width="600px" cellspacing="0" cellpadding="0" style="margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)">
    <tbody>
        <tr>
            <td style="background:#fff;padding:20px 0 10px; text-align:center;">
                <h4
                    style="font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;">
                </h4>
                <h2 style="margin:0; font-size:34px; padding:0;">Request for New Quotation Assigned</h2>
            </td>
        </tr>
        <tr>
            <td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="padding:20px 0 30px;"><strong style="font-size:18px;color:#333;">Dear {shop_user_name}
                                </strong><br />
                                A new request for quotation has been assigned to you
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
</table>', '{rfq_table} RFQ information table<br>\r\n{social_media_icons} <br>\r\n{contact_us_url} <br>\r\n', '1')
ON DUPLICATE KEY UPDATE etpl_subject = VALUES(etpl_subject), etpl_body = VALUES(etpl_body);

INSERT INTO `tbl_sms_templates` (`stpl_code`, `stpl_lang_id`, `stpl_name`, `stpl_body`, `stpl_replacements`, `stpl_status`) VALUES 
('NEW_RFQ_ASSIGNED',1,'Request for New Quotation Assigned','Hello {shop_user_name},\r\nA new RFQ is assigned for {rfq_title} ({rfq_number}) with quantity {qty}.\r\n\r\n{SITE_NAME} Team','[{\"title\":\"RFQ Title\", \"variable\":\"{rfq_title}\"}, {\"title\":\"Quantity\", \"variable\":\"{qty}\"}, {\"title\":\"Website Name\", \"variable\":\"{SITE_NAME}\"}]',1)
ON DUPLICATE KEY UPDATE stpl_body = VALUES(stpl_body), stpl_replacements = VALUES(stpl_replacements);

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('RFQ_DELETION', '1', 'Request for Quote Deletion', 'Request for Quote Deletion', '<table width="600px" cellspacing="0" cellpadding="0" style="margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)">
    <tbody>
        <tr>
            <td style="background:#fff;padding:20px 0 10px; text-align:center;">
                <h4
                    style="font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;">
                </h4>
                <h2 style="margin:0; font-size:34px; padding:0;">Request for Quote Deletion</h2>
            </td>
        </tr>
        <tr>
            <td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="padding:20px 0 30px;"><strong style="font-size:18px;color:#333;">Dear {user_name}
                                </strong><br />
                                Your request for quote has been deleted by the site <a href="{website_url}">{website_name}</a> Admin.
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
('RFQ_DELETION',1,'Request for Quote Deletion','Dear {user_name},\r\nRFQ was received for {rfq_title} ({rfq_number}) with quantity {qty} has been deleted by the Admin.\r\n\r\n{SITE_NAME} Team','[{\"title\":\"Buyer/Seller Name\", \"variable\":\"{user_name}\"},{\"title\":\"RFQ Title\", \"variable\":\"{rfq_title}\"}, {\"title\":\"Quantity\", \"variable\":\"{qty}\"}, {\"title\":\"Website Name\", \"variable\":\"{SITE_NAME}\"}]',1)
ON DUPLICATE KEY UPDATE stpl_body = VALUES(stpl_body), stpl_replacements = VALUES(stpl_replacements);

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

INSERT INTO `tbl_collections_lang` (`collectionlang_collection_id`, `collectionlang_lang_id`, `collection_name`, `collection_description`, `collection_link_caption`) VALUES
((SELECT collection_id FROM `tbl_collections` WHERE collection_type = 11 AND collection_layout_type  = 16 AND collection_identifier = 'Content Block 1'), 1, 'Content Block 1', '\r\n<section class=\"section security-floor\" data-collection=\"collection-cms\" style=\"background-image:url(\'/images/bg/security.png\')\">    \r\n	<div class=\"container\">        \r\n		<div class=\"section-head\">            \r\n			<div class=\"section-heading\">                \r\n				<h2>Trade confidently, backed by our dedication to top-notch production and purchase safeguards.</h2>            </div>        </div>        \r\n		<div class=\"section-body\">            \r\n			<div class=\"row\">                \r\n				<div class=\"col-lg-6\">                    \r\n					<div class=\"security-floor-card\">                        <span class=\"security-floor-tag\"> Lorem ipsum dolor sit amet.</span>                      <img class=\"security-floor-icon\" src=\"/images/verified-supplier.png\" alt=\"\" width=\"\" height=\"\" />                        \r\n						<p class=\"security-floor-desc\">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua..</p>                        <a class=\"btn btn-outline-white\" href=\"\">Learn more</a>                    </div>                </div>                \r\n				<div class=\"col-lg-6\">                    \r\n					<div class=\"security-floor-card\">                        <span class=\"security-floor-tag\">Lorem ipsum dolor sit amet,\r\n                        </span>                      <img class=\"security-floor-icon\" src=\"/images/trade-assurance.png\" alt=\"\" width=\"\" height=\"\" />                        \r\n						<p class=\"security-floor-desc\"> Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.\r\n                        </p>                        <a class=\"btn btn-outline-white\" href=\"#\">Learn more</a>                    </div>                </div>            </div>        </div>    </div></section>', ''),
((SELECT collection_id FROM `tbl_collections` WHERE collection_type = 11 AND collection_layout_type  = 31 AND collection_identifier = 'Content Block 2'), 1, 'Content Block 2', '\r\n<section class=\"section\" data-collection=\"collection-cms\">    \r\n	<div class=\"container\">        \r\n		<div class=\"section-head section-head-space\">            \r\n			<div class=\"section-heading\">                \r\n				<h2>                    Discover countless offerings curated to suit your business requirements.</h2>            </div>            \r\n			<div class=\"section-action\">                \r\n				<div class=\"category-number\">                    \r\n					<div class=\"category-number-item\">                        <span class=\"number\">100M+</span>                        \r\n						<p>products</p>                    </div>                    \r\n					<div class=\"category-number-item\"><span class=\"number\">80K+</span>                        \r\n						<p>suppliers</p>                    </div>                    \r\n					<div class=\"category-number-item\"><span class=\"number\">4,250</span>                        \r\n						<p>product categories\r\n                        </p>                    </div>                    \r\n					<div class=\"category-number-item\"><span class=\"number\">100+</span>                        \r\n						<p>countries and regions</p>                    </div>                </div>            </div>        </div>    </div></section>', '')
ON DUPLICATE KEY UPDATE collection_name = VALUES(collection_name), collection_description = VALUES(collection_description);

ALTER TABLE `tbl_rfq_latest_offers` ADD `rlo_seller_acceptance` TINYINT NOT NULL AFTER `rlo_accepted_offer_id`, ADD `rlo_buyer_acceptance` TINYINT NOT NULL AFTER `rlo_seller_acceptance`;

ALTER TABLE `tbl_rfq` ADD `rfq_visibility_type` TINYINT NOT NULL DEFAULT '2' AFTER `rfq_lang_id`;
UPDATE `tbl_rfq` SET `rfq_visibility_type`='1' WHERE `rfq_selprod_id` = 0 AND `rfq_product_id` = 0;
ALTER TABLE `tbl_rfq` ADD `rfq_prodcat_id` INT NOT NULL AFTER `rfq_title`;
ALTER TABLE `tbl_rfq` ADD `rfq_product_type` TINYINT NOT NULL AFTER `rfq_number`;

INSERT INTO `tbl_language_labels` ( `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES 
('LBL_DOWNLOAD_RFQ_COPY', 1, 'Download RFQ Copy', 1)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption);
INSERT INTO `tbl_language_labels` ( `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES 
('FRM_SELECTING_THIS_FEATURE_WILL_UPDATE_PAYOUT_SETTINGS_FOR_ALL_PREVIOUS_CONNECTED_ACCOUNTS.',1,'When activated, all the payout settings will be updated for every previously connected account. This setting will not remain enabled after saving.',1)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption);

INSERT IGNORE INTO `tbl_language_labels` ( `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES 
('ERR_PACKAGE_SUPPORT_MAXIMUM_UP_TO_{PROD-CNT}_PRODUCTS_AND_{INV-CNT}_INVENTORIES._MARK_ALL_THE_INVENTORIES_INACTIVE', 1, 'This package support maximum up to 5 products and 10 inventories. Please mark all the inventories as inactive before buying a plan. Then you can re-activate them again.', 1)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption);


ALTER TABLE `tbl_orders` ADD INDEX( `order_date_added`);
ALTER TABLE `tbl_order_products` ADD INDEX( `op_status_id`);
ALTER TABLE `tbl_orders` ADD INDEX( `order_payment_status`);

ALTER TABLE `tbl_calculative_data` ADD `cd_updated_on` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `cd_value`;
ALTER TABLE `tbl_calculative_data` CHANGE `cd_updated_on` `cd_updated_on` DATETIME on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;
ALTER TABLE `tbl_calculative_data` CHANGE `cd_value` `cd_value` TEXT CHARACTER SET utf8mb3 COLLATE utf8mb3_general_ci NOT NULL;

INSERT INTO `tbl_language_labels` ( `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES 
('LBL_PLEASE_FOLLOW_{STEPS}_TO_GET_FIREBASE_SERVICE_ACCOUNT_JSON_KEY',1,'Please follow {STEPS} to get firebase service account JSON Key',1)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption);

INSERT INTO `tbl_extra_pages` (`epage_identifier`, `epage_type`, `epage_content_for`, `epage_active`, `epage_default`, `epage_default_content`) VALUES 
('Firebase Service Account Private Key JSON File', 86, 0, 1, 0, '<h6 class=\"mt-2\"><strong>To generate a private key file for your service account:</strong></h6>\n<ul class=\"listing--bullet\">\n	<li>\n		<p>In the Firebase console, open <strong>Settings > <a href=\"https://console.firebase.google.com/project/\">Service Accounts</a></strong>.</p></li>\n	<li>\n		<p>Click <strong>Generate New Private Key</strong>, then confirm by clicking <strong>Generate Key</strong>.</p></li>\n	<li>\n		<p>Securely store the JSON file containing the key.</p></li>\n</ul>')
ON DUPLICATE KEY UPDATE epage_identifier = VALUES(epage_identifier), epage_default_content = VALUES(epage_default_content);

ALTER TABLE `tbl_shops` ADD `shop_user_valid` TINYINT(0) NOT NULL AFTER `shop_has_valid_subscription`;
UPDATE tbl_shops AS s
INNER JOIN (
    SELECT user_id
    FROM tbl_users u
    INNER JOIN tbl_user_credentials c ON u.user_id = c.credential_user_id
    WHERE u.user_deleted = 0 AND c.credential_active = 1 AND c.credential_verified = 1 and u.user_is_supplier = 1
) t ON t.user_id = s.shop_user_id
SET s.shop_user_valid = 1;
ALTER TABLE `tbl_shops` ADD INDEX( `shop_user_valid`);
ALTER TABLE `tbl_states` ADD INDEX( `state_active`);