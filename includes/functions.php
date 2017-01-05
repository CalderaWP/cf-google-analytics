<?php



/**
 * Fields for event processor
 *
 * @since 0.0.1
 *
 * @return array
 */
function cf_ga_fields_events(){
	return array(
		array(
			'id' => 'form-load-event-category',
			'label' => __( 'Form Load Event: Category', 'cf-ga' ),
			'desc' => __( 'Required to send a form load event', 'cf-ga' ),
			'magic' => true,
			'required' => true,
		),
		array(
			'id' => 'form-load-event-action',
			'label' => __( 'Form Load Event: Action', 'cf-ga' ),
			'desc' => __( 'Required to send a form load event', 'cf-ga' ),
			'magic' => true,
			'required' => true,
		),
		array(
			'id' => 'form-load-event-label',
			'label' => __( 'Form Load Event: Label', 'cf-ga' ),
			'magic' => true,
			'required' => false,
		),
		array(
			'id' => 'form-load-event-value',
			'label' => __( 'Form Load Event: Value', 'cf-ga' ),
			'magic' => true,
			'required' => false,
		),
		array(
			'id' => 'form-submit-event-category',
			'label' => __( 'Form Submit Event: Category', 'cf-ga' ),
			'desc' => __( 'Required to send a form submit event', 'cf-ga' ),
			'magic' => true,
			'required' => true,
		),
		array(
			'id' => 'form-submit-event-action',
			'label' => __( 'Form Submit Event: Action', 'cf-ga' ),
			'desc' => __( 'Required to send a form submit event', 'cf-ga' ),
			'magic' => true,
			'required' => true,
		),
		array(
			'id' => 'form-submit-event-label',
			'label' => __( 'Form Submit Event: Label', 'cf-ga' ),
			'magic' => true,
			'required' => false,
		),
		array(
			'id' => 'form-submit-event-value',
			'label' => __( 'Form Submit Event: Value', 'cf-ga' ),
			'magic' => true,
			'required' => false,
		),
	);
}


function cf_ga_ecommerce_fields(){
	return array(
		array(
			'id' => 'transaction-id',
			'label' => __( 'Transaction ID', 'cf-ga' ),
			'magic' => true,
			'required' => true,
		),
		array(
			'id' => 'store-name',
			'label' => __( 'Store Name', 'cf-ga' ),
			'magic' => true,
			'required' => true,
		),
		array(
			'id' => 'total',
			'label' => __( 'Transaction Total', 'cf-ga' ),
			'magic' => true,
			'required' => true,
		),

		array(
			'id' => 'tax',
			'label' => __( 'Tax Amount', 'cf-ga' ),
			'magic' => true,
			'required' => false,
		),
		array(
			'id' => 'shipping',
			'label' => __( 'Shipping Amount', 'cf-ga' ),
			'magic' => true,
			'required' => false,
		),
		array(
			'id' => 'city',
			'label' => __( 'City', 'cf-ga' ),
			'magic' => true,
			'required' => false,
		),
		array(
			'id' => 'region',
			'label' => __( 'Region', 'cf-ga' ),
			'magic' => true,
			'required' => false,
		),
		array(
			'id' => 'country',
			'label' => __( 'Country', 'cf-ga' ),
			'magic' => true,
			'required' => false,
		),
	);
}
