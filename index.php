<?php

require 'vendor/autoload.php';
require_once 'core/bootstrap.php';

use Wiar\Core\{Router, Request};

Router::load('app/routes.php')
	->direct(Request::uri(), Request::method());
