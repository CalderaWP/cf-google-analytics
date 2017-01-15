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
        add_action( 'caldera_forms_submit_complete', array( $this, 'send' ) );
    }

    /**
     * @inheritdoc
     */
    public function pre_processor(array $config, array $form, $proccesid){
        $this->set_data_object_initial( $config, $form );

        $data_object_errors = $this->data_object->get_errors();

        if( empty( $data_object_errors ) ){
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
    public static function load_event( $form ){
        $processors = Caldera_Forms::get_processor_by_type( 'ga-events', $form );
        if ( false !== $processors && is_array( $processors ) ) {
            foreach ( $processors as $key => $processor ) {
                if ( is_array( $processor ) && $key === $processor['ID'] && array_key_exists( 'runtimes', $processor ) ) {
                    $data = new Caldera_Forms_Processor_Get_Data( $processor['config'], $form, cf_ga_fields_events() );
                    $category = trim( $data->get_value( 'form-load-event-category') );
                    $action   = trim( $data->get_value( 'form-load-event-action') );
                    if ( true === is_string( $category ) && true === is_string( $action ) && ! empty( $category ) && ! empty( $action ) ) {
                        $api = CF_GA_Tracking::default_instance();
                        $api->set_event(
                            $category,
                            $action,
                            trim( $data->get_value( 'form-load-event-label' ) ),
                            trim( $data->get_value( 'form-load-event-value' ) )
                        );
                        $api->send();
                        $api->reset();
                    }
                }
            }
        }
    }

    public function send(){
        add_action( 'cf_ga_pre_send_events', $this->get_api() );
        $this->get_api()->send();
        $this->get_api()->reset();
    }

    protected function submit_event(){
        $category = trim( $this->data_object->get_value( 'form-submit-event-category' ) );
        $action   = trim( $this->data_object->get_value( 'form-submit-event-action' ) );
        if ( true === is_string( $category ) && true === is_string( $action ) && ! empty( $category ) && ! empty( $action ) ) {
            $this->get_api()->set_event(
                $category,
                $action,
                trim( $this->data_object->get_value( 'form-submit-event-label' ) ),
                trim( $this->data_object->get_value( 'form-submit-event-value' ) )
            );
        }
    }



}
