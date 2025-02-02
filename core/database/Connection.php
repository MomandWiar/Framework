<?php

namespace Wiar\Core\Database;

use PDO;
use PDOException;

class Connection
{
    /**
     * Create a new PDO connection.
     *
     * @param array $config
     * @return PDO
     */
    public static function make($config)
    {
        try {
            return new PDO(
            	$config['connection'] . ";dbname=" . $config['name'],
            	$config['username'],
            	$config['password'],
            	$config['options']
            );
        } catch (PDOException $e) {
            die('<b>Could not connect <br></b>' . $e->getMessage());
        }
    }
}
