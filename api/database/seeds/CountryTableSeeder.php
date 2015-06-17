<?php

use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('country')->delete();
        
		\DB::table('country')->insert(array (
			0 => 
			array (
				'country_id' => 3,
				'name' => 'Algeria',
				'iso_code_2' => 'DZ',
				'iso_code_3' => 'DZA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			1 => 
			array (
				'country_id' => 4,
				'name' => 'American Samoa',
				'iso_code_2' => 'AS',
				'iso_code_3' => 'ASM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			2 => 
			array (
				'country_id' => 5,
				'name' => 'Andorra',
				'iso_code_2' => 'AD',
				'iso_code_3' => 'AND',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			3 => 
			array (
				'country_id' => 6,
				'name' => 'Angola',
				'iso_code_2' => 'AO',
				'iso_code_3' => 'AGO',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			4 => 
			array (
				'country_id' => 7,
				'name' => 'Anguilla',
				'iso_code_2' => 'AI',
				'iso_code_3' => 'AIA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			5 => 
			array (
				'country_id' => 8,
				'name' => 'Antarctica',
				'iso_code_2' => 'AQ',
				'iso_code_3' => 'ATA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			6 => 
			array (
				'country_id' => 9,
				'name' => 'Antigua and Barbuda',
				'iso_code_2' => 'AG',
				'iso_code_3' => 'ATG',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			7 => 
			array (
				'country_id' => 10,
				'name' => 'Argentina',
				'iso_code_2' => 'AR',
				'iso_code_3' => 'ARG',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			8 => 
			array (
				'country_id' => 11,
				'name' => 'Armenia',
				'iso_code_2' => 'AM',
				'iso_code_3' => 'ARM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			9 => 
			array (
				'country_id' => 12,
				'name' => 'Aruba',
				'iso_code_2' => 'AW',
				'iso_code_3' => 'ABW',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			10 => 
			array (
				'country_id' => 13,
				'name' => 'Australia',
				'iso_code_2' => 'AU',
				'iso_code_3' => 'AUS',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			11 => 
			array (
				'country_id' => 14,
				'name' => 'Austria',
				'iso_code_2' => 'AT',
				'iso_code_3' => 'AUT',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			12 => 
			array (
				'country_id' => 15,
				'name' => 'Azerbaijan',
				'iso_code_2' => 'AZ',
				'iso_code_3' => 'AZE',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			13 => 
			array (
				'country_id' => 16,
				'name' => 'Bahamas',
				'iso_code_2' => 'BS',
				'iso_code_3' => 'BHS',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			14 => 
			array (
				'country_id' => 17,
				'name' => 'Bahrain',
				'iso_code_2' => 'BH',
				'iso_code_3' => 'BHR',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			15 => 
			array (
				'country_id' => 18,
				'name' => 'Bangladesh',
				'iso_code_2' => 'BD',
				'iso_code_3' => 'BGD',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			16 => 
			array (
				'country_id' => 19,
				'name' => 'Barbados',
				'iso_code_2' => 'BB',
				'iso_code_3' => 'BRB',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			17 => 
			array (
				'country_id' => 21,
				'name' => 'Belgium',
				'iso_code_2' => 'BE',
				'iso_code_3' => 'BEL',
				'address_format' => '{firstname} {lastname}
{company}
{address_1}
{address_2}
{postcode} {city}
{country}',
				'postcode_required' => 0,
				'status' => 0,
			),
			18 => 
			array (
				'country_id' => 22,
				'name' => 'Belize',
				'iso_code_2' => 'BZ',
				'iso_code_3' => 'BLZ',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			19 => 
			array (
				'country_id' => 23,
				'name' => 'Benin',
				'iso_code_2' => 'BJ',
				'iso_code_3' => 'BEN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			20 => 
			array (
				'country_id' => 24,
				'name' => 'Bermuda',
				'iso_code_2' => 'BM',
				'iso_code_3' => 'BMU',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			21 => 
			array (
				'country_id' => 25,
				'name' => 'Bhutan',
				'iso_code_2' => 'BT',
				'iso_code_3' => 'BTN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			22 => 
			array (
				'country_id' => 26,
				'name' => 'Bolivia',
				'iso_code_2' => 'BO',
				'iso_code_3' => 'BOL',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			23 => 
			array (
				'country_id' => 28,
				'name' => 'Botswana',
				'iso_code_2' => 'BW',
				'iso_code_3' => 'BWA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			24 => 
			array (
				'country_id' => 29,
				'name' => 'Bouvet Island',
				'iso_code_2' => 'BV',
				'iso_code_3' => 'BVT',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			25 => 
			array (
				'country_id' => 30,
				'name' => 'Brazil',
				'iso_code_2' => 'BR',
				'iso_code_3' => 'BRA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			26 => 
			array (
				'country_id' => 31,
				'name' => 'British Indian Ocean Territory',
				'iso_code_2' => 'IO',
				'iso_code_3' => 'IOT',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			27 => 
			array (
				'country_id' => 32,
				'name' => 'Brunei Darussalam',
				'iso_code_2' => 'BN',
				'iso_code_3' => 'BRN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			28 => 
			array (
				'country_id' => 34,
				'name' => 'Burkina Faso',
				'iso_code_2' => 'BF',
				'iso_code_3' => 'BFA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			29 => 
			array (
				'country_id' => 35,
				'name' => 'Burundi',
				'iso_code_2' => 'BI',
				'iso_code_3' => 'BDI',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			30 => 
			array (
				'country_id' => 36,
				'name' => 'Cambodia',
				'iso_code_2' => 'KH',
				'iso_code_3' => 'KHM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			31 => 
			array (
				'country_id' => 37,
				'name' => 'Cameroon',
				'iso_code_2' => 'CM',
				'iso_code_3' => 'CMR',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			32 => 
			array (
				'country_id' => 38,
				'name' => 'Canada',
				'iso_code_2' => 'CA',
				'iso_code_3' => 'CAN',
				'address_format' => '',
				'postcode_required' => 1,
				'status' => 1,
			),
			33 => 
			array (
				'country_id' => 39,
				'name' => 'Cape Verde',
				'iso_code_2' => 'CV',
				'iso_code_3' => 'CPV',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			34 => 
			array (
				'country_id' => 40,
				'name' => 'Cayman Islands',
				'iso_code_2' => 'KY',
				'iso_code_3' => 'CYM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			35 => 
			array (
				'country_id' => 41,
				'name' => 'Central African Republic',
				'iso_code_2' => 'CF',
				'iso_code_3' => 'CAF',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			36 => 
			array (
				'country_id' => 42,
				'name' => 'Chad',
				'iso_code_2' => 'TD',
				'iso_code_3' => 'TCD',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			37 => 
			array (
				'country_id' => 43,
				'name' => 'Chile',
				'iso_code_2' => 'CL',
				'iso_code_3' => 'CHL',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			38 => 
			array (
				'country_id' => 44,
				'name' => 'China',
				'iso_code_2' => 'CN',
				'iso_code_3' => 'CHN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			39 => 
			array (
				'country_id' => 45,
				'name' => 'Christmas Island',
				'iso_code_2' => 'CX',
				'iso_code_3' => 'CXR',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			40 => 
			array (
				'country_id' => 46,
			'name' => 'Cocos (Keeling) Islands',
				'iso_code_2' => 'CC',
				'iso_code_3' => 'CCK',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			41 => 
			array (
				'country_id' => 47,
				'name' => 'Colombia',
				'iso_code_2' => 'CO',
				'iso_code_3' => 'COL',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			42 => 
			array (
				'country_id' => 48,
				'name' => 'Comoros',
				'iso_code_2' => 'KM',
				'iso_code_3' => 'COM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			43 => 
			array (
				'country_id' => 50,
				'name' => 'Cook Islands',
				'iso_code_2' => 'CK',
				'iso_code_3' => 'COK',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			44 => 
			array (
				'country_id' => 51,
				'name' => 'Costa Rica',
				'iso_code_2' => 'CR',
				'iso_code_3' => 'CRI',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			45 => 
			array (
				'country_id' => 56,
				'name' => 'Czech Republic',
				'iso_code_2' => 'CZ',
				'iso_code_3' => 'CZE',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			46 => 
			array (
				'country_id' => 57,
				'name' => 'Denmark',
				'iso_code_2' => 'DK',
				'iso_code_3' => 'DNK',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			47 => 
			array (
				'country_id' => 58,
				'name' => 'Djibouti',
				'iso_code_2' => 'DJ',
				'iso_code_3' => 'DJI',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			48 => 
			array (
				'country_id' => 59,
				'name' => 'Dominica',
				'iso_code_2' => 'DM',
				'iso_code_3' => 'DMA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			49 => 
			array (
				'country_id' => 60,
				'name' => 'Dominican Republic',
				'iso_code_2' => 'DO',
				'iso_code_3' => 'DOM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			50 => 
			array (
				'country_id' => 61,
				'name' => 'East Timor',
				'iso_code_2' => 'TL',
				'iso_code_3' => 'TLS',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			51 => 
			array (
				'country_id' => 62,
				'name' => 'Ecuador',
				'iso_code_2' => 'EC',
				'iso_code_3' => 'ECU',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			52 => 
			array (
				'country_id' => 63,
				'name' => 'Egypt',
				'iso_code_2' => 'EG',
				'iso_code_3' => 'EGY',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			53 => 
			array (
				'country_id' => 64,
				'name' => 'El Salvador',
				'iso_code_2' => 'SV',
				'iso_code_3' => 'SLV',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			54 => 
			array (
				'country_id' => 65,
				'name' => 'Equatorial Guinea',
				'iso_code_2' => 'GQ',
				'iso_code_3' => 'GNQ',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			55 => 
			array (
				'country_id' => 67,
				'name' => 'Estonia',
				'iso_code_2' => 'EE',
				'iso_code_3' => 'EST',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			56 => 
			array (
				'country_id' => 68,
				'name' => 'Ethiopia',
				'iso_code_2' => 'ET',
				'iso_code_3' => 'ETH',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			57 => 
			array (
				'country_id' => 69,
			'name' => 'Falkland Islands (Malvinas)',
				'iso_code_2' => 'FK',
				'iso_code_3' => 'FLK',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			58 => 
			array (
				'country_id' => 70,
				'name' => 'Faroe Islands',
				'iso_code_2' => 'FO',
				'iso_code_3' => 'FRO',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			59 => 
			array (
				'country_id' => 71,
				'name' => 'Fiji',
				'iso_code_2' => 'FJ',
				'iso_code_3' => 'FJI',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			60 => 
			array (
				'country_id' => 72,
				'name' => 'Finland',
				'iso_code_2' => 'FI',
				'iso_code_3' => 'FIN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			61 => 
			array (
				'country_id' => 74,
				'name' => 'France, Metropolitan',
				'iso_code_2' => 'FR',
				'iso_code_3' => 'FRA',
				'address_format' => '{firstname} {lastname}
{company}
{address_1}
{address_2}
{postcode} {city}
{country}',
				'postcode_required' => 1,
				'status' => 0,
			),
			62 => 
			array (
				'country_id' => 75,
				'name' => 'French Guiana',
				'iso_code_2' => 'GF',
				'iso_code_3' => 'GUF',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			63 => 
			array (
				'country_id' => 76,
				'name' => 'French Polynesia',
				'iso_code_2' => 'PF',
				'iso_code_3' => 'PYF',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			64 => 
			array (
				'country_id' => 77,
				'name' => 'French Southern Territories',
				'iso_code_2' => 'TF',
				'iso_code_3' => 'ATF',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			65 => 
			array (
				'country_id' => 78,
				'name' => 'Gabon',
				'iso_code_2' => 'GA',
				'iso_code_3' => 'GAB',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			66 => 
			array (
				'country_id' => 79,
				'name' => 'Gambia',
				'iso_code_2' => 'GM',
				'iso_code_3' => 'GMB',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			67 => 
			array (
				'country_id' => 80,
				'name' => 'Georgia',
				'iso_code_2' => 'GE',
				'iso_code_3' => 'GEO',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			68 => 
			array (
				'country_id' => 81,
				'name' => 'Germany',
				'iso_code_2' => 'DE',
				'iso_code_3' => 'DEU',
				'address_format' => '{company}
{firstname} {lastname}
{address_1}
{address_2}
{postcode} {city}
{country}',
				'postcode_required' => 1,
				'status' => 0,
			),
			69 => 
			array (
				'country_id' => 82,
				'name' => 'Ghana',
				'iso_code_2' => 'GH',
				'iso_code_3' => 'GHA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			70 => 
			array (
				'country_id' => 83,
				'name' => 'Gibraltar',
				'iso_code_2' => 'GI',
				'iso_code_3' => 'GIB',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			71 => 
			array (
				'country_id' => 84,
				'name' => 'Greece',
				'iso_code_2' => 'GR',
				'iso_code_3' => 'GRC',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			72 => 
			array (
				'country_id' => 85,
				'name' => 'Greenland',
				'iso_code_2' => 'GL',
				'iso_code_3' => 'GRL',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			73 => 
			array (
				'country_id' => 86,
				'name' => 'Grenada',
				'iso_code_2' => 'GD',
				'iso_code_3' => 'GRD',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			74 => 
			array (
				'country_id' => 87,
				'name' => 'Guadeloupe',
				'iso_code_2' => 'GP',
				'iso_code_3' => 'GLP',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			75 => 
			array (
				'country_id' => 88,
				'name' => 'Guam',
				'iso_code_2' => 'GU',
				'iso_code_3' => 'GUM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			76 => 
			array (
				'country_id' => 89,
				'name' => 'Guatemala',
				'iso_code_2' => 'GT',
				'iso_code_3' => 'GTM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			77 => 
			array (
				'country_id' => 90,
				'name' => 'Guinea',
				'iso_code_2' => 'GN',
				'iso_code_3' => 'GIN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			78 => 
			array (
				'country_id' => 91,
				'name' => 'Guinea-Bissau',
				'iso_code_2' => 'GW',
				'iso_code_3' => 'GNB',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			79 => 
			array (
				'country_id' => 92,
				'name' => 'Guyana',
				'iso_code_2' => 'GY',
				'iso_code_3' => 'GUY',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			80 => 
			array (
				'country_id' => 93,
				'name' => 'Haiti',
				'iso_code_2' => 'HT',
				'iso_code_3' => 'HTI',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			81 => 
			array (
				'country_id' => 94,
				'name' => 'Heard and Mc Donald Islands',
				'iso_code_2' => 'HM',
				'iso_code_3' => 'HMD',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			82 => 
			array (
				'country_id' => 95,
				'name' => 'Honduras',
				'iso_code_2' => 'HN',
				'iso_code_3' => 'HND',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			83 => 
			array (
				'country_id' => 96,
				'name' => 'Hong Kong',
				'iso_code_2' => 'HK',
				'iso_code_3' => 'HKG',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			84 => 
			array (
				'country_id' => 97,
				'name' => 'Hungary',
				'iso_code_2' => 'HU',
				'iso_code_3' => 'HUN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			85 => 
			array (
				'country_id' => 98,
				'name' => 'Iceland',
				'iso_code_2' => 'IS',
				'iso_code_3' => 'ISL',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			86 => 
			array (
				'country_id' => 99,
				'name' => 'India',
				'iso_code_2' => 'IN',
				'iso_code_3' => 'IND',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			87 => 
			array (
				'country_id' => 100,
				'name' => 'Indonesia',
				'iso_code_2' => 'ID',
				'iso_code_3' => 'IDN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			88 => 
			array (
				'country_id' => 103,
				'name' => 'Ireland',
				'iso_code_2' => 'IE',
				'iso_code_3' => 'IRL',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			89 => 
			array (
				'country_id' => 104,
				'name' => 'Israel',
				'iso_code_2' => 'IL',
				'iso_code_3' => 'ISR',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			90 => 
			array (
				'country_id' => 105,
				'name' => 'Italy',
				'iso_code_2' => 'IT',
				'iso_code_3' => 'ITA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			91 => 
			array (
				'country_id' => 106,
				'name' => 'Jamaica',
				'iso_code_2' => 'JM',
				'iso_code_3' => 'JAM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			92 => 
			array (
				'country_id' => 107,
				'name' => 'Japan',
				'iso_code_2' => 'JP',
				'iso_code_3' => 'JPN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			93 => 
			array (
				'country_id' => 108,
				'name' => 'Jordan',
				'iso_code_2' => 'JO',
				'iso_code_3' => 'JOR',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			94 => 
			array (
				'country_id' => 109,
				'name' => 'Kazakhstan',
				'iso_code_2' => 'KZ',
				'iso_code_3' => 'KAZ',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			95 => 
			array (
				'country_id' => 110,
				'name' => 'Kenya',
				'iso_code_2' => 'KE',
				'iso_code_3' => 'KEN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			96 => 
			array (
				'country_id' => 111,
				'name' => 'Kiribati',
				'iso_code_2' => 'KI',
				'iso_code_3' => 'KIR',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			97 => 
			array (
				'country_id' => 113,
				'name' => 'Korea, Republic of',
				'iso_code_2' => 'KR',
				'iso_code_3' => 'KOR',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			98 => 
			array (
				'country_id' => 114,
				'name' => 'Kuwait',
				'iso_code_2' => 'KW',
				'iso_code_3' => 'KWT',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			99 => 
			array (
				'country_id' => 115,
				'name' => 'Kyrgyzstan',
				'iso_code_2' => 'KG',
				'iso_code_3' => 'KGZ',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			100 => 
			array (
				'country_id' => 116,
				'name' => 'Lao People\'s Democratic Republic',
				'iso_code_2' => 'LA',
				'iso_code_3' => 'LAO',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			101 => 
			array (
				'country_id' => 117,
				'name' => 'Latvia',
				'iso_code_2' => 'LV',
				'iso_code_3' => 'LVA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			102 => 
			array (
				'country_id' => 119,
				'name' => 'Lesotho',
				'iso_code_2' => 'LS',
				'iso_code_3' => 'LSO',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			103 => 
			array (
				'country_id' => 122,
				'name' => 'Liechtenstein',
				'iso_code_2' => 'LI',
				'iso_code_3' => 'LIE',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			104 => 
			array (
				'country_id' => 123,
				'name' => 'Lithuania',
				'iso_code_2' => 'LT',
				'iso_code_3' => 'LTU',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			105 => 
			array (
				'country_id' => 124,
				'name' => 'Luxembourg',
				'iso_code_2' => 'LU',
				'iso_code_3' => 'LUX',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			106 => 
			array (
				'country_id' => 125,
				'name' => 'Macau',
				'iso_code_2' => 'MO',
				'iso_code_3' => 'MAC',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			107 => 
			array (
				'country_id' => 127,
				'name' => 'Madagascar',
				'iso_code_2' => 'MG',
				'iso_code_3' => 'MDG',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			108 => 
			array (
				'country_id' => 128,
				'name' => 'Malawi',
				'iso_code_2' => 'MW',
				'iso_code_3' => 'MWI',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			109 => 
			array (
				'country_id' => 129,
				'name' => 'Malaysia',
				'iso_code_2' => 'MY',
				'iso_code_3' => 'MYS',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			110 => 
			array (
				'country_id' => 130,
				'name' => 'Maldives',
				'iso_code_2' => 'MV',
				'iso_code_3' => 'MDV',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			111 => 
			array (
				'country_id' => 131,
				'name' => 'Mali',
				'iso_code_2' => 'ML',
				'iso_code_3' => 'MLI',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			112 => 
			array (
				'country_id' => 132,
				'name' => 'Malta',
				'iso_code_2' => 'MT',
				'iso_code_3' => 'MLT',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			113 => 
			array (
				'country_id' => 133,
				'name' => 'Marshall Islands',
				'iso_code_2' => 'MH',
				'iso_code_3' => 'MHL',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			114 => 
			array (
				'country_id' => 134,
				'name' => 'Martinique',
				'iso_code_2' => 'MQ',
				'iso_code_3' => 'MTQ',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			115 => 
			array (
				'country_id' => 135,
				'name' => 'Mauritania',
				'iso_code_2' => 'MR',
				'iso_code_3' => 'MRT',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			116 => 
			array (
				'country_id' => 136,
				'name' => 'Mauritius',
				'iso_code_2' => 'MU',
				'iso_code_3' => 'MUS',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			117 => 
			array (
				'country_id' => 137,
				'name' => 'Mayotte',
				'iso_code_2' => 'YT',
				'iso_code_3' => 'MYT',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			118 => 
			array (
				'country_id' => 138,
				'name' => 'Mexico',
				'iso_code_2' => 'MX',
				'iso_code_3' => 'MEX',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			119 => 
			array (
				'country_id' => 139,
				'name' => 'Micronesia, Federated States of',
				'iso_code_2' => 'FM',
				'iso_code_3' => 'FSM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			120 => 
			array (
				'country_id' => 140,
				'name' => 'Moldova, Republic of',
				'iso_code_2' => 'MD',
				'iso_code_3' => 'MDA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			121 => 
			array (
				'country_id' => 141,
				'name' => 'Monaco',
				'iso_code_2' => 'MC',
				'iso_code_3' => 'MCO',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			122 => 
			array (
				'country_id' => 142,
				'name' => 'Mongolia',
				'iso_code_2' => 'MN',
				'iso_code_3' => 'MNG',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			123 => 
			array (
				'country_id' => 143,
				'name' => 'Montserrat',
				'iso_code_2' => 'MS',
				'iso_code_3' => 'MSR',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			124 => 
			array (
				'country_id' => 144,
				'name' => 'Morocco',
				'iso_code_2' => 'MA',
				'iso_code_3' => 'MAR',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			125 => 
			array (
				'country_id' => 145,
				'name' => 'Mozambique',
				'iso_code_2' => 'MZ',
				'iso_code_3' => 'MOZ',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			126 => 
			array (
				'country_id' => 147,
				'name' => 'Namibia',
				'iso_code_2' => 'NA',
				'iso_code_3' => 'NAM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			127 => 
			array (
				'country_id' => 148,
				'name' => 'Nauru',
				'iso_code_2' => 'NR',
				'iso_code_3' => 'NRU',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			128 => 
			array (
				'country_id' => 149,
				'name' => 'Nepal',
				'iso_code_2' => 'NP',
				'iso_code_3' => 'NPL',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			129 => 
			array (
				'country_id' => 150,
				'name' => 'Netherlands',
				'iso_code_2' => 'NL',
				'iso_code_3' => 'NLD',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			130 => 
			array (
				'country_id' => 151,
				'name' => 'Netherlands Antilles',
				'iso_code_2' => 'AN',
				'iso_code_3' => 'ANT',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			131 => 
			array (
				'country_id' => 152,
				'name' => 'New Caledonia',
				'iso_code_2' => 'NC',
				'iso_code_3' => 'NCL',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			132 => 
			array (
				'country_id' => 153,
				'name' => 'New Zealand',
				'iso_code_2' => 'NZ',
				'iso_code_3' => 'NZL',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			133 => 
			array (
				'country_id' => 154,
				'name' => 'Nicaragua',
				'iso_code_2' => 'NI',
				'iso_code_3' => 'NIC',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			134 => 
			array (
				'country_id' => 155,
				'name' => 'Niger',
				'iso_code_2' => 'NE',
				'iso_code_3' => 'NER',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			135 => 
			array (
				'country_id' => 156,
				'name' => 'Nigeria',
				'iso_code_2' => 'NG',
				'iso_code_3' => 'NGA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			136 => 
			array (
				'country_id' => 157,
				'name' => 'Niue',
				'iso_code_2' => 'NU',
				'iso_code_3' => 'NIU',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			137 => 
			array (
				'country_id' => 158,
				'name' => 'Norfolk Island',
				'iso_code_2' => 'NF',
				'iso_code_3' => 'NFK',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			138 => 
			array (
				'country_id' => 159,
				'name' => 'Northern Mariana Islands',
				'iso_code_2' => 'MP',
				'iso_code_3' => 'MNP',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			139 => 
			array (
				'country_id' => 160,
				'name' => 'Norway',
				'iso_code_2' => 'NO',
				'iso_code_3' => 'NOR',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			140 => 
			array (
				'country_id' => 161,
				'name' => 'Oman',
				'iso_code_2' => 'OM',
				'iso_code_3' => 'OMN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			141 => 
			array (
				'country_id' => 162,
				'name' => 'Pakistan',
				'iso_code_2' => 'PK',
				'iso_code_3' => 'PAK',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			142 => 
			array (
				'country_id' => 163,
				'name' => 'Palau',
				'iso_code_2' => 'PW',
				'iso_code_3' => 'PLW',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			143 => 
			array (
				'country_id' => 164,
				'name' => 'Panama',
				'iso_code_2' => 'PA',
				'iso_code_3' => 'PAN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			144 => 
			array (
				'country_id' => 165,
				'name' => 'Papua New Guinea',
				'iso_code_2' => 'PG',
				'iso_code_3' => 'PNG',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			145 => 
			array (
				'country_id' => 166,
				'name' => 'Paraguay',
				'iso_code_2' => 'PY',
				'iso_code_3' => 'PRY',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			146 => 
			array (
				'country_id' => 167,
				'name' => 'Peru',
				'iso_code_2' => 'PE',
				'iso_code_3' => 'PER',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			147 => 
			array (
				'country_id' => 168,
				'name' => 'Philippines',
				'iso_code_2' => 'PH',
				'iso_code_3' => 'PHL',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			148 => 
			array (
				'country_id' => 169,
				'name' => 'Pitcairn',
				'iso_code_2' => 'PN',
				'iso_code_3' => 'PCN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			149 => 
			array (
				'country_id' => 170,
				'name' => 'Poland',
				'iso_code_2' => 'PL',
				'iso_code_3' => 'POL',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			150 => 
			array (
				'country_id' => 171,
				'name' => 'Portugal',
				'iso_code_2' => 'PT',
				'iso_code_3' => 'PRT',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			151 => 
			array (
				'country_id' => 172,
				'name' => 'Puerto Rico',
				'iso_code_2' => 'PR',
				'iso_code_3' => 'PRI',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			152 => 
			array (
				'country_id' => 173,
				'name' => 'Qatar',
				'iso_code_2' => 'QA',
				'iso_code_3' => 'QAT',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			153 => 
			array (
				'country_id' => 174,
				'name' => 'Reunion',
				'iso_code_2' => 'RE',
				'iso_code_3' => 'REU',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			154 => 
			array (
				'country_id' => 175,
				'name' => 'Romania',
				'iso_code_2' => 'RO',
				'iso_code_3' => 'ROM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			155 => 
			array (
				'country_id' => 176,
				'name' => 'Russian Federation',
				'iso_code_2' => 'RU',
				'iso_code_3' => 'RUS',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			156 => 
			array (
				'country_id' => 177,
				'name' => 'Rwanda',
				'iso_code_2' => 'RW',
				'iso_code_3' => 'RWA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			157 => 
			array (
				'country_id' => 178,
				'name' => 'Saint Kitts and Nevis',
				'iso_code_2' => 'KN',
				'iso_code_3' => 'KNA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			158 => 
			array (
				'country_id' => 179,
				'name' => 'Saint Lucia',
				'iso_code_2' => 'LC',
				'iso_code_3' => 'LCA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			159 => 
			array (
				'country_id' => 180,
				'name' => 'Saint Vincent and the Grenadines',
				'iso_code_2' => 'VC',
				'iso_code_3' => 'VCT',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			160 => 
			array (
				'country_id' => 181,
				'name' => 'Samoa',
				'iso_code_2' => 'WS',
				'iso_code_3' => 'WSM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			161 => 
			array (
				'country_id' => 182,
				'name' => 'San Marino',
				'iso_code_2' => 'SM',
				'iso_code_3' => 'SMR',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			162 => 
			array (
				'country_id' => 183,
				'name' => 'Sao Tome and Principe',
				'iso_code_2' => 'ST',
				'iso_code_3' => 'STP',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			163 => 
			array (
				'country_id' => 184,
				'name' => 'Saudi Arabia',
				'iso_code_2' => 'SA',
				'iso_code_3' => 'SAU',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			164 => 
			array (
				'country_id' => 185,
				'name' => 'Senegal',
				'iso_code_2' => 'SN',
				'iso_code_3' => 'SEN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			165 => 
			array (
				'country_id' => 186,
				'name' => 'Seychelles',
				'iso_code_2' => 'SC',
				'iso_code_3' => 'SYC',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			166 => 
			array (
				'country_id' => 187,
				'name' => 'Sierra Leone',
				'iso_code_2' => 'SL',
				'iso_code_3' => 'SLE',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			167 => 
			array (
				'country_id' => 188,
				'name' => 'Singapore',
				'iso_code_2' => 'SG',
				'iso_code_3' => 'SGP',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			168 => 
			array (
				'country_id' => 189,
				'name' => 'Slovak Republic',
				'iso_code_2' => 'SK',
				'iso_code_3' => 'SVK',
				'address_format' => '{firstname} {lastname}
{company}
{address_1}
{address_2}
{city} {postcode}
{zone}
{country}',
				'postcode_required' => 0,
				'status' => 0,
			),
			169 => 
			array (
				'country_id' => 191,
				'name' => 'Solomon Islands',
				'iso_code_2' => 'SB',
				'iso_code_3' => 'SLB',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			170 => 
			array (
				'country_id' => 193,
				'name' => 'South Africa',
				'iso_code_2' => 'ZA',
				'iso_code_3' => 'ZAF',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			171 => 
			array (
				'country_id' => 194,
				'name' => 'South Georgia &amp; South Sandwich Islands',
				'iso_code_2' => 'GS',
				'iso_code_3' => 'SGS',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			172 => 
			array (
				'country_id' => 195,
				'name' => 'Spain',
				'iso_code_2' => 'ES',
				'iso_code_3' => 'ESP',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			173 => 
			array (
				'country_id' => 197,
				'name' => 'St. Helena',
				'iso_code_2' => 'SH',
				'iso_code_3' => 'SHN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			174 => 
			array (
				'country_id' => 198,
				'name' => 'St. Pierre and Miquelon',
				'iso_code_2' => 'PM',
				'iso_code_3' => 'SPM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			175 => 
			array (
				'country_id' => 200,
				'name' => 'Suriname',
				'iso_code_2' => 'SR',
				'iso_code_3' => 'SUR',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			176 => 
			array (
				'country_id' => 201,
				'name' => 'Svalbard and Jan Mayen Islands',
				'iso_code_2' => 'SJ',
				'iso_code_3' => 'SJM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			177 => 
			array (
				'country_id' => 202,
				'name' => 'Swaziland',
				'iso_code_2' => 'SZ',
				'iso_code_3' => 'SWZ',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			178 => 
			array (
				'country_id' => 203,
				'name' => 'Sweden',
				'iso_code_2' => 'SE',
				'iso_code_3' => 'SWE',
				'address_format' => '{company}
{firstname} {lastname}
{address_1}
{address_2}
{postcode} {city}
{country}',
				'postcode_required' => 1,
				'status' => 0,
			),
			179 => 
			array (
				'country_id' => 204,
				'name' => 'Switzerland',
				'iso_code_2' => 'CH',
				'iso_code_3' => 'CHE',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			180 => 
			array (
				'country_id' => 206,
				'name' => 'Taiwan',
				'iso_code_2' => 'TW',
				'iso_code_3' => 'TWN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			181 => 
			array (
				'country_id' => 207,
				'name' => 'Tajikistan',
				'iso_code_2' => 'TJ',
				'iso_code_3' => 'TJK',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			182 => 
			array (
				'country_id' => 208,
				'name' => 'Tanzania, United Republic of',
				'iso_code_2' => 'TZ',
				'iso_code_3' => 'TZA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			183 => 
			array (
				'country_id' => 209,
				'name' => 'Thailand',
				'iso_code_2' => 'TH',
				'iso_code_3' => 'THA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			184 => 
			array (
				'country_id' => 210,
				'name' => 'Togo',
				'iso_code_2' => 'TG',
				'iso_code_3' => 'TGO',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			185 => 
			array (
				'country_id' => 211,
				'name' => 'Tokelau',
				'iso_code_2' => 'TK',
				'iso_code_3' => 'TKL',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			186 => 
			array (
				'country_id' => 212,
				'name' => 'Tonga',
				'iso_code_2' => 'TO',
				'iso_code_3' => 'TON',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			187 => 
			array (
				'country_id' => 213,
				'name' => 'Trinidad and Tobago',
				'iso_code_2' => 'TT',
				'iso_code_3' => 'TTO',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			188 => 
			array (
				'country_id' => 214,
				'name' => 'Tunisia',
				'iso_code_2' => 'TN',
				'iso_code_3' => 'TUN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			189 => 
			array (
				'country_id' => 215,
				'name' => 'Turkey',
				'iso_code_2' => 'TR',
				'iso_code_3' => 'TUR',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			190 => 
			array (
				'country_id' => 216,
				'name' => 'Turkmenistan',
				'iso_code_2' => 'TM',
				'iso_code_3' => 'TKM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			191 => 
			array (
				'country_id' => 217,
				'name' => 'Turks and Caicos Islands',
				'iso_code_2' => 'TC',
				'iso_code_3' => 'TCA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			192 => 
			array (
				'country_id' => 218,
				'name' => 'Tuvalu',
				'iso_code_2' => 'TV',
				'iso_code_3' => 'TUV',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			193 => 
			array (
				'country_id' => 219,
				'name' => 'Uganda',
				'iso_code_2' => 'UG',
				'iso_code_3' => 'UGA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			194 => 
			array (
				'country_id' => 220,
				'name' => 'Ukraine',
				'iso_code_2' => 'UA',
				'iso_code_3' => 'UKR',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			195 => 
			array (
				'country_id' => 221,
				'name' => 'United Arab Emirates',
				'iso_code_2' => 'AE',
				'iso_code_3' => 'ARE',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			196 => 
			array (
				'country_id' => 222,
				'name' => 'United Kingdom',
				'iso_code_2' => 'GB',
				'iso_code_3' => 'GBR',
				'address_format' => '',
				'postcode_required' => 1,
				'status' => 1,
			),
			197 => 
			array (
				'country_id' => 223,
				'name' => 'United States',
				'iso_code_2' => 'US',
				'iso_code_3' => 'USA',
				'address_format' => '{firstname} {lastname}
{company}
{address_1}
{address_2}
{city}, {zone} {postcode}
{country}',
				'postcode_required' => 1,
				'status' => 1,
			),
			198 => 
			array (
				'country_id' => 224,
				'name' => 'United States Minor Outlying Islands',
				'iso_code_2' => 'UM',
				'iso_code_3' => 'UMI',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			199 => 
			array (
				'country_id' => 225,
				'name' => 'Uruguay',
				'iso_code_2' => 'UY',
				'iso_code_3' => 'URY',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			200 => 
			array (
				'country_id' => 226,
				'name' => 'Uzbekistan',
				'iso_code_2' => 'UZ',
				'iso_code_3' => 'UZB',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			201 => 
			array (
				'country_id' => 227,
				'name' => 'Vanuatu',
				'iso_code_2' => 'VU',
				'iso_code_3' => 'VUT',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			202 => 
			array (
				'country_id' => 228,
			'name' => 'Vatican City State (Holy See)',
				'iso_code_2' => 'VA',
				'iso_code_3' => 'VAT',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			203 => 
			array (
				'country_id' => 229,
				'name' => 'Venezuela',
				'iso_code_2' => 'VE',
				'iso_code_3' => 'VEN',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			204 => 
			array (
				'country_id' => 230,
				'name' => 'Viet Nam',
				'iso_code_2' => 'VN',
				'iso_code_3' => 'VNM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			205 => 
			array (
				'country_id' => 231,
			'name' => 'Virgin Islands (British)',
				'iso_code_2' => 'VG',
				'iso_code_3' => 'VGB',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			206 => 
			array (
				'country_id' => 232,
			'name' => 'Virgin Islands (U.S.)',
				'iso_code_2' => 'VI',
				'iso_code_3' => 'VIR',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			207 => 
			array (
				'country_id' => 233,
				'name' => 'Wallis and Futuna Islands',
				'iso_code_2' => 'WF',
				'iso_code_3' => 'WLF',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			208 => 
			array (
				'country_id' => 234,
				'name' => 'Western Sahara',
				'iso_code_2' => 'EH',
				'iso_code_3' => 'ESH',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			209 => 
			array (
				'country_id' => 237,
				'name' => 'Democratic Republic of Congo',
				'iso_code_2' => 'CD',
				'iso_code_3' => 'COD',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			210 => 
			array (
				'country_id' => 238,
				'name' => 'Zambia',
				'iso_code_2' => 'ZM',
				'iso_code_3' => 'ZMB',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			211 => 
			array (
				'country_id' => 240,
				'name' => 'Jersey',
				'iso_code_2' => 'JE',
				'iso_code_3' => 'JEY',
				'address_format' => '',
				'postcode_required' => 1,
				'status' => 0,
			),
			212 => 
			array (
				'country_id' => 241,
				'name' => 'Guernsey',
				'iso_code_2' => 'GG',
				'iso_code_3' => 'GGY',
				'address_format' => '',
				'postcode_required' => 1,
				'status' => 0,
			),
			213 => 
			array (
				'country_id' => 242,
				'name' => 'Montenegro',
				'iso_code_2' => 'ME',
				'iso_code_3' => 'MNE',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			214 => 
			array (
				'country_id' => 244,
				'name' => 'Aaland Islands',
				'iso_code_2' => 'AX',
				'iso_code_3' => 'ALA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			215 => 
			array (
				'country_id' => 245,
				'name' => 'Bonaire, Sint Eustatius and Saba',
				'iso_code_2' => 'BQ',
				'iso_code_3' => 'BES',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			216 => 
			array (
				'country_id' => 246,
				'name' => 'Curacao',
				'iso_code_2' => 'CW',
				'iso_code_3' => 'CUW',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			217 => 
			array (
				'country_id' => 247,
				'name' => 'Palestinian Territory, Occupied',
				'iso_code_2' => 'PS',
				'iso_code_3' => 'PSE',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			218 => 
			array (
				'country_id' => 248,
				'name' => 'South Sudan',
				'iso_code_2' => 'SS',
				'iso_code_3' => 'SSD',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			219 => 
			array (
				'country_id' => 249,
				'name' => 'St. Barthelemy',
				'iso_code_2' => 'BL',
				'iso_code_3' => 'BLM',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			220 => 
			array (
				'country_id' => 250,
			'name' => 'St. Martin (French part)',
				'iso_code_2' => 'MF',
				'iso_code_3' => 'MAF',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
			221 => 
			array (
				'country_id' => 251,
				'name' => 'Canary Islands',
				'iso_code_2' => 'IC',
				'iso_code_3' => 'ICA',
				'address_format' => '',
				'postcode_required' => 0,
				'status' => 0,
			),
		));
	}

}
