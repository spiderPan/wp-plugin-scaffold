<?php

namespace WpPluginScaffold\controllers;


require_once dirname( __FILE__ ) . '/../lib/class-tgm-plugin-activation.php';

class Admin {
	function hook(): void {
		add_action( 'tgmpa_register', [ $this, 'halligan_register_required_plugins' ] );

		// Open filter `halligan_need_bootstrap_pages` to add pages that need Bootstrap
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
	}

	function halligan_register_required_plugins(): void {
		$plugins = array(
			// This is an example of how to include a plugin from the WordPress Plugin Repository.
			array(
				'name'     => 'CMB2',
				'slug'     => 'cmb2',
				'required' => true,
			),
			array(
				'name'   => 'CMB2 Post Search field',
				'slug'   => 'cmb2-post-search-field',
				'source' => 'https://github.com/CMB2/CMB2-Post-Search-field/archive/refs/tags/v0.2.5.zip',
			),
		);

		/*
		 * Array of configuration settings. Amend each line as needed.
		 *
		 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
		 * strings available, please help us make TGMPA even better by giving us access to these translations or by
		 * sending in a pull-request with .po file(s) with the translations.
		 *
		 * Only uncomment the strings in the config array if you want to customize the strings.
		 */
		$config = array(
			'id'           => 'halligan',
			// Unique ID for hashing notices for multiple instances of TGMPA.
			'default_path' => '',
			// Default absolute path to bundled plugins.
			'menu'         => 'tgmpa-install-plugins',
			// Menu slug.
			'parent_slug'  => 'plugins.php',
			// Parent menu slug.
			'capability'   => 'manage_options',
			// Capability needed to view plugin install page, should be a capability associated with the parent menu used.
			'has_notices'  => true,
			// Show admin notices or not.
			'dismissable'  => true,
			// If false, a user cannot dismiss the nag message.
			'dismiss_msg'  => '',
			// If 'dismissable' is false, this message will be output at top of nag.
			'is_automatic' => false,
			// Automatically activate plugins after installation or not.
			'message'      => '',
			// Message to output right before the plugins table.
		);

		tgmpa( $plugins, $config );
	}

	function enqueue_scripts(): void {
		$need_bootstrap_pages = apply_filters( 'halligan_need_bootstrap_pages', array() );
		$current_screen       = get_current_screen();
		if ( ! in_array( $current_screen->id, $need_bootstrap_pages ) ) {
			return;
		}

		$boostrap_version = '5.2.3';
		// Enqueue Bootstrap CSS
		wp_enqueue_style( 'bootstrap-css', 'https://cdn.jsdelivr.net/npm/bootstrap@' . $boostrap_version . '/dist/css/bootstrap.min.css' );

		// Enqueue Bootstrap JS
		wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@' . $boostrap_version . '/dist/js/bootstrap.bundle.min.js', array( 'jquery' ), $boostrap_version, true );
	}
}
