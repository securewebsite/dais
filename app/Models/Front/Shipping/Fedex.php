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

class Fedex extends Model {
    function getQuote($address) {
        Lang::load('shipping/fedex');
        
        $query = $this->db->query("
            SELECT * 
            FROM {$this->db->prefix}zone_to_geo_zone 
            WHERE geo_zone_id = '" . (int)Config::get('fedex_geo_zone_id') . "' 
            AND country_id    = '" . (int)$address['country_id'] . "' 
            AND (zone_id      = '" . (int)$address['zone_id'] . "' OR zone_id = '0')"
        );
        
        if (!Config::get('fedex_geo_zone_id')):
            $status = true;
        elseif ($query->num_rows):
            $status = true;
        else:
            $status = false;
        endif;
        
        $error      = '';
        $quote_data = array();
        
        if ($status):
            $weight      = $this->weight->convert($this->cart->getWeight(), Config::get('config_weight_class_id'), Config::get('fedex_weight_class_id'));
            $weight_code = strtoupper($this->weight->getUnit(Config::get('fedex_weight_class_id')));
            $date        = time();
            $day         = date('l', $date);
            
            if ($day == 'Saturday'):
                $date+= 172800;
            elseif ($day == 'Sunday'):
                $date+= 86400;
            endif;
            
            Theme::model('locale/country');
            $country_info = $this->model_locale_country->getCountry(Config::get('config_country_id'));
            
            Theme::model('locale/zone');
            $zone_info = $this->model_locale_zone->getZone(Config::get('config_zone_id'));
            
            if (!Config::get('fedex_test')):
                $url = 'https://gateway.fedex.com/web-services/';
            else:
                $url = 'https://gatewaybeta.fedex.com/web-services/';
            endif;
            
            // Whoever introduced xml to shipping companies should be flogged!!!!
            $xml = '<?xml version="1.0"?>';
            $xml.= '<SOAP-ENV:Envelope xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/" xmlns:ns1="http://fedex.com/ws/rate/v10">';
            $xml.= '	<SOAP-ENV:Body>';
            $xml.= '		<ns1:RateRequest>';
            $xml.= '			<ns1:WebAuthenticationDetail>';
            $xml.= '				<ns1:UserCredential>';
            $xml.= '					<ns1:Key>' . Config::get('fedex_key') . '</ns1:Key>';
            $xml.= '					<ns1:Password>' . Config::get('fedex_password') . '</ns1:Password>';
            $xml.= '				</ns1:UserCredential>';
            $xml.= '			</ns1:WebAuthenticationDetail>';
            $xml.= '			<ns1:ClientDetail>';
            $xml.= '				<ns1:AccountNumber>' . Config::get('fedex_account') . '</ns1:AccountNumber>';
            $xml.= '				<ns1:MeterNumber>' . Config::get('fedex_meter') . '</ns1:MeterNumber>';
            $xml.= '			</ns1:ClientDetail>';
            $xml.= '			<ns1:Version>';
            $xml.= '				<ns1:ServiceId>crs</ns1:ServiceId>';
            $xml.= '				<ns1:Major>10</ns1:Major>';
            $xml.= '				<ns1:Intermediate>0</ns1:Intermediate>';
            $xml.= '				<ns1:Minor>0</ns1:Minor>';
            $xml.= '			</ns1:Version>';
            $xml.= '			<ns1:ReturnTransitAndCommit>true</ns1:ReturnTransitAndCommit>';
            $xml.= '			<ns1:RequestedShipment>';
            $xml.= '				<ns1:ShipTimestamp>' . date('c', $date) . '</ns1:ShipTimestamp>';
            $xml.= '				<ns1:DropoffType>' . Config::get('fedex_dropoff_type') . '</ns1:DropoffType>';
            $xml.= '				<ns1:PackagingType>' . Config::get('fedex_packaging_type') . '</ns1:PackagingType>';
            $xml.= '				<ns1:Shipper>';
            $xml.= '					<ns1:Contact>';
            $xml.= '						<ns1:PersonName>' . Config::get('config_owner') . '</ns1:PersonName>';
            $xml.= '						<ns1:CompanyName>' . Config::get('config_name') . '</ns1:CompanyName>';
            $xml.= '						<ns1:PhoneNumber>' . Config::get('config_telephone') . '</ns1:PhoneNumber>';
            $xml.= '					</ns1:Contact>';
            $xml.= '					<ns1:Address>';
            
            if ($country_info['iso_code_2'] == 'US'):
                $xml.= '						<ns1:StateOrProvinceCode>' . ($zone_info ? $zone_info['code'] : '') . '</ns1:StateOrProvinceCode>';
            else:
                $xml.= '						<ns1:StateOrProvinceCode>' . ($zone_info ? $zone_info['name'] : '') . '</ns1:StateOrProvinceCode>';
            endif;
            
            $xml.= '						<ns1:PostalCode>' . Config::get('fedex_postcode') . '</ns1:PostalCode>';
            $xml.= '						<ns1:CountryCode>' . $country_info['iso_code_2'] . '</ns1:CountryCode>';
            $xml.= '					</ns1:Address>';
            $xml.= '				</ns1:Shipper>';
            
            $xml.= '				<ns1:Recipient>';
            $xml.= '					<ns1:Contact>';
            $xml.= '						<ns1:PersonName>' . $address['firstname'] . ' ' . $address['lastname'] . '</ns1:PersonName>';
            $xml.= '						<ns1:CompanyName>' . $address['company'] . '</ns1:CompanyName>';
            $xml.= '						<ns1:PhoneNumber>' . $this->customer->getTelephone() . '</ns1:PhoneNumber>';
            $xml.= '					</ns1:Contact>';
            $xml.= '					<ns1:Address>';
            $xml.= '						<ns1:StreetLines>' . $address['address_1'] . '</ns1:StreetLines>';
            $xml.= '						<ns1:City>' . $address['city'] . '</ns1:City>';
            
            if ($address['iso_code_2'] == 'US'):
                $xml.= '						<ns1:StateOrProvinceCode>' . $address['zone_code'] . '</ns1:StateOrProvinceCode>';
            else:
                $xml.= '						<ns1:StateOrProvinceCode>' . $address['zone'] . '</ns1:StateOrProvinceCode>';
            endif;
            
            $xml.= '						<ns1:PostalCode>' . $address['postcode'] . '</ns1:PostalCode>';
            $xml.= '						<ns1:CountryCode>' . $address['iso_code_2'] . '</ns1:CountryCode>';
            $xml.= '						<ns1:Residential>' . ($address['company'] ? 'true' : 'false') . '</ns1:Residential>';
            $xml.= '					</ns1:Address>';
            $xml.= '				</ns1:Recipient>';
            $xml.= '				<ns1:ShippingChargesPayment>';
            $xml.= '					<ns1:PaymentType>SENDER</ns1:PaymentType>';
            $xml.= '					<ns1:Payor>';
            $xml.= '						<ns1:AccountNumber>' . Config::get('fedex_account') . '</ns1:AccountNumber>';
            $xml.= '						<ns1:CountryCode>' . $country_info['iso_code_2'] . '</ns1:CountryCode>';
            $xml.= '					</ns1:Payor>';
            $xml.= '				</ns1:ShippingChargesPayment>';
            $xml.= '				<ns1:RateRequestTypes>' . Config::get('fedex_rate_type') . '</ns1:RateRequestTypes>';
            $xml.= '				<ns1:PackageCount>1</ns1:PackageCount>';
            $xml.= '				<ns1:RequestedPackageLineItems>';
            $xml.= '					<ns1:SequenceNumber>1</ns1:SequenceNumber>';
            $xml.= '					<ns1:GroupPackageCount>1</ns1:GroupPackageCount>';
            $xml.= '					<ns1:Weight>';
            $xml.= '						<ns1:Units>' . $weight_code . '</ns1:Units>';
            $xml.= '						<ns1:Value>' . $weight . '</ns1:Value>';
            $xml.= '					</ns1:Weight>';
            $xml.= '					<ns1:Dimensions>';
            $xml.= '						<ns1:Length>20</ns1:Length>';
            $xml.= '						<ns1:Width>20</ns1:Width>';
            $xml.= '						<ns1:Height>10</ns1:Height>';
            $xml.= '						<ns1:Units>IN</ns1:Units>';
            $xml.= '					</ns1:Dimensions>';
            $xml.= '				</ns1:RequestedPackageLineItems>';
            $xml.= '			</ns1:RequestedShipment>';
            $xml.= '		</ns1:RateRequest>';
            $xml.= '	</SOAP-ENV:Body>';
            $xml.= '</SOAP-ENV:Envelope>';
            
            $curl = curl_init($url);
            
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $xml);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_TIMEOUT, 30);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            
            $response = curl_exec($curl);
            
            curl_close($curl);
            
            $dom = new \DOMDocument('1.0', 'UTF-8');
            $dom->loadXml($response);
            
            if ($dom->getElementsByTagName('HighestSeverity')->item(0)->nodeValue == 'FAILURE' || $dom->getElementsByTagName('HighestSeverity')->item(0)->nodeValue == 'ERROR'):
                $error = $dom->getElementsByTagName('HighestSeverity')->item(0)->nodeValue;
            else:
                $rate_reply_details = $dom->getElementsByTagName('RateReplyDetails');
                
                foreach ($rate_reply_details as $rate_reply_detail):
                    $code = strtolower($rate_reply_detail->getElementsByTagName('ServiceType')->item(0)->nodeValue);
                    
                    if (in_array(strtoupper($code), Config::get('fedex_service'))):
                        $title = Lang::get('lang_text_' . $code);
                        
                        if (Config::get('fedex_display_time')):
                            $title.= ' (' . Lang::get('lang_text_eta') . ' ' . date(Lang::get('lang_date_format_short') . ' ' . Lang::get('lang_time_format'), strtotime($rate_reply_detail->getElementsByTagName('DeliveryTimestamp')->item(0)->nodeValue)) . ')';
                        endif;
                        
                        $total_net_charge = $rate_reply_detail->getElementsByTagName('RatedShipmentDetails')->item(0)->getElementsByTagName('ShipmentRateDetail')->item(0)->getElementsByTagName('TotalNetCharge')->item(0);
                        $cost             = $total_net_charge->getElementsByTagName('Amount')->item(0)->nodeValue;
                        $currency         = $total_net_charge->getElementsByTagName('Currency')->item(0)->nodeValue;
                        
                        $quote_data[$code] = array(
                            'code'         => 'fedex.' . $code, 
                            'title'        => $title, 
                            'cost'         => $this->currency->convert($cost, $currency, Config::get('config_currency')), 
                            'tax_class_id' => Config::get('fedex_tax_class_id'), 
                            'text'         => $this->currency->format($this->tax->calculate($this->currency->convert($cost, $currency, $this->currency->getCode()), Config::get('fedex_tax_class_id'), Config::get('config_tax')), $this->currency->getCode(), 1.0000000)
                        );
                    endif;
                endforeach;
            endif;
        endif;
        
        $method_data = array();
        
        if ($quote_data || $error):
            $title = Lang::get('lang_text_title');
            
            if (Config::get('fedex_display_weight')):
                $title.= ' (' . Lang::get('lang_text_weight') . ' ' . $this->weight->format($weight, Config::get('fedex_weight_class_id')) . ')';
            endif;
            
            $method_data = array(
                'code'       => 'fedex', 
                'title'      => $title, 
                'quote'      => $quote_data, 
                'sort_order' => Config::get('fedex_sort_order'), 
                'error'      => $error
            );
        endif;
        
        return $method_data;
    }
}
