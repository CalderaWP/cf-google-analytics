<?php


class CF_GA_ECommerce extends CF_GA_Processor {
	/**
	 * @inheritdoc
	 */
	public function pre_processor( array $config, array $form, $proccesid ) {
		//wait until we have validation

	}

	/**
	 * @inheritdoc
	 */
	public function processor( array $config, array $form, $proccesid ) {
		$this->set_data_object_initial( $config, $form );
		$errors = $this->data_object->get_errors();
		if ( ! empty( $errors ) ) {
			return $errors;
		}

		$transaction_id = $_transaction_id = $this->data_object->get_value( 'transaction-id' );

		$this->get_api()->send_transaction( $transaction_id, $this->data_object->get_value( 'store-name' ), $this->data_object->get_value( 'total' ), $this->data_object->get_value( 'tax-amount' ), $this->data_object->get_value( 'shipping' ), $this->data_object->get_value( 'city' ), $this->data_object->get_value( 'region' ), $this->data_object->get_value( 'country' ) );

		/**
		 * Add items to Google Analytics eCommerce tracking
		 *
		 * @since 0.0.1
		 */
		$items = apply_filters( 'cf_ga_ecommerce_items', array(), $transaction_id, $config, $form );
		if ( ! empty( $items ) ) {

			foreach ( $items as $item ) {
				$item['transaction_id'] = $_transaction_id;

				$this->sendLineItem( $item );
			}

		}

	}

	private function sendLineItem( array $rawLineItemDetails ) {
		$preparedLineItemDetails = $this->prepareLineItemDetails( $rawLineItemDetails );

		$this->get_api()->send_item(
			$preparedLineItemDetails['transaction_id'],
			$preparedLineItemDetails['sku'],
			$preparedLineItemDetails['product_name'],
			$preparedLineItemDetails['variation'],
			$preparedLineItemDetails['unit_price'],
			$preparedLineItemDetails['quantity']
		);
	}

	private function prepareLineItemDetails( array $unpreparedLineItemDetails ) {
		$defaults = array(
			'sku'            => '0',
			'product_name'   => '',
			'unit_price'     => '0.00',
			'variation'      => '0',
			'transaction_id' => '0',
			'quantity'       => 0,
		);

		$mergedLineItemDetails = wp_parse_args( $unpreparedLineItemDetails, $defaults );

		// Set the SKU equal to the product name, if the SKU wasn't set originally.
		if ( $mergedLineItemDetails['sku'] === $defaults['sku'] && $unpreparedLineItemDetails['sku'] !== $defaults['sku'] ) {
			$mergedLineItemDetails['sku'] = $mergedLineItemDetails['product_name'];
		}

		return $mergedLineItemDetails;
	}


}