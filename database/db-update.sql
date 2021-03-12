/* Renaming DPO payment gateway to Paygate. */
UPDATE `tbl_plugins` SET `plugin_identifier`='Paygate', `plugin_code`='Paygate' WHERE plugin_code = 'Dpo';
/* Renaming DPO payment gateway to Paygate. */

-- --- Dpo Payment Gateway--- --
INSERT IGNORE INTO `tbl_plugins` (`plugin_identifier`, `plugin_type`, `plugin_code`, `plugin_active`, `plugin_display_order`) VALUES ('Dpo', '13', 'Dpo', '0', '23');
-- --- Dpo Payment Gateway--- --

-- --- Easypost Shipping API--- --
INSERT IGNORE INTO `tbl_plugins` (`plugin_identifier`, `plugin_type`, `plugin_code`, `plugin_active`, `plugin_display_order`) VALUES ('EasyPost', '8', 'EasyPost', '0', '2');
ALTER TABLE `tbl_order_product_shipment` CHANGE `opship_tracking_number` `opship_tracking_number` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL, CHANGE `opship_tracking_url` `opship_tracking_url` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL;

CREATE TABLE `tbl_order_product_responses` (
  `opr_op_id` bigint NOT NULL,
  `opr_type` int NOT NULL,
  `opr_response` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `opr_added_on` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
ALTER TABLE `tbl_order_product_responses`
ADD PRIMARY KEY (`opr_op_id`,`opr_type`);

/* For Shipment Responses */
INSERT IGNORE INTO `tbl_order_product_responses` (opr_op_id, opr_type, opr_response, opr_added_on)
SELECT ops.opship_op_id, 1, opship_response, op_shipped_date FROM tbl_order_product_shipment ops
INNER JOIN tbl_order_products op ON op.op_id = ops.opship_op_id;

ALTER TABLE `tbl_order_product_shipment` DROP `opship_response`;
/* For Shipment Responses */
-- --- Easypost Shipping API--- --