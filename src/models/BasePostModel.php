<?php

namespace WpPluginScaffold\Models;

class BasePostModel {
	protected string|int $id;

	public function __construct( $id = 0 ) {
		$this->id = $id;
	}

	public function get_post(): \WP_Post {
		return get_post( $this->id ) ?: new \WP_Post( new \stdClass() );
	}
}
