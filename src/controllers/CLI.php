<?php

namespace WpPluginScaffold\Controllers;

class CLI {
	public function hook(): void {
		if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
			return;
		}
		\WP_CLI::add_command( 'halligan', [ $this, 'halligan' ] );
	}

	public function halligan( $args, $assoc_args ): void {
		//TODO: add validation & help
		$module = $args[0] ?? null;
		$action = $args[1] ?? null;
		switch ( $module ) {
			default:
				\WP_CLI::error( 'Invalid command' );
				break;
		}
	}
}
