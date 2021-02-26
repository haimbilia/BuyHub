INSERT INTO `tbl_plugins` (`plugin_id`, `plugin_identifier`, `plugin_type`, `plugin_code`, `plugin_active`, `plugin_display_order`) VALUES (NULL, 'Shopify', '16', 'Shopify', '0', '1');


CREATE TABLE `tbl_products_to_plugin_product` (
  `ptpp_product_id` int NOT NULL,
  `ptpp_plugin_id` int NOT NULL,
  `ptpp_plugin_product_id` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tbl_products_to_plugin_product`
  ADD UNIQUE KEY `ptpp_product_id` (`ptpp_product_id`,`ptpp_plugin_id`,`ptpp_plugin_product_id`);


CREATE TABLE `tbl_seller_products_to_plugin_selprod` (
  `spps_selprod_id` int NOT NULL,
  `spps_plugin_id` int NOT NULL,
  `spps_plugin_selprod_id` varchar(100) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tbl_seller_products_to_plugin_selprod` ADD UNIQUE( `spps_selprod_id`, `spps_plugin_id`, `spps_plugin_selprod_id`);

CREATE TABLE `tbl_orders_to_plugin_order` (
  `opo_order_id` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `opo_plugin_id` int NOT NULL,
  `opo_plugin_order_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tbl_orders_to_plugin_order`
  ADD UNIQUE KEY `opo_order_id` (`opo_order_id`,`opo_plugin_id`,`opo_plugin_order_id`);

INSERT INTO `tbl_cron_schedules` (`cron_id`, `cron_name`, `cron_command`, `cron_duration`, `cron_active`) VALUES (NULL, 'Data Migrate', 'DataMigration/sync', '3', '1');
