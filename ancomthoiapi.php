<?php

/**
 * @wordpress-plugin
 * Plugin Name:      Ancomthoi
 * Plugin URI:
 * Description:       oder food
 * Version:           1.0.0
 * Author:            Duvit
 * Author URI:        vuongnam1009@gmail.com
 * License:           GPL-2.0+
 * License URI:
 * Text Domain:
 * Domain Path:
 */

if (!defined('WPINC')) {
    die;
}
require_once 'define.php';
require_once plugin_dir_path(__FILE__) . 'vendor/autoload.php';


require_once  ANCOMTHOI_REST_API_PATH . '/models/index.php';
$models = new Models(null, null);
$models->createDatabase();


require ANCOMTHOI_REST_API_PATH . '/routers/index.php';


$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
