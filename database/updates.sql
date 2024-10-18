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

INSERT INTO `tbl_language_labels` ( `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES 
('FRM_SELECTING_THIS_FEATURE_WILL_UPDATE_PAYOUT_SETTINGS_FOR_ALL_PREVIOUS_CONNECTED_ACCOUNTS.',1,'When activated, all the payout settings will be updated for every previously connected account. This setting will not remain enabled after saving.',1)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption);

INSERT IGNORE INTO `tbl_language_labels` ( `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES 
('ERR_PACKAGE_SUPPORT_MAXIMUM_UP_TO_{PROD-CNT}_PRODUCTS_AND_{INV-CNT}_INVENTORIES._MARK_ALL_THE_INVENTORIES_INACTIVE', 1, 'This package support maximum up to {PROD-CNT} products and {INV-CNT} inventories. Please mark all the inventories as inactive before buying a plan. Then you can re-activate them again.', 1)
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

ALTER TABLE `tbl_shops` ADD `shop_has_valid_subscription` TINYINT(4) NOT NULL AFTER `shop_total_reviews`;
ALTER TABLE `tbl_shops` ADD `shop_user_valid` TINYINT(0) NOT NULL AFTER `shop_has_valid_subscription`;
UPDATE tbl_shops AS s
INNER JOIN (
    SELECT user_id
    FROM tbl_users u
    INNER JOIN tbl_user_credentials c ON u.user_id = c.credential_user_id
    WHERE u.user_deleted = 0 AND c.credential_active = 1 AND c.credential_verified = 1 and u.user_is_supplier = 1
) t ON t.user_id = s.shop_user_id
SET s.shop_user_valid = 1;
-- admin/admin-users/create-procedures/------------
ALTER TABLE `tbl_shops` ADD INDEX( `shop_user_valid`);
ALTER TABLE `tbl_states` ADD INDEX( `state_active`);

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_priority`, `etpl_status`) VALUES
('BANK_TRANSFER_ORDER_PAYMENT_ACTIONS', 1, 'Bank Transfer Order Payment Transaction Action', 'Order #{ORDER_ID} payment has been {STATUS}', '<table width="600px" cellspacing="0" cellpadding="0" style="margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)">
	<tbody>
		<tr>                        
			<td style="background:#fff;padding:20px 0 10px; text-align:center;">                            
				<h4 style="font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;"></h4>                            
				<h2 style="margin:0; font-size:34px; padding:0;">Bank Transfer</h2></td>                    
		</tr>
		<tr>                        
			<td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">                            
				<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">                                
					<tbody>                                    
						<tr>                                        
							<td style="padding:20px 0 30px;" colspan="2"><strong style="font-size:18px;color:#333;">Dear {USER_NAME}</strong><br />
								Your bank transfer transaction belongs to Order #{ORDER_ID} has been {STATUS}.
                            </td>                                    
						</tr>                               
					</tbody>                            
				</table>
			</td>                    
		</tr>
	</tbody>
</table>', '{USER_NAME} - Name of the User.<br>\r\n{ORDER_ID} - Order Id.<br>\r\n{STATUS} - Status of the transaction.<br>', 5, 1)
ON DUPLICATE KEY UPDATE etpl_subject = VALUES(etpl_subject), etpl_body = VALUES(etpl_body), etpl_replacements = VALUES(etpl_replacements);

INSERT INTO `tbl_sms_templates` (`stpl_code`, `stpl_lang_id`, `stpl_name`, `stpl_body`, `stpl_replacements`, `stpl_status`) VALUES
('BANK_TRANSFER_ORDER_PAYMENT_ACTIONS', 1, 'Bank Transfer Order Payment Transaction Action', 'Dear {USER_NAME},\r\n\r\nPayment txn. of order #{ORDER_ID} has been {STATUS}.\r\nFor #{ORDER_ID}.\r\n\r\n{SITE_NAME} Team', '[{\"title\":\"User Name\", \"variable\":\"{USER_NAME}\"},{\"title\":\"Order Id\", \"variable\":\"{ORDER_ID}\"},{\"title\":\"Transaction Status\", \"variable\":\"{STATUS}\"}, {\"title\":\"Website Name\", \"variable\":\"{SITE_NAME}\"}]', 1)
ON DUPLICATE KEY UPDATE stpl_name = VALUES(stpl_name), stpl_body = VALUES(stpl_body), stpl_replacements = VALUES(stpl_replacements);
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

INSERT IGNORE INTO `tbl_language_labels` ( `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES 
('ERR_PACKAGE_SUPPORT_MAXIMUM_UP_TO_{PROD-CNT}_PRODUCTS_AND_{INV-CNT}_INVENTORIES._MARK_ALL_THE_INVENTORIES_INACTIVE', 1, 'This package support maximum up to {PROD-CNT} products and {INV-CNT} inventories. Please mark additional inventories as inactive before buying a plan.', 1)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption);


INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_priority`, `etpl_status`) VALUES ('receiver-gift-card', '1', 'Gift Card Order Placed', 'A new gift card order was placed', '<table width="600px" cellspacing="0" cellpadding="0" style="margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)">
    <tbody>
        <tr>
            <td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="background:#fff;padding:20px 0 10px; text-align:center;">
                                <h4 style="font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;">Gift Card</h4>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:20px 0 30px;"><strong style="font-size:18px;color:#333;">Dear {recipient_name}</strong><br /> A new gift card order was placed. Below are the details::</td>
                        </tr>
                        <tr>
                            <table style="border:1px solid #ddd; border-collapse:collapse;" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;" width="153">Sender</td>
                                        <td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" width="620">{sender_name}<br>({sender_email})</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;" width="153">Receiver Name<span class="Apple-tab-span" style="white-space:pre"></span></td>
                                        <td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" width="620">{recipient_name}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;" width="153">Code</td>
                                        <td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" width="620">{giftcard_code}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>', '{recipient_name} Receiver Name<br/> {sender_name} Sender Name <br/> {sender_email} Sender Email <br/> {giftcard_code} Redeem Code <br/>', '5', '1')
ON DUPLICATE KEY UPDATE etpl_subject = VALUES(etpl_subject), etpl_body = VALUES(etpl_body), etpl_replacements = VALUES(etpl_replacements);


INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_priority`, `etpl_status`) VALUES ('admin-gift-card', '1', 'Gift Card Order Placed', 'A new gift card order was placed', '<table width="600px" cellspacing="0" cellpadding="0" style="margin: 0 auto; table-layout: fixed; background: #ffffff; border-radius: 4px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.04)">
    <tbody>
        <tr>
            <td style="background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="background:#fff;padding:20px 0 10px; text-align:center;">
                                <h4 style="font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;">Gift Card</h4>
                            </td>
                        </tr>
                        <tr>
                            <td style="padding:20px 0 30px;"><strong style="font-size:18px;color:#333;">Dear Admin</strong><br /> A new gift card order was placed. Below are the details::</td>
                        </tr>
                        <tr>
                            <table style="border:1px solid #ddd; border-collapse:collapse;" cellspacing="0" cellpadding="0" border="0">
                                <tbody>
                                    <tr>
                                        <td style="padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;" width="153">Sender</td>
                                        <td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" width="620">{sender_name}<br>({sender_email})</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;" width="153">Receiver<span class="Apple-tab-span" style="white-space:pre"></span></td>
                                        <td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" width="620">{recipient_name}<br>({recipient_email})</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;" width="153">Amount</td>
                                        <td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" width="620">{giftcard_amount}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding:10px;font-size:13px;border:1px solid #ddd; color:#333; font-weight:bold;" width="153">Code</td>
                                        <td style="padding:10px;font-size:13px; color:#333;border:1px solid #ddd;" width="620">{giftcard_code}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>', '\r\n{recipient_email} Receiver Email<br/> {recipient_name} Receiver Name<br/> {giftcard_code} Redeem Code <br/> {sender_name} Sender Name <br/>{sender_email} Sender Email <br/> {giftcard_amount} Total Amount <br/>', '5', '1')
ON DUPLICATE KEY UPDATE etpl_subject = VALUES(etpl_subject), etpl_body = VALUES(etpl_body), etpl_replacements = VALUES(etpl_replacements);

-- ----------------------TV-10.1.0.20240926------------------------------------