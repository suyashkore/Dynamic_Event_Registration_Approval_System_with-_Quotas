<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';  // Make sure active group is defined
$active_record = TRUE;

// Database connection settings
$db['default'] = array(
    'dsn'   => '',
    'hostname' => '127.0.0.1',  // Database hostname (localhost for local setups)
    'username' => 'root',       // Default MySQL username for XAMPP/WAMP
    'password' => '',           // Default MySQL password for XAMPP/WAMP (empty)
    'database' => 'event_system_ci3',  // Make sure your database name matches
    'dbdriver' => 'mysqli',     // Using MySQLi for the connection
    'dbprefix' => '',           // You can set a prefix for your tables if needed
    'pconnect' => FALSE,        // Using persistent connections, set to FALSE
    'db_debug' => TRUE,         // Enable or disable DB debug, TRUE for error details
    'cache_on' => FALSE,        // Set to TRUE if you want to enable query caching
    'cachedir' => '',           // Directory path for cache
    'char_set' => 'utf8',       // Default character set
    'dbcollat' => 'utf8_general_ci',  // Default collation
    'swap_pre' => '',           // Prefix swap, leave empty unless needed
    'encrypt' => FALSE,         // Set to TRUE if encryption is required
    'compress' => FALSE,        // Set to TRUE if compression is needed
    'stricton' => FALSE,        // Strict mode for database (leave FALSE unless required)
    'failover' => array(),      // Failover array if needed for secondary database
    'save_queries' => TRUE      // Save query information for debugging
);
