<?php


abstract class CF_GA_Processor extends Caldera_Forms_Processor_Processor{

    /**
     * @var CF_GA_API
     */
    private $api;

    /**
     * @return CF_GA_API
     */
    protected function get_api(){
        if( null == $this->api ){
            $this->api = CF_GA_Tracking::get_instance( 'ua' );
        }

        return $this->api;
    }
}