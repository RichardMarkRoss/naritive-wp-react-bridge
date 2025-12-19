<?php
/**
 * Plugin Name: Naritive Bridge
 * Description: Campaign CPT + REST API bridge for Naritive challenge.
 * Version: 0.1.0
 * Author: Richard
 */

if (!defined('ABSPATH')) exit;

define('NARITIVE_BRIDGE_PATH', plugin_dir_path(__FILE__));
define('NARITIVE_BRIDGE_URL', plugin_dir_url(__FILE__));
define('NARITIVE_BRIDGE_VERSION', '0.1.0');

require_once NARITIVE_BRIDGE_PATH . 'includes/Plugin.php';

add_action('plugins_loaded', function () {
    \NaritiveBridge\Plugin::instance()->boot();
});
