<?php

/*
|--------------------------------------------------------------------------
|   Dais
|--------------------------------------------------------------------------
|
|   This file is part of the Dais Framework package.
|    
|   (c) Vince Kronlein <vince@dais.io>
|    
|   For the full copyright and license information, please view the LICENSE
|   file that was distributed with this source code.
|   
|   Your table prefix has been included so that you can easily write your 
|   migrations to include the proper prefix.
|   
|   $users = $this->create_table("{$this->prefix}users");
|
|   Obviously if you have no table prefix, this variable will be empty.
|   
*/

namespace Database\Migration;
use Egress\Library\Migration\MigrationBase;

class CreateCountry_20150524063322 extends MigrationBase {

    private $prefix = 'dais_';

    public function up() {
        $table = $this->create_table("{$this->prefix}country", array(
            'id'      => false, 
            'options' => 'Engine=InnoDB'
        ));

        $table->column('country_id', 'integer', array('unsigned' => true, 'primary_key' => true, 'auto_increment' => true));
        $table->column('name', 'string', array('limit' => 128));
        $table->column('iso_code_2', 'string', array('limit' => 2));
        $table->column('iso_code_3', 'string', array('limit' => 3));
        $table->column('address_format', 'text');
        $table->column('postcode_required', 'tinyinteger', array('unsigned' => true, 'limit' => 1));
        $table->column('status', 'tinyinteger', array('unsigned' => true, 'limit' => 1, 'default' => 1));
        
        $table->finish();

        $sql = "INSERT INTO `{$this->prefix}country` (`country_id`, `name`, `iso_code_2`, `iso_code_3`, `address_format`, `postcode_required`, `status`) VALUES
                (3, 'Algeria', 'DZ', 'DZA', '', 0, 0),
                (4, 'American Samoa', 'AS', 'ASM', '', 0, 0),
                (5, 'Andorra', 'AD', 'AND', '', 0, 0),
                (6, 'Angola', 'AO', 'AGO', '', 0, 0),
                (7, 'Anguilla', 'AI', 'AIA', '', 0, 0),
                (8, 'Antarctica', 'AQ', 'ATA', '', 0, 0),
                (9, 'Antigua and Barbuda', 'AG', 'ATG', '', 0, 0),
                (10, 'Argentina', 'AR', 'ARG', '', 0, 0),
                (11, 'Armenia', 'AM', 'ARM', '', 0, 0),
                (12, 'Aruba', 'AW', 'ABW', '', 0, 0),
                (13, 'Australia', 'AU', 'AUS', '', 0, 0),
                (14, 'Austria', 'AT', 'AUT', '', 0, 0),
                (15, 'Azerbaijan', 'AZ', 'AZE', '', 0, 0),
                (16, 'Bahamas', 'BS', 'BHS', '', 0, 0),
                (17, 'Bahrain', 'BH', 'BHR', '', 0, 0),
                (18, 'Bangladesh', 'BD', 'BGD', '', 0, 0),
                (19, 'Barbados', 'BB', 'BRB', '', 0, 0),
                (21, 'Belgium', 'BE', 'BEL', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 0, 0),
                (22, 'Belize', 'BZ', 'BLZ', '', 0, 0),
                (23, 'Benin', 'BJ', 'BEN', '', 0, 0),
                (24, 'Bermuda', 'BM', 'BMU', '', 0, 0),
                (25, 'Bhutan', 'BT', 'BTN', '', 0, 0),
                (26, 'Bolivia', 'BO', 'BOL', '', 0, 0),
                (28, 'Botswana', 'BW', 'BWA', '', 0, 0),
                (29, 'Bouvet Island', 'BV', 'BVT', '', 0, 0),
                (30, 'Brazil', 'BR', 'BRA', '', 0, 0),
                (31, 'British Indian Ocean Territory', 'IO', 'IOT', '', 0, 0),
                (32, 'Brunei Darussalam', 'BN', 'BRN', '', 0, 0),
                (34, 'Burkina Faso', 'BF', 'BFA', '', 0, 0),
                (35, 'Burundi', 'BI', 'BDI', '', 0, 0),
                (36, 'Cambodia', 'KH', 'KHM', '', 0, 0),
                (37, 'Cameroon', 'CM', 'CMR', '', 0, 0),
                (38, 'Canada', 'CA', 'CAN', '', 1, 1),
                (39, 'Cape Verde', 'CV', 'CPV', '', 0, 0),
                (40, 'Cayman Islands', 'KY', 'CYM', '', 0, 0),
                (41, 'Central African Republic', 'CF', 'CAF', '', 0, 0),
                (42, 'Chad', 'TD', 'TCD', '', 0, 0),
                (43, 'Chile', 'CL', 'CHL', '', 0, 0),
                (44, 'China', 'CN', 'CHN', '', 0, 0),
                (45, 'Christmas Island', 'CX', 'CXR', '', 0, 0),
                (46, 'Cocos (Keeling) Islands', 'CC', 'CCK', '', 0, 0),
                (47, 'Colombia', 'CO', 'COL', '', 0, 0),
                (48, 'Comoros', 'KM', 'COM', '', 0, 0),
                (50, 'Cook Islands', 'CK', 'COK', '', 0, 0),
                (51, 'Costa Rica', 'CR', 'CRI', '', 0, 0),
                (56, 'Czech Republic', 'CZ', 'CZE', '', 0, 0),
                (57, 'Denmark', 'DK', 'DNK', '', 0, 0),
                (58, 'Djibouti', 'DJ', 'DJI', '', 0, 0),
                (59, 'Dominica', 'DM', 'DMA', '', 0, 0),
                (60, 'Dominican Republic', 'DO', 'DOM', '', 0, 0),
                (61, 'East Timor', 'TL', 'TLS', '', 0, 0),
                (62, 'Ecuador', 'EC', 'ECU', '', 0, 0),
                (63, 'Egypt', 'EG', 'EGY', '', 0, 0),
                (64, 'El Salvador', 'SV', 'SLV', '', 0, 0),
                (65, 'Equatorial Guinea', 'GQ', 'GNQ', '', 0, 0),
                (67, 'Estonia', 'EE', 'EST', '', 0, 0),
                (68, 'Ethiopia', 'ET', 'ETH', '', 0, 0),
                (69, 'Falkland Islands (Malvinas)', 'FK', 'FLK', '', 0, 0),
                (70, 'Faroe Islands', 'FO', 'FRO', '', 0, 0),
                (71, 'Fiji', 'FJ', 'FJI', '', 0, 0),
                (72, 'Finland', 'FI', 'FIN', '', 0, 0),
                (74, 'France, Metropolitan', 'FR', 'FRA', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 1, 0),
                (75, 'French Guiana', 'GF', 'GUF', '', 0, 0),
                (76, 'French Polynesia', 'PF', 'PYF', '', 0, 0),
                (77, 'French Southern Territories', 'TF', 'ATF', '', 0, 0),
                (78, 'Gabon', 'GA', 'GAB', '', 0, 0),
                (79, 'Gambia', 'GM', 'GMB', '', 0, 0),
                (80, 'Georgia', 'GE', 'GEO', '', 0, 0),
                (81, 'Germany', 'DE', 'DEU', '{company}\r\n{firstname} {lastname}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 1, 0),
                (82, 'Ghana', 'GH', 'GHA', '', 0, 0),
                (83, 'Gibraltar', 'GI', 'GIB', '', 0, 0),
                (84, 'Greece', 'GR', 'GRC', '', 0, 0),
                (85, 'Greenland', 'GL', 'GRL', '', 0, 0),
                (86, 'Grenada', 'GD', 'GRD', '', 0, 0),
                (87, 'Guadeloupe', 'GP', 'GLP', '', 0, 0),
                (88, 'Guam', 'GU', 'GUM', '', 0, 0),
                (89, 'Guatemala', 'GT', 'GTM', '', 0, 0),
                (90, 'Guinea', 'GN', 'GIN', '', 0, 0),
                (91, 'Guinea-Bissau', 'GW', 'GNB', '', 0, 0),
                (92, 'Guyana', 'GY', 'GUY', '', 0, 0),
                (93, 'Haiti', 'HT', 'HTI', '', 0, 0),
                (94, 'Heard and Mc Donald Islands', 'HM', 'HMD', '', 0, 0),
                (95, 'Honduras', 'HN', 'HND', '', 0, 0),
                (96, 'Hong Kong', 'HK', 'HKG', '', 0, 0),
                (97, 'Hungary', 'HU', 'HUN', '', 0, 0),
                (98, 'Iceland', 'IS', 'ISL', '', 0, 0),
                (99, 'India', 'IN', 'IND', '', 0, 0),
                (100, 'Indonesia', 'ID', 'IDN', '', 0, 0),
                (103, 'Ireland', 'IE', 'IRL', '', 0, 0),
                (104, 'Israel', 'IL', 'ISR', '', 0, 0),
                (105, 'Italy', 'IT', 'ITA', '', 0, 0),
                (106, 'Jamaica', 'JM', 'JAM', '', 0, 0),
                (107, 'Japan', 'JP', 'JPN', '', 0, 0),
                (108, 'Jordan', 'JO', 'JOR', '', 0, 0),
                (109, 'Kazakhstan', 'KZ', 'KAZ', '', 0, 0),
                (110, 'Kenya', 'KE', 'KEN', '', 0, 0),
                (111, 'Kiribati', 'KI', 'KIR', '', 0, 0),
                (113, 'Korea, Republic of', 'KR', 'KOR', '', 0, 0),
                (114, 'Kuwait', 'KW', 'KWT', '', 0, 0),
                (115, 'Kyrgyzstan', 'KG', 'KGZ', '', 0, 0),
                (116, 'Lao People''s Democratic Republic', 'LA', 'LAO', '', 0, 0),
                (117, 'Latvia', 'LV', 'LVA', '', 0, 0),
                (119, 'Lesotho', 'LS', 'LSO', '', 0, 0),
                (122, 'Liechtenstein', 'LI', 'LIE', '', 0, 0),
                (123, 'Lithuania', 'LT', 'LTU', '', 0, 0),
                (124, 'Luxembourg', 'LU', 'LUX', '', 0, 0),
                (125, 'Macau', 'MO', 'MAC', '', 0, 0),
                (127, 'Madagascar', 'MG', 'MDG', '', 0, 0),
                (128, 'Malawi', 'MW', 'MWI', '', 0, 0),
                (129, 'Malaysia', 'MY', 'MYS', '', 0, 0),
                (130, 'Maldives', 'MV', 'MDV', '', 0, 0),
                (131, 'Mali', 'ML', 'MLI', '', 0, 0),
                (132, 'Malta', 'MT', 'MLT', '', 0, 0),
                (133, 'Marshall Islands', 'MH', 'MHL', '', 0, 0),
                (134, 'Martinique', 'MQ', 'MTQ', '', 0, 0),
                (135, 'Mauritania', 'MR', 'MRT', '', 0, 0),
                (136, 'Mauritius', 'MU', 'MUS', '', 0, 0),
                (137, 'Mayotte', 'YT', 'MYT', '', 0, 0),
                (138, 'Mexico', 'MX', 'MEX', '', 0, 0),
                (139, 'Micronesia, Federated States of', 'FM', 'FSM', '', 0, 0),
                (140, 'Moldova, Republic of', 'MD', 'MDA', '', 0, 0),
                (141, 'Monaco', 'MC', 'MCO', '', 0, 0),
                (142, 'Mongolia', 'MN', 'MNG', '', 0, 0),
                (143, 'Montserrat', 'MS', 'MSR', '', 0, 0),
                (144, 'Morocco', 'MA', 'MAR', '', 0, 0),
                (145, 'Mozambique', 'MZ', 'MOZ', '', 0, 0),
                (147, 'Namibia', 'NA', 'NAM', '', 0, 0),
                (148, 'Nauru', 'NR', 'NRU', '', 0, 0),
                (149, 'Nepal', 'NP', 'NPL', '', 0, 0),
                (150, 'Netherlands', 'NL', 'NLD', '', 0, 0),
                (151, 'Netherlands Antilles', 'AN', 'ANT', '', 0, 0),
                (152, 'New Caledonia', 'NC', 'NCL', '', 0, 0),
                (153, 'New Zealand', 'NZ', 'NZL', '', 0, 0),
                (154, 'Nicaragua', 'NI', 'NIC', '', 0, 0),
                (155, 'Niger', 'NE', 'NER', '', 0, 0),
                (156, 'Nigeria', 'NG', 'NGA', '', 0, 0),
                (157, 'Niue', 'NU', 'NIU', '', 0, 0),
                (158, 'Norfolk Island', 'NF', 'NFK', '', 0, 0),
                (159, 'Northern Mariana Islands', 'MP', 'MNP', '', 0, 0),
                (160, 'Norway', 'NO', 'NOR', '', 0, 0),
                (161, 'Oman', 'OM', 'OMN', '', 0, 0),
                (162, 'Pakistan', 'PK', 'PAK', '', 0, 0),
                (163, 'Palau', 'PW', 'PLW', '', 0, 0),
                (164, 'Panama', 'PA', 'PAN', '', 0, 0),
                (165, 'Papua New Guinea', 'PG', 'PNG', '', 0, 0),
                (166, 'Paraguay', 'PY', 'PRY', '', 0, 0),
                (167, 'Peru', 'PE', 'PER', '', 0, 0),
                (168, 'Philippines', 'PH', 'PHL', '', 0, 0),
                (169, 'Pitcairn', 'PN', 'PCN', '', 0, 0),
                (170, 'Poland', 'PL', 'POL', '', 0, 0),
                (171, 'Portugal', 'PT', 'PRT', '', 0, 0),
                (172, 'Puerto Rico', 'PR', 'PRI', '', 0, 0),
                (173, 'Qatar', 'QA', 'QAT', '', 0, 0),
                (174, 'Reunion', 'RE', 'REU', '', 0, 0),
                (175, 'Romania', 'RO', 'ROM', '', 0, 0),
                (176, 'Russian Federation', 'RU', 'RUS', '', 0, 0),
                (177, 'Rwanda', 'RW', 'RWA', '', 0, 0),
                (178, 'Saint Kitts and Nevis', 'KN', 'KNA', '', 0, 0),
                (179, 'Saint Lucia', 'LC', 'LCA', '', 0, 0),
                (180, 'Saint Vincent and the Grenadines', 'VC', 'VCT', '', 0, 0),
                (181, 'Samoa', 'WS', 'WSM', '', 0, 0),
                (182, 'San Marino', 'SM', 'SMR', '', 0, 0),
                (183, 'Sao Tome and Principe', 'ST', 'STP', '', 0, 0),
                (184, 'Saudi Arabia', 'SA', 'SAU', '', 0, 0),
                (185, 'Senegal', 'SN', 'SEN', '', 0, 0),
                (186, 'Seychelles', 'SC', 'SYC', '', 0, 0),
                (187, 'Sierra Leone', 'SL', 'SLE', '', 0, 0),
                (188, 'Singapore', 'SG', 'SGP', '', 0, 0),
                (189, 'Slovak Republic', 'SK', 'SVK', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{city} {postcode}\r\n{zone}\r\n{country}', 0, 0),
                (191, 'Solomon Islands', 'SB', 'SLB', '', 0, 0),
                (193, 'South Africa', 'ZA', 'ZAF', '', 0, 0),
                (194, 'South Georgia &amp; South Sandwich Islands', 'GS', 'SGS', '', 0, 0),
                (195, 'Spain', 'ES', 'ESP', '', 0, 0),
                (197, 'St. Helena', 'SH', 'SHN', '', 0, 0),
                (198, 'St. Pierre and Miquelon', 'PM', 'SPM', '', 0, 0),
                (200, 'Suriname', 'SR', 'SUR', '', 0, 0),
                (201, 'Svalbard and Jan Mayen Islands', 'SJ', 'SJM', '', 0, 0),
                (202, 'Swaziland', 'SZ', 'SWZ', '', 0, 0),
                (203, 'Sweden', 'SE', 'SWE', '{company}\r\n{firstname} {lastname}\r\n{address_1}\r\n{address_2}\r\n{postcode} {city}\r\n{country}', 1, 0),
                (204, 'Switzerland', 'CH', 'CHE', '', 0, 0),
                (206, 'Taiwan', 'TW', 'TWN', '', 0, 0),
                (207, 'Tajikistan', 'TJ', 'TJK', '', 0, 0),
                (208, 'Tanzania, United Republic of', 'TZ', 'TZA', '', 0, 0),
                (209, 'Thailand', 'TH', 'THA', '', 0, 0),
                (210, 'Togo', 'TG', 'TGO', '', 0, 0),
                (211, 'Tokelau', 'TK', 'TKL', '', 0, 0),
                (212, 'Tonga', 'TO', 'TON', '', 0, 0),
                (213, 'Trinidad and Tobago', 'TT', 'TTO', '', 0, 0),
                (214, 'Tunisia', 'TN', 'TUN', '', 0, 0),
                (215, 'Turkey', 'TR', 'TUR', '', 0, 0),
                (216, 'Turkmenistan', 'TM', 'TKM', '', 0, 0),
                (217, 'Turks and Caicos Islands', 'TC', 'TCA', '', 0, 0),
                (218, 'Tuvalu', 'TV', 'TUV', '', 0, 0),
                (219, 'Uganda', 'UG', 'UGA', '', 0, 0),
                (220, 'Ukraine', 'UA', 'UKR', '', 0, 0),
                (221, 'United Arab Emirates', 'AE', 'ARE', '', 0, 0),
                (222, 'United Kingdom', 'GB', 'GBR', '', 1, 1),
                (223, 'United States', 'US', 'USA', '{firstname} {lastname}\r\n{company}\r\n{address_1}\r\n{address_2}\r\n{city}, {zone} {postcode}\r\n{country}', 1, 1),
                (224, 'United States Minor Outlying Islands', 'UM', 'UMI', '', 0, 0),
                (225, 'Uruguay', 'UY', 'URY', '', 0, 0),
                (226, 'Uzbekistan', 'UZ', 'UZB', '', 0, 0),
                (227, 'Vanuatu', 'VU', 'VUT', '', 0, 0),
                (228, 'Vatican City State (Holy See)', 'VA', 'VAT', '', 0, 0),
                (229, 'Venezuela', 'VE', 'VEN', '', 0, 0),
                (230, 'Viet Nam', 'VN', 'VNM', '', 0, 0),
                (231, 'Virgin Islands (British)', 'VG', 'VGB', '', 0, 0),
                (232, 'Virgin Islands (U.S.)', 'VI', 'VIR', '', 0, 0),
                (233, 'Wallis and Futuna Islands', 'WF', 'WLF', '', 0, 0),
                (234, 'Western Sahara', 'EH', 'ESH', '', 0, 0),
                (237, 'Democratic Republic of Congo', 'CD', 'COD', '', 0, 0),
                (238, 'Zambia', 'ZM', 'ZMB', '', 0, 0),
                (240, 'Jersey', 'JE', 'JEY', '', 1, 0),
                (241, 'Guernsey', 'GG', 'GGY', '', 1, 0),
                (242, 'Montenegro', 'ME', 'MNE', '', 0, 0),
                (244, 'Aaland Islands', 'AX', 'ALA', '', 0, 0),
                (245, 'Bonaire, Sint Eustatius and Saba', 'BQ', 'BES', '', 0, 0),
                (246, 'Curacao', 'CW', 'CUW', '', 0, 0),
                (247, 'Palestinian Territory, Occupied', 'PS', 'PSE', '', 0, 0),
                (248, 'South Sudan', 'SS', 'SSD', '', 0, 0),
                (249, 'St. Barthelemy', 'BL', 'BLM', '', 0, 0),
                (250, 'St. Martin (French part)', 'MF', 'MAF', '', 0, 0),
                (251, 'Canary Islands', 'IC', 'ICA', '', 0, 0)";

        $this->execute($sql);
    }

    public function down() {
        $this->drop_table("{$this->prefix}country");
    }
}
