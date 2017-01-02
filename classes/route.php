<?php

/**
 * Class CF_GA_Route
 *
 * REST API route for plugin settings
 *
 * @package CF-GA
 * @author    Josh Pollock <Josh@CalderaForms.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2007 CalderaWP LLC
 */
class CF_GA_Route implements Caldera_Forms_API_Route {

	/**
	 * @inheritdoc
	 */
	public function add_routes( $namespace ) {
		$base = 'add-ons/cf-ga/settings';
		register_rest_route( $namespace, $base, array(
			'methods'             => 'POST',
			'callback'            => array( $this, 'save_settings' ),
			'permission_callback' => array( $this, 'permissions'),
			'args'                => array(
				'ua' => array(
					'required' => false,

				),
				'domain'  => array(
					'required' => false,
				),
			)

		) );
		register_rest_route( $namespace, $base, array(
			'methods'             => 'GET',
			'callback'            => array( $this, 'get_settings' ),
			'permission_callback' => array( $this, 'permissions'),
		) );


	}

	/**
	 * Get settings via REST API
	 *
	 * @since 0.0.1
	 *
	 * @return Caldera_Forms_API_Response
	 */
	public function get_settings(){
		return $this->return_settings();
	}

	/**
	 * Save settings via REST API
	 *
	 * @since 0.0.1
	 *
	 * @param WP_REST_Request $request
	 *
	 * @return Caldera_Forms_API_Response
	 */
	public function save_settings( WP_REST_Request $request ){
		$status = 200;
		$domain = $request[ 'domain' ];
		if( $domain ){
			$status = 201;
			CF_GA_Settings::save_domain( $domain );
		}
		$ua = $request[ 'ua' ];
		if( $ua ){
			$status = 201;
			CF_GA_Settings::save_ua( $ua );
		}

		return $this->return_settings( $status );
	}

	/**
	 * Create response for both requests with saved settings
	 *
	 * @since 0.0.1
	 *
	 * @param int $status status code
	 *
	 * @return Caldera_Forms_API_Response
	 */
	protected function return_settings( $status = 200 ){
		return new Caldera_Forms_API_Response( CF_GA_Settings::get_settings(), $status );

	}

	/**
	 * Permissions check
	 *
	 * @since 0.0.1
	 *
	 * @return bool
	 */
	public function permissions(){
		return current_user_can( Caldera_Forms::get_manage_cap( 'cf-ga' ) );
	}


}