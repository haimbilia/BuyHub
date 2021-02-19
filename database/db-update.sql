/* Renaming DPO payment gateway to Paygate. */
UPDATE `tbl_plugins` SET `plugin_identifier`='Paygate', `plugin_code`='Paygate' WHERE plugin_code = 'Dpo';
/* Renaming DPO payment gateway to Paygate. */

-- --- Dpo Payment Gateway--- --
INSERT IGNORE INTO `tbl_plugins` (`plugin_identifier`, `plugin_type`, `plugin_code`, `plugin_active`, `plugin_display_order`) VALUES ('Dpo', '13', 'Dpo', '0', '23');
-- --- Dpo Payment Gateway--- --

-- --- Handling Multi Level Categories --- --
DELIMITER $$
DROP PROCEDURE IF EXISTS UPDATECATEGORYRELATIONS$$
CREATE PROCEDURE UPDATECATEGORYRELATIONS(IN catId INT)
BEGIN
   DECLARE levelCounter INT DEFAULT 0;
   DECLARE maxLevel INT DEFAULT 20;
   WHILE levelCounter <= maxLevel DO
        /**Sql statement**/
        IF 0 < catId THEN 
            DELETE FROM `tbl_product_category_relations` WHERE `pcr_prodcat_id` = catId;
        END IF;

        IF 1 > levelCounter THEN 
            INSERT IGNORE INTO `tbl_product_category_relations`(`pcr_prodcat_id`, `pcr_parent_id`, `pcr_level`) 
			SELECT prodcat_id, prodcat_id, 0 FROM `tbl_product_categories` WHERE (CASE WHEN 0 < catId THEN prodcat_id = catId ELSE TRUE END) ORDER BY prodcat_id ASC;
			INSERT IGNORE INTO `tbl_product_category_relations`(`pcr_prodcat_id`, `pcr_parent_id`, `pcr_level`)
			SELECT prodcat_id, prodcat_parent, 1 FROM `tbl_product_categories` WHERE prodcat_parent > 0 AND (CASE WHEN 0 < catId THEN prodcat_id = catId ELSE TRUE END) ORDER BY prodcat_id ASC;
        END IF;

        INSERT IGNORE INTO `tbl_product_category_relations`(`pcr_prodcat_id`, `pcr_parent_id`, `pcr_level`)
        SELECT prodcat_id, pcr_parent_id, (pcr_level+1) FROM `tbl_product_categories`
        INNER JOIN tbl_product_category_relations ON pcr_prodcat_id = prodcat_parent
        WHERE pcr_prodcat_id != pcr_parent_id 
        AND (CASE WHEN 0 < catId THEN prodcat_id = catId ELSE TRUE END) 
        ORDER BY prodcat_id ASC;

        IF 0 < catId THEN 
            SET levelCounter = maxLevel;
        END IF;
		
		SET levelCounter = levelCounter + 1;
   END WHILE;
END$$
DELIMITER ;


CREATE TRIGGER `ADDNEWCATEGORY`
AFTER INSERT ON `tbl_product_categories` 
FOR EACH ROW 
CALL UPDATECATEGORYRELATIONS(new.prodcat_id);

CREATE TRIGGER `UPDATECATEGORY`
AFTER UPDATE ON `tbl_product_categories` 
FOR EACH ROW 
CALL UPDATECATEGORYRELATIONS(new.prodcat_id);
-- --- Handling Multi Level Categories --- --