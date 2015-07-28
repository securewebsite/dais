<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|	
|	(c) Vince Kronlein <vince@dais.io>
|	
|	For the full copyright and license information, please view the LICENSE
|	file that was distributed with this source code.
|	
*/

namespace App\Models\Front\Shipping;
use App\Models\Model;
use DOMDocument;

class Ups extends Model {
    function getQuote($address) {
        Lang::load('shipping/ups');
        
        $query = DB::query("
            SELECT * 
            FROM " . DB::prefix() . "zone_to_geo_zone 
            WHERE geo_zone_id = '" . (int)Config::get('ups_geo_zone_id') . "' 
            AND country_id    = '" . (int)$address['country_id'] . "' 
            AND (zone_id      = '" . (int)$address['zone_id'] . "' OR zone_id = '0')"
        );
        
        if (!Config::get('ups_geo_zone_id')):
            $status = true;
        elseif ($query->num_rows):
            $status = true;
        else:
            $status = false;
        endif;
        
        $method_data = array();
        
        if ($status):
            $weight      = Weight::convert(Cart::getWeight(), Config::get('config_weight_class_id'), Config::get('ups_weight_class_id'));
            $weight_code = strtoupper(Weight::getUnit(Config::get('ups_weight_class_id')));
            
            if ($weight_code == 'KG'):
                $weight_code = 'KGS';
            elseif ($weight_code == 'LB'):
                $weight_code = 'LBS';
            endif;
            
            $weight      = ($weight < 0.1 ? 0.1 : $weight);
            $length      = Length::convert(Config::get('ups_length'), Config::get('config_length_class_id'), Config::get('ups_length_class_id'));
            $width       = Length::convert(Config::get('ups_width'), Config::get('config_length_class_id'), Config::get('ups_length_class_id'));
            $height      = Length::convert(Config::get('ups_height'), Config::get('config_length_class_id'), Config::get('ups_length_class_id'));
            $length_code = strtoupper(Length::getUnit(Config::get('ups_length_class_id')));
            
            $service_code = array(
                // US Origin
                'US' => array(
                    '01' => Lang::get('lang_text_us_origin_01'), 
                    '02' => Lang::get('lang_text_us_origin_02'), 
                    '03' => Lang::get('lang_text_us_origin_03'), 
                    '07' => Lang::get('lang_text_us_origin_07'), 
                    '08' => Lang::get('lang_text_us_origin_08'), 
                    '11' => Lang::get('lang_text_us_origin_11'), 
                    '12' => Lang::get('lang_text_us_origin_12'), 
                    '13' => Lang::get('lang_text_us_origin_13'), 
                    '14' => Lang::get('lang_text_us_origin_14'), 
                    '54' => Lang::get('lang_text_us_origin_54'), 
                    '59' => Lang::get('lang_text_us_origin_59'), 
                    '65' => Lang::get('lang_text_us_origin_65')
                ),
                
                // Canada Origin
                'CA' => array(
                    '01' => Lang::get('lang_text_ca_origin_01'), 
                    '02' => Lang::get('lang_text_ca_origin_02'), 
                    '07' => Lang::get('lang_text_ca_origin_07'), 
                    '08' => Lang::get('lang_text_ca_origin_08'), 
                    '11' => Lang::get('lang_text_ca_origin_11'), 
                    '12' => Lang::get('lang_text_ca_origin_12'), 
                    '13' => Lang::get('lang_text_ca_origin_13'), 
                    '14' => Lang::get('lang_text_ca_origin_14'), 
                    '54' => Lang::get('lang_text_ca_origin_54'), 
                    '65' => Lang::get('lang_text_ca_origin_65')
                ),
                
                // European Union Origin
                'EU' => array(
                    '07' => Lang::get('lang_text_eu_origin_07'), 
                    '08' => Lang::get('lang_text_eu_origin_08'), 
                    '11' => Lang::get('lang_text_eu_origin_11'), 
                    '54' => Lang::get('lang_text_eu_origin_54'), 
                    '65' => Lang::get('lang_text_eu_origin_65'),
                
                    // next five services Poland domestic only
                    '82' => Lang::get('lang_text_eu_origin_82'), 
                    '83' => Lang::get('lang_text_eu_origin_83'), 
                    '84' => Lang::get('lang_text_eu_origin_84'), 
                    '85' => Lang::get('lang_text_eu_origin_85'), 
                    '86' => Lang::get('lang_text_eu_origin_86')
                ),
                
                // Puerto Rico Origin
                'PR' => array(
                    '01' => Lang::get('lang_text_pr_origin_01'), 
                    '02' => Lang::get('lang_text_pr_origin_02'), 
                    '03' => Lang::get('lang_text_pr_origin_03'), 
                    '07' => Lang::get('lang_text_pr_origin_07'), 
                    '08' => Lang::get('lang_text_pr_origin_08'), 
                    '14' => Lang::get('lang_text_pr_origin_14'), 
                    '54' => Lang::get('lang_text_pr_origin_54'), 
                    '65' => Lang::get('lang_text_pr_origin_65')
                ),
                
                // Mexico Origin
                'MX' => array(
                    '07' => Lang::get('lang_text_mx_origin_07'), 
                    '08' => Lang::get('lang_text_mx_origin_08'), 
                    '54' => Lang::get('lang_text_mx_origin_54'), 
                    '65' => Lang::get('lang_text_mx_origin_65')
                ),
                
                // All other origins
                'other' => array(
                
                    // service code 7 seems to be gone after January 2, 2007
                    '07' => Lang::get('lang_text_other_origin_07'), 
                    '08' => Lang::get('lang_text_other_origin_08'), 
                    '11' => Lang::get('lang_text_other_origin_11'), 
                    '54' => Lang::get('lang_text_other_origin_54'), 
                    '65' => Lang::get('lang_text_other_origin_65')
                )
            );
            
            $xml = '<?xml version="1.0"?>';
            $xml.= '<AccessRequest xml:lang="en-US">';
            $xml.= '	<AccessLicenseNumber>' . Config::get('ups_key') . '</AccessLicenseNumber>';
            $xml.= '	<UserId>' . Config::get('ups_username') . '</UserId>';
            $xml.= '	<Password>' . Config::get('ups_password') . '</Password>';
            $xml.= '</AccessRequest>';
            $xml.= '<?xml version="1.0"?>';
            $xml.= '<RatingServiceSelectionRequest xml:lang="en-US">';
            $xml.= '	<Request>';
            $xml.= '		<TransactionReference>';
            $xml.= '			<CustomerContext>Bare Bones Rate Request</CustomerContext>';
            $xml.= '			<XpciVersion>1.0001</XpciVersion>';
            $xml.= '		</TransactionReference>';
            $xml.= '		<RequestAction>Rate</RequestAction>';
            $xml.= '		<RequestOption>shop</RequestOption>';
            $xml.= '	</Request>';
            $xml.= '   <PickupType>';
            $xml.= '       <Code>' . Config::get('ups_pickup') . '</Code>';
            $xml.= '   </PickupType>';
            
            if (Config::get('ups_country') == 'US' && Config::get('ups_pickup') == '11'):
                $xml.= '   <CustomerClassification>';
                $xml.= '       <Code>' . Config::get('ups_classification') . '</Code>';
                $xml.= '   </CustomerClassification>';
            endif;
            
            $xml.= '	<Shipment>';
            $xml.= '		<Shipper>';
            $xml.= '			<Address>';
            $xml.= '				<City>' . Config::get('ups_city') . '</City>';
            $xml.= '				<StateProvinceCode>' . Config::get('ups_state') . '</StateProvinceCode>';
            $xml.= '				<CountryCode>' . Config::get('ups_country') . '</CountryCode>';
            $xml.= '				<PostalCode>' . Config::get('ups_postcode') . '</PostalCode>';
            $xml.= '			</Address>';
            $xml.= '		</Shipper>';
            $xml.= '		<ShipTo>';
            $xml.= '			<Address>';
            $xml.= ' 				<City>' . $address['city'] . '</City>';
            $xml.= '				<StateProvinceCode>' . $address['zone_code'] . '</StateProvinceCode>';
            $xml.= '				<CountryCode>' . $address['iso_code_2'] . '</CountryCode>';
            $xml.= '				<PostalCode>' . $address['postcode'] . '</PostalCode>';
            
            if (Config::get('ups_quote_type') == 'residential'):
                $xml.= '				<ResidentialAddressIndicator />';
            endif;
            
            $xml.= '			</Address>';
            $xml.= '		</ShipTo>';
            $xml.= '		<ShipFrom>';
            $xml.= '			<Address>';
            $xml.= '				<City>' . Config::get('ups_city') . '</City>';
            $xml.= '				<StateProvinceCode>' . Config::get('ups_state') . '</StateProvinceCode>';
            $xml.= '				<CountryCode>' . Config::get('ups_country') . '</CountryCode>';
            $xml.= '				<PostalCode>' . Config::get('ups_postcode') . '</PostalCode>';
            $xml.= '			</Address>';
            $xml.= '		</ShipFrom>';
            
            $xml.= '		<Package>';
            $xml.= '			<PackagingType>';
            $xml.= '				<Code>' . Config::get('ups_packaging') . '</Code>';
            $xml.= '			</PackagingType>';
            
            $xml.= '		    <Dimensions>';
            $xml.= '				<UnitOfMeasurement>';
            $xml.= '					<Code>' . $length_code . '</Code>';
            $xml.= '				</UnitOfMeasurement>';
            $xml.= '				<Length>' . $length . '</Length>';
            $xml.= '				<Width>' . $width . '</Width>';
            $xml.= '				<Height>' . $height . '</Height>';
            $xml.= '			</Dimensions>';
            
            $xml.= '			<PackageWeight>';
            $xml.= '				<UnitOfMeasurement>';
            $xml.= '					<Code>' . $weight_code . '</Code>';
            $xml.= '				</UnitOfMeasurement>';
            $xml.= '				<Weight>' . $weight . '</Weight>';
            $xml.= '			</PackageWeight>';
            
            if (Config::get('ups_insurance')):
                $xml.= '           <PackageServiceOptions>';
                $xml.= '               <InsuredValue>';
                $xml.= '                   <CurrencyCode>' . Currency::getCode() . '</CurrencyCode>';
                $xml.= '                   <MonetaryValue>' . Currency::format(Cart::getSubTotal(), false, false, false) . '</MonetaryValue>';
                $xml.= '               </InsuredValue>';
                $xml.= '           </PackageServiceOptions>';
            endif;
            
            $xml.= '		</Package>';
            
            $xml.= '	</Shipment>';
            $xml.= '</RatingServiceSelectionRequest>';
            
            if (!Config::get('ups_test')):
                $url = 'https://www.ups.com/ups.app/xml/Rate';
            else:
                $url = 'https://wwwcie.ups.com/ups.app/xml/Rate';
            endif;
            
            $curl = curl_init($url);
            
            curl_setopt($curl, CURLOPT_HEADER, 0);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_TIMEOUT, 60);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
            
            $result = curl_exec($curl);
            
            curl_close($curl);
            
            $error = '';
            
            $quote_data = array();
            
            if ($result):
                if (Config::get('ups_debug')):
                    Log::write("UPS DATA SENT: " . $xml);
                    Log::write("UPS DATA RECV: " . $result);
                endif;
                
                $dom = new \DOMDocument('1.0', 'UTF-8');
                $dom->loadXml($result);
                
                $rating_service_selection_response = $dom->getElementsByTagName('RatingServiceSelectionResponse')->item(0);
                $response                          = $rating_service_selection_response->getElementsByTagName('Response')->item(0);
                $response_status_code              = $response->getElementsByTagName('ResponseStatusCode');
                
                if ($response_status_code->item(0)->nodeValue != '1'):
                    $error = $response->getElementsByTagName('Error')->item(0)->getElementsByTagName('ErrorCode')->item(0)->nodeValue . ': ' . $response->getElementsByTagName('Error')->item(0)->getElementsByTagName('ErrorDescription')->item(0)->nodeValue;
                else:
                    $rated_shipments = $rating_service_selection_response->getElementsByTagName('RatedShipment');
                    
                    foreach ($rated_shipments as $rated_shipment):
                        $service       = $rated_shipment->getElementsByTagName('Service')->item(0);
                        $code          = $service->getElementsByTagName('Code')->item(0)->nodeValue;
                        $total_charges = $rated_shipment->getElementsByTagName('TotalCharges')->item(0);
                        $cost          = $total_charges->getElementsByTagName('MonetaryValue')->item(0)->nodeValue;
                        $currency      = $total_charges->getElementsByTagName('CurrencyCode')->item(0)->nodeValue;
                        
                        if (!($code && $cost)):
                            continue;
                        endif;
                        
                        if (Config::get('ups_' . strtolower(Config::get('ups_origin')) . '_' . $code)):
                            $quote_data[$code] = array(
                                'code'         => 'ups.' . $code, 
                                'title'        => $service_code[Config::get('ups_origin') ][$code], 
                                'cost'         => Currency::convert($cost, $currency, Config::get('config_currency')), 
                                'tax_class_id' => Config::get('ups_tax_class_id'), 
                                'text'         => Currency::format(Tax::calculate(Currency::convert($cost, $currency, Currency::getCode()), Config::get('ups_tax_class_id'), Config::get('config_tax')), Currency::getCode(), 1.0000000)
                            );
                        endif;
                    endforeach;
                endif;
            endif;
            
            $title = Lang::get('lang_text_title');
            
            if (Config::get('ups_display_weight')):
                $title.= ' (' . Lang::get('lang_text_weight') . ' ' . Weight::format($weight, Config::get('ups_weight_class_id')) . ')';
            endif;
            
            $method_data = array(
                'code'       => 'ups', 
                'title'      => $title, 
                'quote'      => $quote_data, 
                'sort_order' => Config::get('ups_sort_order'), 
                'error'      => $error
            );
        endif;
        
        return $method_data;
    }
}
