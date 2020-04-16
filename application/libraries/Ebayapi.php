<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ebayapi{
	//ebay api config
	private $app_id;
	private $dev_id;
	private $cert_id;
	private $ru_name;

	private $end_point;

	private $ci;

	public function __construct(){
		$this->ci =& get_instance();
		$this->ci->config->load('ebay');
		$config_name = $this->ci->config->item('load');
		$config = $this->ci->config->item($config_name);

		$this->app_id = $config['app_id'];
		$this->dev_id = $config['dev_id'];
		$this->cert_id = $config['cert_id'];
		$this->ru_name = $config['ru_name'];

		$this->end_point = $config['end_point'];
	}

	private function get_simple_xml_input($api_name, $data){
		$data['ErrorLanguage'] = 'en_US';
		$data['MessageID'] = '';
		$data['Version'] = '859';
		$data['WarningLevel'] = 'High';
		$data_str = '';
		foreach($data as $key=>$val){
			$sub_data = '';
			if(is_array($val)){
				foreach($val as $sub_key=>$sub_val){
					$sub_data .= '<'.$sub_key.'>'.$sub_val.'</'.$sub_key.'>';
				}
			}else{
				$sub_data = $val;
			}
			$data_str .= '<'.$key.'>'.$sub_data.'</'.$key.'>';
		}
		$xml_data = '<?xml version="1.0" encoding="utf-8"?><'.$api_name.'Request xmlns="urn:ebay:apis:eBLBaseComponents">'.$data_str.'</'.$api_name.'Request>';
		return $xml_data;
	}

	public function get_site_code($site_id){
		$data = array(
			0 => 'US',
			3 => 'UK',
			193 => 'Switzerland',
			186 => 'Spain',
			216 => 'Singapore',
			215 => 'Russia',
			212 => 'Poland',
			211 => 'Philippines',
			146 => 'Netherlands',
			207 => 'Malaysia',
			101 => 'Italy',
			205 => 'Ireland',
			203 => 'India',
			201 => 'HongKong',
			77 => 'Germany',
			71 => 'France',
			100 => 'eBayMotors',
			210 => 'CanadaFrench',
			2 => 'Canada',
			23 => 'Belgium_French',
			123 => 'Belgium_Dutch',
			16 => 'Austria',
			15 => 'Australia'
		);
		return array_key_exists($site_id, $data) ? $data[$site_id] : 'US';
	}


	public function call_api($api_name, $xml_data, $post=0, $site_id=0){
		$url = $this->end_point;

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,0);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        // Include header in result? (0 = yes, 1 = no)
        curl_setopt($ch, CURLOPT_HEADER, 0);

        //set header token
        $headers = array(
        	'X-EBAY-API-COMPATIBILITY-LEVEL:859',
			'X-EBAY-API-DEV-NAME:'.$this->dev_id,
			'X-EBAY-API-APP-NAME:'.$this->app_id,
			'X-EBAY-API-CERT-NAME:'.$this->cert_id,
			'X-EBAY-API-CALL-NAME:'.$api_name,
			'X-EBAY-API-SITEID:'.$site_id,
			'Content-Type:text/xml'
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_POST, 1);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_data);

        //curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }

	public function generate_sign_in(){
		$session_id = $this->get_session_id();
		$result = 'https://signin.ebay.com/ws/eBayISAPI.dll?SignIn&runame=EDrop_Tooldrops-EDropToo-EDrop--ohyok&SessID='.$session_id;
		return $result;
	}

	public function get_session_id(){
		$session_id = $this->ci->session->userdata('session_id');
		if($session_id) return $session_id;
		$api_name = 'GetSessionID';
		$data = array(
			'RuName' => $this->ru_name
		);
		$xml_data = $this->get_simple_xml_input($api_name, $data);
		$result_string = $this->call_api($api_name, $xml_data, 1);
		$result_xml = simplexml_load_string($result_string, "SimpleXMLElement", LIBXML_NOCDATA);
		$result_json = json_encode($result_xml);
		$result = json_decode($result_json);
		$this->ci->session->set_userdata('session_id', $result->SessionID);
		return $result->SessionID;
	}

	public function get_token($session_id){
		$api_name = 'FetchToken';
		$data = array(
			'SessionID' => $session_id
		);
		$xml_data = $this->get_simple_xml_input($api_name, $data);
		$result_string = $this->call_api($api_name, $xml_data, 1);
		$result_xml = simplexml_load_string($result_string, "SimpleXMLElement", LIBXML_NOCDATA);
		$result_json = json_encode($result_xml);
		$result = json_decode($result_json);

		if(isset($result->Errors)){
			if(isset($result->Errors->LongMessage)){
				return $result->Errors->LongMessage;
			}else{
				return 'Error: Can not get token';
			}
		}
		$data = array(
			'token' => $result->eBayAuthToken,
			'expired_date' => date('Y-m-d H:i:s', strtotime($result->HardExpirationTime))
		);
		return $data;
	}

	/* GetSuggestedCategories */
	public function suggest_category($product_name, $token, $site_id = 0){
		$api_name = 'GetSuggestedCategories';
		$data = array(
			'Query' => '<![CDATA['.($product_name).']]>',
			'RequesterCredentials' => array(
				'eBayAuthToken' => $token
			)
		);
		$xml_data = $this->get_simple_xml_input($api_name, $data);
		$result_string = $this->call_api($api_name, $xml_data, 1, $site_id);
		$result_xml = simplexml_load_string($result_string, "SimpleXMLElement", LIBXML_NOCDATA);
		$result_json = json_encode($result_xml);
		$result = json_decode($result_json);
		return $result;
	}

	public function get_category_specifics($ebay_category_id, $token, $site_id=0){
		$api_name = 'GetCategorySpecifics';
		$data = array(
			'CategorySpecific' => array(
				'CategoryID' => $ebay_category_id
			),
			'RequesterCredentials' => array(
				'eBayAuthToken' => $token
			)
		);
		$xml_data = $this->get_simple_xml_input($api_name, $data);
		$result_string = $this->call_api($api_name, $xml_data, 1, $site_id);
		$result_xml = simplexml_load_string($result_string, "SimpleXMLElement", LIBXML_NOCDATA);
		$result_json = json_encode($result_xml);
		$result = json_decode($result_json);
		return $result;
	}

	private function get_variant_sku($variant){
        $sku_arr = array();

        foreach($variant as $variant_name => $variant_value){
        	if(in_array($variant_name, array('image','upc','price','quantity','id'))===true){
                continue;
            }
            $sku_arr[] = strtoupper( url_friendly($variant_value, '') );
        }
        return implode('_', $sku_arr);
    }

	private function xml_specifics($data){
		$specifics = '';
		if($data->specifics){
			$count = 0;
			foreach($data->specifics as $name=>$val){
				$count++;
				if($count > 24){
					break;
				}
				$pass = false;
				if(isset($data->variants) && $data->variants){
					foreach($data->variants[0] as $variant_name=>$variant_value){
						if($variant_name==$name){
							$pass = true;
						}
					}
				}
				if(!$pass){
					$specifics .= '<NameValueList><Name>'.htmlspecialchars($name).'</Name><Value>'.htmlspecialchars($val).'</Value></NameValueList>';
				}
			}
			$specifics = '<ItemSpecifics>'.$specifics.'</ItemSpecifics>';
		}
		return $specifics;
	}
	private function xml_shipping_package($data){
		$shipping_package = '';
		if($data->package_dimensions && $data->package_dimensions['width'] && $data->package_dimensions['length'] && $data->package_dimensions['depth'] && $data->package_dimensions['weight']){
			$shipping_package = '<ShippingPackageDetails> ShipPackageDetailsType
				<MeasurementUnit>English</MeasurementUnit>
				<ShippingPackage>PackageThickEnvelope</ShippingPackage>
				<PackageDepth unit="inch" measurementSystem="English">'.$data->package_dimensions['depth'].'</PackageDepth>
				<PackageLength unit="inch" measurementSystem="English">'.$data->package_dimensions['length'].'</PackageLength>
				<PackageWidth unit="inch" measurementSystem="English">'.$data->package_dimensions['width'].'</PackageWidth>
				<WeightMajor unit="lbs" measurementSystem="English">'.$data->package_dimensions['weight'].'</WeightMajor>
			</ShippingPackageDetails>';
		}
		return $shipping_package;
	}

	private function get_variation_specifics_set($variants){
        $result = array();
        foreach($variants as $variant){
            foreach($variant as $key=>$val){
                if(in_array($key, array('image','upc','price','quantity','id'))===true){
                    continue;
                }
                if(!array_key_exists($key, $result)){
                    $result[$key] = array();
                }
                $result[$key][md5($val)] = $val;
            }
        }
        return $result;
    }

    private function variant_pictures($variants, $variation_specifics_set){
    	$pictures = '';

    	$image_variants = array();
    	$check_variants = array();
    	foreach($variants as $variant){
    		if(array_key_exists('image', $variant)===false || !$variant['image']){
    			continue;
    		}
    		$key = md5($variant['image']);
    		if(array_key_exists($key, $image_variants)===false){
    			foreach($variant as $name=>$val){
    				if(in_array($name, array('image','upc','price','quantity','id'))===true){
	                    continue;
	                }
	                $image_variants[$key][$name] = $val;
	                $check_variants[$name] = true;
    			}
    		}else{
    			foreach($variant as $name=>$val){
    				if(in_array($name, array('image','upc','price','quantity','id'))===true){
	                    continue;
	                }
	                if( $image_variants[$key][$name] !== $val){
	                	$check_variants[$name] = false;
	                }
    			}
    		}
    	}
    	if(empty($check_variants)){
    		return $pictures;
    	}

    	$variation_specific_name = '';
    	foreach($check_variants as $name=>$check){
    		if($check!==false){
    			$variation_specific_name = $name;
    		}
    	}
    	$variation_picture_set = array();
    	foreach($variants as $variant){
    		foreach($variant as $name=>$val){
    			if($variation_specific_name==$name){
    				$image = str_replace('.jpg_50x50.jpg', '.jpg', $variant['image']);
    				$variation_picture_set[$val] = $image;
    			}
    		}
    	}

    	foreach($variation_picture_set as $variant_value=>$image){
    		$pictures .= '<VariationSpecificPictureSet>
				<VariationSpecificValue>'.$variant_value.'</VariationSpecificValue>
				<PictureURL>'.$image.'</PictureURL>
			</VariationSpecificPictureSet>';
    	}

    	$pictures = '<Pictures>
			<VariationSpecificName>'.$variation_specific_name.'</VariationSpecificName>
			'.$pictures.'</Pictures>';
		return $pictures;

    }
	private function xml_variants($data){
		$variants_xml = '';
		if($data->variants){
			$variation_specifics_set = $this->get_variation_specifics_set($data->variants);

			$variation_specifics_set_xml = '';
			foreach($variation_specifics_set as $name=>$values){
				$name_value_list = '';
				foreach($values as $val){
					$name_value_list .= '<Value>'.$val.'</Value>';
				}
				$variation_specifics_set_xml .= '<NameValueList><Name>'.$name.'</Name>'.$name_value_list.'</NameValueList>';
			}
			$variation_specifics_set_xml = '<VariationSpecificsSet>'.$variation_specifics_set_xml.'</VariationSpecificsSet>';

			$variant_items = '';
			foreach($data->variants as $variant){
				$value_list = '';
				foreach($variant as $name=>$value){
					if(in_array($name, array('image','upc','price','quantity','id'))===true){
	                    continue;
	                }
					$value_list .= '<NameValueList>
						<Name>'.$name.'</Name>
						<Value>'.$value.'</Value>
					</NameValueList>';
				}
				$variant_items .= '<Variation>
					<Quantity>'.$variant['quantity'].'</Quantity>
					<StartPrice>'.$variant['price'].'</StartPrice>
					<VariationProductListingDetails>
					  <UPC>'.$data->specifics['UPC'].'</UPC>
					</VariationProductListingDetails>
					<VariationSpecifics>
						'.$value_list.'
					</VariationSpecifics>
				</Variation>';
			}

			$pictures = $this->variant_pictures($data->variants, $variation_specifics_set);

			$variants_xml .= '<Variations>
			'.$variation_specifics_set_xml.'
			'.$variant_items.'
			'.$pictures.'
			</Variations>';
		}
		return $variants_xml;
	}

	public function listing($data, $token, $site_id=0){
		$data = is_object($data) ? $data : (object)$data;
		$api_name = 'AddItem';
		$gallery = $data->images_gallery;
		$picture_url = '';
		foreach($gallery as $img){
			$picture_url .= '<PictureURL>'.$img.'</PictureURL>'."\n\t\t";
		}
		$specifics = $this->xml_specifics($data);
		$shipping_package = $this->xml_shipping_package($data);
		

		$xml_data = '<?xml version="1.0" encoding="utf-8"?>
			<AddItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			  <RequesterCredentials>
			    <eBayAuthToken>'.$token.'</eBayAuthToken>
			  </RequesterCredentials>
			  <ErrorLanguage>en_US</ErrorLanguage>
			  <WarningLevel>High</WarningLevel>
			  <Item>
			    <Title>'.$data->name.'</Title>
			    <Description><![CDATA['.($data->description).']]></Description>
			    <PrimaryCategory>
			      <CategoryID>'.$data->category_id.'</CategoryID>
			    </PrimaryCategory>
			    <StartPrice>'.$data->price.'</StartPrice>
			    <CategoryMappingAllowed>true</CategoryMappingAllowed>
			    <ConditionID>1000</ConditionID>
			    <Location>'.$data->location.'</Location>
			    <Country>'.$data->country_code.'</Country>
			    <Currency>USD</Currency>
			    <DispatchTimeMax>'.$data->handling_time.'</DispatchTimeMax>
			    <ListingDuration>'.$data->duration.'</ListingDuration>
			    <ListingType>FixedPriceItem</ListingType>
			    <PaymentMethods>PayPal</PaymentMethods>
			    <PayPalEmailAddress>'.$data->paypal_email.'</PayPalEmailAddress>
			    <PictureDetails>
			      <GalleryType>Gallery</GalleryType>
			      '.$picture_url.'
			    </PictureDetails>
			    <ProductListingDetails>
			      '.(isset($data->specifics['UPC']) ? '<UPC>'.$data->specifics['UPC'].'</UPC>' : '').'
			      <IncludeStockPhotoURL>true</IncludeStockPhotoURL>
			      <IncludePrefilledItemInformation>true</IncludePrefilledItemInformation>
			      <UseFirstProduct>true</UseFirstProduct>
			      <UseStockPhotoURLAsGallery>true</UseStockPhotoURLAsGallery>
			      <ReturnSearchResultOnDuplicates>true</ReturnSearchResultOnDuplicates>
			    </ProductListingDetails>
			    '.$specifics.'
			    <Quantity>'.$data->quantity.'</Quantity>
			    <ReturnPolicy>
			      <ReturnsAcceptedOption>ReturnsAccepted</ReturnsAcceptedOption>
			      <RefundOption>MoneyBack</RefundOption>
			      <ReturnsWithinOption>Days_30</ReturnsWithinOption>
			      <Description>If you are not satisfied, return the item for refund.</Description>
			      <ShippingCostPaidByOption>Buyer</ShippingCostPaidByOption>
			    </ReturnPolicy>
			    <ShippingDetails>
			      <ShippingType>'.$data->shipping_type.'</ShippingType>
			      <ShippingServiceOptions>
			        <ShippingServicePriority>1</ShippingServicePriority>
			        <ShippingService>'.$data->shipping_service_code.'</ShippingService>
			        <FreeShipping>'.$data->free_shipping.'</FreeShipping>
			        <ShippingServiceCost currencyID="USD">'.$data->shipping_cost.'</ShippingServiceCost>
			      </ShippingServiceOptions>
			    </ShippingDetails>
			    '.$shipping_package.'
			    <Site>'.$this->get_site_code($site_id).'</Site>
			  </Item>
			</AddItemRequest>';
		$result_string = $this->call_api($api_name, $xml_data, 1, $site_id);
		$result_xml = simplexml_load_string($result_string, "SimpleXMLElement", LIBXML_NOCDATA);
		$result_json = json_encode($result_xml);
		$result = json_decode($result_json);
		return $result;
	}

	public function listing_variant($data, $token, $site_id=0){
		$data = is_object($data) ? $data : (object)$data;
		$api_name = 'AddItem';
		$gallery = $data->images_gallery;
		$picture_url = '';
		foreach($gallery as $img){
			$picture_url .= '<PictureURL>'.$img.'</PictureURL>'."\n\t\t";
		}
		$specifics = $this->xml_specifics($data);
		$variants = $this->xml_variants($data);

		$shipping_package = $this->xml_shipping_package($data);

		$xml_data = '<?xml version="1.0" encoding="utf-8"?>
			<AddItemRequest xmlns="urn:ebay:apis:eBLBaseComponents">
			  <RequesterCredentials>
			    <eBayAuthToken>'.$token.'</eBayAuthToken>
			  </RequesterCredentials>
			  <ErrorLanguage>en_US</ErrorLanguage>
			  <WarningLevel>High</WarningLevel>
			  <Item>
			    <Title>'.$data->name.'</Title>
			    <Description><![CDATA['.($data->description).']]></Description>
			    <PrimaryCategory>
			      <CategoryID>'.$data->category_id.'</CategoryID>
			    </PrimaryCategory>
			    <CategoryMappingAllowed>true</CategoryMappingAllowed>
			    <ConditionID>1000</ConditionID>
			    <Location>'.$data->location.'</Location>
			    <Country>'.$data->country_code.'</Country>
			    <Currency>USD</Currency>
			    <DispatchTimeMax>'.$data->handling_time.'</DispatchTimeMax>
			    <ListingDuration>'.$data->duration.'</ListingDuration>
			    <ListingType>FixedPriceItem</ListingType>
			    <PaymentMethods>PayPal</PaymentMethods>
			    <PayPalEmailAddress>'.$data->paypal_email.'</PayPalEmailAddress>
			    <PictureDetails>
			      <GalleryType>Gallery</GalleryType>
			      '.$picture_url.'
			    </PictureDetails>
			    <ProductListingDetails>
			      '.(isset($data->specifics['UPC']) ? '<UPC>'.$data->specifics['UPC'].'</UPC>' : '').'
			      <IncludeStockPhotoURL>true</IncludeStockPhotoURL>
			      <IncludePrefilledItemInformation>true</IncludePrefilledItemInformation>
			      <UseFirstProduct>true</UseFirstProduct>
			      <UseStockPhotoURLAsGallery>true</UseStockPhotoURLAsGallery>
			      <ReturnSearchResultOnDuplicates>true</ReturnSearchResultOnDuplicates>
			    </ProductListingDetails>
			    '.$specifics.$variants.'
			    <ReturnPolicy>
			      <ReturnsAcceptedOption>ReturnsAccepted</ReturnsAcceptedOption>
			      <RefundOption>MoneyBack</RefundOption>
			      <ReturnsWithinOption>Days_30</ReturnsWithinOption>
			      <Description>If you are not satisfied, return the item for refund.</Description>
			      <ShippingCostPaidByOption>Buyer</ShippingCostPaidByOption>
			    </ReturnPolicy>
			    <ShippingDetails>
			      <ShippingType>'.$data->shipping_type.'</ShippingType>
			      <ShippingServiceOptions>
			        <ShippingServicePriority>1</ShippingServicePriority>
			        <ShippingService>'.$data->shipping_service_code.'</ShippingService>
			        <FreeShipping>'.$data->free_shipping.'</FreeShipping>
			        <ShippingServiceCost currencyID="USD">'.$data->shipping_cost.'</ShippingServiceCost>
			      </ShippingServiceOptions>
			    </ShippingDetails>
			    '.$shipping_package.'
			    <Site>'.$this->get_site_code($site_id).'</Site>
			  </Item>
			</AddItemRequest>';
		$result_string = $this->call_api($api_name, $xml_data, 1, $site_id);
		$result_xml = simplexml_load_string($result_string, "SimpleXMLElement", LIBXML_NOCDATA);
		$result_json = json_encode($result_xml);
		$result = json_decode($result_json);
		return $result;
	}
}