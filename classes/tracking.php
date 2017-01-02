<?php


class CF_GA_Tracking{


    private static $instances = array();

	/**
	 * Get the API instance based on saved settings
	 *
	 * @since 0.0.1
	 *
	 * @return CF_GA_API
	 */
	public static function default_instance(){
		if( empty( self::$instances[ 'default'  ] ) ){
			self::$instances[ 'default'  ] = self::factory( CF_GA_Settings::get_ua(), CF_GA_Settings::get_domain() );
		}

		return self::$instances[ 'default' ];
	}

    /**
     * Get an API instance, possibly from cache
     *
     * @since 0.0.1
     *
     * @param string $ua UA code for property
     * @param null|string $domain Optional. Domain name. Defaults to home_url()
     *
     * @return CF_GA_API
     */
    public static function get_instance(  $ua, $domain = null ){
        if( ! filter_var( $domain, FILTER_VALIDATE_URL ) ){
            $domain = home_url();
        }

        $key = md5( $ua . $domain );
        if( ! isset( self::$instances[ $key ] ) ){
            self::$instances[ $key ] = self::factory( $ua, $domain );
        }

        return self::$instances[ $key ];
    }

	/**
	 * Create API instance
	 *
	 * @since 0.0.1
	 *
	 * @param string $ua UA code for property
	 * @param null|string $domain Optional. Domain name. Defaults to home_url()
	 *
	 * @return CF_GA_API
	*/
	protected static function factory( $ua, $domain  ){
        return new CF_GA_API( $ua, $domain );
    }

}