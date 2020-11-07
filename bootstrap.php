<?php

$config = require 'config.php';

require 'database/Connection.php';
require 'database/QueryBuilder.php';

return new QueryBuilder(
	connection::make($config['database'])
);