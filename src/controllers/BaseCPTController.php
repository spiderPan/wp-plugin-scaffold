<?php

namespace WpPluginScaffold\Controllers;

class BaseCPTController {
	protected function get_caps( $custom_caps ): array {
		return [
			// Meta capabilities
			"edit_" . $custom_caps['singular'],
			"read_" . $custom_caps['singular'],
			"delete_" . $custom_caps['singular'],
			// Primitive capabilities used outside of map_meta_cap():
			"edit_" . $custom_caps['plural'],
			"edit_others_" . $custom_caps['plural'],
			"publish_" . $custom_caps['plural'],
			"read_private_" . $custom_caps['plural'],
			// Primitive capabilities used within map_meta_cap():
			"read",
			"delete_" . $custom_caps['plural'],
			"delete_private_" . $custom_caps['plural'],
			"delete_published_" . $custom_caps['plural'],
			"delete_others_" . $custom_caps['plural'],
			"edit_private_" . $custom_caps['plural'],
			"edit_published_" . $custom_caps['plural'],
			"create_" . $custom_caps['plural'],
		];
	}

	protected function grant_capabilities_to_roles( array $roles, array $cpt_caps ): void {
		foreach ( $roles as $role ) {
			$wp_role = get_role( $role );
			foreach ( $cpt_caps as $cap ) {
				if ( ! $wp_role->has_cap( $cap ) ) {
					$wp_role->add_cap( $cap );
				}
			}
		}
	}
}
