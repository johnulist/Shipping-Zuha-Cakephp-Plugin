<?php
class ShippingsController extends AppController {

	var $name = 'Shippings';
	var $components = array('Shipping');
	var $uses = array();
	
	/*
	 * getShippingRate function 
	 */
	function getShippingCharge(){
			$this->autoRender = false;
			if(Configure::read('debug')) {
				Configure::write('debug', 0);
			}

			$options_req_shipment1 =  defined('__ORDERS_SHIPPING_FEDEX_REQUESTED_SHIPMENT') ? unserialize(__ORDERS_SHIPPING_FEDEX_REQUESTED_SHIPMENT) : '' ;
					
			$options_req_shipment2 = array(
					'ServiceType' => isset($this->data['OrderTransaction']['shippingType']) ? $this->data['OrderTransaction']['shippingType'] : '' ,
					'TotalInsuredValue' => array('Ammount'=>100,'Currency'=>'USD') ,
					'Shipper' => defined('__ORDERS_SHIPPING_FEDEX_REQUESTED_SHIPMENT_SHIPPER') ? unserialize(__ORDERS_SHIPPING_FEDEX_REQUESTED_SHIPMENT_SHIPPER) : '',
					
					'Recipient' => array(
								'Address' => array(
								'StreetLines' => array('Address Line 1'),
								'City' => 'Richmond',
								'StateOrProvinceCode' => isset($this->data['OrderShipment']['state']) ? $this->data['OrderShipment']['state'] : '' ,
								'PostalCode' => isset($this->data['OrderShipment']['zip']) ? $this->data['OrderShipment']['zip'] : '' ,
								'CountryCode' => isset($this->data['OrderShipment']['country']) ? $this->data['OrderShipment']['country'] : '' ,
								'Residential' => false)
							),
					'ShippingChargesPayment' => array('PaymentType' => 'SENDER'),
					'RateRequestTypes' => 'ACCOUNT', 
					'RateRequestTypes' => 'LIST', 
					'PackageCount' => isset($this->data['OrderTransaction']['quantity']) ? $this->data['OrderTransaction']['quantity'] : '' ,
					'PackageDetail' =>		'INDIVIDUAL_PACKAGES',
					'RequestedPackageLineItems' => array('0' => array('Weight' => array('Value' => isset($this->data['OrderTransaction']['weight']) ? 
							(empty($this->data['OrderTransaction']['weight']) ? __ORDERS_SHIPPING_FEDEX_DEFAULT_WEIGHT : $this->data['OrderTransaction']['weight']) : '' ,
																		'Units' => defined('__ORDERS_SHIPPING_FEDEX_WEIGHT_UNIT') ? __ORDERS_SHIPPING_FEDEX_WEIGHT_UNIT : ''
																		),
																		'Dimensions' => array(
																			'Length' => isset($this->data['OrderTransaction']['length']) ? $this->data['OrderTransaction']['length'] : '' ,
																			'Width' => isset($this->data['OrderTransaction']['width']) ? $this->data['OrderTransaction']['width'] : '' ,
																			'Height' => isset($this->data['OrderTransaction']['height']) ? $this->data['OrderTransaction']['height'] : '' ,
																			'Units' => defined('__ORDERS_SHIPPING_FEDEX_DIMENSIONS_UNIT') ? __ORDERS_SHIPPING_FEDEX_DIMENSIONS_UNIT : ''
																		)),
												 		)
					);
			
			$options_req_shipment = array_merge((array)$options_req_shipment2, (array)$options_req_shipment1);															
			
			$options = array(
					'WebAuthenticationDetail' => defined('__ORDERS_SHIPPING_FEDEX_USER_CREDENTIAL') ? unserialize(__ORDERS_SHIPPING_FEDEX_USER_CREDENTIAL) : '',
					'ClientDetail' => defined('__ORDERS_SHIPPING_FEDEX_CLIENT_DETAIL') ? unserialize(__ORDERS_SHIPPING_FEDEX_CLIENT_DETAIL) : '',
					'TransactionDetail' => array('CustomerTransactionId' => ' *** Rate Request v9 using PHP ***'),
					'Version' => defined('__ORDERS_SHIPPING_FEDEX_VERSION') ? unserialize(__ORDERS_SHIPPING_FEDEX_VERSION) : '',
					'ReturnTransitAndCommit' => true,
					'RequestedShipment' => $options_req_shipment,
				);
			$data = $this->Shipping->getRate($options);
			
			//@todo 		Get rid of the json_encode() thing, you only need to put .json on the url
			echo json_encode($data);
			
	}
	
	
	// for getting in form of array intead of json
	function getShippingCharge_array(){
			$this->autoRender = false;
			
			$options_req_shipment1 =  defined('__ORDERS_SHIPPING_FEDEX_REQUESTED_SHIPMENT') ? unserialize(__ORDERS_SHIPPING_FEDEX_REQUESTED_SHIPMENT) : '' ;
					
			$options_req_shipment2 = array(
					'ServiceType' => isset($this->data['OrderTransaction']['shippingType']) ? $this->data['OrderTransaction']['shippingType'] : '' ,
					'TotalInsuredValue' => array('Ammount'=>100,'Currency'=>'USD') ,
					'Shipper' => defined('__ORDERS_SHIPPING_FEDEX_REQUESTED_SHIPMENT_SHIPPER') ? unserialize(__ORDERS_SHIPPING_FEDEX_REQUESTED_SHIPMENT_SHIPPER) : '',
					
					'Recipient' => array(
								'Address' => array(
								'StreetLines' => array('Address Line 1'),
								'City' => 'Richmond',
								'StateOrProvinceCode' => isset($this->data['OrderShipment']['state']) ? $this->data['OrderShipment']['state'] : '' ,
								'PostalCode' => isset($this->data['OrderShipment']['zip']) ? $this->data['OrderShipment']['zip'] : '' ,
								'CountryCode' => isset($this->data['OrderShipment']['country']) ? $this->data['OrderShipment']['country'] : '' ,
								'Residential' => false)
							),
					'ShippingChargesPayment' => array('PaymentType' => 'SENDER'),
					'RateRequestTypes' => 'ACCOUNT', 
					'RateRequestTypes' => 'LIST', 
					'PackageCount' => isset($this->data['OrderTransaction']['quantity']) ? $this->data['OrderTransaction']['quantity'] : '' ,
					'PackageDetail' =>		'INDIVIDUAL_PACKAGES',
					'RequestedPackageLineItems' => array('0' => array('Weight' => array('Value' => isset($this->data['OrderTransaction']['weight']) ? 
							(empty($this->data['OrderTransaction']['weight']) ? __ORDERS_SHIPPING_FEDEX_DEFAULT_WEIGHT : $this->data['OrderTransaction']['weight']) : '' ,
																		'Units' => defined('__ORDERS_SHIPPING_FEDEX_WEIGHT_UNIT') ? __ORDERS_SHIPPING_FEDEX_WEIGHT_UNIT : ''
																		),
																		'Dimensions' => array(
																			'Length' => isset($this->data['OrderTransaction']['length']) ? $this->data['OrderTransaction']['length'] : '' ,
																			'Width' => isset($this->data['OrderTransaction']['width']) ? $this->data['OrderTransaction']['width'] : '' ,
																			'Height' => isset($this->data['OrderTransaction']['height']) ? $this->data['OrderTransaction']['height'] : '' ,
																			'Units' => defined('__ORDERS_SHIPPING_FEDEX_DIMENSIONS_UNIT') ? __ORDERS_SHIPPING_FEDEX_DIMENSIONS_UNIT : ''
																		)),
												 		)
					);
			
			$options_req_shipment = array_merge((array)$options_req_shipment2, (array)$options_req_shipment1);															
			
			$options = array(
					'WebAuthenticationDetail' => defined('__ORDERS_SHIPPING_FEDEX_USER_CREDENTIAL') ? unserialize(__ORDERS_SHIPPING_FEDEX_USER_CREDENTIAL) : '',
					'ClientDetail' => defined('__ORDERS_SHIPPING_FEDEX_CLIENT_DETAIL') ? unserialize(__ORDERS_SHIPPING_FEDEX_CLIENT_DETAIL) : '',
					'TransactionDetail' => array('CustomerTransactionId' => ' *** Rate Request v9 using PHP ***'),
					'Version' => defined('__ORDERS_SHIPPING_FEDEX_VERSION') ? unserialize(__ORDERS_SHIPPING_FEDEX_VERSION) : '',
					'ReturnTransitAndCommit' => true,
					'RequestedShipment' => $options_req_shipment,
				);
			$data = $this->Shipping->getRate($options);
								 		
			return ($data);
			
	}
	
}
?>