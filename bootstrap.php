<?php

/**
 * Make plugin go
 */
add_action( 'plugins_loaded', function(){
	include_once  CF_GA_PATH . '/includes/functions.php';
    add_action( 'caldera_forms_pre_load_processors', function(){
        new CF_GA_Events( cf_ga_get_events_config(), cf_ga_fields_events(), 'ga-events' );
		new CF_GA_ECommerce( cf_ga_get_ecommerce_config(), cf_ga_ecommerce_fields(), 'ga-ecommerce' );
    });

    Caldera_Forms_Autoloader::add_root( 'CF_GA', CF_GA_PATH. '/classes' );

	//Admin page
	if( is_admin() ){
		new CF_GA_Menu();
	}

	//REST API
	if( ! did_action( 'caldera_forms_rest_api_init' ) ){
		add_action( 'rest_api_init', array('Caldera_Forms', 'init_rest_api'), 25 );
	}

	add_action( 'caldera_forms_rest_api_pre_init', function( $api ){
		$api->add_route( new CF_GA_Route() );
	});

	/**
	 * Handle the form load event
	 */
	add_action( 'caldera_forms_render_start', array( 'CF_GA_Events', 'load_event' ) );


	/**
	 * Software Licensing
	 */
	add_action( 'admin_init', 'cf_ga_init_license' );
}, 2 );

/**
 * Config for GA Events Processor
 *
 * @since 0.0.1
 *
 * @return array
 */
function cf_ga_get_events_config(){
	return array(
        'name' => __( 'Google Analytics Events', 'cf-ga' ),
        'description' => __( 'Trigger events on form load and submit', 'cf-ga' ),
        'author' => 'Caldera Labs',
        'template' => CF_GA_PATH . '/includes/event-config.php',
        'version' => '1.4.7',
        'single' => true,
		'icon' => CF_GA_URL . '/icon.png'
    );
}

/**
* Config for GA eCommerce Processor
 *
 * @since 0.0.1
 *
 * @return array
 */
function cf_ga_get_ecommerce_config(){
	return array(
		'name' => __( 'Google Analytics eCommerce Tracking', 'cf-ga' ),
		'description' => __( 'Send eCommerce Tracking on form submission', 'cf-ga' ),
		'author' => 'Caldera Labs',
		'template' => CF_GA_PATH . '/includes/ecommerce-config.php',
		'version' => '1.4.7',
		'single' => true,
		'icon' => CF_GA_URL . '/icon.png'

	);
}



/**
 * Initializes the licensing system
 *
 * @since 1.0.0
 */
function cf_ga_init_license(){

	$plugin = array(
		'name'		=>	'Caldera Forms Google Analytics Tracking',
		'slug'		=>	'caldera-forms-google-analytics-tracking',
		'url'		=>	'https://calderaforms.com/',
		'version'	=>	CF_GA_VER,
		'key_store'	=>  'cfga_license',
		'file'		=>  CF_GA_CORE
	);

	new \calderawp\licensing_helper\licensing( $plugin );

}