<?php
add_action( 'plugins_loaded', function(){
	include_once  CF_GA_PATH . '/includes/functions.php';

	function cf_ga_get_events_config(){
		return array(
            'name' => __( 'Google Analytics Events', 'cf-ga' ),
            'description' => __( 'Trigger events on form load and submit', 'cf-ga' ),
            'author' => 'Caldera Labs',
            'template' => CF_GA_PATH . '/includes/event-config.php',
            'version' => '1.4.7',
            'single' => false,
        );
	}
	function cf_ga_get_ecommerce_config(){
		return array(
			'name' => __( 'Google Analytics eCommerce Tracking', 'cf-ga' ),
			'description' => __( 'Send eCommerce Tracking on form submission', 'cf-ga' ),
			'author' => 'Caldera Labs',
			'template' => CF_GA_PATH . '/includes/ecommerce-config.php',
			'version' => '1.4.7',
			'single' => true,
		);
	}
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
		add_action( 'rest_api_init', [ 'Caldera_Forms', 'init_rest_api' ], 25 );
	}

	add_action( 'caldera_forms_rest_api_pre_init', function( $api ){
		$api->add_route( new CF_GA_Route() );
	});

	add_action( 'caldera_forms_render_start', array( 'CF_GA_Events', 'load_event' ) );
});


