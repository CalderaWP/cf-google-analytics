<?php

/**
 * Created by PhpStorm.
 * User: josh
 * Date: 12/31/16
 * Time: 12:32 AM
 */
class CF_GA_Tracking{


    private static $instances = array();

    /**
     * @param $ua
     * @param null $domain
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

    protected static function factory( $ua, $domain  ){
        new CF_GA_API( $ua, $domain );
    }

}