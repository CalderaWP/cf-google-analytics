<?php

/**
 * Class CF_GA_Settings
 *
 * Database abstraction for settings
 *
 * @package CF-GA
 * @author    Josh Pollock <Josh@CalderaForms.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2007 CalderaWP LLC
 */
class CF_GA_Settings {

	/**
	 * Option key to save settings
	 *
	 * @since 0.0.1
	 *
	 * @var string
	 */
	protected static $key = '_caldera_forms_google_analytics';

	/**
	 * Default values for settings
	 *
	 * @since 0.0.1
	 *
	 * @return array
	 */
	protected static function defaults() {
		return array(
			'ua' => 0,
			'domain' => get_home_url()
		);
	}

	/**
	 * Get saved value for UA code
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	public static function get_ua(){
		$settings = self::prepare( get_option( self::$key, array() ) );
		return $settings[ 'ua' ];
	}

	/**
	 * Get saved value for domain
	 *
	 * @since 0.0.1
	 *
	 * @return string
	 */
	public static function get_domain(){
		$settings = self::get_settings();
		return $settings[ 'domain' ];
	}

	/**
	 * Save value for UA code
	 *
	 * @since 0.0.1
	 */
	public static function save_ua( $ua ){
		$settings = self::get_settings();
		$settings[ 'ua' ] = strip_tags( $ua );
		update_option( self::$key, $settings );
	}

	/**
	 * Save value for domain
	 *
	 * @since 0.0.1
	 */
	public static function save_domain( $domain ){
		$settings = self::get_settings();
		$settings[ 'domain' ] = esc_url( $domain );
		update_option( self::$key, $settings );
	}

	/**
	 * Get saved settings
	 *
	 * @since 0.0.1
	 *
	 * @return array
	 */
	public static function get_settings(){
		return self::prepare( get_option( self::$key, array() ) );
	}

	/**
	 * Prepare  settings array
	 *
	 * @since 0.0.1
	 *
	 * @param  array $values Optional. Values to prepare.
	 *
	 * @return array
	 */
	protected static  function prepare( $values = array( ) ){
		$defaults = self::defaults();
		$values = wp_parse_args( $values, $defaults );
		foreach ( $values as $key => $value ) {
			if( 'domain' == $key ){
				$values[ $key ] = filter_var( $values[ $key ], FILTER_SANITIZE_URL  );
			}elseif ( 'ua' == $key ){
				$values[ $key ] = strip_tags( $values[ $key ] );
			}else{
				unset( $values[ $key ] );
			}
		}

		return $values;

	}
}