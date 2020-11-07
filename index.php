<?php

$query = require 'bootstrap.php';

$task = $query->selectAll('tasks');

require 'index.view.php';
