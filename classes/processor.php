<?php

/**
 * Class CF_GA_Processor
 *
 * Base class for processors
 *
 * @package CF-GA
 * @author    Josh Pollock <Josh@CalderaForms.com>
 * @license   GPL-2.0+
 * @link
 * @copyright 2007 CalderaWP LLC
 */
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
            $this->api = CF_GA_Tracking::default_instance();
        }

        return $this->api;
    }
}