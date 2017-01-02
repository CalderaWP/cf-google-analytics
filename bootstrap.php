<?php
add_action( 'plugins_loaded', function(){
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

function cf_ga_fields_events(){
    return array(
        array(
            'id' => 'form-load-event-category',
            'label' => __( 'Form Load Event: Category', 'cf-ga' ),
            'desc' => __( 'Required to send a form load event', 'cf-ga' ),
            'magic' => true,
            'required' => false,
        ),
        array(
            'id' => 'form-load-event-action',
            'label' => __( 'Form Load Event: Action', 'cf-ga' ),
            'desc' => __( 'Required to send a form load event', 'cf-ga' ),
            'magic' => true,
            'required' => false,
        ),
        array(
            'id' => 'form-load-event-label',
            'label' => __( 'Form Load Event: Category', 'cf-ga' ),
            'magic' => true,
            'required' => false,
        ),
        array(
            'id' => 'form-load-event-value',
            'label' => __( 'Form Load Event: Category', 'cf-ga' ),
            'magic' => true,
            'required' => false,
        ),
        array(
            'id' => 'form-submit-event-category',
            'label' => __( 'Form Submit Event: Category', 'cf-ga' ),
            'desc' => __( 'Required to send a form submit event', 'cf-ga' ),
            'magic' => true,
            'required' => false,
        ),
        array(
            'id' => 'form-submit-event-action',
            'label' => __( 'Form Submit Event: Action', 'cf-ga' ),
            'desc' => __( 'Required to send a form submit event', 'cf-ga' ),
            'magic' => true,
            'required' => false,
        ),
        array(
            'id' => 'form-submit-event-label',
            'label' => __( 'Form Submit Event: Category', 'cf-ga' ),
            'magic' => true,
            'required' => false,
        ),
        array(
            'id' => 'form-submit-event-value',
            'label' => __( 'Form Submit Event: Category', 'cf-ga' ),
            'magic' => true,
            'required' => false,
        ),


    );
}
