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
ALTER TABLE `tbl_tax_rule_locations` ADD UNIQUE( `taxruleloc_taxcat_id`, `taxruleloc_from_country_id`, `taxruleloc_from_state_id`, `taxruleloc_to_country_id`, `taxruleloc_to_state_id`, `taxruleloc_type`, `taxruleloc_unique`);
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

