<?php
/*
 * Plugin Name: Blexr bettings odds
 * Plugin URI: https://khadreal.github.io
 * Description: Symphony Technical assessment
 * Author: Opeyemi Ibrahim
 * Version: 1.0
 * Requires at least: WP 5.2
 * Text Domain: blexr-odd
 */

namespace Symphony\Blexr;

if( ! defined( 'ABSPATH' ) ) {
    exit();
}

define( 'BLEXR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
require_once( BLEXR_PLUGIN_DIR . 'vendor/autoload.php' );

( new Component() )->init();

register_activation_hook( __FILE__, 'flush_rewrite_rules' );
register_deactivation_hook( __FILE__, 'flush_rewrite_rules' );