INSERT INTO `tbl_plugins` (`plugin_id`, `plugin_identifier`, `plugin_type`, `plugin_code`, `plugin_active`, `plugin_display_order`) VALUES (NULL, 'Shopify', '16', 'Shopify', '0', '1');


CREATE TABLE `tbl_products_to_plugin_product` (
  `ptpp_product_id` int NOT NULL,
  `ptpp_plugin_id` int NOT NULL,
  `ptpp_plugin_product_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tbl_products_to_plugin_product`
  ADD UNIQUE KEY `ptpp_product_id` (`ptpp_product_id`,`ptpp_plugin_id`,`ptpp_plugin_product_id`);