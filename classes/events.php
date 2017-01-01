<?php

/**
 * Class CF_GA_Events
 *
 * Google Analytics Event Tracking
 */
class CF_GA_Events extends CF_GA_Processor {

    /**
     * @inheritdoc
     */
    public function __construct(array $processor_config, array $fields, $slug){
        parent::__construct($processor_config, $fields, $slug);
        add_action( 'caldera_forms_render_start', array( $this, 'maybe_send_start' ) );
        add_action( 'caldera_forms_submit_complete', array( $this, 'send' ) );
    }

    /**
     * @inheritdoc
     */
    public function pre_processor(array $config, array $form, $proccesid){
        $this->set_data_object_initial( $config, $form );
        if( empty(  $this->data_object->get_errors() ) ){
            $this->submit_event();
        }else{
            return $this->data_object->get_errors();
        }

    }

    /**
     * @inheritdoc
     */
    public function processor(array $config, array $form, $proccesid){
        //Hi Roy
    }

    /**
     * If needed, set form load event
     *
     * @uses "caldera_forms_render_start" action
     *
     * @since 0.0.1
     *
     * @param $form
     */
    public function load_event( $form ){
        $processor = Caldera_Forms::get_processor_by_type( $this->slug, $form );
        if( is_array( $processor ) ){
            $category = $this->data_object->get_value( 'form-load-event-category' );
            $action = $this->data_object->get_value( 'form-load-event-action' );
            if( is_string( $category ) && is_string( $action ) ){
                $this->get_api()->set_event(
                    $category,
                    $action,
                    $this->data_object->get_value( 'form-load-event-label' ),
                    $this->data_object->get_value( 'form-load-event-value' )
                );
            }
        }
    }

    public function send(){
        add_action( 'cf_ga_pre_send_events', $this->get_api() );
        $this->get_api()->send();
        $this->get_api()->reset();
    }

    protected function submit_event(){
        $category = $this->data_object->get_value( 'form-submit-event-category' );
        $action = $this->data_object->get_value( 'form-submit-event-action' );
        if( is_string( $category ) && is_string( $action ) ){
            $this->get_api()->set_event(
                $category,
                $action,
                $this->data_object->get_value( 'form-submit-event-label' ),
                $this->data_object->get_value( 'form-submit-event-value' )
            );
        }
    }



}
