/* Renaming DPO payment gateway to Paygate. */
UPDATE `tbl_plugins` SET `plugin_identifier`='Paygate', `plugin_code`='Paygate' WHERE plugin_code = 'Dpo';
/* Renaming DPO payment gateway to Paygate. */

-- --- Dpo Payment Gateway--- --
INSERT IGNORE INTO `tbl_plugins` (`plugin_identifier`, `plugin_type`, `plugin_code`, `plugin_active`, `plugin_display_order`) VALUES ('Dpo', '13', 'Dpo', '0', '23');
-- --- Dpo Payment Gateway--- --
ALTER TABLE `tbl_shops` ADD INDEX( `shop_country_id`);
ALTER TABLE `tbl_shops` ADD INDEX( `shop_state_id`);
ALTER TABLE `tbl_products` ADD INDEX( `product_ship_package`);
ALTER TABLE `tbl_shop_specifics` ADD `shop_pickup_interval` TINYINT(1) NOT NULL COMMENT 'In Hours' AFTER `shop_invoice_codes`;
INSERT INTO `tbl_configurations` (`conf_name`, `conf_val`, `conf_common`) VALUES
("CONF_LOADER", 1, 1) ON DUPLICATE KEY UPDATE conf_common = 1;
DELETE FROM tbl_language_labels WHERE label_key = "LBL_ADD_WALLET_CREDITS_[$]";

delete from tbl_extra_pages where epage_id = 44;
delete from tbl_extra_pages_lang where epagelang_epage_id = 44;

ALTER TABLE `tbl_extra_pages_lang` CHANGE `epage_content` `epage_content` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `tbl_content_pages_lang` CHANGE `cpage_content` `cpage_content` LONGTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

/* Bind all phone number fields with flag field. */
ALTER TABLE `tbl_addresses` CHANGE `addr_phone` `addr_phone` BIGINT NOT NULL;
ALTER TABLE `tbl_addresses` ADD `addr_phone_dcode` VARCHAR(50) NOT NULL AFTER `addr_country_id`;

ALTER TABLE `tbl_blog_contributions` CHANGE `bcontributions_author_phone` `bcontributions_author_phone` BIGINT NOT NULL;
ALTER TABLE `tbl_blog_contributions` ADD `bcontributions_author_phone_dcode` VARCHAR(50) NOT NULL AFTER `bcontributions_author_email`;

ALTER TABLE `tbl_order_products` CHANGE `op_shop_owner_phone` `op_shop_owner_phone` BIGINT NOT NULL;
ALTER TABLE `tbl_order_products` ADD `op_shop_owner_phone_dcode` VARCHAR(50) NOT NULL AFTER `op_shop_owner_email`;

ALTER TABLE `tbl_order_user_address` CHANGE `oua_phone` `oua_phone` BIGINT NOT NULL;
ALTER TABLE `tbl_order_user_address` ADD `oua_phone_dcode` VARCHAR(50) NOT NULL AFTER `oua_country_code_alpha3`;

ALTER TABLE `tbl_shops` CHANGE `shop_phone` `shop_phone` BIGINT NOT NULL;
ALTER TABLE `tbl_shops` ADD `shop_phone_dcode` VARCHAR(50) NOT NULL AFTER `shop_state_id`;

ALTER TABLE `tbl_user_return_address` CHANGE `ura_phone` `ura_phone` BIGINT NOT NULL;
ALTER TABLE `tbl_user_return_address` ADD `ura_phone_dcode` VARCHAR(50) NOT NULL AFTER `ura_zip`;

ALTER TABLE `tbl_user_phone_verification` CHANGE `upv_phone` `upv_phone` BIGINT NOT NULL;
ALTER TABLE `tbl_user_phone_verification` CHANGE `upv_dial_code` `upv_phone_dcode` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `tbl_user_phone_verification` DROP `upv_country_iso`;

ALTER TABLE `tbl_countries` ADD `country_dial_code` VARCHAR(50) NOT NULL AFTER `country_code_alpha3`;
UPDATE `tbl_countries` SET `country_dial_code`='+93' WHERE `country_code` = 'AF';
UPDATE `tbl_countries` SET `country_dial_code`='+355' WHERE `country_code` = 'AL';
UPDATE `tbl_countries` SET `country_dial_code`='+213' WHERE `country_code` = 'DZ';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'AS';
UPDATE `tbl_countries` SET `country_dial_code`='+376' WHERE `country_code` = 'AD';
UPDATE `tbl_countries` SET `country_dial_code`='+244' WHERE `country_code` = 'AO';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'AI';
UPDATE `tbl_countries` SET `country_dial_code`='+672' WHERE `country_code` = 'AQ';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'AG';
UPDATE `tbl_countries` SET `country_dial_code`='+54' WHERE `country_code` = 'AR';
UPDATE `tbl_countries` SET `country_dial_code`='+374' WHERE `country_code` = 'AM';
UPDATE `tbl_countries` SET `country_dial_code`='+297' WHERE `country_code` = 'AW';
UPDATE `tbl_countries` SET `country_dial_code`='+61' WHERE `country_code` = 'AU';
UPDATE `tbl_countries` SET `country_dial_code`='+43' WHERE `country_code` = 'AT';
UPDATE `tbl_countries` SET `country_dial_code`='+994' WHERE `country_code` = 'AZ';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'BS';
UPDATE `tbl_countries` SET `country_dial_code`='+973' WHERE `country_code` = 'BH';
UPDATE `tbl_countries` SET `country_dial_code`='+880' WHERE `country_code` = 'BD';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'BB';
UPDATE `tbl_countries` SET `country_dial_code`='+375' WHERE `country_code` = 'BY';
UPDATE `tbl_countries` SET `country_dial_code`='+32' WHERE `country_code` = 'BE';
UPDATE `tbl_countries` SET `country_dial_code`='+501' WHERE `country_code` = 'BZ';
UPDATE `tbl_countries` SET `country_dial_code`='+229' WHERE `country_code` = 'BJ';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'BM';
UPDATE `tbl_countries` SET `country_dial_code`='+975' WHERE `country_code` = 'BT';
UPDATE `tbl_countries` SET `country_dial_code`='+591' WHERE `country_code` = 'BO';
UPDATE `tbl_countries` SET `country_dial_code`='+387' WHERE `country_code` = 'BA';
UPDATE `tbl_countries` SET `country_dial_code`='+267' WHERE `country_code` = 'BW';
UPDATE `tbl_countries` SET `country_dial_code`='+55' WHERE `country_code` = 'BR';
UPDATE `tbl_countries` SET `country_dial_code`='+246' WHERE `country_code` = 'IO';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'VG';
UPDATE `tbl_countries` SET `country_dial_code`='+673' WHERE `country_code` = 'BN';
UPDATE `tbl_countries` SET `country_dial_code`='+359' WHERE `country_code` = 'BG';
UPDATE `tbl_countries` SET `country_dial_code`='+226' WHERE `country_code` = 'BF';
UPDATE `tbl_countries` SET `country_dial_code`='+257' WHERE `country_code` = 'BI';
UPDATE `tbl_countries` SET `country_dial_code`='+855' WHERE `country_code` = 'KH';
UPDATE `tbl_countries` SET `country_dial_code`='+237' WHERE `country_code` = 'CM';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'CA';
UPDATE `tbl_countries` SET `country_dial_code`='+238' WHERE `country_code` = 'CV';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'KY';
UPDATE `tbl_countries` SET `country_dial_code`='+236' WHERE `country_code` = 'CF';
UPDATE `tbl_countries` SET `country_dial_code`='+235' WHERE `country_code` = 'TD';
UPDATE `tbl_countries` SET `country_dial_code`='+56' WHERE `country_code` = 'CL';
UPDATE `tbl_countries` SET `country_dial_code`='+86' WHERE `country_code` = 'CN';
UPDATE `tbl_countries` SET `country_dial_code`='+61' WHERE `country_code` = 'CX';
UPDATE `tbl_countries` SET `country_dial_code`='+61' WHERE `country_code` = 'CC';
UPDATE `tbl_countries` SET `country_dial_code`='+57' WHERE `country_code` = 'CO';
UPDATE `tbl_countries` SET `country_dial_code`='+269' WHERE `country_code` = 'KM';
UPDATE `tbl_countries` SET `country_dial_code`='+682' WHERE `country_code` = 'CK';
UPDATE `tbl_countries` SET `country_dial_code`='+506' WHERE `country_code` = 'CR';
UPDATE `tbl_countries` SET `country_dial_code`='+385' WHERE `country_code` = 'HR';
UPDATE `tbl_countries` SET `country_dial_code`='+53' WHERE `country_code` = 'CU';
UPDATE `tbl_countries` SET `country_dial_code`='+599' WHERE `country_code` = 'CW';
UPDATE `tbl_countries` SET `country_dial_code`='+357' WHERE `country_code` = 'CY';
UPDATE `tbl_countries` SET `country_dial_code`='+420' WHERE `country_code` = 'CZ';
UPDATE `tbl_countries` SET `country_dial_code`='+243' WHERE `country_code` = 'CD';
UPDATE `tbl_countries` SET `country_dial_code`='+45' WHERE `country_code` = 'DK';
UPDATE `tbl_countries` SET `country_dial_code`='+253' WHERE `country_code` = 'DJ';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'DM';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'DO';
UPDATE `tbl_countries` SET `country_dial_code`='+670' WHERE `country_code` = 'TL';
UPDATE `tbl_countries` SET `country_dial_code`='+593' WHERE `country_code` = 'EC';
UPDATE `tbl_countries` SET `country_dial_code`='+20' WHERE `country_code` = 'EG';
UPDATE `tbl_countries` SET `country_dial_code`='+503' WHERE `country_code` = 'SV';
UPDATE `tbl_countries` SET `country_dial_code`='+240' WHERE `country_code` = 'GQ';
UPDATE `tbl_countries` SET `country_dial_code`='+291' WHERE `country_code` = 'ER';
UPDATE `tbl_countries` SET `country_dial_code`='+372' WHERE `country_code` = 'EE';
UPDATE `tbl_countries` SET `country_dial_code`='+251' WHERE `country_code` = 'ET';
UPDATE `tbl_countries` SET `country_dial_code`='+500' WHERE `country_code` = 'FK';
UPDATE `tbl_countries` SET `country_dial_code`='+298' WHERE `country_code` = 'FO';
UPDATE `tbl_countries` SET `country_dial_code`='+679' WHERE `country_code` = 'FJ';
UPDATE `tbl_countries` SET `country_dial_code`='+358' WHERE `country_code` = 'FI';
UPDATE `tbl_countries` SET `country_dial_code`='+33' WHERE `country_code` = 'FR';
UPDATE `tbl_countries` SET `country_dial_code`='+689' WHERE `country_code` = 'PF';
UPDATE `tbl_countries` SET `country_dial_code`='+241' WHERE `country_code` = 'GA';
UPDATE `tbl_countries` SET `country_dial_code`='+220' WHERE `country_code` = 'GM';
UPDATE `tbl_countries` SET `country_dial_code`='+995' WHERE `country_code` = 'GE';
UPDATE `tbl_countries` SET `country_dial_code`='+49' WHERE `country_code` = 'DE';
UPDATE `tbl_countries` SET `country_dial_code`='+233' WHERE `country_code` = 'GH';
UPDATE `tbl_countries` SET `country_dial_code`='+350' WHERE `country_code` = 'GI';
UPDATE `tbl_countries` SET `country_dial_code`='+30' WHERE `country_code` = 'GR';
UPDATE `tbl_countries` SET `country_dial_code`='+299' WHERE `country_code` = 'GL';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'GD';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'GU';
UPDATE `tbl_countries` SET `country_dial_code`='+502' WHERE `country_code` = 'GT';
UPDATE `tbl_countries` SET `country_dial_code`='+44' WHERE `country_code` = 'GG';
UPDATE `tbl_countries` SET `country_dial_code`='+224' WHERE `country_code` = 'GN';
UPDATE `tbl_countries` SET `country_dial_code`='+245' WHERE `country_code` = 'GW';
UPDATE `tbl_countries` SET `country_dial_code`='+592' WHERE `country_code` = 'GY';
UPDATE `tbl_countries` SET `country_dial_code`='+509' WHERE `country_code` = 'HT';
UPDATE `tbl_countries` SET `country_dial_code`='+504' WHERE `country_code` = 'HN';
UPDATE `tbl_countries` SET `country_dial_code`='+852' WHERE `country_code` = 'HK';
UPDATE `tbl_countries` SET `country_dial_code`='+36' WHERE `country_code` = 'HU';
UPDATE `tbl_countries` SET `country_dial_code`='+354' WHERE `country_code` = 'IS';
UPDATE `tbl_countries` SET `country_dial_code`='+91' WHERE `country_code` = 'IN';
UPDATE `tbl_countries` SET `country_dial_code`='+62' WHERE `country_code` = 'ID';
UPDATE `tbl_countries` SET `country_dial_code`='+98' WHERE `country_code` = 'IR';
UPDATE `tbl_countries` SET `country_dial_code`='+964' WHERE `country_code` = 'IQ';
UPDATE `tbl_countries` SET `country_dial_code`='+353' WHERE `country_code` = 'IE';
UPDATE `tbl_countries` SET `country_dial_code`='+44' WHERE `country_code` = 'IM';
UPDATE `tbl_countries` SET `country_dial_code`='+972' WHERE `country_code` = 'IL';
UPDATE `tbl_countries` SET `country_dial_code`='+39' WHERE `country_code` = 'IT';
UPDATE `tbl_countries` SET `country_dial_code`='+225' WHERE `country_code` = 'CI';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'JM';
UPDATE `tbl_countries` SET `country_dial_code`='+81' WHERE `country_code` = 'JP';
UPDATE `tbl_countries` SET `country_dial_code`='+44' WHERE `country_code` = 'JE';
UPDATE `tbl_countries` SET `country_dial_code`='+962' WHERE `country_code` = 'JO';
UPDATE `tbl_countries` SET `country_dial_code`='+7' WHERE `country_code` = 'KZ';
UPDATE `tbl_countries` SET `country_dial_code`='+254' WHERE `country_code` = 'KE';
UPDATE `tbl_countries` SET `country_dial_code`='+686' WHERE `country_code` = 'KI';
UPDATE `tbl_countries` SET `country_dial_code`='+383' WHERE `country_code` = 'XK';
UPDATE `tbl_countries` SET `country_dial_code`='+965' WHERE `country_code` = 'KW';
UPDATE `tbl_countries` SET `country_dial_code`='+996' WHERE `country_code` = 'KG';
UPDATE `tbl_countries` SET `country_dial_code`='+856' WHERE `country_code` = 'LA';
UPDATE `tbl_countries` SET `country_dial_code`='+371' WHERE `country_code` = 'LV';
UPDATE `tbl_countries` SET `country_dial_code`='+961' WHERE `country_code` = 'LB';
UPDATE `tbl_countries` SET `country_dial_code`='+266' WHERE `country_code` = 'LS';
UPDATE `tbl_countries` SET `country_dial_code`='+231' WHERE `country_code` = 'LR';
UPDATE `tbl_countries` SET `country_dial_code`='+218' WHERE `country_code` = 'LY';
UPDATE `tbl_countries` SET `country_dial_code`='+423' WHERE `country_code` = 'LI';
UPDATE `tbl_countries` SET `country_dial_code`='+370' WHERE `country_code` = 'LT';
UPDATE `tbl_countries` SET `country_dial_code`='+352' WHERE `country_code` = 'LU';
UPDATE `tbl_countries` SET `country_dial_code`='+853' WHERE `country_code` = 'MO';
UPDATE `tbl_countries` SET `country_dial_code`='+389' WHERE `country_code` = 'MK';
UPDATE `tbl_countries` SET `country_dial_code`='+261' WHERE `country_code` = 'MG';
UPDATE `tbl_countries` SET `country_dial_code`='+265' WHERE `country_code` = 'MW';
UPDATE `tbl_countries` SET `country_dial_code`='+60' WHERE `country_code` = 'MY';
UPDATE `tbl_countries` SET `country_dial_code`='+960' WHERE `country_code` = 'MV';
UPDATE `tbl_countries` SET `country_dial_code`='+223' WHERE `country_code` = 'ML';
UPDATE `tbl_countries` SET `country_dial_code`='+356' WHERE `country_code` = 'MT';
UPDATE `tbl_countries` SET `country_dial_code`='+692' WHERE `country_code` = 'MH';
UPDATE `tbl_countries` SET `country_dial_code`='+222' WHERE `country_code` = 'MR';
UPDATE `tbl_countries` SET `country_dial_code`='+230' WHERE `country_code` = 'MU';
UPDATE `tbl_countries` SET `country_dial_code`='+262' WHERE `country_code` = 'YT';
UPDATE `tbl_countries` SET `country_dial_code`='+52' WHERE `country_code` = 'MX';
UPDATE `tbl_countries` SET `country_dial_code`='+691' WHERE `country_code` = 'FM';
UPDATE `tbl_countries` SET `country_dial_code`='+373' WHERE `country_code` = 'MD';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'PR';
UPDATE `tbl_countries` SET `country_dial_code`='+674' WHERE `country_code` = 'NR';
UPDATE `tbl_countries` SET `country_dial_code`='+977' WHERE `country_code` = 'NP';
UPDATE `tbl_countries` SET `country_dial_code`='+31' WHERE `country_code` = 'NL';
UPDATE `tbl_countries` SET `country_dial_code`='+599' WHERE `country_code` = 'AN';
UPDATE `tbl_countries` SET `country_dial_code`='+687' WHERE `country_code` = 'NC';
UPDATE `tbl_countries` SET `country_dial_code`='+64' WHERE `country_code` = 'NZ';
UPDATE `tbl_countries` SET `country_dial_code`='+505' WHERE `country_code` = 'NI';
UPDATE `tbl_countries` SET `country_dial_code`='+227' WHERE `country_code` = 'NE';
UPDATE `tbl_countries` SET `country_dial_code`='+234' WHERE `country_code` = 'NG';
UPDATE `tbl_countries` SET `country_dial_code`='+683' WHERE `country_code` = 'NU';
UPDATE `tbl_countries` SET `country_dial_code`='+850' WHERE `country_code` = 'KP';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'MP';
UPDATE `tbl_countries` SET `country_dial_code`='+47' WHERE `country_code` = 'NO';
UPDATE `tbl_countries` SET `country_dial_code`='+968' WHERE `country_code` = 'OM';
UPDATE `tbl_countries` SET `country_dial_code`='+92' WHERE `country_code` = 'PK';
UPDATE `tbl_countries` SET `country_dial_code`='+680' WHERE `country_code` = 'PW';
UPDATE `tbl_countries` SET `country_dial_code`='+970' WHERE `country_code` = 'PS';
UPDATE `tbl_countries` SET `country_dial_code`='+507' WHERE `country_code` = 'PA';
UPDATE `tbl_countries` SET `country_dial_code`='+675' WHERE `country_code` = 'PG';
UPDATE `tbl_countries` SET `country_dial_code`='+595' WHERE `country_code` = 'PY';
UPDATE `tbl_countries` SET `country_dial_code`='+51' WHERE `country_code` = 'PE';
UPDATE `tbl_countries` SET `country_dial_code`='+63' WHERE `country_code` = 'PH';
UPDATE `tbl_countries` SET `country_dial_code`='+64' WHERE `country_code` = 'PN';
UPDATE `tbl_countries` SET `country_dial_code`='+48' WHERE `country_code` = 'PL';
UPDATE `tbl_countries` SET `country_dial_code`='+351' WHERE `country_code` = 'PT';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'PR';
UPDATE `tbl_countries` SET `country_dial_code`='+974' WHERE `country_code` = 'QA';
UPDATE `tbl_countries` SET `country_dial_code`='+242' WHERE `country_code` = 'CG';
UPDATE `tbl_countries` SET `country_dial_code`='+262' WHERE `country_code` = 'RE';
UPDATE `tbl_countries` SET `country_dial_code`='+40' WHERE `country_code` = 'RO';
UPDATE `tbl_countries` SET `country_dial_code`='+7' WHERE `country_code` = 'RU';
UPDATE `tbl_countries` SET `country_dial_code`='+250' WHERE `country_code` = 'RW';
UPDATE `tbl_countries` SET `country_dial_code`='+590' WHERE `country_code` = 'BL';
UPDATE `tbl_countries` SET `country_dial_code`='+290' WHERE `country_code` = 'SH';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'KN';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'LC';
UPDATE `tbl_countries` SET `country_dial_code`='+590' WHERE `country_code` = 'MF';
UPDATE `tbl_countries` SET `country_dial_code`='+508' WHERE `country_code` = 'PM';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'VC';
UPDATE `tbl_countries` SET `country_dial_code`='+685' WHERE `country_code` = 'WS';
UPDATE `tbl_countries` SET `country_dial_code`='+378' WHERE `country_code` = 'SM';
UPDATE `tbl_countries` SET `country_dial_code`='+239' WHERE `country_code` = 'ST';
UPDATE `tbl_countries` SET `country_dial_code`='+966' WHERE `country_code` = 'SA';
UPDATE `tbl_countries` SET `country_dial_code`='+221' WHERE `country_code` = 'SN';
UPDATE `tbl_countries` SET `country_dial_code`='+381' WHERE `country_code` = 'RS';
UPDATE `tbl_countries` SET `country_dial_code`='+248' WHERE `country_code` = 'SC';
UPDATE `tbl_countries` SET `country_dial_code`='+232' WHERE `country_code` = 'SL';
UPDATE `tbl_countries` SET `country_dial_code`='+65' WHERE `country_code` = 'SG';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'SX';
UPDATE `tbl_countries` SET `country_dial_code`='+421' WHERE `country_code` = 'SK';
UPDATE `tbl_countries` SET `country_dial_code`='+386' WHERE `country_code` = 'SI';
UPDATE `tbl_countries` SET `country_dial_code`='+677' WHERE `country_code` = 'SB';
UPDATE `tbl_countries` SET `country_dial_code`='+252' WHERE `country_code` = 'SO';
UPDATE `tbl_countries` SET `country_dial_code`='+27' WHERE `country_code` = 'ZA';
UPDATE `tbl_countries` SET `country_dial_code`='+82' WHERE `country_code` = 'KR';
UPDATE `tbl_countries` SET `country_dial_code`='+211' WHERE `country_code` = 'SS';
UPDATE `tbl_countries` SET `country_dial_code`='+34' WHERE `country_code` = 'ES';
UPDATE `tbl_countries` SET `country_dial_code`='+94' WHERE `country_code` = 'LK';
UPDATE `tbl_countries` SET `country_dial_code`='+249' WHERE `country_code` = 'SD';
UPDATE `tbl_countries` SET `country_dial_code`='+597' WHERE `country_code` = 'SR';
UPDATE `tbl_countries` SET `country_dial_code`='+47' WHERE `country_code` = 'SJ';
UPDATE `tbl_countries` SET `country_dial_code`='+268' WHERE `country_code` = 'SZ';
UPDATE `tbl_countries` SET `country_dial_code`='+46' WHERE `country_code` = 'SE';
UPDATE `tbl_countries` SET `country_dial_code`='+41' WHERE `country_code` = 'CH';
UPDATE `tbl_countries` SET `country_dial_code`='+963' WHERE `country_code` = 'SY';
UPDATE `tbl_countries` SET `country_dial_code`='+886' WHERE `country_code` = 'TW';
UPDATE `tbl_countries` SET `country_dial_code`='+992' WHERE `country_code` = 'TJ';
UPDATE `tbl_countries` SET `country_dial_code`='+255' WHERE `country_code` = 'TZ';
UPDATE `tbl_countries` SET `country_dial_code`='+66' WHERE `country_code` = 'TH';
UPDATE `tbl_countries` SET `country_dial_code`='+228' WHERE `country_code` = 'TG';
UPDATE `tbl_countries` SET `country_dial_code`='+690' WHERE `country_code` = 'TK';
UPDATE `tbl_countries` SET `country_dial_code`='+676' WHERE `country_code` = 'TO';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'TT';
UPDATE `tbl_countries` SET `country_dial_code`='+216' WHERE `country_code` = 'TN';
UPDATE `tbl_countries` SET `country_dial_code`='+90' WHERE `country_code` = 'TR';
UPDATE `tbl_countries` SET `country_dial_code`='+993' WHERE `country_code` = 'TM';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'TC';
UPDATE `tbl_countries` SET `country_dial_code`='+688' WHERE `country_code` = 'TV';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'VI';
UPDATE `tbl_countries` SET `country_dial_code`='+256' WHERE `country_code` = 'UG';
UPDATE `tbl_countries` SET `country_dial_code`='+380' WHERE `country_code` = 'UA';
UPDATE `tbl_countries` SET `country_dial_code`='+971' WHERE `country_code` = 'AE';
UPDATE `tbl_countries` SET `country_dial_code`='+44' WHERE `country_code` = 'GB';
UPDATE `tbl_countries` SET `country_dial_code`='+1' WHERE `country_code` = 'US';
UPDATE `tbl_countries` SET `country_dial_code`='+598' WHERE `country_code` = 'UY';
UPDATE `tbl_countries` SET `country_dial_code`='+998' WHERE `country_code` = 'UZ';
UPDATE `tbl_countries` SET `country_dial_code`='+678' WHERE `country_code` = 'VU';
UPDATE `tbl_countries` SET `country_dial_code`='+379' WHERE `country_code` = 'VA';
UPDATE `tbl_countries` SET `country_dial_code`='+58' WHERE `country_code` = 'VE';
UPDATE `tbl_countries` SET `country_dial_code`='+84' WHERE `country_code` = 'VN';
UPDATE `tbl_countries` SET `country_dial_code`='+681' WHERE `country_code` = 'WF';
UPDATE `tbl_countries` SET `country_dial_code`='+212' WHERE `country_code` = 'EH';
UPDATE `tbl_countries` SET `country_dial_code`='+967' WHERE `country_code` = 'YE';
UPDATE `tbl_countries` SET `country_dial_code`='+260' WHERE `country_code` = 'ZM';
UPDATE `tbl_countries` SET `country_dial_code`='+263' WHERE `country_code` = 'ZW';

UPDATE tbl_users tu
INNER JOIN tbl_countries tc ON tc.country_dial_code = tu.user_dial_code
SET tu.user_dial_code = CONCAT(tu.user_dial_code, '-', LOWER(tc.country_code))
WHERE tu.user_dial_code != '';

ALTER TABLE `tbl_users` CHANGE `user_phone` `user_phone` BIGINT NULL DEFAULT NULL;
ALTER TABLE `tbl_users` CHANGE `user_dial_code` `user_phone_dcode` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;

ALTER TABLE `tbl_countries` DROP `country_dial_code`;

/* Bind all phone number fields with flag field. */
-- --- Easypost Shipping API--- --
INSERT IGNORE INTO `tbl_plugins` (`plugin_identifier`, `plugin_type`, `plugin_code`, `plugin_active`, `plugin_display_order`) VALUES ('EasyPost', '8', 'EasyPost', '0', '2');

ALTER TABLE `tbl_order_product_shipment` CHANGE `opship_tracking_number` `opship_tracking_number` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL, CHANGE `opship_tracking_url` `opship_tracking_url` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL;

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

-- --- Tax Module Update --- --
ALTER TABLE `tbl_tax_rule_locations` CHANGE `taxruleloc_country_id` `taxruleloc_to_country_id` INT NOT NULL, CHANGE `taxruleloc_state_id` `taxruleloc_to_state_id` INT NOT NULL;
ALTER TABLE `tbl_tax_rule_locations` ADD `taxruleloc_from_country_id` INT NOT NULL AFTER `taxruleloc_taxcat_id`, ADD `taxruleloc_from_state_id` INT NOT NULL AFTER `taxruleloc_from_country_id`;
ALTER TABLE `tbl_tax_rule_locations` DROP INDEX `taxruleloc_taxcat_id`;
ALTER TABLE `tbl_tax_rule_locations` ADD UNIQUE( `taxruleloc_taxcat_id`, `taxruleloc_from_country_id`, `taxruleloc_from_state_id`, `taxruleloc_to_country_id`, `taxruleloc_to_state_id`, `taxruleloc_type`);
UPDATE `tbl_tax_rule_locations` SET `taxruleloc_from_country_id` = '-1'  and `taxruleloc_from_state_id` = '-1';

CREATE TABLE `tbl_tax_rule_rates` (
  `trr_taxrule_id` int NOT NULL,
  `trr_rate` decimal(10,2) NOT NULL,
  `trr_user_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tbl_tax_rule_rates`
  ADD PRIMARY KEY (`trr_taxrule_id`,`trr_user_id`);

INSERT INTO tbl_tax_rule_rates (trr_taxrule_id, trr_rate ,trr_user_id) SELECT taxrule_id, taxrule_rate,0 FROM tbl_tax_rules;
ALTER TABLE tbl_tax_rules DROP taxrule_rate;
ALTER TABLE `tbl_tax_rule_details` ADD `taxruledet_user_id` INT NOT NULL AFTER `taxruledet_rate`;
ALTER TABLE `tbl_tax_rule_details` ADD UNIQUE( `taxruledet_taxrule_id`, `taxruledet_taxstr_id`, `taxruledet_user_id`);
ALTER TABLE `tbl_tax_rule_details` DROP `taxruledet_id`;
ALTER TABLE `tbl_tax_rule_locations` DROP `taxruleloc_unique`;
-- --- Tax Module Update--- --


-- --- Shopify --- --
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

INSERT INTO `tbl_cron_schedules` (`cron_id`, `cron_name`, `cron_command`, `cron_duration`, `cron_active`) VALUES (NULL, 'Data Migrate', 'DataMigration/sync', '5', '1');

ALTER TABLE `tbl_plugin_settings` ADD `pluginsetting_record_id` INT NOT NULL AFTER `pluginsetting_plugin_id`;

ALTER TABLE `tbl_plugin_settings` DROP PRIMARY KEY;
ALTER TABLE `tbl_plugin_settings` ADD PRIMARY KEY( `pluginsetting_plugin_id`, `pluginsetting_record_id`, `pluginsetting_key`);


CREATE TABLE `tbl_plugin_to_user` (
  `pu_plugin_id` int NOT NULL,
  `pu_user_id` int NOT NULL,
  `pu_active` tinyint NOT NULL,
  `pu_created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tbl_plugin_to_user`
  ADD PRIMARY KEY (`pu_plugin_id`,`pu_user_id`);
-- --- Shopify --- --

INSERT INTO `tbl_language_labels` (`label_id`, `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES (NULL, 'LBL_SET_PASSWORD_MSG', '1', 'To set your password enter a new password below', '1');
INSERT IGNORE INTO `tbl_configurations` (`conf_name`, `conf_val`, `conf_common`) VALUES ('CONF_DEFAULT_CURRENCY_SEPARATOR', '.', '0');


-- --- Mollie Payment Gateway--- --
INSERT IGNORE INTO `tbl_plugins` (`plugin_identifier`, `plugin_type`, `plugin_code`, `plugin_active`, `plugin_display_order`) VALUES ('Mollie', '13', 'Mollie', '0', '25');
-- --- Mollie Payment Gateway--- --

-- --- Payfast Payment Gateway--- --
INSERT IGNORE INTO `tbl_plugins` (`plugin_identifier`, `plugin_type`, `plugin_code`, `plugin_active`, `plugin_display_order`) VALUES ('Payfast', '13', 'Payfast', '0', '24');
INSERT IGNORE INTO `tbl_language_labels` (`label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES
('LBL_PAYFAST_PASSPHRASE_DESCRIPTION', 1, 'The passphrase is considered a secret between the merchant and PayFast and should never be sent or given out.<br>The merchant may set their own passphrase by:<br> 1. Login to PayFast using their merchant credentials.<br> 2. Clicking on "Settings", and then "Edit" under the Security Pass Phrase section.<br> 3. Inputting the desired passphrase and click "Update"', 1),
('LBL_PAYFAST_SIGNATURE_DESCRIPTION', 1, 'System generated MD5 signature. It will generate automatically while checkout using "Payfast".', 1)
ON DUPLICATE KEY UPDATE label_caption = VALUES(label_caption);
-- --- Payfast Payment Gateway--- --
 
-- --- task_81779_advanced_GDPR_module --- --
UPDATE
    `tbl_content_pages_lang`
SET
    `cpage_content` = '<h2>Yo!Kart (FATbit Technologies)</h2>\r\n<h6 class=\"descrptn_title\" style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 0px; font-family: Muli, sans-serif; line-height: 1.3; font-size: calc(14px + ((6 * (100vw - 320px)) / 1600)); color: rgb(34, 34, 34); letter-spacing: 0.32px; background-color: rgb(255, 255, 255);\">(Terms 1<span style=\"box-sizing: inherit; margin: 0px; padding: 0px; color: rgb(255, 57, 87); display: inline-block; vertical-align: top;\">st</span>&nbsp;to 25<span style=\"box-sizing: inherit; margin: 0px; padding: 0px; color: rgb(255, 57, 87); display: inline-block; vertical-align: top;\">th</span>&nbsp;Standard Terms applicable on all services/projects)</h6>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">1. Contract:</span>&nbsp;The clientâ€™s approval for work to commence shall be deemed a contractual agreement between the Client and Yo!Kart. The approval for the work can be through either an email confirming back the quote (with the quote document attached) or the quote document signed by the client.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Whereas, Yo!Kart is in the business of providing Consultancy and allied Services on Computer based Information Technology, to its clientele, including any affiliates, subsidiaries, divisions of Yo!Kart\'s clients and customers (hereinafter referred to as \"Customers\") and Yo!Kart is in the business of producing Softwares, Designs, Software Planning Documents/Diagrams and Creative works for its Customers â€“ whether copyrightable/patentable or not (hereinafter referred to as \"Productâ€ or \"Productsâ€)</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Now THEREFORE, in consideration of mutual promises, covenants and conditions set forth herein, The parties hereto agree to the terms mentioned in this agreement/proposal.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"font-weight: bold;\">Important:</span>&nbsp;Payment of the advance fee indicates that the client accepts these terms and conditions, and approves to commence the work.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">2. Usage of Yo!Kart Services/Products/Solutions:</span>&nbsp;Client agrees not to use the Yo!Kart services/products delivered for any business which is harmful to the society or children or is illegal. Further the Client is fully responsible for all and any content published/distributed or allowed to be published/distributed through the Clientâ€™s website whether hosted on servers owned/maintained by Yo!Kart or by the Client himself. Client shall execute best possible precautionary and security measures to restrict any illegitimate use of the services/solutions precured from Yo!Kart.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">3. 1 Year Free Technical Support:</span>&nbsp;Yo!Kart provides 1 year free technical support for following kind of issues:</p>\r\n<ul class=\"lower-alpha\" style=\"box-sizing: inherit; margin: 0px 0px 0px 30px; padding: 0px 0px 5px; list-style: none; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">Server side scripting/programming errors/bugs</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">Logical Bugs/Calculation related errors/bugs</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">Connection errors/API Integration Errors</li>\r\n</ul>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Above support is not available if the errors/bugs arise due to any external entity. Examples:</p>\r\n<ul class=\"lower-alpha\" style=\"box-sizing: inherit; margin: 0px 0px 0px 30px; padding: 0px 0px 5px; list-style: none; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">Server or software or application or extension downgrades or upgrades</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">Edits done in the code/scripts delivered by any external entity/person/professional</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">Operating System or Browser Version Downgrades/Upgrades</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">Any other factor which is not directly related to any deficiency at the end of Yo!Kart</li>\r\n</ul>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Above support is not available for following kind of instances, unless otherwise specifically covered in the scope of project and/or deliverables:</p>\r\n<ul class=\"lower-alpha\" style=\"box-sizing: inherit; margin: 0px 0px 0px 30px; padding: 0px 0px 5px; list-style: none; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">Training for using the software/solutions delivered</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">General enquiries/questions related to particular features of the software/solution delivered</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">Cosmetic updates and/or UI/UX updates</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">Enhancements or modifications in the default features/functional logics of the software/solutions delivered</li>\r\n</ul>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">4. Photography and graphics:</span>&nbsp;Both the parties agree to abide by the following terms:</p>\r\n<ul class=\"lower-alpha\" style=\"box-sizing: inherit; margin: 0px 0px 0px 30px; padding: 0px 0px 5px; list-style: none; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">Unless otherwise agreed - Stock Images used for creating any banner or promotion graphic or animation are not part of the project deliverables, Client should purchase the license to use the stock images from respective 3rd parties at his/her own cost.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">Yo!Kart may use stock photographs and images while creating the website. Images and graphics purchased from stock libraries are not generally included in the quote and will be invoiced separately.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">At request of the Client - Yo!Kart will keep the client updated about the stock images being used and the cost involved before raising the invoice.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">Images used by Yo!Kart for product demos shall not be used by the client unless the client has purchased the usage rights for those images. Client shall be fully responsible for violation of any 3rd party copyright.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">Images delivered by Yo!Kart along with a bundled software/solution/script are for Demo Purpose only and shall not be used for commercial purpose. Client should contact Yo!Kart for more information about the price of those images if the Client wishes to use those images for commercial purpose OR Client should replace the default images with the images owned by the Client.</li>\r\n</ul>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">5. Browser compatibility:&nbsp;</span>Yo!Kart makes every effort to design pages that work flawlessly on most popular current browsers i.e. latest version of IE/FireFox/Chrome released on the date of project agreement. However, Yo!Kart cannot be held responsible for pages that do not display acceptably in newer versions of browsers released after pages have been designed. IE11 and older IE versions are outdated browsers and hence we donâ€™t design with them in mind. We recommend using latest version of Chrome or Firefox instead of older versions of Microsoft Internet Explorer. Yo!Kart can work on improving UI/UX for older versions of Internet Explorer for an additional charge.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">6. Search Engine Submission:</span>&nbsp;Following services are not part of the project unless agreed otherwise in writing:</p>\r\n<ul class=\"terms_listing\" style=\"box-sizing: inherit; margin: 0px 0px 0px 30px; padding: 0px 0px 5px; list-style: none; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Submission of websites on different search engines.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Securing good ranking of your website on different search engines.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Search Engine Optimization â€“ On Page/Off Page.</li>\r\n</ul>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">7. Site maintenance:</span>&nbsp;Unless otherwise agreed in writing, following services will be separately billed after the website has been made live:</p>\r\n<ul class=\"terms_listing\" style=\"box-sizing: inherit; margin: 0px 0px 0px 30px; padding: 0px 0px 5px; list-style: none; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Content updates</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Refinements and logical tweaks to the website, which were not planned/approvedby client earlier.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Content presentation and design updates which were not planned/approved by client earlier.</li>\r\n</ul>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">8. Content:</span>&nbsp;After Yo!Kart has delivered the website to client, client is solely responsible for the content/information/images posted on his website. If there is any error or omission by Yo!Kart team while uploading/posting the content/information/images on clientâ€™s website, Yo!Kart will correct it if reported to Yo!Kart representatives.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">9. Material:&nbsp;</span>All material supplied by the client shall remain clientâ€™s property. Yo!Kart rightfully believes that this material belongs to the client and that it does not breach any copyright laws. Under no circumstances shall Yo!Kart be held responsible for any claims, damages, and loss of profit or reputation caused to client due to the use of material provided by the client.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">10. Domain names booked by Yo!Kart on behalf of client:&nbsp;</span>Yo!Kart provides domain name consultancy if required. Domain names registered by Yo!Kart on the clientâ€™s behalf are property of Yo!Kart until client has paid for the domain booked and any fee involved.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Yo!Kart agrees to transfer such domains to the client or his/her agent when asked to do so provided that all accounts have been settled.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"font-weight: bold;\">Note:</span>&nbsp;Domains booked and owned by client are not subject to this term. This term applies only to those domains which are booked by Yo!Kart upon the request of client.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">11. Travel Time and Expenses:</span>&nbsp;Travelling time to and from the client premises is not generally included in our estimate. If a visit/travel is required for meeting, the client will bear all the expenses or as agreed by both the parties.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">12. 3<span style=\"box-sizing: inherit; margin: 0px; padding: 0px; color: rgb(255, 57, 87); display: inline-block; vertical-align: top;\">rd</span>&nbsp;Party Add-ons/services/applications:</span>&nbsp;All third party costs arising from the registration of a domain name/purchase of third party utilities/services shall be met by the Client and are payable to Yo!Kart before a formal application for registration is made. Examples of 3<span style=\"box-sizing: inherit; margin: 0px; padding: 0px; color: rgb(255, 57, 87); display: inline-block; vertical-align: top;\">rd</span>&nbsp;party fees are as under:</p>\r\n<ul class=\"terms_listing\" style=\"box-sizing: inherit; margin: 0px 0px 0px 30px; padding: 0px 0px 5px; list-style: none; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Domain Names</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Server Space Hosting Fees</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">SSL Certificates</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Backup Services</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">3<span style=\"box-sizing: inherit; margin: 0px; padding: 0px; color: rgb(255, 57, 87); display: inline-block; vertical-align: top;\">rd</span>&nbsp;Party APIs, if any, required by â€˜Clientâ€™ to be integrated with the work ordered.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">3<span style=\"box-sizing: inherit; margin: 0px; padding: 0px; color: rgb(255, 57, 87); display: inline-block; vertical-align: top;\">rd</span>&nbsp;Party Plugins/Scripts/Applications/Software/Widgets/Services, if any, required by â€˜Clientâ€™ to be integrated with the work ordered.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Payment Gateways Signup and Recurring Fees</li>\r\n</ul>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">13. Examples of work:</span>&nbsp;Unless negotiated otherwise, Yo!Kart retains the right to list/display the client name and logo with or without work performed (Design/Development/Online Promotion) for the Client in its respective portfolios and promotion materials. This over-rides all previous agreements and NDAs signed.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">14. Quotations:</span>&nbsp;The price quoted to the client is for the work agreed in the proposal document only. Should the client decide that changes are required after the project work has been initiated, then Yo!Kart will provide a separate quote for the additional work and may need to review the timescale for completing the project. Cost estimates and prices quoted are valid for maximum one month unless otherwise agreed.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">15. Mode of Payment</span></p>\r\n<ul class=\"terms_listing\" style=\"box-sizing: inherit; margin: 0px 0px 0px 30px; padding: 0px 0px 5px; list-style: none; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Clients Based Outside India: International Wire Transfers, Credit Card/PayPal via 2Checkout payment gateway.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Clients Based in India: NEFT, RTGS or Physical Cheques mailed to our office address.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Payments for packages/services other than covered under Startup Package and GoQuick Packages should be made via Wire Transfer only.</li>\r\n</ul>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">16. Payment Terms:</span></p>\r\n<ul class=\"terms_listing\" style=\"box-sizing: inherit; margin: 0px 0px 0px 30px; padding: 0px 0px 5px; list-style: none; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Payment plan is agreed between the â€˜Clientâ€™ and Yo!Kart based on the milestones.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Payment shall be due within 14 days of the invoice date unless specifically mentioned in the Invoice.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Full publication of the website/technical work will only take place after full payment has been received in our account unless otherwise agreed in writing.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Any material previously published may be removed if payment is not received. When this occurs, a minimum charge of $250 USD will be charged to have the site restored.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Accounts that have not been settled within 14 days of the date shown on the invoice will incur a late payment charge of $100 USD or 5% of the Invoiced Amount (whichever is higher), for each week delayed.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">In case of delay in payments beyond the due date, Yo!Kart reserves the right to stop the work being commenced and â€˜Clientâ€™ agrees to exempt Yo!Kart from meeting the timelines agreed.</li>\r\n</ul>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">17. Cancellation: Both the parties reserve the right to cancel the project at any stage.</span></p>\r\n<ul class=\"terms_listing\" style=\"box-sizing: inherit; margin: 0px 0px 0px 30px; padding: 0px 0px 5px; list-style: none; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">In case the project is cancelled by Client, the payments made for the project can be refunded to the client after deducting the upfront payment amount received for Initiation of the project and the other payments received against the milestones completed.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">In case the project is cancelled by Yo!Kart, the payments made for the project can be refunded after deducting USD 15 per hour for the hours spent on the work performed for the client including but not limited to the time spent on project discussion, requirements gathering, project planning &amp; documentation, project initiation and execution. After the payments are settled between the two parties â€“ Yo!Kart shall transfer to â€˜Clientâ€™ - all the documents, designs and scripts produced for the project.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">30 days money back guarantee:</span>&nbsp;Yo!Kart offers \"30-Days Money-Back Guaranteeâ€ to ensure customer satisfaction and mutual trust. If for any reason you wish to discontinue using the product, within 30 days of the purchase, we will issue a refund within 24-48 hours after deducting 4% payment gateway transaction fee and USD 15/hour for the hours spent on your project.\r\n		<ul class=\"lower-alpha\" style=\"box-sizing: inherit; margin: 10px 0px 0px 30px; padding: 0px; list-style: none;\">\r\n			<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative;\">This guarantee is specifically for GoQuick/Start-Up Package orders.</li>\r\n			<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 0px 15px; list-style: lower-alpha inside; position: relative;\">After project/order cancellation/refund issued, Yo!Kart reserves all rights to take down the website published. Client is responsible to keep a backup of the data published on the website/server, Yo!Kart shall not be held responsible for any data/files lost.</li>\r\n		</ul></li>\r\n</ul>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">18. Penalty Clause</span></p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">(A) Penalties applicable on Yo!Kart :</span></p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Yo!Kart agrees to finish the project as per the detailed project scope agreed to, within the agreed timeline. If there is the&nbsp;delay in finishing the project, Yo!Kart agrees to the penalty of X % of the original project price for each week delay in submitting the Project for the final review to the client. If the Yo!Kart delays the project submission for clientâ€™s final review by more than 8 weeks, then Client can request for cancellation of the project and seek the full refund, however, the refund amount shall not exceed the originally agreed project price (excluding the Amount Charged for additional requirements and change requests). Amount charged for additional requirements/change requests shall not be refunded.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">X% = 50/Project Duration Weeks (Calendar Weeks); X% should not exceed 4% unless otherwise explicitly agreed to.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Penalty Amount/Refund applicable shall be adjusted against/out of the pending amount owed by the client towards Yo!Kart/AblySoft and any remaining amount shall be refunded to the client via wire transfer or PayPal or any other mode of payment as per mutual agreement.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Once full refund has been issued, the project shall be marked cancelled and Yo!Kart shall be relieved from all liabilities towards the client and client shall not make any claims, objections, demands from Yo!Kart for any loss or damages incurred at his/her end due to the delay. Yo!Kart shall own all rights on the work done, designs, scripts, documents, other outputs and elements created for the project and client shall not use any of the work, scripts, designs, documents already delivered. Client shall be liable to pay full project price in case Client uses or copies any piece of the work, design, script, elements and documents produced by Yo!Kart for the project.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">(B) Responsibilities applicable on Client:</span></p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Client should provide all comments, feedbacks, suggestions about the project scope during the Detailed Project Scope Documentation phase; subsequently any changes or modifications or enhancements done to the project scope would be additionally chargeable with or without delivery timelines revision. And if there are changes which are accepted by Yo!Kart without additional charge, timeline should extend by the number of days required to implement those additional non-billable items.</p>\r\n<ul class=\"lower-alpha\" style=\"box-sizing: inherit; margin: 0px 0px 0px 30px; padding: 0px 0px 5px; list-style: none; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">Client should make payments as per the agreed payment terms, else Yo!Kart should be exempt from meeting the timelines agreed to, and will not be liable to any kind of penalties for the delay in delivery of the project.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">Client should provide his feedback on the work submitted for their review within 1 week, if there is a delay from client side in providing feedback on the work submitted for their review, Yo!Kart should be exempt from meeting the timelines agreed to, and will not be liable to any kind of penalties for the delay in delivery of the project.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">If Client changes the Functional Requirement â€“ Client understands and accepts that additional cost and working days will be added to the project,&nbsp;<span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">hence the project delivery timeline will need to be revised.</span></li>\r\n</ul>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">19. Delayed Response From Client Side:</span>&nbsp;Unreasonable delays from client side in providing the required feedback/information/data to finish the project shall exempt Yo!Kart from meeting the timelines mentioned in the quote.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">In case client does not provide required details/data/information for more than 15 working days, client authorizes Yo!Kart to forfeit the payments made towards this project.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">In case, during the project duration, the client does not maintain communication with Yo!Kart for more than 30 calendar days, client agrees that the project/services shall be deemed as received and accepted by the client, and the client further authorizes Yo!Kart to mark the project completed and invoice the client for remaining un-invoiced amount as per the total project price agreed.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">However, Client can instruct Yo!Kart to put project on hold provided:</p>\r\n<ul class=\"lower-alpha\" style=\"box-sizing: inherit; margin: 0px 0px 0px 30px; padding: 0px 0px 5px; list-style: none; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">client agrees to pay project resumption fee of USD 1,000 or 25% of the total project price, whichever is higher.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">â€˜on-holdâ€™ period does not exceed 2 calendar months</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">client agrees the professionals attached to the project (Project Team Structure) may be different from originally agreed.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\">client agrees to pay this project resumption fee every time a project is being put â€˜on-holdâ€™</li>\r\n</ul>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">20. Escalation:</span>&nbsp;Yo!Kart ensures you get right assistance to resolve issues in a timely manner. If your concerns are not entertained to your satisfaction, you can escalate critical issues to higher level of management. You may follow the below-mentioned escalation matrix to avoid any delay or discomfort in the event of dissatisfaction.</p>\r\n<ul class=\"lower-alpha\" style=\"box-sizing: inherit; margin: 0px 0px 0px 30px; padding: 0px 0px 5px; list-style: none; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">First Level Escalation:</span>&nbsp;In case of delay in project timelines or unsatisfactory response from your associated Project Manager/Business Analyst, You may escalate your case to&nbsp;<a href=\"mailto:salesteam@fatbit.com\" style=\"box-sizing: inherit; margin: 0px; padding: 0px; text-decoration-line: none; line-height: inherit; outline: none; transition: all 0.5s ease-in-out 0s;\">Kapil Grover</a>,&nbsp;<a href=\"mailto:shekhar.sharda@fatbit.com\" style=\"box-sizing: inherit; margin: 0px; padding: 0px; text-decoration-line: none; line-height: inherit; outline: none; transition: all 0.5s ease-in-out 0s;\">Shekhar Sharda&nbsp;</a>or&nbsp;<a href=\"mailto:rohit.kapoor@fatbit.com\" style=\"box-sizing: inherit; margin: 0px; padding: 0px; text-decoration-line: none; line-height: inherit; outline: none; transition: all 0.5s ease-in-out 0s;\">Rohit Kapoor</a>&nbsp;and expect a response within next 2 working days.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 10px 15px; list-style: lower-alpha inside; position: relative; color: rgb(74, 73, 73); font-size: 15px;\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">Final Escalation:</span>&nbsp;If you donâ€™t receive a satisfactory solution from any of the team members following the first level of escalation, or haven\'t received a reply within 5 business days after submitting your Feedback/Query/Complaint, you may escalate your case to our Chief Sales Officer&nbsp;<a href=\"mailto:sales@fatbit.com\" style=\"box-sizing: inherit; margin: 0px; padding: 0px; text-decoration-line: none; line-height: inherit; outline: none; transition: all 0.5s ease-in-out 0s;\">Mr. Rajiv Sharma</a>. Rest assured that immediate action will be taken.</li>\r\n</ul>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">21. Time Estimates:</span>&nbsp;Client agrees that stipulated timelines cannot be met if the project scope is changed by client once the project scope document is finalized. Client agrees not to change the requirements without extending the original agreed timelines by minimum 1 week against each change request.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">22. Share in profits from business or sale of business:&nbsp;</span>After client makes the agreed payment for the project, Yo!Kart will not claim share in clientâ€™s profits from business or from sale of business to some other company.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">23. Copyright/Ownership Rights:</span>&nbsp;Yo!Kart will retain the copyright of any material, including design, artwork and the source code, created for the client by Yo!Kart. Yo!Kart reserves the right to retain the copyright on all material created by Yo!Kart unless otherwise agreed between the two parties in writing. As per the agreed terms client owns rights on following items:</p>\r\n<ul class=\"terms_listing\" style=\"box-sizing: inherit; margin: 0px 0px 0px 30px; padding: 0px 0px 5px; list-style: none; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Logo/Graphics/Pictures/Images supplied by client â€“ Yes</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Website Interface/PSD/Creatives/Designs â€“ Yes, if client has ordered custom design with Exclusive Rights.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Programming Files/Source Code â€“ Yes, if the Client has ordered the project with Exclusive Rights. Client does not own the copyright/Intellectual property rights for projects being done on Single Domain License basis.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">If the project is being done on Single Domain License basis, Client owns the rights to use the system only on designated domains and Client should take reasonable care of the system files to restrict un-authorized access of the system scripts/source code delivered.</li>\r\n</ul>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">24. Ownership of Code and Intellectual Property Rights:</span>&nbsp;Unless otherwise agreed, Yo!Kart is the owner of the source code and the intellectual property rights and reserves the right to reuse the code for other projects. Following terms shall be applicable and obliged:</p>\r\n<ul class=\"terms_listing\" style=\"box-sizing: inherit; margin: 0px 0px 0px 30px; padding: 0px 0px 5px; list-style: none; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Client shall not create un-authorized copies of any Software/Scripts/Designs/File/Document/Information delivered to the Client by Yo!Kart</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Client shall not access and/or share and/or transfer any Software/Products/information/document owned by Yo!Kart unless authorized to do so</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Client shall not reverse engineer any software/script/application owned by Yo!Kart.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">Client shall not make any Software/Document/File/Information available to any third party in any manner, nor may Client use such works to provide services to any third party unless explicitly agreed otherwise in writing.</li>\r\n	<li style=\"box-sizing: inherit; margin: 0px; padding: 0px 0px 5px; position: relative; color: rgb(74, 73, 73); font-size: 15px; list-style: lower-roman;\">In the event that Client breaches any of terms specified in this clause, Client hereby authorizes any court of competent jurisdiction in India or Abroad to pass the judgment against the Client for and in the amount of USD 100,000 (USD Dollar One Hundred Thousand) for each default, as provided in the afore mentioned paragraphs, together with costs of suit and the cost of attorney incurred by Yo!Kart for recovery of above compensation/damages from Client. These damages/compensation allowed shall be considered as interim relief to Yo!Kart and Yo!Kart shall have the liberty to claim higher amount as compensation for the direct/indirect damages and Employer may pursue criminal proceedings as well</li>\r\n</ul>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">25. Termination of the agreement:</span>&nbsp;If either party terminates this Agreement for any reason, the parties will continue to perform all of their respective obligations under this Agreement</p>\r\n<h3 class=\"descrptn_title\" style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 0px; font-family: Muli, sans-serif; line-height: 1.3; font-size: calc(17px + ((15 * (100vw - 320px)) / 1600)); font-weight: 400; color: rgb(34, 34, 34); letter-spacing: 0.32px; background-color: rgb(255, 255, 255);\">(Terms 26th to 29th are only applicable in case of Single Domain Non Exclusive License)</h3>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">26. Single Domain License:&nbsp;</span>Unless otherwise agreed, client agrees to setup the scripts delivered only on one domain, one sub-domain (wip.yourdomain.com) and localhost. However if client wish to run same website on different domain/sub-domain, then client has to purchase separate license for each domain/sub-domain.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">No license would be required for Add-on Domains that will point to the main domain where this system will be implemented. All add-on domains will be forwarded to the main domain from the hosting server and no additional license would be required for these domains.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">For every new domain or sub-domain , client has to buy a separate license.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">27. License Validity Period:</span>&nbsp;Limited period license is issued initially. After 6 months from the date of full payment, life time license is issued. Feel Free to contact Yo!Kart Support Team, in case your license has expired and payment has been made in full, such issues will be resolved on highest priority.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">28. No recurring costs of license:</span>&nbsp;There is no renewal/recurring license fee. However, if client wishes to run same website on different domain or sub domain, then client has to purchase separate license for each domain or sub domain.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">29. Use of encrypted files:</span>&nbsp;Unless otherwise agreed, Yo!Kart can use own framework (code library in encrypted format) for web applications development for making source code of our intellectual property/scripts secure from other programmers; faster turnaround time; and bug free application development. Client will be provided with detailed documentation for using framework (code library functions). With the help of documentation provided, other programmers can modify the website functionality. Yo!Kart framework is collection of functions related to Database Manipulation, Images/Files Management, Paging, and Form Builder etc. which looks like PHP Functions but have different syntax than default PHP functions. Other willing and efficient PHP programmers can learn and practice these functions/framework within 2-4 days.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\"><span style=\"box-sizing: inherit; margin: 0px; padding: 0px; font-weight: 700;\">Note :</span>&nbsp;In no event, Yo!Kart shall be liable to the client or any third party for any damages, including any lost profits, lost savings or other incidental, consequential or special damages arising out of the operation of or inability to operate these Web pages or website, even if Yo!Kart has been advised of the possibility of such damages. Despite the best efforts of Yo!Kart, errors in web page information may occur. At no time will Yo!Kart be held responsible for accidentally including erroneous information, extending beyond correcting the error.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Should Yo!Kart waive any of these terms on an individual basis, this shall not affect the validity of remaining clauses or commit Yo!Kart to waive the same clause on any other occasion.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px 0px 20px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">By agreeing to these terms and conditions, your statutory rights are not affected.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Yo!Kart reserves the right to change or modify any of these terms or conditions at any time, but agreements signed prior to the updates in this agreement remains unaffected. Please feel free to contact us for more info/clarification about any of the terms and conditions mentioned above.</p>\r\n<p style=\"box-sizing: inherit; margin: 0px; padding: 8px 0px; font-size: 15px; color: rgb(34, 34, 34); font-family: \" open=\"\" sans\",=\"\" sans-serif;=\"\" letter-spacing:=\"\" 0.32px;=\"\" background-color:=\"\" rgb(255,=\"\" 255,=\"\" 255);\"=\"\">Please review <a target=\"_self\" data-org-url=\"/cms/view/3\" href=\"/cms/view/3\">Privacy Policies</a> from here</p>'
WHERE
    `tbl_content_pages_lang`.`cpagelang_cpage_id` = 2 AND `tbl_content_pages_lang`.`cpagelang_lang_id` = 1;

CREATE TABLE `tbl_user_cookies_preferences` (
  `ucp_user_id` int(11) NOT NULL,
  `ucp_statistical` tinyint(1) NOT NULL,
  `ucp_personalized` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `tbl_user_cookies_preferences`
  ADD PRIMARY KEY (`ucp_user_id`);

INSERT IGNORE INTO `tbl_language_labels` (`label_id`, `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES (NULL, "LBL_I_AGREE_TO_THE_TERMS_CONDITIONS_AND_PRIVACY_POLICY", "1", "I Agree To The %s And %s", "2");

INSERT IGNORE INTO `tbl_language_labels` (`label_id`, `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES (NULL, "LBL_What_is_a_cookie_Information", "1", "A cookie is a small text file that is stored in a dedicated location on your computer, tablet, smartphone or other device when you use your browser to visit an online service. A cookie allows its sender to identify the device on which it is stored during the period of validity of consent, which does not exceed 13 months.\r\n\r\nYou may accept or reject the cookies listed below using the check box provided.", "2");

INSERT IGNORE INTO `tbl_language_labels` (`label_id`, `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES (NULL, "LBL_Functional_Cookies_Information", "1", "These cookies are required for optimum operation of the website, and cannot be configured. They allow us to offer you the key functions of the website (language used, display resolution, account access, shopping bag, wish list, etc.), provide you with online advice and secure our website against any attempted fraud.", "2");

INSERT IGNORE INTO `tbl_language_labels` (`label_id`, `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES (NULL, "LBL_STATISTICAL_ANALYSIS_COOKIES_INFORMATION", "1", "These cookies are used to measure and analyse our website audience (visitor volume, pages viewed, average browsing time, etc.) to help us improve its performance. By accepting these cookies, you are helping us to improve our website.", "2");

INSERT IGNORE INTO `tbl_language_labels` (`label_id`, `label_key`, `label_lang_id`, `label_caption`, `label_type`) VALUES (NULL, "LBL_PERSONALISE_COOKIES_INFORMATION", "1", "These cookies allow us to provide you with online or in-store recommendations of products, services and content that match your expectations and preferences. By accepting these cookies, you are opting for an enriched and personalized experience.", "2");
ALTER TABLE `tbl_admin` CHANGE `admin_password` `admin_password_old` VARCHAR(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL;
ALTER TABLE `tbl_admin` ADD `admin_password` VARCHAR(100) NOT NULL AFTER `admin_password_old`;
ALTER TABLE `tbl_user_credentials` CHANGE `credential_password` `credential_password_old` VARCHAR(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `tbl_user_credentials` ADD `credential_password` VARCHAR(100) NOT NULL AFTER `credential_password_old`;
-- --- task_81779_advanced_GDPR_module --- --

DELETE FROM `tbl_language_labels` WHERE label_key = 'ERR_USER_INACTIVE_OR_DELTED';

UPDATE
    tbl_email_templates
SET
    etpl_body =
REPLACE
    (
        etpl_body,
        "style=\"background:#ff3a59;\"",
        ""
    );

UPDATE `tbl_configurations` SET `conf_val` = '<table align=\"center\" cellpadding=\"0\" cellspacing=\"0\" style=\"width:100%; margin:auto;\">\r\n                        <tr>\r\n                            <td style=\"background:#fff;vertical-align:top;text-align: center;\">\r\n                                <table cellpadding=\"0\" cellspacing=\"0\" style=\"width: 100%;\">\r\n                                    <tr>\r\n                                        <td style=\"color:#999;padding:30px 30px;\">\r\n                                            Get in touch if you have any questions regarding our Services.<br /> Feel free to contact us 24/7. We are here to help.<br />\r\n                                            <br /> All the best,<br /> The {website_name} Team<br />\r\n                                        </td>\r\n                                    </tr>\r\n                                </table>\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td style=\"padding: 30px 30px;background:rgba(0,0,0,0.04); text-align: center;\">\r\n                                <h4 style=\"font-size:20px; color:#000;margin: 0;\">Need more help?</h4>\r\n                                <a href=\"{contact_us_url}\" style=\"color:#ff3a59;\">We are here, ready to talk</a>\r\n                                <br> <br>\r\n                                {social_media_icons}\r\n                            </td>\r\n                        </tr>\r\n                        <tr>\r\n                            <td style=\"padding:0; text-align: center; font-size:13px; color:#999;vertical-align:top; line-height:20px;padding: 10px;\">\r\n                                {website_name} Inc.\r\n                            </td>\r\n                        </tr>\r\n                    </table>' WHERE `tbl_configurations`.`conf_name` = 'CONF_EMAIL_TEMPLATE_FOOTER_HTML1';
UPDATE `tbl_seller_packages` SET `spackage_type` = '2' WHERE `tbl_seller_packages`.`spackage_id` = 4;

ALTER TABLE `tbl_affiliate_commission_settings` CHANGE `afcommsetting_fees` `afcommsetting_fees` DECIMAL(12,2) NOT NULL;

INSERT INTO `tbl_email_templates` (`etpl_code`, `etpl_lang_id`, `etpl_name`, `etpl_subject`, `etpl_body`, `etpl_replacements`, `etpl_status`) VALUES ('admin_new_user_creation_email', '1', 'New Account Created By Admin', 'Welcome to {website_name}', '<table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n    <tr>\r\n        <td >\r\n            <!--\r\n            page title start here\r\n            -->\r\n\r\n            <table width=\"600\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                <tbody>\r\n                    <tr>\r\n                        <td style=\"background:#fff;padding:20px 0 10px; text-align:center;\">\r\n                            <h4 style=\"font-weight:normal; text-transform:uppercase; color:#999;margin:0; padding:10px 0; font-size:18px;\"></h4>\r\n                            <h2 style=\"margin:0; font-size:34px; padding:0;\">Welcome to {website_name}</h2></td>\r\n                    </tr>\r\n                </tbody>\r\n            </table>\r\n            <!--\r\n            page title end here\r\n            -->\r\n        </td>\r\n    </tr>\r\n    <tr>\r\n        <td>\r\n            <!--\r\n            page body start here\r\n            -->\r\n\r\n            <table width=\"600\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                <tbody>\r\n                    <tr>\r\n                        <td style=\"background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;\">\r\n                            <table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">\r\n                                <tbody>\r\n                                    <tr>\r\n                                        <td style=\"padding:20px 0 30px;\"><strong style=\"font-size:18px;color:#333;\">Dear {name} </strong><br />\r\n                                            <a href=\"{website_url}\">{website_name}</a> admin has created an {account_type} account for you.</td>\r\n                                    </tr>\r\n                                    <tr>\r\n                                        <td style=\"padding:20px 0 30px;\">To access and verify your account please visit the link given below. Your email address will be your username. \r\n                                            Please note that the link is valid for next {days} days.<br />\r\n                                            <a href=\"{reset_url}\">{reset_url}</a>.</td>\r\n                                    </tr>\r\n\r\n                                </tbody>\r\n                            </table></td>\r\n                    </tr>\r\n                </tbody>\r\n            </table>\r\n            <!--\r\n            page body end here\r\n            -->\r\n        </td>\r\n    </tr>\r\n</table>', '{user_full_name} Name of the email receiver<br>\r\n{user_email} User Email <br>\r\n{account_type} Account Type <br>\r\n{days} Days after which link expire\r\n{website_name} Name of our website<br>\r\n{website_url} URL of our website<br>\r\n{reset_url} URL to reset the password<br>\r\n{social_media_icons} <br>\r\n{contact_us_url} <br>', '1');

/* Shop And Product Ratings */
--
-- Table structure for table `tbl_rating_types`
--

CREATE TABLE IF NOT EXISTS `tbl_rating_types` (
  `ratingtype_id` bigint NOT NULL,
  `ratingtype_identifier` varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `ratingtype_type` tinyint(4) NOT NULL,
  `ratingtype_default` tinyint NOT NULL,
  `ratingtype_active` tinyint NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_rating_types`
--

INSERT INTO `tbl_rating_types` (`ratingtype_id`, `ratingtype_identifier`, `ratingtype_type`, `ratingtype_default`, `ratingtype_active`) VALUES
(1, 'Product', 1, 1, 1),
(2, 'Shop', 2, 1, 1),
(3, 'Delivery', 3, 1, 1),
(4, 'Stock Availability', 4, 0, 1),
(5, 'Packaging Quality', 4, 0, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_rating_types`
--
ALTER TABLE `tbl_rating_types`
  ADD PRIMARY KEY (`ratingtype_id`),
  ADD UNIQUE KEY `ratingtype_identifier` (`ratingtype_identifier`) USING BTREE;

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_rating_types`
--
ALTER TABLE `tbl_rating_types`
  MODIFY `ratingtype_id` bigint NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

CREATE TABLE IF NOT EXISTS `tbl_rating_types_lang` ( `ratingtypelang_ratingtype_id` BIGINT NOT NULL ,  `ratingtypelang_lang_id` INT NOT NULL ,  `ratingtype_name` VARCHAR(150) NOT NULL ) ENGINE = InnoDB;
ALTER TABLE `tbl_rating_types_lang`
  ADD PRIMARY KEY (`ratingtypelang_ratingtype_id`,`ratingtypelang_lang_id`),
  ADD UNIQUE KEY `ratingtype_name` (`ratingtypelang_lang_id`,`ratingtype_name`);

CREATE TABLE IF NOT EXISTS `tbl_prodcat_rating_types` ( `prt_prodcat_id` BIGINT NOT NULL ,  `prt_ratingtype_id` BIGINT NOT NULL ) ENGINE = InnoDB;
ALTER TABLE `tbl_prodcat_rating_types` ADD PRIMARY KEY (`prt_prodcat_id`,`prt_ratingtype_id`);

ALTER TABLE `tbl_order_product_specifics` ADD `op_prodcat_id` BIGINT NOT NULL AFTER `op_product_warranty`;
UPDATE tbl_order_product_specifics tops
INNER JOIN tbl_order_products op ON op.op_id = tops.ops_op_id
INNER JOIN tbl_product_to_category ptc ON ptc.ptc_product_id = SUBSTRING( op.op_selprod_code, 1, (LOCATE( "_", op.op_selprod_code ) - 1 ) )
SET tops.op_prodcat_id = ptc.ptc_prodcat_id;

ALTER TABLE `tbl_seller_product_rating` CHANGE `sprating_rating_type` `sprating_ratingtype_id` BIGINT NOT NULL;
UPDATE `tbl_seller_product_rating` SET `sprating_ratingtype_id` = '5' WHERE `tbl_seller_product_rating`.`sprating_ratingtype_id` = 4;
UPDATE `tbl_seller_product_rating` SET `sprating_ratingtype_id` = '4' WHERE `tbl_seller_product_rating`.`sprating_ratingtype_id` = 3;
UPDATE `tbl_seller_product_rating` SET `sprating_ratingtype_id` = '3' WHERE `tbl_seller_product_rating`.`sprating_ratingtype_id` = 2;
/* Shop And Product Ratings */

DELETE FROM tbl_language_labels WHERE label_key = "ERR_USER_INACTIVE_OR_DELTED";

INSERT IGNORE INTO `tbl_orders_status` (`orderstatus_id`, `orderstatus_identifier`, `orderstatus_color_class`, `orderstatus_type`, `orderstatus_priority`, `orderstatus_is_active`, `orderstatus_is_digital`) VALUES (NULL, 'Ready For Pickup', NULL, '1', '6', '1', '');
INSERT IGNORE INTO `tbl_configurations` (`conf_name`, `conf_val`) VALUES ('CONF_PICKUP_READY_ORDER_STATUS', 0);
UPDATE `tbl_configurations` SET `conf_val` = (select orderstatus_id from tbl_orders_status where orderstatus_identifier = 'Ready For Pickup') WHERE `tbl_configurations`.`conf_name` = 'CONF_PICKUP_READY_ORDER_STATUS';


-- --- Task 83836 - Font and Theme Color Management --- --
INSERT IGNORE INTO `tbl_configurations` (`conf_name`, `conf_val`, `conf_common`) VALUES ('CONF_THEME_FONT_FAMILY', 'Poppins-regular', '1');
INSERT IGNORE INTO `tbl_configurations` (`conf_name`, `conf_val`, `conf_common`) VALUES ('CONF_THEME_COLOR', '#ff3a59', '1');
INSERT IGNORE INTO `tbl_configurations` (`conf_name`, `conf_val`, `conf_common`) VALUES ('CONF_THEME_COLOR_INVERSE', '#fff', '1');
DROP TABLE `tbl_theme`;
DROP TABLE `tbl_theme_colors`;
-- --- Task 83836 - Font and Theme Color Management --- --

ALTER TABLE `tbl_order_products` ADD `op_refund_tax` DECIMAL(10,2) NOT NULL AFTER `op_refund_shipping`;

-- --- query to update cancel order data --- --

CREATE VIEW view_cancel_order AS SELECT
    op.op_id,
    op.op_invoice_number,
    op.op_qty,
    op.op_commission_charged,
    op.op_affiliate_commission_charged,
    (
        (op.op_unit_price * op.op_qty) + SUM(opc.opcharge_amount) + op.op_rounding_off
    ) AS txnAmount,
    SUM(
        CASE WHEN opc.opcharge_type = 3 THEN opc.opcharge_amount ELSE 0
    END
) AS shipping,
SUM(
CASE WHEN opc.opcharge_type = 1 THEN opc.opcharge_amount ELSE 0
END
) AS tax
FROM
`tbl_order_cancel_requests` ocr
INNER JOIN  
tbl_order_products as op on op.op_id = ocr.ocrequest_op_id and ocr.ocrequest_status = 1
LEFT OUTER JOIN `tbl_order_product_charges` AS opc
ON
opc.opcharge_op_id = op.op_id 
WHERE
op_refund_amount = 0
GROUP BY
op_id;    

UPDATE tbl_order_products op
INNER JOIN  
view_cancel_order on op.op_id = view_cancel_order.op_id
SET
op.op_refund_qty = view_cancel_order.op_qty,
op.op_refund_amount = view_cancel_order.txnAmount,
op.op_refund_commission = view_cancel_order.op_commission_charged,
op.op_refund_shipping = view_cancel_order.shipping,
op.op_refund_tax = view_cancel_order.tax,
op.op_refund_affiliate_commission = view_cancel_order.op_affiliate_commission_charged;

DROP VIEW view_cancel_order;

-- --- query to update cancel order data --- --

-- --- query to update refund order data --- --
CREATE VIEW view_refund_order AS SELECT
    orrequest_op_id,
    LEAST(
        (
            (
                opc.opcharge_amount / op.op_qty
            ) * orrequest_qty
        ),
        opc.opcharge_amount
    ) AS refund_tax
FROM
    `tbl_order_return_requests` orrequest
LEFT OUTER JOIN `tbl_order_products` AS op
ON
    orrequest.orrequest_op_id = op.op_id
LEFT OUTER JOIN `tbl_orders` AS o
ON
    op_order_id = order_id
INNER JOIN `tbl_order_product_charges` AS opc
ON
    opc.opcharge_op_id = op.op_id AND opcharge_type = 1
WHERE
    orrequest_status = 2 AND op_refund_tax = 0;

UPDATE tbl_order_products op
INNER JOIN  
view_refund_order on op.op_id = view_refund_order.orrequest_op_id
SET
op.op_refund_tax = view_refund_order.refund_tax;

DROP VIEW view_refund_order;

-- --- query to update refund order data --- --

UPDATE `tbl_email_templates` SET `etpl_replacements` = '{shop_name} - Shop Name.<br/>\r\n{website_name} Name of our website<br>\r\n{product_name} Product Name <br>\r\n{new_status} New Request Status (Approved/Declined) <br>\r\n{reference_number} Reference Number of the request<br>\r\n{social_media_icons} <br>\r\n{contact_us_url} <br>' WHERE `tbl_email_templates`.`etpl_code` = 'seller_catalog_request_status_change' AND `tbl_email_templates`.`etpl_lang_id` = 1;
UPDATE `tbl_email_templates` SET `etpl_body` = '<table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">    \r\n	<tbody>\r\n		<tr>        \r\n			<td>            \r\n				<!--\r\n				page title start here\r\n				-->\r\n				               \r\n            \r\n				<table width=\"600\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">                \r\n					<tbody>                    \r\n						<tr>                        \r\n							<td style=\"background:#fff;padding:20px 0 10px; text-align:center;\">                           \r\n								                           \r\n								<h2 style=\"margin:0; font-size:34px; padding:0;\">Catalog {new_status}</h2></td>                    \r\n						</tr>                \r\n					</tbody>            \r\n				</table>            \r\n				<!--\r\n				page title end here\r\n				-->\r\n				               </td>    \r\n		</tr>    \r\n		<tr>        \r\n			<td>            \r\n				<!--\r\n				page body start here\r\n				-->\r\n				               \r\n            \r\n				<table width=\"600\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">                \r\n					<tbody>                    \r\n						<tr>                        \r\n							<td style=\"background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;\">                            \r\n								<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">                                \r\n									<tbody>                                    \r\n										<tr>                                        \r\n											<td style=\"padding:20px 0 30px;\"><strong style=\"font-size:18px;color:#333;\">Dear {shop_name} </strong><br />\r\n												                                              Your catalog {product_name} has been {new_status} on {website_name}.</td>                                    \r\n										</tr> \r\n									</tbody>                            \r\n								</table></td>                    \r\n						</tr>                \r\n					</tbody>            \r\n				</table>            \r\n				<!--\r\n				page body end here\r\n				-->\r\n				               </td>    \r\n		</tr>\r\n	</tbody>\r\n</table> ' WHERE `tbl_email_templates`.`etpl_code` = 'seller_catalog_request_status_change' AND `tbl_email_templates`.`etpl_lang_id` = 1;
UPDATE `tbl_email_templates` SET `etpl_name` = 'Seller - Catalog  Status Change' WHERE `tbl_email_templates`.`etpl_code` = 'seller_catalog_request_status_change' AND `tbl_email_templates`.`etpl_lang_id` = 1;
UPDATE `tbl_email_templates` SET `etpl_subject` = 'Your Catalog {product_name} {new_status} at {website_name}' WHERE `tbl_email_templates`.`etpl_code` = 'seller_catalog_request_status_change' AND `tbl_email_templates`.`etpl_lang_id` = 1;

UPDATE `tbl_sms_templates` SET `stpl_body` = 'Hello {shop_name},\r\nYour catalog {product_name} has been {new_status} on {website_name}\r\n\r\n{SITE_NAME} Team' WHERE `tbl_sms_templates`.`stpl_code` = 'seller_catalog_request_status_change' AND `tbl_sms_templates`.`stpl_lang_id` = 1;
UPDATE `tbl_sms_templates` SET `stpl_replacements` = '[{\"title\":\"Seller Shop\", \"variable\":\"{shop_name}\"},{\"title\":\"New Status\", \"variable\":\"{new_status}\"},{\"title\":\"Product Name\", \"variable\":\"{product_name}\"}, {\"title\":\"Website Name\", \"variable\":\"{SITE_NAME}\"}]' WHERE `tbl_sms_templates`.`stpl_code` = 'seller_catalog_request_status_change' AND `tbl_sms_templates`.`stpl_lang_id` = 1;

ALTER TABLE `tbl_shipping_profile` CHANGE `shipprofile_name` `shipprofile_identifier` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

CREATE TABLE `tbl_shipping_profile_lang` (
  `shipprofilelang_shipprofile_id` int NOT NULL,
  `shipprofilelang_lang_id` int NOT NULL,
  `shipprofile_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tbl_shipping_profile_lang` ADD UNIQUE( `shipprofilelang_shipprofile_id`, `shipprofilelang_lang_id`);
INSERT INTO `tbl_configurations` (`conf_name`, `conf_val`) VALUES
('CONF_DEFAULT_INPROCESS_ORDER_STATUS', 3)
ON DUPLICATE KEY UPDATE conf_val = 3;

DELETE FROM `tbl_language_labels` WHERE label_key = 'LBL_Products(Catalog_Wise)';
DELETE FROM `tbl_language_labels` WHERE label_key = 'LBL_Products(Seller_Products)';
DELETE FROM `tbl_language_labels` WHERE label_key = 'LBL_Buyers/Sellers';

-- --- task_84719_Preview_module_for_digital_files -- ---
ALTER TABLE `tbl_products` ADD `product_attachements_with_inventory` TINYINT(1) NOT NULL DEFAULT '0' AFTER `product_type`;

--
-- Table structure for table `tbl_product_digital_data_relation`
--

CREATE TABLE `tbl_product_digital_data_relation` (
  `pddr_id` int(11) NOT NULL,
  `pddr_record_id` int(11) NOT NULL COMMENT 'anyone of following: 1) Catalog id (pddr_id) 2) Seller inventory id',
  `pddr_options_code` varchar(255) NOT NULL COMMENT '0 for all options',
  `pddr_type` tinyint(4) NOT NULL COMMENT '0 => Master Catalog, 1 => catalog request'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_product_digital_data_relation`
--

ALTER TABLE `tbl_product_digital_data_relation`
  ADD PRIMARY KEY (`pddr_id`),
  ADD UNIQUE KEY `pdd_options_code` (`pddr_record_id`,`pddr_options_code`,`pddr_type`) USING BTREE;

--
-- AUTO_INCREMENT for table `tbl_product_digital_data_relation`
--
ALTER TABLE `tbl_product_digital_data_relation`
  MODIFY `pddr_id` int(11) NOT NULL AUTO_INCREMENT;


--
-- Table structure for table `tbl_product_digital_links`
--

CREATE TABLE `tbl_product_digital_links` (
  `pdl_id` int(11) NOT NULL,
  `pdl_record_id` int(11) NOT NULL COMMENT 'anyone of following: 1) Catalog id (pddr_id) 2) Seller inventory id',
  `pdl_lang_id` int(11) NOT NULL,
  `pdl_download_link` varchar(255) NOT NULL,
  `pdl_preview_link` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='Contains Digital download links which are related to a Catalog product or seller Inventory';

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_product_digital_links`
--
ALTER TABLE `tbl_product_digital_links`
  ADD PRIMARY KEY (`pdl_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_product_digital_links`
--
ALTER TABLE `tbl_product_digital_links`
  MODIFY `pdl_id` int(11) NOT NULL AUTO_INCREMENT;
-- --- task_84719_Preview_module_for_digital_files -- ---

UPDATE `tbl_email_templates` SET `etpl_replacements` = '{shop_name} - Shop Name.<br/>\r\n{website_name} Name of our website<br>\r\n{product_name} Product Name <br>\r\n{new_status} New Request Status (Approved/Declined) <br>\r\n{reference_number} Reference Number of the request<br>\r\n{social_media_icons} <br>\r\n{contact_us_url} <br>' WHERE `tbl_email_templates`.`etpl_code` = 'seller_catalog_request_status_change' AND `tbl_email_templates`.`etpl_lang_id` = 1;
UPDATE `tbl_email_templates` SET `etpl_body` = '<table width=\"100%\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">    \r\n	<tbody>\r\n		<tr>        \r\n			<td>            \r\n				<!--\r\n				page title start here\r\n				-->\r\n				               \r\n            \r\n				<table width=\"600\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">                \r\n					<tbody>                    \r\n						<tr>                        \r\n							<td style=\"background:#fff;padding:20px 0 10px; text-align:center;\">                           \r\n								                           \r\n								<h2 style=\"margin:0; font-size:34px; padding:0;\">Catalog {new_status}</h2></td>                    \r\n						</tr>                \r\n					</tbody>            \r\n				</table>            \r\n				<!--\r\n				page title end here\r\n				-->\r\n				               </td>    \r\n		</tr>    \r\n		<tr>        \r\n			<td>            \r\n				<!--\r\n				page body start here\r\n				-->\r\n				               \r\n            \r\n				<table width=\"600\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">                \r\n					<tbody>                    \r\n						<tr>                        \r\n							<td style=\"background:#fff;padding:0 30px; text-align:center; color:#999;vertical-align:top;\">                            \r\n								<table width=\"100%\" border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"0\">                                \r\n									<tbody>                                    \r\n										<tr>                                        \r\n											<td style=\"padding:20px 0 30px;\"><strong style=\"font-size:18px;color:#333;\">Dear {shop_name} </strong><br />\r\n												                                              Your catalog {product_name} has been {new_status} on {website_name}.</td>                                    \r\n										</tr> \r\n									</tbody>                            \r\n								</table></td>                    \r\n						</tr>                \r\n					</tbody>            \r\n				</table>            \r\n				<!--\r\n				page body end here\r\n				-->\r\n				               </td>    \r\n		</tr>\r\n	</tbody>\r\n</table> ' WHERE `tbl_email_templates`.`etpl_code` = 'seller_catalog_request_status_change' AND `tbl_email_templates`.`etpl_lang_id` = 1;
UPDATE `tbl_email_templates` SET `etpl_name` = 'Seller - Catalog  Status Change' WHERE `tbl_email_templates`.`etpl_code` = 'seller_catalog_request_status_change' AND `tbl_email_templates`.`etpl_lang_id` = 1;
UPDATE `tbl_email_templates` SET `etpl_subject` = 'Your Catalog {product_name} {new_status} at {website_name}' WHERE `tbl_email_templates`.`etpl_code` = 'seller_catalog_request_status_change' AND `tbl_email_templates`.`etpl_lang_id` = 1;

UPDATE `tbl_sms_templates` SET `stpl_body` = 'Hello {shop_name},\r\nYour catalog {product_name} has been {new_status} on {website_name}\r\n\r\n{SITE_NAME} Team' WHERE `tbl_sms_templates`.`stpl_code` = 'seller_catalog_request_status_change' AND `tbl_sms_templates`.`stpl_lang_id` = 1;
UPDATE `tbl_sms_templates` SET `stpl_replacements` = '[{\"title\":\"Seller Shop\", \"variable\":\"{shop_name}\"},{\"title\":\"New Status\", \"variable\":\"{new_status}\"},{\"title\":\"Product Name\", \"variable\":\"{product_name}\"}, {\"title\":\"Website Name\", \"variable\":\"{SITE_NAME}\"}]' WHERE `tbl_sms_templates`.`stpl_code` = 'seller_catalog_request_status_change' AND `tbl_sms_templates`.`stpl_lang_id` = 1;

ALTER TABLE `tbl_shipping_profile` CHANGE `shipprofile_name` `shipprofile_identifier` VARCHAR(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL;

CREATE TABLE `tbl_shipping_profile_lang` (
  `shipprofilelang_shipprofile_id` int NOT NULL,
  `shipprofilelang_lang_id` int NOT NULL,
  `shipprofile_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `tbl_shipping_profile_lang` ADD UNIQUE( `shipprofilelang_shipprofile_id`, `shipprofilelang_lang_id`);
INSERT INTO `tbl_configurations` (`conf_name`, `conf_val`) VALUES
('CONF_DEFAULT_INPROCESS_ORDER_STATUS', 3)
ON DUPLICATE KEY UPDATE conf_val = 3;


--------------------------------------------------

-- --- task_84719_Preview_module_for_digital_files -- ---
--- Update tbl_attached_files table ---
DROP VIEW IF EXISTS pddr_files_view;

CREATE VIEW pddr_files_view AS select tbl_seller_products.selprod_id, selprod_product_id, selprod_code, SUBSTRING(selprod_code, INSTR(selprod_code, '_') + 1) as new_selprodcode
FROM tbl_seller_products
INNER JOIN tbl_attached_files ON afile_type = 42 AND afile_record_id = tbl_seller_products.selprod_id
INNER JOIN tbl_products ON product_id = selprod_product_id AND product_type = 2;

INSERT INTO tbl_product_digital_data_relation (pddr_record_id, pddr_options_code, pddr_type) 
SELECT selprod_id, new_selprodcode, 2 FROM pddr_files_view ON DUPLICATE KEY UPDATE pddr_record_id = selprod_id;

UPDATE tbl_attached_files as afile
INNER JOIN pddr_files_view as v ON selprod_id = afile_record_id
INNER JOIN tbl_product_digital_data_relation as pddr ON pddr_record_id = afile_record_id AND v.new_selprodcode = pddr.pddr_options_code 
SET afile.afile_record_id = pddr_id;

DROP VIEW IF EXISTS pddr_files_view;

-----------------------------------------------------------------------------------------
--- Process links stored in tbl_seller_products table (selprod_downloadable_link) ---

UPDATE tbl_seller_products SET selprod_downloadable_link = REPLACE(selprod_downloadable_link,'\n',',');

DROP VIEW IF EXISTS pddr_links_view;

CREATE VIEW pddr_links_view AS select tbl_seller_products.selprod_id, selprod_product_id, selprod_code, SUBSTRING(selprod_code, INSTR(selprod_code, '_') + 1) as new_selprodcode,
SUBSTRING_INDEX(SUBSTRING_INDEX(tbl_seller_products.selprod_downloadable_link, ',', numbers.n), ',', -1) link, 0 as pddr
from
(select 1 n union all
 select 2 union all select 3 union all
 select 4 union all select 5) numbers INNER JOIN tbl_seller_products
on CHAR_LENGTH(tbl_seller_products.selprod_downloadable_link)
   -CHAR_LENGTH(REPLACE(tbl_seller_products.selprod_downloadable_link, ',', ''))>=numbers.n-1 and CHAR_LENGTH(tbl_seller_products.selprod_downloadable_link) > 0    
order by
selprod_id, n;

INSERT INTO tbl_product_digital_data_relation (pddr_record_id, pddr_options_code, pddr_type) 
SELECT selprod_id, new_selprodcode, 2 FROM pddr_links_view ON DUPLICATE KEY UPDATE pddr_record_id = selprod_id;

ALTER TABLE `tbl_product_digital_links` ADD `pdl_selprod_code` VARCHAR(255) NOT NULL AFTER `pdl_preview_link`;
ALTER TABLE `tbl_product_digital_links` ADD `pdl_selprod_id` VARCHAR(255) NOT NULL AFTER `pdl_preview_link`;

INSERT INTO tbl_product_digital_links (pdl_record_id, pdl_lang_id, pdl_download_link, pdl_selprod_code, pdl_selprod_id)
SELECT 0, 0, link, new_selprodcode, selprod_id FROM pddr_links_view;

UPDATE tbl_product_digital_links INNER JOIN  tbl_product_digital_data_relation ON pdl_selprod_id = pddr_record_id AND pdl_selprod_code =  pddr_options_code AND pddr_type = 2 SET pdl_record_id = pddr_id;

DROP VIEW IF EXISTS pddr_links_view;
-----------------------------------------------------------------------------------------
ALTER TABLE `tbl_product_digital_links` DROP `pdl_selprod_id`;
ALTER TABLE `tbl_product_digital_links` DROP `pdl_selprod_code`;

ALTER TABLE `tbl_seller_products` DROP `selprod_downloadable_link`;

UPDATE tbl_product_digital_data_relation SET pddr_options_code = IF(pddr_options_code = '', 0, ifnull(pddr_options_code,0));
-----------------------------------------------------------------------------------------
-- --- task_84719_Preview_module_for_digital_files -- ---


INSERT IGNORE INTO `tbl_plugins` (`plugin_identifier`, `plugin_type`, `plugin_code`, `plugin_active`, `plugin_display_order`) VALUES ('Qnb', '13', 'Qnb', '0', '1');