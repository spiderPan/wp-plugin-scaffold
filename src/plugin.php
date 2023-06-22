<?php
// Plugin Name: wp-plugin-scaffold
// Plugin URI: https://thepan.co
// Description: A plugin to add custom functionality to the Halligan theme.
// Version: 1.0.0
namespace WpPluginScaffold;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once 'vendor/autoload.php';

spl_autoload_register( function ( $classname ) {
	$class = str_replace( '\\', DIRECTORY_SEPARATOR, str_replace( '_', '-', $classname ) );

	$file_path = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . $class . '.php';

	if ( file_exists( $file_path ) ) {
		require_once $file_path;
	}
} );

function get_all_controllers(): array {
	$controllers    = [];
	$controller_dir = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'controllers' . DIRECTORY_SEPARATOR;
	foreach ( glob( $controller_dir . '*.php' ) as $controller ) {
		$controller    = str_replace( '.php', '', basename( $controller ) );
		$controller    = str_replace( '-', '_', $controller );
		$controller    = 'WpPluginScaffold\\Controllers\\' . $controller;
		$controllers[] = $controller;
	}

	return $controllers;
}

function init_halligan(): void {
	// Load all hooks
	$controllers = get_all_controllers();
	foreach ( $controllers as $controller ) {
		if ( ! class_exists( $controller ) ) {
			echo 'class not found: ' . $controller . PHP_EOL;
			continue;
		}

		if ( method_exists( $controller, 'hook' ) ) {
			$controller = new $controller();
			$controller->hook();
		}
	}
}

register_activation_hook( __FILE__, function () {
	// Load all activate methods
	$controllers = get_all_controllers();
	foreach ( $controllers as $controller ) {
		if ( ! class_exists( $controller ) ) {
			continue;
		}

		if ( method_exists( $controller, 'activate_once' ) ) {
			$controller = new $controller();
			$controller->activate_once();
		}
	}
} );

init_halligan();
