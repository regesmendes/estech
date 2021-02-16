#
# Stored Procedure to import a csv file
#

# DELIMITER $$
CREATE PROCEDURE `importPrices`(
    IN p_sku VARCHAR (100),
    IN p_account_ref VARCHAR (100),
    IN p_user_ref VARCHAR (100),
    IN p_quantity INTEGER,
    IN p_value DOUBLE
)
BEGIN
    DECLARE v_product_id, v_account_id, v_user_id INT DEFAULT NULL;
    DECLARE v_code CHAR (5) DEFAULT '00000';
    DECLARE v_msg TEXT;

    DECLARE CONTINUE HANDLER FOR SQLEXCEPTION
    BEGIN 
        GET DIAGNOSTICS CONDITION 1 v_code = RETURNED_SQLSTATE, v_msg = MESSAGE_TEXT;
    END;

    SELECT id INTO v_product_id FROM products WHERE sku = p_sku;
    SELECT id INTO v_account_id FROM accounts WHERE external_reference = p_account_ref;
    SELECT id INTO v_user_id FROM users WHERE external_reference = p_user_ref;

	IF (v_product_id IS NOT NULL) THEN
		INSERT INTO prices (
			product_id, 
			account_id, 
			user_id, 
			quantity, 
			`value`, 
			created_at, 
			updated_at
		) VALUES (
			v_product_id,
			v_account_id,
			v_user_id,
			p_quantity,
			p_value,
			NOW(),
			NOW()
		);
    ELSE  
		SET v_code = '-9999';
        SET v_msg= 'Unknown product!';
	END IF;
    
    SELECT v_code AS `code`, v_msg AS `message`;
END;

#
# Store Procedure to query the lowest price
#

CREATE PROCEDURE `getPrices`(
	IN p_product TEXT,
    IN p_account VARCHAR(100)
)
BEGIN
	SELECT `products`.`sku`, 
			least(coalesce(products.price, prices.value), coalesce(prices.value, products.price)) AS price 
	FROM `products` LEFT JOIN `prices` ON `products`.`id` = `prices`.`product_id` 
	  AND (`prices`.`account_id` IS NULL OR `prices`.`account_id` = (SELECT id FROM `accounts` WHERE `accounts`.`external_reference` = p_account)) 
	WHERE FIND_IN_SET(`products`.`sku`, p_product);
END;

# DELIMITER ;

#
# Usefull indexes to optimze the DB price query 
#

ALTER TABLE `prices` 
ADD INDEX `prices_idx_product_id` (`product_id` ASC),
ADD INDEX `prices_idx_account_id` (`account_id` ASC);

ALTER TABLE `products` 
ADD UNIQUE INDEX `products_idx_sku` (`sku` ASC);

ALTER TABLE `accounts` 
ADD UNIQUE INDEX `accounts_idx_external_ref` (`external_reference` ASC);
