ALTER TABLE `payment_accounts` ADD `billing_firstname` VARCHAR(100) NOT NULL AFTER `name`;
ALTER TABLE `payment_accounts` ADD `billing_lastname` VARCHAR(100) NOT NULL AFTER `billing_firstname`;
ALTER TABLE `user_payments` ADD `passcode` VARCHAR(100) NOT NULL AFTER `transaction_type`;