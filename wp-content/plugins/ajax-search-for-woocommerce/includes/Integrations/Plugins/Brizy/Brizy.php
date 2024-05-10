<?php

namespace DgoraWcas\Integrations\Plugins\Brizy;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Integration with Brizy - Page Builder
 *
 * Plugin URL: https://brizy.io/
 * Author: Brizy.io
 */
class Brizy {

	public function init() {
		if ( ! defined( 'BRIZY_PRO_VERSION' ) ) {
			return;
		}

		add_filter( 'brizy_post_loop_args', array( $this, 'overwriteSearchResults' ), 1000 );
		add_filter( 'dgwt/wcas/helpers/is_search_query', array( $this, 'markQueryToProcess' ), 10, 2 );

		/**
		 * Brizy creates several WP_Query objects, and we need to remove the restriction that only one is hooked.
		 */
		add_filter( 'dgwt/wcas/native/hook_query_once', '__return_false' );
	}

	public function overwriteSearchResults( $params ) {
		$phrase = '';
		if ( ! empty( $_GET['dgwt_wcas_s'] ) ) {
			$phrase = $_GET['dgwt_wcas_s'];
		}
		if ( ! empty( $_GET['s'] ) ) {
			$phrase = $_GET['s'];
		}

		if (
			isset( $_GET['dgwt_wcas'] ) && $_GET['dgwt_wcas'] === '1' &&
			isset( $_GET['post_type'] ) && $_GET['post_type'] === 'product' &&
			! empty( $phrase )
		) {
			if ( empty( $_GET['orderby'] ) ) {
				$params['orderby'] = 'relevance';
				$params['order']   = 'DESC';
			}
			$params['s']                = $phrase;
			$params['brizy_fibosearch'] = true;
		}

		return $params;
	}

	public function markQueryToProcess( $enabled, $query ) {
		if ( $query->get( 'brizy_fibosearch' ) ) {
			$enabled = true;
		}

		return $enabled;
	}
}
