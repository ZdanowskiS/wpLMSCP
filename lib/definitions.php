<?php

define('WP_ELEMENTTYPE_REQUIRED', 1);
define('WP_ELEMENTTYPE_OPTIONAL', 2);
define('WP_ELEMENTTYPE_ALTERNATIVE', 3);

define('WP_SUGGESTTYPE_REQUIRED', 1);
define('WP_SUGGESTTYPE_CONFLICT', 2);

define('STOCK_COMPANY', 1);
define('STOCK_STANDARD', 2);
define('STOCK_ADDITIONAL', 3);
define('STOCK_LEASE', 4);
define('STOCK_INSTALLMENT', 5);
define('STOCK_SOLD', 6);
define('STOCK_LIQUIDATION', 7);

$STOCKSTATUS = array(
	STOCK_COMPANY => 'Company property',
	STOCK_STANDARD => 'Standard instalation',
	STOCK_ADDITIONAL => 'Additional instalation',
	STOCK_LEASE => 'Lease',
	STOCK_INSTALLMENT => 'Installment',
	STOCK_SOLD => 'Sold',
	STOCK_LIQUIDATION => 'Liquidation',
);

?>
