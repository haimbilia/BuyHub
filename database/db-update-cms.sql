UPDATE `tbl_extra_pages_lang` SET `epage_content` = '<div class=\"heading1\">Simple steps to start selling online</div>        \r\n        \r\n<div class=\"seller-steps\">  \r\n	<ul>      \r\n		<li><i class=\"icn\"><img src=\"/images/easyto-use.png\" alt=\"\" width=\"84\" height=\"105\" /></i>\r\n			<h3>Easy to Use</h3>  \r\n			<p>Set up simulation exercises for large group of students in a few steps.</p></li>      \r\n		<li><i class=\"icn\"><img src=\"/images/real-market.png\" alt=\"\" /></i>  \r\n			<h3>Real Market Data</h3>  \r\n			<p>Use real financial markets data in simulation activities.</p></li>      \r\n		<li><i class=\"icn\"><img src=\"/images/simulated.png\" alt=\"\" /></i>  \r\n			<h3>Simulated Market Data</h3>  \r\n			<p>Simulate past market events and data over a specific historical time period.</p></li>      \r\n		<li><i class=\"icn\"><img src=\"/images/customization.png\" alt=\"\" /></i>  \r\n			<h3>Fully Customisable</h3>  \r\n			<p>Fully customize activities to meet various learning outcomes, disciplines and levels of difficulty.</p></li>  \r\n	</ul></div>' WHERE `tbl_extra_pages_lang`.`epagelang_epage_id` = 17 AND `tbl_extra_pages_lang`.`epagelang_lang_id` = 1;
UPDATE `tbl_extra_pages` SET `epage_default_content` = '<div class=\"heading1\">Simple steps to start selling online</div>  <div class=\"seller-steps\">  	<ul>  		<li> <i class=\"icn\"><img src=\"/images/easyto-use.png\" alt=\"\" /></i>  			<h3>Easy to Use</h3>  			<p>Set up simulation exercises for large group of students in a few steps.</p> </li>  		<li> <i class=\"icn\"><img src=\"/images/real-market.png\" alt=\"\" /></i>  			<h3>Real Market Data</h3>  			<p>Use real financial markets data in simulation activities.</p> </li>  		<li> <i class=\"icn\"><img src=\"/images/simulated.png\" alt=\"\" /></i>  			<h3>Simulated Market Data</h3>  			<p>Simulate past market events and data over a specific historical time period.</p> </li>  		<li> <i class=\"icn\"><img src=\"/images/customization.png\" alt=\"\" /></i>  			<h3>Fully Customisable</h3>  			<p>Fully customise activities to meet various learning outcomes, disciplines and levels of difficulty.</p> </li>  	</ul> </div>' WHERE `tbl_extra_pages`.`epage_id` = 17;

/* TaxJar Enhancements */
INSERT IGNORE INTO `tbl_attached_files`(  
    `afile_type`,
    `afile_record_id`,
    `afile_record_subid`,
    `afile_lang_id`,
    `afile_screen`,
    `afile_physical_path`,
    `afile_name`,
    `afile_attribute_title`,
    `afile_attribute_alt`,
    `afile_aspect_ratio`,
    `afile_display_order`,
    `afile_downloaded_times`,
    `afile_updated_at`
)
VALUES( 
    '54',
    (SELECT plugin_id FROM `tbl_plugins` where plugin_code ='TaxJarTax'), '0', '0', '0', '2021/04/1619761288-taxjarglyphpng', 'taxjar-glyph.png', '', '', '0', '3', '0', '2021-04-30 11:11:28');
/* TaxJar Enhancements */