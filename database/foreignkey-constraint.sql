/* 
=> Not included lang id as as foreign key constraint 
=> SET FOREIGN_KEY_CHECKS=0; or run with blank DB 
=> Used for ER diagrams
*/

-- --------tbl_abandoned_cart---------
ALTER TABLE `tbl_abandoned_cart` ADD CONSTRAINT `abandonedcart_user_id` FOREIGN KEY (`abandonedcart_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_abandoned_cart` ADD CONSTRAINT `abandonedcart_selprod_id` FOREIGN KEY (`abandonedcart_selprod_id`) REFERENCES `tbl_seller_products`(`selprod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- --------tbl_addresses---------
ALTER TABLE `tbl_addresses` ADD CONSTRAINT `addr_state_id` FOREIGN KEY (`addr_state_id`) REFERENCES `tbl_states`(`state_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_addresses` ADD CONSTRAINT `addr_country_id` FOREIGN KEY (`addr_country_id`) REFERENCES `tbl_countries`(`country_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ----------tbl_admin_auth_token------------------
ALTER TABLE `tbl_admin_auth_token` ADD CONSTRAINT `admrm_admin_id` FOREIGN KEY (`admauth_admin_id`) REFERENCES `tbl_admin`(`admin_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -----------tbl_admin_password_reset_requests-------------------------------
ALTER TABLE `tbl_admin_password_reset_requests` ADD CONSTRAINT `aprr_admin_id` FOREIGN KEY (`aprr_admin_id`) REFERENCES `tbl_admin`(`admin_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -----------tbl_admin_permissions-------------------------------
ALTER TABLE `tbl_admin_permissions` ADD CONSTRAINT `admperm_admin_id` FOREIGN KEY (`admperm_admin_id`) REFERENCES `tbl_admin`(`admin_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ---------------tbl_ads_batches--------------------------
ALTER TABLE `tbl_ads_batches` ADD CONSTRAINT `adsbatch_user_id` FOREIGN KEY (`adsbatch_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_ads_batches` ADD CONSTRAINT `adsbatch_target_country_id` FOREIGN KEY (`adsbatch_target_country_id`) REFERENCES `tbl_countries`(`country_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ----------------tbl_ads_batch_products-------------------
ALTER TABLE `tbl_ads_batch_products` ADD CONSTRAINT `abprod_selprod_id` FOREIGN KEY (`abprod_selprod_id`) REFERENCES `tbl_seller_products`(`selprod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ----------------tbl_affiliate_commission_settings-------------------
ALTER TABLE `tbl_affiliate_commission_settings` ADD CONSTRAINT `afcommsetting_prodcat_id` FOREIGN KEY (`afcommsetting_prodcat_id`) REFERENCES `tbl_product_categories`(`prodcat_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_affiliate_commission_settings` ADD CONSTRAINT `afcommsetting_user_id` FOREIGN KEY (`afcommsetting_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ----------------tbl_affiliate_commission_setting_history-------------------
ALTER TABLE `tbl_affiliate_commission_setting_history` ADD CONSTRAINT `acsh_afcommsetting_id` FOREIGN KEY (`acsh_afcommsetting_id`) REFERENCES `tbl_affiliate_commission_settings`(`afcommsetting_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_affiliate_commission_setting_history` ADD CONSTRAINT `acsh_afcommsetting_prodcat_id` FOREIGN KEY (`acsh_afcommsetting_prodcat_id`) REFERENCES `tbl_product_categories`(`prodcat_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_affiliate_commission_setting_history` ADD CONSTRAINT `acsh_afcommsetting_user_id` FOREIGN KEY (`acsh_afcommsetting_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- --------------tbl_attribute_group_attributes-------------
ALTER TABLE `tbl_attribute_group_attributes` ADD CONSTRAINT `attr_attrgrp_id` FOREIGN KEY (`attr_attrgrp_id`) REFERENCES `tbl_attribute_groups`(`attrgrp_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_badge_links-------------------------
ALTER TABLE `tbl_badge_links` ADD CONSTRAINT `badgelink_badge_id` FOREIGN KEY (`badgelink_badge_id`) REFERENCES `tbl_badges`(`badge_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ------------------tbl_banners------------------------
ALTER TABLE `tbl_banners` ADD CONSTRAINT `banner_blocation_id` FOREIGN KEY (`banner_blocation_id`) REFERENCES `tbl_banner_locations`(`blocation_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ------------------tbl_banners_clicks------------------------
ALTER TABLE `tbl_banners_clicks` ADD CONSTRAINT `bclick_banner_id` FOREIGN KEY (`bclick_banner_id`) REFERENCES `tbl_banners`(`banner_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_banners_clicks` ADD CONSTRAINT `bclick_user_id` FOREIGN KEY (`bclick_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ----------------tbl_banners_logs---------------------
ALTER TABLE `tbl_banners_logs` ADD CONSTRAINT `lbanner_banner_id` FOREIGN KEY (`lbanner_banner_id`) REFERENCES `tbl_banners`(`banner_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -----------------tbl_banner_locations----------------
ALTER TABLE `tbl_banner_locations` ADD CONSTRAINT `blocation_collection_id` FOREIGN KEY (`blocation_collection_id`) REFERENCES `tbl_collections`(`collection_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -----------------tbl_banner_location_dimensions-------------
ALTER TABLE `tbl_banner_location_dimensions` ADD CONSTRAINT `bldimension_blocation_id` FOREIGN KEY (`bldimension_blocation_id`) REFERENCES `tbl_banner_locations`(`blocation_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- --------------------tbl_blog_contributions--------------------------
ALTER TABLE `tbl_blog_contributions` ADD CONSTRAINT `bcontributions_user_id` FOREIGN KEY (`bcontributions_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ------------------tbl_blog_post_comments-----------------------
ALTER TABLE `tbl_blog_post_comments` ADD CONSTRAINT `bpcomment_post_id` FOREIGN KEY (`bpcomment_post_id`) REFERENCES `tbl_blog_post`(`post_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_blog_post_comments` ADD CONSTRAINT `bpcomment_user_id` FOREIGN KEY (`bpcomment_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -----------------tbl_blog_post_to_category---------------------------
ALTER TABLE `tbl_blog_post_to_category` ADD CONSTRAINT `ptc_bpcategory_id` FOREIGN KEY (`ptc_bpcategory_id`) REFERENCES `tbl_blog_post_categories`(`bpcategory_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_blog_post_to_category` ADD CONSTRAINT `ptc_post_id` FOREIGN KEY (`ptc_post_id`) REFERENCES `tbl_blog_post`(`post_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- --------------------tbl_brands---------------------------
ALTER TABLE `tbl_brands` ADD CONSTRAINT `brand_seller_id` FOREIGN KEY (`brand_seller_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ------------------tbl_catalog_request_messages-------------
ALTER TABLE `tbl_catalog_request_messages` ADD CONSTRAINT `scatrequestmsg_scatrequest_id` FOREIGN KEY (`scatrequestmsg_scatrequest_id`) REFERENCES `tbl_seller_catalog_requests`(`scatrequest_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_catalog_request_messages` ADD CONSTRAINT `scatrequestmsg_from_user_id` FOREIGN KEY (`scatrequestmsg_from_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_catalog_request_messages` ADD CONSTRAINT `scatrequestmsg_from_admin_id` FOREIGN KEY (`scatrequestmsg_from_admin_id`) REFERENCES `tbl_admin`(`admin_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ---------------------tbl_collection_to_records-----------------
ALTER TABLE `tbl_collection_to_records` ADD CONSTRAINT `ctr_collection_id` FOREIGN KEY (`ctr_collection_id`) REFERENCES `tbl_collections`(`collection_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------tbl_commission_settings-------------------
ALTER TABLE `tbl_commission_settings` ADD CONSTRAINT `commsetting_product_id` FOREIGN KEY (`commsetting_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_commission_settings` ADD CONSTRAINT `commsetting_user_id` FOREIGN KEY (`commsetting_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_commission_settings` ADD CONSTRAINT `commsetting_prodcat_id` FOREIGN KEY (`commsetting_prodcat_id`) REFERENCES `tbl_product_categories`(`prodcat_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ----------------tbl_commission_setting_history---------------------
ALTER TABLE `tbl_commission_setting_history` ADD CONSTRAINT `csh_commsetting_id` FOREIGN KEY (`csh_commsetting_id`) REFERENCES `tbl_commission_settings`(`commsetting_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_commission_setting_history` ADD CONSTRAINT `csh_commsetting_product_id` FOREIGN KEY (`csh_commsetting_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; ALTER TABLE `tbl_commission_setting_history` ADD CONSTRAINT `csh_commsetting_user_id` FOREIGN KEY (`csh_commsetting_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_commission_setting_history` ADD CONSTRAINT `csh_commsetting_prodcat_id` FOREIGN KEY (`csh_commsetting_prodcat_id`) REFERENCES `tbl_product_categories`(`prodcat_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- --------------------tbl_content_block_to_category-----------------------------
ALTER TABLE `tbl_content_block_to_category` ADD CONSTRAINT `cbtc_prodcat_id` FOREIGN KEY (`cbtc_prodcat_id`) REFERENCES `tbl_product_categories`(`prodcat_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_content_block_to_category` ADD CONSTRAINT `cbtc_cpage_id` FOREIGN KEY (`cbtc_cpage_id`) REFERENCES `tbl_content_pages`(`cpage_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------tbl_coupons_history----------------------------
ALTER TABLE `tbl_coupons_history` ADD CONSTRAINT `couponhistory_coupon_id` FOREIGN KEY (`couponhistory_coupon_id`) REFERENCES `tbl_coupons`(`coupon_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_coupons_history` ADD CONSTRAINT `couponhistory_order_id` FOREIGN KEY (`couponhistory_order_id`) REFERENCES `tbl_orders`(`order_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_coupons_history` ADD CONSTRAINT `couponhistory_user_id` FOREIGN KEY (`couponhistory_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- --------------------tbl_coupons_hold-----------------------------
ALTER TABLE `tbl_coupons_hold` ADD CONSTRAINT `couponhold_coupon_id` FOREIGN KEY (`couponhold_coupon_id`) REFERENCES `tbl_coupons`(`coupon_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_coupons_hold` ADD CONSTRAINT `couponhold_user_id` FOREIGN KEY (`couponhold_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ----------------------tbl_coupons_hold_pending_order-----------------
ALTER TABLE `tbl_coupons_hold_pending_order` ADD CONSTRAINT `ochold_order_id` FOREIGN KEY (`ochold_order_id`) REFERENCES `tbl_orders`(`order_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_coupons_hold_pending_order` ADD CONSTRAINT `ochold_coupon_id` FOREIGN KEY (`ochold_coupon_id`) REFERENCES `tbl_coupons`(`coupon_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -----------------------tbl_coupon_to_brands--------------------------
ALTER TABLE `tbl_coupon_to_brands` ADD CONSTRAINT `ctb_brand_id` FOREIGN KEY (`ctb_brand_id`) REFERENCES `tbl_brands`(`brand_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_coupon_to_brands` ADD CONSTRAINT `ctb_coupon_id` FOREIGN KEY (`ctb_coupon_id`) REFERENCES `tbl_coupons`(`coupon_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -----------------------tbl_coupon_to_category--------------------------
ALTER TABLE `tbl_coupon_to_category` ADD CONSTRAINT `ctc_prodcat_id` FOREIGN KEY (`ctc_prodcat_id`) REFERENCES `tbl_product_categories`(`prodcat_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_coupon_to_category` ADD CONSTRAINT `ctc_coupon_id` FOREIGN KEY (`ctc_coupon_id`) REFERENCES `tbl_coupons`(`coupon_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- --------------------------tbl_coupon_to_plan------------------------------
ALTER TABLE `tbl_coupon_to_plan` ADD CONSTRAINT `ctplan_spplan_id` FOREIGN KEY (`ctplan_spplan_id`) REFERENCES `tbl_seller_packages_plan`(`spplan_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_coupon_to_plan` ADD CONSTRAINT `ctplan_coupon_id` FOREIGN KEY (`ctplan_coupon_id`) REFERENCES `tbl_coupons`(`coupon_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- --------------------tbl_coupon_to_products-------------------
ALTER TABLE `tbl_coupon_to_products` ADD CONSTRAINT `ctp_product_id` FOREIGN KEY (`ctp_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_coupon_to_products` ADD CONSTRAINT `ctp_coupon_id` FOREIGN KEY (`ctp_coupon_id`) REFERENCES `tbl_coupons`(`coupon_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------tbl_coupon_to_seller-----------------------------
ALTER TABLE `tbl_coupon_to_seller` ADD CONSTRAINT `cts_user_id` FOREIGN KEY (`cts_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_coupon_to_seller` ADD CONSTRAINT `cts_coupon_id` FOREIGN KEY (`cts_coupon_id`) REFERENCES `tbl_coupons`(`coupon_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------tbl_coupon_to_shops-----------------------------
/* ALTER TABLE `tbl_coupon_to_shops` ADD CONSTRAINT `cts_shop_id` FOREIGN KEY (`cts_shop_id`) REFERENCES `tbl_shops`(`shop_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_coupon_to_shops` ADD CONSTRAINT `cts_coupon_id` FOREIGN KEY (`cts_coupon_id`) REFERENCES `tbl_coupons`(`coupon_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; */

-- -------------------tbl_coupon_to_users-----------------------------
ALTER TABLE `tbl_coupon_to_users` ADD CONSTRAINT `ctu_user_id` FOREIGN KEY (`ctu_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_coupon_to_users` ADD CONSTRAINT `ctu_coupon_id` FOREIGN KEY (`ctu_coupon_id`) REFERENCES `tbl_coupons`(`coupon_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ---------------------tbl_cron_log----------------
ALTER TABLE `tbl_cron_log` ADD CONSTRAINT `cronlog_cron_id` FOREIGN KEY (`cronlog_cron_id`) REFERENCES `tbl_cron_schedules`(`cron_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ---------------------tbl_extra_attributes----------------------------
ALTER TABLE `tbl_extra_attributes` ADD CONSTRAINT `eattribute_eattrgroup_id` FOREIGN KEY (`eattribute_eattrgroup_id`) REFERENCES `tbl_extra_attribute_groups`(`eattrgroup_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -----------------tbl_extra_attribute_groups----------------------
ALTER TABLE `tbl_extra_attribute_groups` ADD CONSTRAINT `eattrgroup_seller_id` FOREIGN KEY (`eattrgroup_seller_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ----------------------tbl_faqs---------------------
ALTER TABLE `tbl_faqs` ADD CONSTRAINT `faq_faqcat_id` FOREIGN KEY (`faq_faqcat_id`) REFERENCES `tbl_faqs`(`faq_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -----------------tbl_filters------------------------------------
ALTER TABLE `tbl_filters` ADD CONSTRAINT `filter_filtergroup_id` FOREIGN KEY (`filter_filtergroup_id`) REFERENCES `tbl_filter_groups`(`filtergroup_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -----------------tbl_import_export_settings--------------------------------
ALTER TABLE `tbl_import_export_settings` ADD CONSTRAINT `impexp_setting_user_id` FOREIGN KEY (`impexp_setting_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ---------------------tbl_shipping_durations-------------------------
ALTER TABLE `tbl_manual_shipping_api` ADD CONSTRAINT `mshipapi_sduration_id` FOREIGN KEY (`mshipapi_sduration_id`) REFERENCES `tbl_shipping_durations`(`sduration_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_manual_shipping_api` ADD CONSTRAINT `mshipapi_state_id` FOREIGN KEY (`mshipapi_state_id`) REFERENCES `tbl_states`(`state_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_manual_shipping_api` ADD CONSTRAINT `mshipapi_country_id` FOREIGN KEY (`mshipapi_country_id`) REFERENCES `tbl_countries`(`country_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ---------------tbl_navigation_links--------------------
ALTER TABLE `tbl_navigation_links` ADD CONSTRAINT `nlink_nav_id` FOREIGN KEY (`nlink_nav_id`) REFERENCES `tbl_navigations`(`nav_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_navigation_links` ADD CONSTRAINT `nlink_cpage_id` FOREIGN KEY (`nlink_cpage_id`) REFERENCES `tbl_content_pages`(`cpage_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_navigation_links` ADD CONSTRAINT `nlink_category_id` FOREIGN KEY (`nlink_category_id`) REFERENCES `tbl_product_categories`(`prodcat_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ----------------------tbl_notifications---------------
ALTER TABLE `tbl_notifications` ADD CONSTRAINT `notification_user_id` FOREIGN KEY (`notification_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ------------------tbl_options----------------
ALTER TABLE `tbl_options` ADD CONSTRAINT `option_seller_id` FOREIGN KEY (`option_seller_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------tbl_option_values----------------------------
ALTER TABLE `tbl_option_values` ADD CONSTRAINT `optionvalue_option_id` FOREIGN KEY (`optionvalue_option_id`) REFERENCES `tbl_options`(`option_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- --------------------tbl_orders----------------------------------
ALTER TABLE `tbl_orders` ADD  CONSTRAINT `order_user_id` FOREIGN KEY (`order_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_orders` ADD  CONSTRAINT `order_language_id` FOREIGN KEY (`order_language_id`) REFERENCES `tbl_languages`(`language_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_orders` ADD  CONSTRAINT `order_currency_id` FOREIGN KEY (`order_currency_id`) REFERENCES `tbl_currency`(`currency_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_orders` ADD  CONSTRAINT `order_shippingapi_id` FOREIGN KEY (`order_shippingapi_id`) REFERENCES `tbl_shipping_apis`(`shippingapi_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_orders` ADD  CONSTRAINT `order_pmethod_id` FOREIGN KEY (`order_pmethod_id`) REFERENCES `tbl_payment_methods`(`pmethod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_orders` ADD  CONSTRAINT `order_referrer_user_id` FOREIGN KEY (`order_referrer_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_orders` ADD  CONSTRAINT `order_affiliate_user_id` FOREIGN KEY (`order_affiliate_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ------------------tbl_orders_status_history-----------------------
ALTER TABLE `tbl_orders_status_history` ADD CONSTRAINT `oshistory_order_id` FOREIGN KEY (`oshistory_order_id`) REFERENCES `tbl_orders`(`order_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_orders_status_history` ADD CONSTRAINT `oshistory_op_id` FOREIGN KEY (`oshistory_op_id`) REFERENCES `tbl_order_products`(`op_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_orders_status_history` ADD CONSTRAINT `oshistory_orderstatus_id` FOREIGN KEY (`oshistory_orderstatus_id`) REFERENCES `tbl_orders_status`(`orderstatus_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------tbl_order_cancel_requests----------
ALTER TABLE `tbl_order_cancel_requests` ADD CONSTRAINT `ocrequest_user_id` FOREIGN KEY (`ocrequest_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_order_cancel_requests` ADD CONSTRAINT `ocrequest_op_id` FOREIGN KEY (`ocrequest_op_id`) REFERENCES `tbl_order_products`(`op_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_order_cancel_requests` ADD CONSTRAINT `ocrequest_ocreason_id` FOREIGN KEY (`ocrequest_ocreason_id`) REFERENCES `tbl_order_cancel_reasons`(`ocreason_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- --------------tbl_order_payments--------------
ALTER TABLE `tbl_order_payments` ADD CONSTRAINT `opayment_order_id` FOREIGN KEY (`opayment_order_id`) REFERENCES `tbl_orders`(`order_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -----------------------tbl_order_products--------------------
ALTER TABLE `tbl_order_products` ADD CONSTRAINT `op_order_id` FOREIGN KEY (`op_order_id`) REFERENCES `tbl_orders`(`order_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_order_products` ADD CONSTRAINT `op_selprod_id` FOREIGN KEY (`op_selprod_id`) REFERENCES `tbl_seller_products`(`selprod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_order_products` ADD CONSTRAINT `op_selprod_user_id` FOREIGN KEY (`op_selprod_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_order_products` ADD CONSTRAINT `op_shop_id` FOREIGN KEY (`op_shop_id`) REFERENCES `tbl_shops`(`shop_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_order_products` ADD CONSTRAINT `op_status_id` FOREIGN KEY (`op_status_id`) REFERENCES `tbl_orders_status`(`orderstatus_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ---------------------------tbl_order_product_charges-----------------
ALTER TABLE `tbl_order_product_charges` ADD CONSTRAINT `opcharge_op_id` FOREIGN KEY (`opcharge_op_id`) REFERENCES `tbl_order_products`(`op_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ----------------------tbl_order_product_digital_download_links-------------------------
ALTER TABLE `tbl_order_product_digital_download_links` ADD CONSTRAINT `opddl_op_id` FOREIGN KEY (`opddl_op_id`) REFERENCES `tbl_order_products`(`op_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- ---------------------------tbl_order_product_settings-----------------------------
ALTER TABLE `tbl_order_product_settings` ADD CONSTRAINT `opsetting_op_id` FOREIGN KEY (`opsetting_op_id`) REFERENCES `tbl_order_products`(`op_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_order_product_shipment-------------------------
ALTER TABLE `tbl_order_product_shipment` ADD CONSTRAINT `opship_op_id` FOREIGN KEY (`opship_op_id`) REFERENCES `tbl_order_products`(`op_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_order_product_shipping-------------------------
ALTER TABLE `tbl_order_product_shipping` ADD CONSTRAINT `opshipping_op_id` FOREIGN KEY (`opshipping_op_id`) REFERENCES `tbl_order_products`(`op_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_order_product_to_shipping_users-------------------------
ALTER TABLE `tbl_order_product_to_shipping_users` ADD CONSTRAINT `optsu_op_id` FOREIGN KEY (`optsu_op_id`) REFERENCES `tbl_order_products`(`op_id`) ON DELETE RESTRICT ON UPDATE RESTRICT; 
ALTER TABLE `tbl_order_product_to_shipping_users` ADD CONSTRAINT `optsu_user_id` FOREIGN KEY (`optsu_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_order_prod_charges_logs-------------------------
ALTER TABLE `tbl_order_prod_charges_logs` ADD CONSTRAINT `opchargelog_op_id` FOREIGN KEY (`opchargelog_op_id`) REFERENCES `tbl_order_products`(`op_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_order_return_requests-------------------------
ALTER TABLE `tbl_order_return_requests` ADD CONSTRAINT `orrequest_user_id` FOREIGN KEY (`orrequest_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_order_return_requests` ADD CONSTRAINT `orrequest_op_id` FOREIGN KEY (`orrequest_op_id`) REFERENCES `tbl_order_products`(`op_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_order_return_requests` ADD CONSTRAINT `orrequest_returnreason_id` FOREIGN KEY (`orrequest_returnreason_id`) REFERENCES `tbl_order_return_reasons`(`orreason_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_order_return_request_messages-------------------------
ALTER TABLE `tbl_order_return_request_messages` ADD CONSTRAINT `orrmsg_orrequest_id` FOREIGN KEY (`orrmsg_orrequest_id`) REFERENCES `tbl_order_return_requests`(`orrequest_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_order_return_request_messages` ADD CONSTRAINT `orrmsg_from_user_id` FOREIGN KEY (`orrmsg_from_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_order_return_request_messages` ADD CONSTRAINT `orrmsg_from_admin_id` FOREIGN KEY (`orrmsg_from_admin_id`) REFERENCES `tbl_admin`(`admin_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_order_seller_subscriptions-------------------------
ALTER TABLE `tbl_order_seller_subscriptions` ADD CONSTRAINT `ossubs_plan_id` FOREIGN KEY (`ossubs_plan_id`) REFERENCES `tbl_seller_packages_plan`(`spplan_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_order_seller_subscriptions` ADD CONSTRAINT `ossubs_order_id` FOREIGN KEY (`ossubs_order_id`) REFERENCES `tbl_orders`(`order_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_order_user_address-------------------------
ALTER TABLE `tbl_order_user_address` ADD CONSTRAINT `oua_op_id` FOREIGN KEY (`oua_op_id`) REFERENCES `tbl_order_products`(`op_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_polling_feedback-------------------------
ALTER TABLE `tbl_polling_feedback` ADD CONSTRAINT `pollfeedback_polling_id` FOREIGN KEY (`pollfeedback_polling_id`) REFERENCES `tbl_polling`(`polling_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_polling_to_category-------------------------
ALTER TABLE `tbl_polling_to_category` ADD CONSTRAINT `ptc_polling_id` FOREIGN KEY (`ptc_polling_id`) REFERENCES `tbl_polling`(`polling_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_polling_to_category` ADD CONSTRAINT `ptc_prodcat_id` FOREIGN KEY (`ptc_prodcat_id`) REFERENCES `tbl_product_categories`(`prodcat_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_polling_to_products-------------------------
ALTER TABLE `tbl_polling_to_products` ADD CONSTRAINT `ptp_polling_id` FOREIGN KEY (`ptp_polling_id`) REFERENCES `tbl_polling`(`polling_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_polling_to_products` ADD CONSTRAINT `ptp_product_id` FOREIGN KEY (`ptp_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_polling_to_products-------------------------
ALTER TABLE `tbl_polling_to_products` ADD CONSTRAINT `ptp_polling_id` FOREIGN KEY (`ptp_polling_id`) REFERENCES `tbl_polling`(`polling_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_polling_to_products` ADD CONSTRAINT `ptp_product_id` FOREIGN KEY (`ptp_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_products_browsing_history-------------------------
ALTER TABLE `tbl_products_browsing_history` ADD CONSTRAINT `pbhistory_user_id` FOREIGN KEY (`pbhistory_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_products_browsing_history` ADD CONSTRAINT `pbhistory_product_id` FOREIGN KEY (`pbhistory_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_products_min_price-------------------------
ALTER TABLE `tbl_products_min_price` ADD CONSTRAINT `pmp_selprod_id` FOREIGN KEY (`pmp_selprod_id`) REFERENCES `tbl_seller_products`(`selprod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_products_shipped_by_seller-------------------------
ALTER TABLE `tbl_products_shipped_by_seller` ADD CONSTRAINT `psbs_product_id` FOREIGN KEY (`psbs_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_products_shipped_by_seller` ADD CONSTRAINT `psbs_user_id` FOREIGN KEY (`psbs_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_products_shipping-------------------------
ALTER TABLE `tbl_products_shipping` ADD CONSTRAINT `ps_product_id` FOREIGN KEY (`ps_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_products_shipping` ADD CONSTRAINT `ps_user_id` FOREIGN KEY (`ps_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
 
-- -------------------------tbl_products_temp_ids-------------------------
ALTER TABLE `tbl_products_temp_ids` ADD CONSTRAINT `pti_product_id` FOREIGN KEY (`pti_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_products_temp_ids` ADD CONSTRAINT `pti_user_id` FOREIGN KEY (`pti_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_product_product_recommendation-------------------------
ALTER TABLE `tbl_product_product_recommendation` ADD CONSTRAINT `ppr_viewing_product_id` FOREIGN KEY (`ppr_viewing_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_product_product_recommendation` ADD CONSTRAINT `ppr_recommended_product_id` FOREIGN KEY (`ppr_recommended_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_product_requests-------------------------
ALTER TABLE `tbl_product_requests` ADD CONSTRAINT `preq_user_id` FOREIGN KEY (`preq_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_product_requests` ADD CONSTRAINT `preq_prodcat_id` FOREIGN KEY (`preq_prodcat_id`) REFERENCES `tbl_product_categories`(`prodcat_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_product_saved_search-------------------------
ALTER TABLE `tbl_product_saved_search` ADD CONSTRAINT `pssearch_user_id` FOREIGN KEY (`pssearch_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_product_special_prices-------------------------
ALTER TABLE `tbl_product_special_prices` ADD CONSTRAINT `splprice_selprod_id` FOREIGN KEY (`splprice_selprod_id`) REFERENCES `tbl_seller_products`(`selprod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_product_specifications-------------------------
ALTER TABLE `tbl_product_specifications` ADD CONSTRAINT `prodspec_product_id` FOREIGN KEY (`prodspec_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_product_stock_hold-------------------------
ALTER TABLE `tbl_product_stock_hold` ADD CONSTRAINT `pshold_selprod_id` FOREIGN KEY (`pshold_selprod_id`) REFERENCES `tbl_seller_products`(`selprod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_product_to_category-------------------------
ALTER TABLE `tbl_product_to_category` ADD CONSTRAINT `ptc_product_id` FOREIGN KEY (`ptc_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_product_to_category` ADD CONSTRAINT `ptc_prodcat_id` FOREIGN KEY (`ptc_prodcat_id`) REFERENCES `tbl_product_categories`(`prodcat_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_product_to_groups-------------------------
ALTER TABLE `tbl_product_to_groups` ADD CONSTRAINT `ptg_prodgroup_id` FOREIGN KEY (`ptg_prodgroup_id`) REFERENCES `tbl_product_groups`(`prodgroup_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_product_to_groups` ADD CONSTRAINT `ptg_selprod_id` FOREIGN KEY (`ptg_selprod_id`) REFERENCES `tbl_seller_products`(`selprod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_product_to_options-------------------------
ALTER TABLE `tbl_product_to_options` ADD CONSTRAINT `prodoption_product_id` FOREIGN KEY (`prodoption_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_product_to_options` ADD CONSTRAINT `prodoption_option_id` FOREIGN KEY (`prodoption_option_id`) REFERENCES `tbl_options`(`option_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_product_to_tags-------------------------
ALTER TABLE `tbl_product_to_tags` ADD CONSTRAINT `ptt_product_id` FOREIGN KEY (`ptt_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_product_to_tags` ADD CONSTRAINT `ptt_tag_id` FOREIGN KEY (`ptt_tag_id`) REFERENCES `tbl_tags`(`tag_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_product_to_tax-------------------------
ALTER TABLE `tbl_product_to_tax` ADD CONSTRAINT `ptt_tax_product_id` FOREIGN KEY (`ptt_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_product_to_tax` ADD CONSTRAINT `ptt_taxcat_id` FOREIGN KEY (`ptt_taxcat_id`) REFERENCES `tbl_tax_categories`(`taxcat_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_product_volume_discount-------------------------
ALTER TABLE `tbl_product_volume_discount` ADD CONSTRAINT `voldiscount_selprod_id` FOREIGN KEY (`voldiscount_selprod_id`) REFERENCES `tbl_seller_products`(`selprod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_promotions_charges-------------------------
ALTER TABLE `tbl_promotions_charges` ADD CONSTRAINT `pcharge_user_id` FOREIGN KEY (`pcharge_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_promotions_charges` ADD CONSTRAINT `pcharge_promotion_id` FOREIGN KEY (`pcharge_promotion_id`) REFERENCES `tbl_promotions`(`promotion_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_promotions_clicks-------------------------
ALTER TABLE `tbl_promotions_clicks` ADD CONSTRAINT `pclick_promotion_id` FOREIGN KEY (`pclick_promotion_id`) REFERENCES `tbl_promotions`(`promotion_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_promotions_clicks` ADD CONSTRAINT `pclick_user_id` FOREIGN KEY (`pclick_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_promotions_logs-------------------------
ALTER TABLE `tbl_promotions_logs` ADD CONSTRAINT `plog_promotion_id` FOREIGN KEY (`plog_promotion_id`) REFERENCES `tbl_promotions`(`promotion_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_promotion_item_charges-------------------------
ALTER TABLE `tbl_promotion_item_charges` ADD CONSTRAINT `picharge_pclick_id` FOREIGN KEY (`picharge_pclick_id`) REFERENCES `tbl_promotions_clicks`(`pclick_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
 
-- -------------------------tbl_push_notification_to_users-------------------------
ALTER TABLE `tbl_push_notification_to_users` ADD CONSTRAINT `pntu_pnotification_id` FOREIGN KEY (`pntu_pnotification_id`) REFERENCES `tbl_push_notifications`(`pnotification_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_push_notification_to_users` ADD CONSTRAINT `pntu_user_id` FOREIGN KEY (`pntu_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
  
-- -------------------------tbl_questionnaires_to_question-------------------------
ALTER TABLE `tbl_questionnaires_to_question` ADD CONSTRAINT `qtq_question_id` FOREIGN KEY (`qtq_question_id`) REFERENCES `tbl_questionnaires`(`questionnaire_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
 
-- -------------------------tbl_questionnaire_feedback-------------------------
ALTER TABLE `tbl_questionnaire_feedback` ADD CONSTRAINT `qfeedback_questionnaire_id` FOREIGN KEY (`qfeedback_questionnaire_id`) REFERENCES `tbl_questionnaires`(`questionnaire_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
 
-- -------------------------tbl_questions-------------------------
ALTER TABLE `tbl_questions` ADD CONSTRAINT `question_qbank_id` FOREIGN KEY (`question_qbank_id`) REFERENCES `tbl_question_banks`(`qbank_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
 
-- -------------------------tbl_question_to_answers-------------------------
ALTER TABLE `tbl_question_to_answers` ADD CONSTRAINT `qta_qfeedback_id` FOREIGN KEY (`qta_qfeedback_id`) REFERENCES `tbl_questionnaire_feedback`(`qfeedback_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_question_to_answers` ADD CONSTRAINT `qta_question_id` FOREIGN KEY (`qta_question_id`) REFERENCES `tbl_questions`(`question_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
 
-- -------------------------tbl_related_products-------------------------
ALTER TABLE `tbl_related_products` ADD CONSTRAINT `related_sellerproduct_id` FOREIGN KEY (`related_sellerproduct_id`) REFERENCES `tbl_seller_products`(`selprod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_seller_brand_requests-------------------------
ALTER TABLE `tbl_seller_brand_requests` ADD CONSTRAINT `sbrandreq_seller_id` FOREIGN KEY (`sbrandreq_seller_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_seller_catalog_requests-------------------------
ALTER TABLE `tbl_seller_catalog_requests` ADD CONSTRAINT `scatrequest_user_id` FOREIGN KEY (`scatrequest_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_seller_products-------------------------
ALTER TABLE `tbl_seller_products` ADD CONSTRAINT `selprod_user_id` FOREIGN KEY (`selprod_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_seller_products` ADD CONSTRAINT `selprod_product_id` FOREIGN KEY (`selprod_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_seller_product_options-------------------------
ALTER TABLE `tbl_seller_product_options` ADD CONSTRAINT `selprodoption_selprod_id` FOREIGN KEY (`selprodoption_selprod_id`) REFERENCES `tbl_seller_products`(`selprod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_seller_product_options` ADD CONSTRAINT `selprodoption_option_id` FOREIGN KEY (`selprodoption_option_id`) REFERENCES `tbl_options`(`option_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_seller_product_options` ADD CONSTRAINT `selprodoption_optionvalue_id` FOREIGN KEY (`selprodoption_optionvalue_id`) REFERENCES `tbl_option_values`(`optionvalue_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_seller_product_policies-------------------------
ALTER TABLE `tbl_seller_product_policies` ADD CONSTRAINT `sppolicy_selprod_id` FOREIGN KEY (`sppolicy_selprod_id`) REFERENCES `tbl_seller_products`(`selprod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_seller_product_policies` ADD CONSTRAINT `sppolicy_ppoint_id` FOREIGN KEY (`sppolicy_ppoint_id`) REFERENCES `tbl_policy_points`(`ppoint_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_seller_product_rating-------------------------
ALTER TABLE `tbl_seller_product_rating` ADD CONSTRAINT `sprating_spreview_id` FOREIGN KEY (`sprating_spreview_id`) REFERENCES `tbl_seller_product_reviews`(`spreview_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_seller_product_reviews-------------------------
ALTER TABLE `tbl_seller_product_reviews` ADD CONSTRAINT `spreview_seller_user_id` FOREIGN KEY (`spreview_seller_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_seller_product_reviews` ADD CONSTRAINT `spreview_order_id` FOREIGN KEY (`spreview_order_id`) REFERENCES `tbl_orders`(`order_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_seller_product_reviews` ADD CONSTRAINT `spreview_product_id` FOREIGN KEY (`spreview_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_seller_product_reviews` ADD CONSTRAINT `spreview_selprod_id` FOREIGN KEY (`spreview_selprod_id`) REFERENCES `tbl_seller_products`(`selprod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_seller_product_reviews` ADD CONSTRAINT `spreview_postedby_user_id` FOREIGN KEY (`spreview_postedby_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_seller_product_reviews_abuse-------------------------
ALTER TABLE `tbl_seller_product_reviews_abuse` ADD CONSTRAINT `spra_spreview_id` FOREIGN KEY (`spra_spreview_id`) REFERENCES `tbl_seller_product_reviews`(`spreview_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_seller_product_reviews_abuse` ADD CONSTRAINT `spra_user_id` FOREIGN KEY (`spra_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_seller_product_reviews_helpful-------------------------
ALTER TABLE `tbl_seller_product_reviews_helpful` ADD CONSTRAINT `sprh_spreview_id` FOREIGN KEY (`sprh_spreview_id`) REFERENCES `tbl_seller_product_reviews`(`spreview_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_seller_product_reviews_helpful` ADD CONSTRAINT `sprh_user_id` FOREIGN KEY (`sprh_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_seller_product_specifics-------------------------
ALTER TABLE `tbl_seller_product_specifics` ADD CONSTRAINT `sps_selprod_id` FOREIGN KEY (`sps_selprod_id`) REFERENCES `tbl_seller_products`(`selprod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_shipping_locations-------------------------
ALTER TABLE `tbl_shipping_locations` ADD CONSTRAINT `shiploc_zone_id` FOREIGN KEY (`shiploc_zone_id`) REFERENCES `tbl_zones`(`zone_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_shipping_locations` ADD CONSTRAINT `shiploc_country_id` FOREIGN KEY (`shiploc_country_id`) REFERENCES `tbl_countries`(`country_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_shipping_locations` ADD CONSTRAINT `shiploc_state_id` FOREIGN KEY (`shiploc_state_id`) REFERENCES `tbl_states`(`state_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_shipping_profile_products-------------------------
ALTER TABLE `tbl_shipping_profile_products` ADD CONSTRAINT `shippro_product_id` FOREIGN KEY (`shippro_product_id`) REFERENCES `tbl_products`(`product_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_shipping_profile_products` ADD CONSTRAINT `shippro_user_id` FOREIGN KEY (`shippro_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_shipping_profile_zones-------------------------
ALTER TABLE `tbl_shipping_profile_zones` ADD CONSTRAINT `shipprozone_shipprofile_id` FOREIGN KEY (`shipprozone_shipprofile_id`) REFERENCES `tbl_shipping_profile`(`shipprofile_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_shipping_profile_zones` ADD CONSTRAINT `shipprozone_shipzone_id` FOREIGN KEY (`shipprozone_shipzone_id`) REFERENCES `tbl_shipping_zone`(`shipzone_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_shipping_rates-------------------------
ALTER TABLE `tbl_shipping_rates` ADD CONSTRAINT `shiprate_shipprozone_id` FOREIGN KEY (`shiprate_shipprozone_id`) REFERENCES `tbl_shipping_profile_zones`(`shipprozone_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_shipping_zone-------------------------
ALTER TABLE `tbl_shipping_zone` ADD CONSTRAINT `shipzone_user_id` FOREIGN KEY (`shipzone_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_shops-------------------------
ALTER TABLE `tbl_shops` ADD CONSTRAINT `shop_user_id` FOREIGN KEY (`shop_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_shops` ADD CONSTRAINT `shop_country_id` FOREIGN KEY (`shop_country_id`) REFERENCES `tbl_countries`(`country_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_shops` ADD CONSTRAINT `shop_state_id` FOREIGN KEY (`shop_state_id`) REFERENCES `tbl_states`(`state_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_shops_to_theme-------------------------
ALTER TABLE `tbl_shops_to_theme` ADD CONSTRAINT `stt_shop_id` FOREIGN KEY (`stt_shop_id`) REFERENCES `tbl_shops`(`shop_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_shop_collections-------------------------
ALTER TABLE `tbl_shop_collections` ADD CONSTRAINT `scollection_shop_id` FOREIGN KEY (`scollection_shop_id`) REFERENCES `tbl_shops`(`shop_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_shop_collection_products-------------------------
ALTER TABLE `tbl_shop_collection_products` ADD CONSTRAINT `scp_scollection_id` FOREIGN KEY (`scp_scollection_id`) REFERENCES `tbl_shop_collections`(`scollection_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_shop_collection_products` ADD CONSTRAINT `scp_selprod_id` FOREIGN KEY (`scp_selprod_id`) REFERENCES `tbl_seller_products`(`selprod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_shop_reports-------------------------
ALTER TABLE `tbl_shop_reports` ADD CONSTRAINT `sreport_shop_id` FOREIGN KEY (`sreport_shop_id`) REFERENCES `tbl_shops`(`shop_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_shop_reports` ADD CONSTRAINT `sreport_reportreason_id` FOREIGN KEY (`sreport_reportreason_id`) REFERENCES `tbl_report_reasons`(`reportreason_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_shop_reports` ADD CONSTRAINT `sreport_user_id` FOREIGN KEY (`sreport_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_states-------------------------
ALTER TABLE `tbl_states` ADD CONSTRAINT `state_country_id` FOREIGN KEY (`state_country_id`) REFERENCES `tbl_countries`(`country_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_tax_rules-------------------------
ALTER TABLE `tbl_tax_rules` ADD CONSTRAINT `taxrule_taxcat_id` FOREIGN KEY (`taxrule_taxcat_id`) REFERENCES `tbl_tax_categories`(`taxcat_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_tax_rules` ADD CONSTRAINT `taxrule_taxstr_id` FOREIGN KEY (`taxrule_taxstr_id`) REFERENCES `tbl_tax_structure`(`taxstr_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_tax_rule_details-------------------------
ALTER TABLE `tbl_tax_rule_details` ADD CONSTRAINT `taxruledet_taxrule_id` FOREIGN KEY (`taxruledet_taxrule_id`) REFERENCES `tbl_tax_rules`(`taxrule_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_tax_rule_details` ADD CONSTRAINT `taxruledet_taxstr_id` FOREIGN KEY (`taxruledet_taxstr_id`) REFERENCES `tbl_tax_structure`(`taxstr_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_tax_rule_locations-------------------------
ALTER TABLE `tbl_tax_rule_locations` ADD CONSTRAINT `taxruleloc_taxcat_id` FOREIGN KEY (`taxruleloc_taxcat_id`) REFERENCES `tbl_tax_categories`(`taxcat_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_tax_rule_locations` ADD CONSTRAINT `taxruleloc_taxrule_id` FOREIGN KEY (`taxruleloc_taxrule_id`) REFERENCES `tbl_tax_rules`(`taxrule_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_tax_rule_locations` ADD CONSTRAINT `taxruleloc_country_id` FOREIGN KEY (`taxruleloc_country_id`) REFERENCES `tbl_countries`(`country_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_tax_rule_locations` ADD CONSTRAINT `taxruleloc_state_id` FOREIGN KEY (`taxruleloc_state_id`) REFERENCES `tbl_states`(`state_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_thread_messages-------------------------
ALTER TABLE `tbl_thread_messages` ADD CONSTRAINT `message_thread_id` FOREIGN KEY (`message_thread_id`) REFERENCES `tbl_threads`(`thread_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_thread_messages` ADD CONSTRAINT `message_from` FOREIGN KEY (`message_from`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_thread_messages` ADD CONSTRAINT `message_to` FOREIGN KEY (`message_to`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_users-------------------------
ALTER TABLE `tbl_users` ADD CONSTRAINT `user_country_id` FOREIGN KEY (`user_country_id`) REFERENCES `tbl_countries`(`country_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_users` ADD CONSTRAINT `user_state_id` FOREIGN KEY (`user_state_id`) REFERENCES `tbl_states`(`state_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_users` ADD CONSTRAINT `user_referrer_user_id` FOREIGN KEY (`user_referrer_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_users` ADD CONSTRAINT `user_affiliate_referrer_user_id` FOREIGN KEY (`user_affiliate_referrer_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_auth_token-------------------------
ALTER TABLE `tbl_user_auth_token` ADD CONSTRAINT `uauth_user_id` FOREIGN KEY (`uauth_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_bank_details-------------------------
ALTER TABLE `tbl_user_bank_details` ADD CONSTRAINT `ub_user_id` FOREIGN KEY (`ub_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_cart-------------------------
ALTER TABLE `tbl_user_cart` ADD CONSTRAINT `usercart_user_id` FOREIGN KEY (`usercart_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_collections-------------------------
ALTER TABLE `tbl_user_collections` ADD CONSTRAINT `uc_user_id` FOREIGN KEY (`uc_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_credentials-------------------------
ALTER TABLE `tbl_user_credentials` ADD CONSTRAINT `credential_user_id` FOREIGN KEY (`credential_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_email_verification-------------------------
ALTER TABLE `tbl_user_email_verification` ADD CONSTRAINT `uev_user_id` FOREIGN KEY (`uev_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_extras-------------------------
ALTER TABLE `tbl_user_extras` ADD CONSTRAINT `uextra_user_id` FOREIGN KEY (`uextra_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_favourite_products-------------------------
ALTER TABLE `tbl_user_favourite_products` ADD CONSTRAINT `ufp_user_id` FOREIGN KEY (`ufp_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_user_favourite_products` ADD CONSTRAINT `ufp_selprod_id` FOREIGN KEY (`ufp_selprod_id`) REFERENCES `tbl_seller_products`(`selprod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_favourite_shops-------------------------
ALTER TABLE `tbl_user_favourite_shops` ADD CONSTRAINT `ufs_user_id` FOREIGN KEY (`ufs_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_user_favourite_shops` ADD CONSTRAINT `ufs_shop_id` FOREIGN KEY (`ufs_shop_id`) REFERENCES `tbl_shops`(`shop_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_notifications-------------------------
ALTER TABLE `tbl_user_notifications` ADD CONSTRAINT `unotification_user_id` FOREIGN KEY (`unotification_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_product_recommendation-------------------------
ALTER TABLE `tbl_user_product_recommendation` ADD CONSTRAINT `upr_product_id` FOREIGN KEY (`upr_product_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_requests_history-------------------------
ALTER TABLE `tbl_user_requests_history` ADD CONSTRAINT `ureq_user_id` FOREIGN KEY (`ureq_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_return_address-------------------------
ALTER TABLE `tbl_user_requests_history` ADD CONSTRAINT `ura_user_id` FOREIGN KEY (`ura_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_user_requests_history` ADD CONSTRAINT `ura_state_id` FOREIGN KEY (`ura_state_id`) REFERENCES `tbl_states`(`state_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_user_requests_history` ADD CONSTRAINT `ura_country_id` FOREIGN KEY (`ura_country_id`) REFERENCES `tbl_countries`(`country_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_reward_points-------------------------
ALTER TABLE `tbl_user_reward_points` ADD CONSTRAINT `urp_user_id` FOREIGN KEY (`urp_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_user_reward_points` ADD CONSTRAINT `urp_referral_user_id` FOREIGN KEY (`urp_referral_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_reward_point_breakup-------------------------
ALTER TABLE `tbl_user_reward_point_breakup` ADD CONSTRAINT `urpbreakup_urp_id` FOREIGN KEY (`urpbreakup_urp_id`) REFERENCES `tbl_user_reward_points`(`urpbreakup_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_user_reward_point_breakup` ADD CONSTRAINT `urpbreakup_referral_user_id` FOREIGN KEY (`urpbreakup_referral_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_supplier_requests-------------------------
ALTER TABLE `tbl_user_supplier_requests` ADD CONSTRAINT `usuprequest_user_id` FOREIGN KEY (`usuprequest_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_supplier_request_values-------------------------
ALTER TABLE `tbl_user_supplier_request_values` ADD CONSTRAINT `sfreqvalue_request_id` FOREIGN KEY (`sfreqvalue_request_id`) REFERENCES `tbl_user_supplier_requests`(`usuprequest_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_user_supplier_request_values` ADD CONSTRAINT `sfreqvalue_formfield_id` FOREIGN KEY (`sfreqvalue_formfield_id`) REFERENCES `tbl_user_supplier_form_fields`(`sformfield_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_transactions-------------------------
ALTER TABLE `tbl_user_transactions` ADD CONSTRAINT `utxn_user_id` FOREIGN KEY (`utxn_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_wish_lists-------------------------
ALTER TABLE `tbl_user_wish_lists` ADD CONSTRAINT `uwlist_user_id` FOREIGN KEY (`uwlist_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_wish_list_products-------------------------
ALTER TABLE `tbl_user_wish_list_products` ADD CONSTRAINT `uwlp_uwlist_id` FOREIGN KEY (`uwlp_uwlist_id`) REFERENCES `tbl_user_wish_lists`(`uwlist_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
ALTER TABLE `tbl_user_wish_list_products` ADD CONSTRAINT `uwlp_selprod_id` FOREIGN KEY (`uwlp_selprod_id`) REFERENCES `tbl_seller_products`(`selprod_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

-- -------------------------tbl_user_withdrawal_requests-------------------------
ALTER TABLE `tbl_user_withdrawal_requests` ADD CONSTRAINT `withdrawal_user_id` FOREIGN KEY (`withdrawal_user_id`) REFERENCES `tbl_users`(`user_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
