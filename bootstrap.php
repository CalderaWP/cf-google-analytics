<?php
add_action( 'plugins_loaded', function(){
	include_once  CF_GA_PATH . '/includes/functions.php';
    add_action( 'caldera_forms_pre_load_processors', function(){
        $config = array(
            'name' => __( 'Google Analytics Events', 'cf-ga' ),
            'description' => __( 'Trigger events on form load and submit', 'cf-ga' ),
            'author' => 'Caldera Labs',
            'template' => CF_GA_PATH . '/includes/event-config.php',
            'version' => '1.4.7',
            'single' => true,
        );

        new CF_GA_Events( $config, cf_ga_fields_events(), 'ga-events' );

		$config = array(
			'name' => __( 'Google Analytics eCommerce Tracking', 'cf-ga' ),
			'description' => __( 'Send eCommerce Tracking on form submission', 'cf-ga' ),
			'author' => 'Caldera Labs',
			'template' => CF_GA_PATH . '/includes/ecommerce-config.php',
			'version' => '1.4.7',
			'single' => true,
		);

	    new CF_GA_ECommerce( $config, cf_ga_ecommerce_fields(), 'ga-ecommerce' );

    });

    Caldera_Forms_Autoloader::add_root( 'CF_GA', CF_GA_PATH. '/classes' );

	//Admin page
	if( is_admin()  ){
		new CF_GA_Menu();
	}

	//REST API
	if( ! did_action( 'caldera_forms_rest_api_init' ) ){
		add_action( 'rest_api_init', [ 'Caldera_Forms', 'init_rest_api' ], 25 );
	}

	add_action( 'caldera_forms_rest_api_pre_init', function( $api ){
		$api->add_route( new CF_GA_Route() );
	});

});


