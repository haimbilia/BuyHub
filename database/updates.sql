
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

ALTER TABLE `tbl_order_products` ADD `op_offer_id` INT NOT NULL AFTER `op_order_id`;
ALTER TABLE `tbl_shops` ADD `shop_rfq_enabled` TINYINT NOT NULL AFTER `shop_has_valid_subscription`;

ALTER TABLE `tbl_seller_products` ADD `selprod_rfq_enabled` TINYINT(4) NOT NULL AFTER `selprod_urlrewrite_id`;

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


ALTER TABLE `tbl_seller_packages`  ADD `spackage_rfq_offers_allowed` INT NOT NULL  AFTER `spackage_free_trial_days`;
ALTER TABLE `tbl_order_seller_subscriptions`  ADD `ossubs_rfq_offers_allowed` INT NOT NULL  AFTER `ossubs_inventory_allowed`;

ALTER TABLE `tbl_rfq_latest_offers`  ADD `rlo_added_on` DATE NOT NULL  AFTER `rlo_deleted`;

UPDATE `tbl_rfq_latest_offers`
INNER JOIN tbl_rfq_offers ON rlo_primary_offer_id = offer_id
SET rlo_added_on = offer_added_on;

ALTER TABLE `tbl_rfq_offers` CHANGE `offer_quantity` `offer_quantity` INT NULL;

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('RFQ_OFFER_ACCEPTED_BY_BUYER', '1', 'RFQ Offer Action By Buyer', 'RFQ ({rfq_number}) offer from other Seller accepted by Buyer', '<table width="600px" cellspacing="0" cellpadding="0" style="margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)">
    <tbody>
        <tr>
            <td style="background:#fff;padding:20px 0 10px; text-align:center;">
                <h4
                    style="font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;">
                </h4>
                <h2 style="margin:0; font-size:34px; padding:0;">RFQ ({rfq_number}) offer from other seller accepted by Buyer</h2>
            </td>
        </tr>
        <tr>
            <td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="padding:20px 0 30px;">
                                <strong style="font-size:18px;color:#333;">Dear {shop_name} Seller,</strong><br />
                                Buyer {user_name} has accepted RFQ ({rfq_number}) offer from other seller.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>', '{rfq_number} RFQ Number<br>\r\n{shop_name} Seller`s Shop<br>\r\n{user_name} Buyer Name<br>\r\n{website_name} Name of our website<br>\r\n{website_url} URL of our website<br>\r\n{social_media_icons} <br>\r\n{contact_us_url} <br>\r\n', '1')
ON DUPLICATE KEY UPDATE etpl_subject = VALUES(etpl_subject), etpl_body = VALUES(etpl_body), etpl_replacements = VALUES(etpl_replacements);

INSERT INTO `tbl_sms_templates` (`stpl_code`, `stpl_lang_id`, `stpl_name`, `stpl_body`, `stpl_replacements`, `stpl_status`) VALUES 
('RFQ_OFFER_ACCEPTED_BY_BUYER',1,'RFQ offer accepted by Buyer','Dear {shop_name} Seller,\r\n{user_name} has accepted RFQ ({rfq_number}) offer from other seller. \r\n\r\n{SITE_NAME} Team','[{\"title\":\"RFQ Number\", \"variable\":\"{rfq_number}\"},{\"title\":\"Seller`s Shop\", \"variable\":\"{shop_name}\"},{\"title\":\"Buyer Name\", \"variable\":\"{user_name}\"}, {\"title\":\"Website Name\", \"variable\":\"{SITE_NAME}\"}]',1)
ON DUPLICATE KEY UPDATE stpl_body = VALUES(stpl_body), stpl_replacements = VALUES(stpl_replacements);


INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('RFQ_OFFER_ACCEPTED_BY_SELLER', '1', 'RFQ Offer Action By Buyer', 'RFQ ({rfq_number}) counter offer from {user_name} accepted by another Seller', '<table width="600px" cellspacing="0" cellpadding="0" style="margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)">
    <tbody>
        <tr>
            <td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="padding:20px 0 30px;">
                                <strong style="font-size:18px;color:#333;">Dear {shop_name} Seller,</strong><br />
                                Counter offer from {user_name} accepted by another Seller for RFQ ({rfq_number}).
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>', '{rfq_number} RFQ Number<br>\r\n{shop_name} Seller`s Shop<br>\r\n{user_name} Buyer Name<br>\r\n{website_name} Name of our website<br>\r\n{website_url} URL of our website<br>\r\n{social_media_icons} <br>\r\n{contact_us_url} <br>\r\n', '1')
ON DUPLICATE KEY UPDATE etpl_subject = VALUES(etpl_subject), etpl_body = VALUES(etpl_body), etpl_replacements = VALUES(etpl_replacements);

INSERT INTO `tbl_sms_templates` (`stpl_code`, `stpl_lang_id`, `stpl_name`, `stpl_body`, `stpl_replacements`, `stpl_status`) VALUES 
('RFQ_OFFER_ACCEPTED_BY_SELLER',1,'RFQ offer accepted by another Seller','Dear {shop_name} Seller,\r\n{Counter offer from {user_name} accepted by another Seller for RFQ ({rfq_number}). \r\n\r\n{SITE_NAME} Team','[{\"title\":\"RFQ Number\", \"variable\":\"{rfq_number}\"},{\"title\":\"Seller`s Shop\", \"variable\":\"{shop_name}\"},{\"title\":\"Buyer Name\", \"variable\":\"{user_name}\"}, {\"title\":\"Website Name\", \"variable\":\"{SITE_NAME}\"}]',1)
ON DUPLICATE KEY UPDATE stpl_body = VALUES(stpl_body), stpl_replacements = VALUES(stpl_replacements);

UPDATE `tbl_email_templates` SET `etpl_priority` = '5' WHERE `tbl_email_templates`.`etpl_code` IN ('NEW_RFQ', 'RFQ_APPROVAL', 'RFQ_DELETION', 'NEW_RFQ_OFFER', 'NEW_RFQ_ASSIGNED', 'RFQ_OFFER_ACTION_BUYER', 'COUNTER_RFQ_OFFER_BUYER', 'RFQ_OFFER_ACTION_SELLER', 'COUNTER_RFQ_OFFER_SELLER', 'RFQ_OFFER_ACCEPTED_BY_BUYER', 'RFQ_OFFER_ACCEPTED_BY_SELLER');

ALTER TABLE `tbl_rfq_offer_messages`  ADD `rom_read` TINYINT(2) NOT NULL  AFTER `rom_buyer_access`;

ALTER TABLE `tbl_seller_products` DROP `selprod_rfq_enabled`;
ALTER TABLE `tbl_seller_products` ADD `selprod_cart_type` TINYINT NOT NULL AFTER `selprod_fulfillment_type`;


INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('RFQ_OFFER_ACCEPTED_BY_SELLER', '1', 'RFQ Offer Action By Seller', 'Final confirmation for the RFQ ({rfq_number}) by another Seller', '<table width="600px" cellspacing="0" cellpadding="0" style="margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)">
    <tbody>
        <tr>
            <td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="padding:20px 0 30px;">
                                <strong style="font-size:18px;color:#333;">Dear {shop_name} Seller,</strong><br />
                                Another seller shared a final confirmation for the RFQ ({rfq_number}) of {user_name}.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>', '{rfq_number} RFQ Number<br>\r\n{shop_name} Seller`s Shop<br>\r\n{user_name} Buyer Name<br>\r\n{website_name} Name of our website<br>\r\n{website_url} URL of our website<br>\r\n{social_media_icons} <br>\r\n{contact_us_url} <br>\r\n', '1')
ON DUPLICATE KEY UPDATE etpl_name = VALUES(etpl_name), etpl_subject = VALUES(etpl_subject), etpl_body = VALUES(etpl_body), etpl_replacements = VALUES(etpl_replacements);

INSERT INTO `tbl_sms_templates` (`stpl_code`, `stpl_lang_id`, `stpl_name`, `stpl_body`, `stpl_replacements`, `stpl_status`) VALUES 
('RFQ_OFFER_ACCEPTED_BY_SELLER',1,'Final confirmation for the RFQ by another Seller','Dear {shop_name} Seller,\r\nAnother seller shared a final confirmation for the RFQ ({rfq_number}) of {user_name}. \r\n\r\n{SITE_NAME} Team','[{\"title\":\"RFQ Number\", \"variable\":\"{rfq_number}\"},{\"title\":\"Seller`s Shop\", \"variable\":\"{shop_name}\"},{\"title\":\"Buyer Name\", \"variable\":\"{user_name}\"}, {\"title\":\"Website Name\", \"variable\":\"{SITE_NAME}\"}]',1)
ON DUPLICATE KEY UPDATE stpl_name = VALUES(stpl_name), stpl_body = VALUES(stpl_body), stpl_replacements = VALUES(stpl_replacements);
-- ----------------------TV-10.1.0.20240926------------------------------------


ALTER TABLE `tbl_collections`  ADD `collection_full_width` TINYINT(1) NOT NULL  AFTER `collection_for_app`;