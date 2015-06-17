<?php

use Illuminate\Database\Seeder;

class SearchIndexTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('search_index')->delete();
        
		\DB::table('search_index')->insert(array (
			0 => 
			array (
				'id' => 5,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 33,
				'text' => 'Cameras',
			),
			1 => 
			array (
				'id' => 7,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 25,
				'text' => 'Components',
			),
			2 => 
			array (
				'id' => 9,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 29,
				'text' => 'Mice and Trackballs',
			),
			3 => 
			array (
				'id' => 11,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 28,
				'text' => 'Monitors',
			),
			4 => 
			array (
				'id' => 13,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 35,
				'text' => 'test 1',
			),
			5 => 
			array (
				'id' => 15,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 36,
				'text' => 'test 2',
			),
			6 => 
			array (
				'id' => 17,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 30,
				'text' => 'Printers',
			),
			7 => 
			array (
				'id' => 19,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 31,
				'text' => 'Scanners',
			),
			8 => 
			array (
				'id' => 21,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 32,
				'text' => 'Web Cameras',
			),
			9 => 
			array (
				'id' => 23,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 20,
				'text' => 'Desktops',
			),
			10 => 
			array (
				'id' => 24,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 20,
				'text' => 'Example of category description text',
			),
			11 => 
			array (
				'id' => 25,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 27,
				'text' => 'Mac',
			),
			12 => 
			array (
				'id' => 27,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 26,
				'text' => 'PC',
			),
			13 => 
			array (
				'id' => 29,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 18,
				'text' => 'Laptops & Notebooks',
			),
			14 => 
			array (
				'id' => 30,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 18,
				'text' => 'Shop Laptop feature only the best laptop deals on the market. By comparing laptop deals from the likes of PC World, Comet, Dixons, The Link and Carphone Warehouse, Shop Laptop has the most comprehensive selection of laptops on the internet. At Shop Laptop, we pride ourselves on offering customers the very best laptop deals. From refurbished laptops to netbooks, Shop Laptop ensures that every laptop - in every colour, style, size and technical spec - is featured on the site at the lowest possible price.',
			),
			15 => 
			array (
				'id' => 31,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 46,
				'text' => 'Macs',
			),
			16 => 
			array (
				'id' => 32,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 46,
				'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
			),
			17 => 
			array (
				'id' => 33,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 45,
				'text' => 'Windows',
			),
			18 => 
			array (
				'id' => 35,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 59,
				'text' => 'Live Events',
			),
			19 => 
			array (
				'id' => 36,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 59,
				'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus feugiat dui a odio facilisis porta commodo ut ligula. Nullam ligula urna, blandit vel justo eu, tristique tempor nisl. Nam ornare auctor enim vel venenatis. Duis et elit augue. Nulla auctor nunc et ultrices lobortis. Donec ultricies, metus quis convallis tincidunt, nisl nibh molestie tortor, et accumsan turpis nulla rhoncus libero. Donec hendrerit enim ut lectus condimentum malesuada.',
			),
			20 => 
			array (
				'id' => 39,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 34,
				'text' => 'MP3 Players',
			),
			21 => 
			array (
				'id' => 40,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 34,
				'text' => 'Shop Laptop feature only the best laptop deals on the market. By comparing laptop deals from the likes of PC World, Comet, Dixons, The Link and Carphone Warehouse, Shop Laptop has the most comprehensive selection of laptops on the internet. At Shop Laptop, we pride ourselves on offering customers the very best laptop deals. From refurbished laptops to netbooks, Shop Laptop ensures that every laptop - in every colour, style, size and technical spec - is featured on the site at the lowest possible price.',
			),
			22 => 
			array (
				'id' => 41,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 43,
				'text' => 'test 11',
			),
			23 => 
			array (
				'id' => 43,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 44,
				'text' => 'test 12',
			),
			24 => 
			array (
				'id' => 45,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 47,
				'text' => 'test 15',
			),
			25 => 
			array (
				'id' => 47,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 48,
				'text' => 'test 16',
			),
			26 => 
			array (
				'id' => 49,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 49,
				'text' => 'test 17',
			),
			27 => 
			array (
				'id' => 51,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 50,
				'text' => 'test 18',
			),
			28 => 
			array (
				'id' => 53,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 51,
				'text' => 'test 19',
			),
			29 => 
			array (
				'id' => 55,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 52,
				'text' => 'test 20',
			),
			30 => 
			array (
				'id' => 57,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 58,
				'text' => 'test 25',
			),
			31 => 
			array (
				'id' => 61,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 53,
				'text' => 'test 21',
			),
			32 => 
			array (
				'id' => 63,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 54,
				'text' => 'test 22',
			),
			33 => 
			array (
				'id' => 65,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 55,
				'text' => 'test 23',
			),
			34 => 
			array (
				'id' => 67,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 56,
				'text' => 'test 24',
			),
			35 => 
			array (
				'id' => 69,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 38,
				'text' => 'test 4',
			),
			36 => 
			array (
				'id' => 71,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 37,
				'text' => 'test 5',
			),
			37 => 
			array (
				'id' => 73,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 39,
				'text' => 'test 6',
			),
			38 => 
			array (
				'id' => 75,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 40,
				'text' => 'test 7',
			),
			39 => 
			array (
				'id' => 77,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 41,
				'text' => 'test 8',
			),
			40 => 
			array (
				'id' => 79,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 42,
				'text' => 'test 9',
			),
			41 => 
			array (
				'id' => 83,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 24,
				'text' => 'Phones & PDAs',
			),
			42 => 
			array (
				'id' => 85,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 17,
				'text' => 'Software',
			),
			43 => 
			array (
				'id' => 87,
				'language_id' => 1,
				'type' => 'category',
				'object_id' => 57,
				'text' => 'Tablets',
			),
			44 => 
			array (
				'id' => 89,
				'language_id' => 1,
				'type' => 'manufacturer',
				'object_id' => 8,
				'text' => 'Apple',
			),
			45 => 
			array (
				'id' => 90,
				'language_id' => 1,
				'type' => 'manufacturer',
				'object_id' => 9,
				'text' => 'Canon',
			),
			46 => 
			array (
				'id' => 91,
				'language_id' => 1,
				'type' => 'manufacturer',
				'object_id' => 7,
				'text' => 'Hewlett-Packard',
			),
			47 => 
			array (
				'id' => 93,
				'language_id' => 1,
				'type' => 'manufacturer',
				'object_id' => 5,
				'text' => 'HTC',
			),
			48 => 
			array (
				'id' => 94,
				'language_id' => 1,
				'type' => 'manufacturer',
				'object_id' => 6,
				'text' => 'Palm',
			),
			49 => 
			array (
				'id' => 95,
				'language_id' => 1,
				'type' => 'manufacturer',
				'object_id' => 11,
				'text' => 'Solution Labs',
			),
			50 => 
			array (
				'id' => 96,
				'language_id' => 1,
				'type' => 'manufacturer',
				'object_id' => 10,
				'text' => 'Sony',
			),
			51 => 
			array (
				'id' => 139,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 42,
				'text' => 'Apple Cinema 30"',
			),
			52 => 
			array (
				'id' => 140,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 42,
			'text' => 'The 30-inch Apple Cinema HD Display delivers an amazing 2560 x 1600 pixel resolution. Designed specifically for the creative professional, this display provides more space for easier access to all the tools and palettes needed to edit, format and composite your work. Combine this display with a Mac Pro, MacBook Pro, or PowerMac G5 and there\'s no limit to what you can achieve.The Cinema HD features an active-matrix liquid crystal display that produces flicker-free images that deliver twice the brightness, twice the sharpness and twice the contrast ratio of a typical CRT display. Unlike other flat panels, it\'s designed with a pure digital interface to deliver distortion-free images that never need adjusting. With over 4 million digital pixels, the display is uniquely suited for scientific and technical applications such as visualizing molecular structures or analyzing geological data.Offering accurate, brilliant color performance, the Cinema HD delivers up to 16.7 million colors across a wide gamut allowing you to see subtle nuances between colors from soft pastels to rich jewel tones. A wide viewing angle ensures uniform color from edge to edge. Apple\'s ColorSync technology allows you to create custom profiles to maintain consistent color onscreen and in print. The result: You can confidently use this display in all your color-critical applications.Housed in a new aluminum design, the display has a very thin bezel that enhances visual accuracy. Each display features two FireWire 400 ports and two USB 2.0 ports, making attachment of desktop peripherals, such as iSight, iPod, digital and still cameras, hard drives, printers and scanners, even more accessible and convenient. Taking advantage of the much thinner and lighter footprint of an LCD, the new displays support the VESA (Video Electronics Standards Association) mounting interface standard. Customers with the optional Cinema Display VESA Mount Adapter kit gain the flexibility to mount their display in locations most appropriate for their work environment.The Cinema HD features a single cable design with elegant breakout for the USB 2.0, FireWire 400 and a pure digital connection using the industry standard Digital Video Interface (DVI) interface. The DVI connection allows for a direct pure-digital connection.Features:Unrivaled display performance30-inch (viewable) active-matrix liquid crystal display provides breathtaking image quality and vivid, richly saturated color.Support for 2560-by-1600 pixel resolution for display of high definition still and video imagery.Wide-format design for simultaneous display of two full pages of text and graphics.Industry standard DVI connector for direct attachment to Mac- and Windows-based desktops and notebooksIncredibly wide (170 degree) horizontal and vertical viewing angle for maximum visibility and color performance.Lightning-fast pixel response for full-motion digital video playback.Support for 16.7 million saturated colors, for use in all graphics-intensive applications.Simple setup and operationSingle cable with elegant breakout for connection to DVI, USB and FireWire portsBuilt-in two-port USB 2.0 hub for easy connection of desktop peripheral devices.Two FireWire 400 ports to support iSight and other desktop peripheralsSleek, elegant designHuge virtual workspace, very small footprint.Narrow Bezel design to minimize visual impact of using dual displaysUnique hinge design for effortless adjustmentSupport for VESA mounting solutions (Apple Cinema Display VESA Mount Adapter sold separately)Technical specificationsScreen size (diagonal viewable image size)Apple Cinema HD Display: 30 inches (29.7-inch viewable)Screen typeThin film transistor (TFT) active-matrix liquid crystal display (AMLCD)Resolutions2560 x 1600 pixels (optimum resolution)2048 x 12801920 x 12001280 x 8001024 x 640Display colors (maximum)16.7 millionViewing angle (typical)170° horizontal; 170° verticalBrightness (typical)30-inch Cinema HD Display: 400 cd/m2Contrast ratio (typical)700:1Response time (typical)16 msPixel pitch30-inch Cinema HD Display: 0.250 mmScreen treatmentAntiglare hardcoatUser controls (hardware and software)Display Power,System sleep, wakeBrightnessMonitor tiltConnectors and cablesCableDVI (Digital Visual Interface)FireWire 400USB 2.0DC power (24 V)ConnectorsTwo-port, self-powered USB 2.0 hubTwo FireWire 400 portsKensington security portVESA mount adapterRequires optional Cinema Display VESA Mount Adapter (M9649G/A)Compatible with VESA FDMI (MIS-D, 100, C) compliant mounting solutionsElectrical requirementsInput voltage: 100-240 VAC 50-60HzMaximum power when operating: 150WEnergy saver mode: 3W or lessEnvironmental requirementsOperating temperature: 50° to 95° F (10° to 35° C)Storage temperature: -40° to 116° F (-40° to 47° C)Operating humidity: 20% to 80% noncondensingMaximum operating altitude: 10,000 feetAgency approvalsFCC Part 15 Class BEN55022 Class BEN55024VCCI Class BAS/NZS 3548 Class BCNS 13438 Class BICES-003 Class BISO 13406 part 2MPR IIIEC 60950UL 60950CSA 60950EN60950ENERGY STARTCO \'03Size and weight30-inch Apple Cinema HD DisplayHeight: 21.3 inches (54.3 cm)Width: 27.2 inches (68.8 cm)Depth: 8.46 inches (21.5 cm)Weight: 27.5 pounds (12.5 kg)System RequirementsMac Pro, all graphic optionsMacBook ProPower Mac G5 (PCI-X) with ATI Radeon 9650 or better or NVIDIA GeForce 6800 GT DDL or betterPower Mac G5 (PCI Express), all graphics optionsPowerBook G4 with dual-link DVI supportWindows PC and graphics card that supports DVI ports with dual-link digital bandwidth and VESA DDC standard for plug-and-play setup',
			),
			53 => 
			array (
				'id' => 141,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 30,
				'text' => 'Canon EOS 5D',
			),
			54 => 
			array (
				'id' => 142,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 30,
			'text' => 'Canon\'s press material for the EOS 5D states that it \'defines (a) new D-SLR category\', while we\'re not typically too concerned with marketing talk this particular statement is clearly pretty accurate. The EOS 5D is unlike any previous digital SLR in that it combines a full-frame (35 mm sized) high resolution sensor (12.8 megapixels) with a relatively compact body (slightly larger than the EOS 20D, although in your hand it feels noticeably \'chunkier\'). The EOS 5D is aimed to slot in between the EOS 20D and the EOS-1D professional digital SLR\'s, an important difference when compared to the latter is that the EOS 5D doesn\'t have any environmental seals. While Canon don\'t specifically refer to the EOS 5D as a \'professional\' digital SLR it will have obvious appeal to professionals who want a high quality digital SLR in a body lighter than the EOS-1D. It will also no doubt appeal to current EOS 20D owners (although lets hope they\'ve not bought too many EF-S lenses...) äë',
			),
			55 => 
			array (
				'id' => 143,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 50,
				'text' => 'Dais.io Live Conference 2015',
			),
			56 => 
			array (
				'id' => 144,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 50,
				'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus feugiat dui a odio facilisis porta commodo ut ligula. Nullam ligula urna, blandit vel justo eu, tristique tempor nisl. Nam ornare auctor enim vel venenatis. Duis et elit augue. Nulla auctor nunc et ultrices lobortis. Donec ultricies, metus quis convallis tincidunt, nisl nibh molestie tortor, et accumsan turpis nulla rhoncus libero. Donec hendrerit enim ut lectus condimentum malesuada.',
			),
			57 => 
			array (
				'id' => 145,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 47,
				'text' => 'HP LP3065',
			),
			58 => 
			array (
				'id' => 146,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 47,
				'text' => 'Stop your co-workers in their tracks with the stunning new 30-inch diagonal HP LP3065 Flat Panel Monitor. This flagship monitor features best-in-class performance and presentation features on a huge wide-aspect screen while letting you work as comfortably as possible - you might even forget you\'re at the office',
			),
			59 => 
			array (
				'id' => 147,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 28,
				'text' => 'HTC Touch HD',
			),
			60 => 
			array (
				'id' => 148,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 28,
			'text' => 'HTC Touch - in High Definition. Watch music videos and streaming content in awe-inspiring high definition clarity for a mobile experience you never thought possible. Seductively sleek, the HTC Touch HD provides the next generation of mobile functionality, all at a simple touch. Fully integrated with Windows Mobile Professional 6.1, ultrafast 3.5G, GPS, 5MP camera, plus lots more - all delivered on a breathtakingly crisp 3.8" WVGA touchscreen - you can take control of your mobile world with the HTC Touch HD.FeaturesProcessor Qualcomm® MSM 7201A™ 528 MHzWindows Mobile® 6.1 Professional Operating SystemMemory: 512 MB ROM, 288 MB RAMDimensions: 115 mm x 62.8 mm x 12 mm / 146.4 grams3.8-inch TFT-LCD flat touch-sensitive screen with 480 x 800 WVGA resolutionHSDPA/WCDMA: Europe/Asia: 900/2100 MHz; Up to 2 Mbps up-link and 7.2 Mbps down-link speedsQuad-band GSM/GPRS/EDGE: Europe/Asia: 850/900/1800/1900 MHz (Band frequency, HSUPA availability, and data speed are operator dependent.)Device Control via HTC TouchFLO™ 3D & Touch-sensitive front panel buttonsGPS and A-GPS readyBluetooth® 2.0 with Enhanced Data Rate and A2DP for wireless stereo headsetsWi-Fi®: IEEE 802.11 b/gHTC ExtUSB™ (11-pin mini-USB 2.0)5 megapixel color camera with auto focusVGA CMOS color cameraBuilt-in 3.5 mm audio jack, microphone, speaker, and FM radioRing tone formats: AAC, AAC+, eAAC+, AMR-NB, AMR-WB, QCP, MP3, WMA, WAV40 polyphonic and standard MIDI format 0 and 1 (SMF)/SP MIDIRechargeable Lithium-ion or Lithium-ion polymer 1350 mAh batteryExpansion Slot: microSD™ memory card (SD 2.0 compatible)AC Adapter Voltage range/frequency: 100 ~ 240V AC, 50/60 Hz DC output: 5V and 1ASpecial Features: FM Radio, G-Sensor',
			),
			61 => 
			array (
				'id' => 149,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 41,
				'text' => 'iMac',
			),
			62 => 
			array (
				'id' => 150,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 41,
				'text' => 'Just when you thought iMac had everything, now there´s even more. More powerful Intel Core 2 Duo processors. And more memory standard. Combine this with Mac OS X Leopard and iLife ´08, and it´s more all-in-one than ever. iMac packs amazing performance into a stunningly slim space.',
			),
			63 => 
			array (
				'id' => 151,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 40,
				'text' => 'iPhone',
			),
			64 => 
			array (
				'id' => 152,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 40,
				'text' => 'iPhone is a revolutionary new mobile phone that allows you to make a call by simply tapping a name or number in your address book, a favorites list, or a call log. It also automatically syncs all your contacts from a PC, Mac, or Internet service. And it lets you select and listen to voicemail messages in whatever order you want just like email.',
			),
			65 => 
			array (
				'id' => 153,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 48,
				'text' => 'iPod Classic',
			),
			66 => 
			array (
				'id' => 154,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 48,
				'text' => 'More room to move.With 80GB or 160GB of storage and up to 40 hours of battery life, the new iPod classic lets you enjoy up to 40,000 songs or up to 200 hours of video or any combination wherever you go.Cover Flow.Browse through your music collection by flipping through album art. Select an album to turn it over and see the track list.Enhanced interface.Experience a whole new way to browse and view your music and video.Sleeker design.Beautiful, durable, and sleeker than ever, iPod classic now features an anodized aluminum and polished stainless steel enclosure with rounded edges.',
			),
			67 => 
			array (
				'id' => 155,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 36,
				'text' => 'iPod Nano',
			),
			68 => 
			array (
				'id' => 156,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 36,
				'text' => 'Video in your pocket.Its the small iPod with one very big idea: video. The worlds most popular music player now lets you enjoy movies, TV shows, and more on a two-inch display thats 65% brighter than before.Cover Flow.Browse through your music collection by flipping through album art. Select an album to turn it over and see the track list. Enhanced interface.Experience a whole new way to browse and view your music and video.Sleek and colorful.With an anodized aluminum and polished stainless steel enclosure and a choice of five colors, iPod nano is dressed to impress.iTunes.Available as a free download, iTunes makes it easy to browse and buy millions of songs, movies, TV shows, audiobooks, and games and download free podcasts all at the iTunes Store. And you can import your own music, manage your whole media library, and sync your iPod or iPhone with ease.',
			),
			69 => 
			array (
				'id' => 157,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 34,
				'text' => 'iPod Shuffle',
			),
			70 => 
			array (
				'id' => 158,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 34,
				'text' => 'Born to be worn.Clip on the worlds most wearable music player and take up to 240 songs with you anywhere. Choose from five colors including four new hues to make your musical fashion statement.Random meets rhythm.With iTunes autofill, iPod shuffle can deliver a new musical experience every time you sync. For more randomness, you can shuffle songs during playback with the slide of a switch.Everything is easy.Charge and sync with the included USB dock. Operate the iPod shuffle controls with one hand. Enjoy up to 12 hours straight of skip-free music playback.',
			),
			71 => 
			array (
				'id' => 159,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 32,
				'text' => 'iPod Touch',
			),
			72 => 
			array (
				'id' => 160,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 32,
				'text' => 'Revolutionary multi-touch interface.iPod touch features the same multi-touch screen technology as iPhone. Pinch to zoom in on a photo. Scroll through your songs and videos with a flick. Flip through your library by album artwork with Cover Flow.Gorgeous 3.5-inch widescreen display.Watch your movies, TV shows, and photos come alive with bright, vivid color on the 320-by-480-pixel display.Music downloads straight from iTunes.Shop the iTunes Wi-Fi Music Store from anywhere with Wi-Fi.1 Browse or search to find the music youre looking for, preview it, and buy it with just a tap.Surf the web with Wi-Fi.Browse the web using Safari and watch YouTube videos on the first iPod with Wi-Fi built in ',
			),
			73 => 
			array (
				'id' => 161,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 43,
				'text' => 'MacBook',
			),
			74 => 
			array (
				'id' => 162,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 43,
				'text' => 'Intel Core 2 Duo processorPowered by an Intel Core 2 Duo processor at speeds up to 2.16GHz, the new MacBook is the fastest ever.1GB memory, larger hard drivesThe new MacBook now comes with 1GB of memory standard and larger hard drives for the entire line perfect for running more of your favorite applications and storing growing media collections.Sleek, 1.08-inch-thin designMacBook makes it easy to hit the road thanks to its tough polycarbonate case, built-in wireless technologies, and innovative MagSafe Power Adapter that releases automatically if someone accidentally trips on the cord.Built-in iSight cameraRight out of the box, you can have a video chat with friends or family,2 record a video at your desk, or take fun pictures with Photo Booth',
			),
			75 => 
			array (
				'id' => 163,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 44,
				'text' => 'MacBook Air',
			),
			76 => 
			array (
				'id' => 164,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 44,
				'text' => 'MacBook Air is ultrathin, ultraportable, and ultra unlike anything else. But you don’t lose inches and pounds overnight. It’s the result of rethinking conventions. Of multiple wireless innovations. And of breakthrough design. With MacBook Air, mobile computing suddenly has a new standard.',
			),
			77 => 
			array (
				'id' => 165,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 45,
				'text' => 'MacBook Pro',
			),
			78 => 
			array (
				'id' => 166,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 45,
				'text' => 'Latest Intel mobile architecturePowered by the most advanced mobile processors from Intel, the new Core 2 Duo MacBook Pro is over 50% faster than the original Core Duo MacBook Pro and now supports up to 4GB of RAM.Leading-edge graphicsThe NVIDIA GeForce 8600M GT delivers exceptional graphics processing power. For the ultimate creative canvas, you can even configure the 17-inch model with a 1920-by-1200 resolution display.Designed for life on the roadInnovations such as a magnetic power connection and an illuminated keyboard with ambient light sensor put the MacBook Pro in a class by itself.Connect. Create. Communicate.Quickly set up a video conference with the built-in iSight camera. Control presentations and media from up to 30 feet away with the included Apple Remote. Connect to high-bandwidth peripherals with FireWire 800 and DVI.Next-generation wirelessFeaturing 802.11n wireless technology, the MacBook Pro delivers up to five times the performance and up to twice the range of previous-generation technologies.',
			),
			79 => 
			array (
				'id' => 167,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 31,
				'text' => 'Nikon D300',
			),
			80 => 
			array (
				'id' => 168,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 31,
			'text' => 'Engineered with pro-level features and performance, the 12.3-effective-megapixel D300 combines brand new technologies with advanced features inherited from Nikon\'s newly announced D3 professional digital SLR camera to offer serious photographers remarkable performance combined with agility.Similar to the D3, the D300 features Nikon\'s exclusive EXPEED Image Processing System that is central to driving the speed and processing power needed for many of the camera\'s new features. The D300 features a new 51-point autofocus system with Nikon\'s 3D Focus Tracking feature and two new LiveView shooting modes that allow users to frame a photograph using the camera\'s high-resolution LCD monitor. The D300 shares a similar Scene Recognition System as is found in the D3; it promises to greatly enhance the accuracy of autofocus, autoexposure, and auto white balance by recognizing the subject or scene being photographed and applying this information to the calculations for the three functions.The D300 reacts with lightning speed, powering up in a mere 0.13 seconds and shooting with an imperceptible 45-millisecond shutter release lag time. The D300 is capable of shooting at a rapid six frames per second and can go as fast as eight frames per second when using the optional MB-D10 multi-power battery pack. In continuous bursts, the D300 can shoot up to 100 shots at full 12.3-megapixel resolution. (NORMAL-LARGE image setting, using a SanDisk Extreme IV 1GB CompactFlash card.)The D300 incorporates a range of innovative technologies and features that will significantly improve the accuracy, control, and performance photographers can get from their equipment. Its new Scene Recognition System advances the use of Nikon\'s acclaimed 1,005-segment sensor to recognize colors and light patterns that help the camera determine the subject and the type of scene being photographed before a picture is taken. This information is used to improve the accuracy of autofocus, autoexposure, and auto white balance functions in the D300. For example, the camera can track moving subjects better and by identifying them, it can also automatically select focus points faster and with greater accuracy. It can also analyze highlights and more accurately determine exposure, as well as infer light sources to deliver more accurate white balance detection.',
			),
			81 => 
			array (
				'id' => 169,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 29,
				'text' => 'Palm Treo Pro',
			),
			82 => 
			array (
				'id' => 170,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 29,
			'text' => 'Redefine your workday with the Palm Treo Pro smartphone. Perfectly balanced, you can respond to business and personal email, stay on top of appointments and contacts, and use Wi-Fi or GPS when you’re out and about. Then watch a video on YouTube, catch up with news and sports on the web, or listen to a few songs. Balance your work and play the way you like it, with the Palm Treo Pro.FeaturesWindows Mobile® 6.1 Professional EditionQualcomm® MSM7201 400MHz Processor320x320 transflective colour TFT touchscreenHSDPA/UMTS/EDGE/GPRS/GSM radioTri-band UMTS — 850MHz, 1900MHz, 2100MHzQuad-band GSM — 850/900/1800/1900802.11b/g with WPA, WPA2, and 801.1x authenticationBuilt-in GPSBluetooth Version: 2.0 + Enhanced Data Rate256MB storage (100MB user available), 128MB RAM2.0 megapixel camera, up to 8x digital zoom and video captureRemovable, rechargeable 1500mAh lithium-ion batteryUp to 5.0 hours talk time and up to 250 hours standbyMicroSDHC card expansion (up to 32GB supported)MicroUSB 2.0 for synchronization and charging3.5mm stereo headset jack60mm (W) x 114mm (L) x 13.5mm (D) / 133g',
			),
			83 => 
			array (
				'id' => 171,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 49,
				'text' => 'Samsung Galaxy Tab 10.1',
			),
			84 => 
			array (
				'id' => 172,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 49,
				'text' => 'Samsung Galaxy Tab 10.1, is the world’s thinnest tablet, measuring 8.6 mm thickness, running with Android 3.0 Honeycomb OS on a 1GHz dual-core Tegra 2 processor, similar to its younger brother Samsung Galaxy Tab 8.9.Samsung Galaxy Tab 10.1 gives pure Android 3.0 experience, adding its new TouchWiz UX or TouchWiz 4.0 – includes a live panel, which lets you to customize with different content, such as your pictures, bookmarks, and social feeds, sporting a 10.1 inches WXGA capacitive touch screen with 1280 x 800 pixels of resolution, equipped with 3 megapixel rear camera with LED flash and a 2 megapixel front camera, HSPA+ connectivity up to 21Mbps, 720p HD video recording capability, 1080p HD playback, DLNA support, Bluetooth 2.1, USB 2.0, gyroscope, Wi-Fi 802.11 a/b/g/n, micro-SD slot, 3.5mm headphone jack, and SIM slot, including the Samsung Stick – a Bluetooth microphone that can be carried in a pocket like a pen and sound dock with powered subwoofer.Samsung Galaxy Tab 10.1 will come in 16GB / 32GB / 64GB verities and pre-loaded with Social Hub, Reader’s Hub, Music Hub and Samsung Mini Apps Tray – which gives you access to more commonly used apps to help ease multitasking and it is capable of Adobe Flash Player 10.2, powered by 6860mAh battery that gives you 10hours of video-playback time. äö',
			),
			85 => 
			array (
				'id' => 173,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 33,
				'text' => 'Samsung SyncMaster 941BW',
			),
			86 => 
			array (
				'id' => 174,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 33,
				'text' => 'Imagine the advantages of going big without slowing down. The big 19" 941BW monitor combines wide aspect ratio with fast pixel response time, for bigger images, more room to work and crisp motion. In addition, the exclusive MagicBright 2, MagicColor and MagicTune technologies help deliver the ideal image in every situation, while sleek, narrow bezels and adjustable stands deliver style just the way you want it. With the Samsung 941BW widescreen analog/digital LCD monitor, it\'s not hard to imagine.',
			),
			87 => 
			array (
				'id' => 175,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 46,
				'text' => 'Sony VAIO',
			),
			88 => 
			array (
				'id' => 176,
				'language_id' => 1,
				'type' => 'product',
				'object_id' => 46,
				'text' => 'Unprecedented power. The next generation of processing technology has arrived. Built into the newest VAIO notebooks lies Intel\'s latest, most powerful innovation yet: Intel® Centrino® 2 processor technology. Boasting incredible speed, expanded wireless connectivity, enhanced multimedia support and greater energy efficiency, all the high-performance essentials are seamlessly combined into a single chip.',
			),
			89 => 
			array (
				'id' => 177,
				'language_id' => 1,
				'type' => 'page',
				'object_id' => 4,
				'text' => 'About Us',
			),
			90 => 
			array (
				'id' => 178,
				'language_id' => 1,
				'type' => 'page',
				'object_id' => 4,
				'text' => 'About Us',
			),
			91 => 
			array (
				'id' => 179,
				'language_id' => 1,
				'type' => 'page',
				'object_id' => 8,
				'text' => 'Affiliate Terms',
			),
			92 => 
			array (
				'id' => 180,
				'language_id' => 1,
				'type' => 'page',
				'object_id' => 8,
				'text' => 'Affiliate terms go here.',
			),
			93 => 
			array (
				'id' => 181,
				'language_id' => 1,
				'type' => 'page',
				'object_id' => 6,
				'text' => 'Delivery Information',
			),
			94 => 
			array (
				'id' => 182,
				'language_id' => 1,
				'type' => 'page',
				'object_id' => 6,
				'text' => 'Delivery Information',
			),
			95 => 
			array (
				'id' => 183,
				'language_id' => 1,
				'type' => 'page',
				'object_id' => 11,
				'text' => 'Online Webinar',
			),
			96 => 
			array (
				'id' => 184,
				'language_id' => 1,
				'type' => 'page',
				'object_id' => 11,
				'text' => 'Once the event is created, you cannot switch from a product to a page or vice-versa. If you want to switch, you must delete the entire event and start over. Keep in mind that this will delete all data for the event including anyone who is already registered.And here\'s another line of text.More text.',
			),
			97 => 
			array (
				'id' => 185,
				'language_id' => 1,
				'type' => 'page',
				'object_id' => 3,
				'text' => 'Privacy Policy',
			),
			98 => 
			array (
				'id' => 186,
				'language_id' => 1,
				'type' => 'page',
				'object_id' => 3,
				'text' => 'Privacy Policy',
			),
			99 => 
			array (
				'id' => 187,
				'language_id' => 1,
				'type' => 'page',
				'object_id' => 7,
				'text' => 'Return Policy',
			),
			100 => 
			array (
				'id' => 188,
				'language_id' => 1,
				'type' => 'page',
				'object_id' => 7,
				'text' => 'Your return policy here.',
			),
			101 => 
			array (
				'id' => 189,
				'language_id' => 1,
				'type' => 'page',
				'object_id' => 5,
				'text' => 'Terms & Conditions',
			),
			102 => 
			array (
				'id' => 190,
				'language_id' => 1,
				'type' => 'page',
				'object_id' => 5,
				'text' => 'Terms & Conditions',
			),
			103 => 
			array (
				'id' => 191,
				'language_id' => 1,
				'type' => 'blog_category',
				'object_id' => 1,
				'text' => 'General',
			),
			104 => 
			array (
				'id' => 192,
				'language_id' => 1,
				'type' => 'blog_category',
				'object_id' => 1,
				'text' => 'This is the general category for all things general.',
			),
			105 => 
			array (
				'id' => 193,
				'language_id' => 1,
				'type' => 'blog_category',
				'object_id' => 2,
				'text' => 'Latest Product News',
			),
			106 => 
			array (
				'id' => 194,
				'language_id' => 1,
				'type' => 'blog_category',
				'object_id' => 2,
				'text' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.',
			),
			107 => 
			array (
				'id' => 195,
				'language_id' => 1,
				'type' => 'post',
				'object_id' => 1,
				'text' => 'Lorem Ipsum Test Post',
			),
			108 => 
			array (
				'id' => 196,
				'language_id' => 1,
				'type' => 'post',
				'object_id' => 1,
				'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus feugiat dui a odio facilisis porta commodo ut ligula. Nullam ligula urna, blandit vel justo eu, tristique tempor nisl. Nam ornare auctor enim vel venenatis. Duis et elit augue. Nulla auctor nunc et ultrices lobortis. Donec ultricies, metus quis convallis tincidunt, nisl nibh molestie tortor, et accumsan turpis nulla rhoncus libero. Donec hendrerit enim ut lectus condimentum malesuada.Quisque vel augue semper, euismod turpis sed, suscipit odio. Morbi venenatis neque a tristique sodales. Suspendisse sed tempor mauris, eu blandit nulla. Vivamus quis enim et nibh ultrices pellentesque. In nec dapibus orci. Nam vel augue at nunc convallis adipiscing eget quis libero. Cras semper odio congue, varius diam a, rutrum dolor.Pellentesque sed tincidunt velit, pellentesque luctus tellus. Duis vulputate lacus eu metus consectetur pretium. Interdum et malesuada fames ac ante ipsum primis in faucibus. Fusce pulvinar quam non magna aliquet, a tincidunt diam lobortis. Vestibulum quam quam, commodo commodo ornare at, sodales ac elit. Pellentesque convallis pellentesque ante at facilisis. Duis ut porta mauris. Vestibulum suscipit elit vitae urna hendrerit, fermentum placerat justo tristique. Quisque eget odio nunc. Morbi interdum sed mi sit amet suscipit. Nullam nec lacinia dolor, vel dapibus nulla. Aenean sed congue nisi, id dictum diam. Phasellus ac metus non ligula interdum hendrerit eget vitae nisi.In posuere molestie imperdiet. Nunc auctor sagittis risus, ullamcorper elementum dui ullamcorper eget. Donec quis diam porttitor, fringilla purus nec, viverra tellus. In sit amet pulvinar risus, sed porttitor lectus. Proin nunc metus, porta id viverra nec, aliquet in lorem. Quisque faucibus lorem vitae nulla adipiscing, in aliquet lorem cursus. Pellentesque id suscipit justo. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi sagittis non ante quis vehicula.Sed at metus ipsum. Integer odio leo, volutpat eu sagittis sed, sodales vel dui. Vestibulum nec tellus orci. Etiam hendrerit at arcu vel interdum. Praesent quis nulla adipiscing, convallis est in, pulvinar quam. Curabitur at massa pulvinar eros rhoncus molestie vitae eget purus. Curabitur ullamcorper dictum tortor, in blandit urna gravida et. Nulla a nisl ligula. Vestibulum lobortis rutrum luctus. Phasellus mattis, turpis at dignissim fringilla, quam quam egestas nisl, vel viverra sem diam gravida purus. In eget erat rutrum, pulvinar lectus porta, aliquam lorem. Sed lorem purus, sodales id pellentesque id, volutpat a tellus. Nam aliquam ullamcorper odio sed egestas. Donec vel dictum odio.',
			),
		));
	}

}
