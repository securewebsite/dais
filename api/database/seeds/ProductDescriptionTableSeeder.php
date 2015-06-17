<?php

use Illuminate\Database\Seeder;

class ProductDescriptionTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('product_description')->delete();
        
		\DB::table('product_description')->insert(array (
			0 => 
			array (
				'product_id' => 28,
				'language_id' => 1,
				'name' => 'HTC Touch HD',
				'description' => '&lt;p&gt;HTC Touch - in High Definition. Watch music videos and streaming content in awe-inspiring high definition clarity for a mobile experience you never thought possible. Seductively sleek, the HTC Touch HD provides the next generation of mobile functionality, all at a simple touch. Fully integrated with Windows Mobile Professional 6.1, ultrafast 3.5G, GPS, 5MP camera, plus lots more - all delivered on a breathtakingly crisp 3.8&quot; WVGA touchscreen - you can take control of your mobile world with the HTC Touch HD.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Features&lt;/strong&gt;&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;Processor Qualcomm® MSM 7201A™ 528 MHz&lt;/li&gt;
&lt;li&gt;Windows Mobile® 6.1 Professional Operating System&lt;/li&gt;
&lt;li&gt;Memory: 512 MB ROM, 288 MB RAM&lt;/li&gt;
&lt;li&gt;Dimensions: 115 mm x 62.8 mm x 12 mm / 146.4 grams&lt;/li&gt;
&lt;li&gt;3.8-inch TFT-LCD flat touch-sensitive screen with 480 x 800 WVGA resolution&lt;/li&gt;
&lt;li&gt;HSDPA/WCDMA: Europe/Asia: 900/2100 MHz; Up to 2 Mbps up-link and 7.2 Mbps down-link speeds&lt;/li&gt;
&lt;li&gt;Quad-band GSM/GPRS/EDGE: Europe/Asia: 850/900/1800/1900 MHz (Band frequency, HSUPA availability, and data speed are operator dependent.)&lt;/li&gt;
&lt;li&gt;Device Control via HTC TouchFLO™ 3D &amp; Touch-sensitive front panel buttons&lt;/li&gt;
&lt;li&gt;GPS and A-GPS ready&lt;/li&gt;
&lt;li&gt;Bluetooth® 2.0 with Enhanced Data Rate and A2DP for wireless stereo headsets&lt;/li&gt;
&lt;li&gt;Wi-Fi®: IEEE 802.11 b/g&lt;/li&gt;
&lt;li&gt;HTC ExtUSB™ (11-pin mini-USB 2.0)&lt;/li&gt;
&lt;li&gt;5 megapixel color camera with auto focus&lt;/li&gt;
&lt;li&gt;VGA CMOS color camera&lt;/li&gt;
&lt;li&gt;Built-in 3.5 mm audio jack, microphone, speaker, and FM radio&lt;/li&gt;
&lt;li&gt;Ring tone formats: AAC, AAC+, eAAC+, AMR-NB, AMR-WB, QCP, MP3, WMA, WAV&lt;/li&gt;
&lt;li&gt;40 polyphonic and standard MIDI format 0 and 1 (SMF)/SP MIDI&lt;/li&gt;
&lt;li&gt;Rechargeable Lithium-ion or Lithium-ion polymer 1350 mAh battery&lt;/li&gt;
&lt;li&gt;Expansion Slot: microSD™ memory card (SD 2.0 compatible)&lt;/li&gt;
&lt;li&gt;AC Adapter Voltage range/frequency: 100 ~ 240V AC, 50/60 Hz DC output: 5V and 1A&lt;/li&gt;
&lt;li&gt;Special Features: FM Radio, G-Sensor&lt;/li&gt;
&lt;/ul&gt;
',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			1 => 
			array (
				'product_id' => 29,
				'language_id' => 1,
				'name' => 'Palm Treo Pro',
				'description' => '&lt;p&gt;Redefine your workday with the Palm Treo Pro smartphone. Perfectly balanced, you can respond to business and personal email, stay on top of appointments and contacts, and use Wi-Fi or GPS when you’re out and about. Then watch a video on YouTube, catch up with news and sports on the web, or listen to a few songs. Balance your work and play the way you like it, with the Palm Treo Pro.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Features&lt;/strong&gt;&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;Windows Mobile® 6.1 Professional Edition&lt;/li&gt;
&lt;li&gt;Qualcomm® MSM7201 400MHz Processor&lt;/li&gt;
&lt;li&gt;320x320 transflective colour TFT touchscreen&lt;/li&gt;
&lt;li&gt;HSDPA/UMTS/EDGE/GPRS/GSM radio&lt;/li&gt;
&lt;li&gt;Tri-band UMTS — 850MHz, 1900MHz, 2100MHz&lt;/li&gt;
&lt;li&gt;Quad-band GSM — 850/900/1800/1900&lt;/li&gt;
&lt;li&gt;802.11b/g with WPA, WPA2, and 801.1x authentication&lt;/li&gt;
&lt;li&gt;Built-in GPS&lt;/li&gt;
&lt;li&gt;Bluetooth Version: 2.0 + Enhanced Data Rate&lt;/li&gt;
&lt;li&gt;256MB storage (100MB user available), 128MB RAM&lt;/li&gt;
&lt;li&gt;2.0 megapixel camera, up to 8x digital zoom and video capture&lt;/li&gt;
&lt;li&gt;Removable, rechargeable 1500mAh lithium-ion battery&lt;/li&gt;
&lt;li&gt;Up to 5.0 hours talk time and up to 250 hours standby&lt;/li&gt;
&lt;li&gt;MicroSDHC card expansion (up to 32GB supported)&lt;/li&gt;
&lt;li&gt;MicroUSB 2.0 for synchronization and charging&lt;/li&gt;
&lt;li&gt;3.5mm stereo headset jack&lt;/li&gt;
&lt;li&gt;60mm (W) x 114mm (L) x 13.5mm (D) / 133g&lt;/li&gt;
&lt;/ul&gt;
',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			2 => 
			array (
				'product_id' => 30,
				'language_id' => 1,
				'name' => 'Canon EOS 5D',
			'description' => '&lt;p&gt;Canon\'s press material for the EOS 5D states that it \'defines (a) new D-SLR category\', while we\'re not typically too concerned with marketing talk this particular statement is clearly pretty accurate. The EOS 5D is unlike any previous digital SLR in that it combines a full-frame (35 mm sized) high resolution sensor (12.8 megapixels) with a relatively compact body (slightly larger than the EOS 20D, although in your hand it feels noticeably \'chunkier\'). The EOS 5D is aimed to slot in between the EOS 20D and the EOS-1D professional digital SLR\'s, an important difference when compared to the latter is that the EOS 5D doesn\'t have any environmental seals. While Canon don\'t specifically refer to the EOS 5D as a \'professional\' digital SLR it will have obvious appeal to professionals who want a high quality digital SLR in a body lighter than the EOS-1D. It will also no doubt appeal to current EOS 20D owners (although lets hope they\'ve not bought too many EF-S lenses...) äë&lt;/p&gt;
',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			3 => 
			array (
				'product_id' => 31,
				'language_id' => 1,
				'name' => 'Nikon D300',
				'description' => '&lt;p&gt;Engineered with pro-level features and performance, the 12.3-effective-megapixel D300 combines brand new technologies with advanced features inherited from Nikon\'s newly announced D3 professional digital SLR camera to offer serious photographers remarkable performance combined with agility.&lt;br&gt;
&lt;br&gt;
Similar to the D3, the D300 features Nikon\'s exclusive EXPEED Image Processing System that is central to driving the speed and processing power needed for many of the camera\'s new features. The D300 features a new 51-point autofocus system with Nikon\'s 3D Focus Tracking feature and two new LiveView shooting modes that allow users to frame a photograph using the camera\'s high-resolution LCD monitor. The D300 shares a similar Scene Recognition System as is found in the D3; it promises to greatly enhance the accuracy of autofocus, autoexposure, and auto white balance by recognizing the subject or scene being photographed and applying this information to the calculations for the three functions.&lt;br&gt;
&lt;br&gt;
The D300 reacts with lightning speed, powering up in a mere 0.13 seconds and shooting with an imperceptible 45-millisecond shutter release lag time. The D300 is capable of shooting at a rapid six frames per second and can go as fast as eight frames per second when using the optional MB-D10 multi-power battery pack. In continuous bursts, the D300 can shoot up to 100 shots at full 12.3-megapixel resolution. (NORMAL-LARGE image setting, using a SanDisk Extreme IV 1GB CompactFlash card.)&lt;br&gt;
&lt;br&gt;
The D300 incorporates a range of innovative technologies and features that will significantly improve the accuracy, control, and performance photographers can get from their equipment. Its new Scene Recognition System advances the use of Nikon\'s acclaimed 1,005-segment sensor to recognize colors and light patterns that help the camera determine the subject and the type of scene being photographed before a picture is taken. This information is used to improve the accuracy of autofocus, autoexposure, and auto white balance functions in the D300. For example, the camera can track moving subjects better and by identifying them, it can also automatically select focus points faster and with greater accuracy. It can also analyze highlights and more accurately determine exposure, as well as infer light sources to deliver more accurate white balance detection.&lt;/p&gt;
&lt;!-- cpt_container_end --&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			4 => 
			array (
				'product_id' => 32,
				'language_id' => 1,
				'name' => 'iPod Touch',
				'description' => '&lt;p&gt;&lt;strong&gt;Revolutionary multi-touch interface.&lt;/strong&gt;&lt;br&gt;
iPod touch features the same multi-touch screen technology as iPhone. Pinch to zoom in on a photo. Scroll through your songs and videos with a flick. Flip through your library by album artwork with Cover Flow.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Gorgeous 3.5-inch widescreen display.&lt;/strong&gt;&lt;br&gt;
Watch your movies, TV shows, and photos come alive with bright, vivid color on the 320-by-480-pixel display.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Music downloads straight from iTunes.&lt;/strong&gt;&lt;br&gt;
Shop the iTunes Wi-Fi Music Store from anywhere with Wi-Fi.1 Browse or search to find the music youre looking for, preview it, and buy it with just a tap.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Surf the web with Wi-Fi.&lt;/strong&gt;&lt;br&gt;
Browse the web using Safari and watch YouTube videos on the first iPod with Wi-Fi built in&lt;br&gt;
 &lt;/p&gt;
',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			5 => 
			array (
				'product_id' => 33,
				'language_id' => 1,
				'name' => 'Samsung SyncMaster 941BW',
				'description' => '&lt;p&gt;Imagine the advantages of going big without slowing down. The big 19&quot; 941BW monitor combines wide aspect ratio with fast pixel response time, for bigger images, more room to work and crisp motion. In addition, the exclusive MagicBright 2, MagicColor and MagicTune technologies help deliver the ideal image in every situation, while sleek, narrow bezels and adjustable stands deliver style just the way you want it. With the Samsung 941BW widescreen analog/digital LCD monitor, it\'s not hard to imagine.&lt;/p&gt;
',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			6 => 
			array (
				'product_id' => 34,
				'language_id' => 1,
				'name' => 'iPod Shuffle',
				'description' => '&lt;p&gt;&lt;strong&gt;Born to be worn.&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;Clip on the worlds most wearable music player and take up to 240 songs with you anywhere. Choose from five colors including four new hues to make your musical fashion statement.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Random meets rhythm.&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;With iTunes autofill, iPod shuffle can deliver a new musical experience every time you sync. For more randomness, you can shuffle songs during playback with the slide of a switch.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Everything is easy.&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;Charge and sync with the included USB dock. Operate the iPod shuffle controls with one hand. Enjoy up to 12 hours straight of skip-free music playback.&lt;/p&gt;
',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			7 => 
			array (
				'product_id' => 36,
				'language_id' => 1,
				'name' => 'iPod Nano',
				'description' => '&lt;p&gt;&lt;strong&gt;Video in your pocket.&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;Its the small iPod with one very big idea: video. The worlds most popular music player now lets you enjoy movies, TV shows, and more on a two-inch display thats 65% brighter than before.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Cover Flow.&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;Browse through your music collection by flipping through album art. Select an album to turn it over and see the track list.&lt;strong&gt; &lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Enhanced interface.&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;Experience a whole new way to browse and view your music and video.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Sleek and colorful.&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;With an anodized aluminum and polished stainless steel enclosure and a choice of five colors, iPod nano is dressed to impress.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;iTunes.&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;Available as a free download, iTunes makes it easy to browse and buy millions of songs, movies, TV shows, audiobooks, and games and download free podcasts all at the iTunes Store. And you can import your own music, manage your whole media library, and sync your iPod or iPhone with ease.&lt;/p&gt;
',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			8 => 
			array (
				'product_id' => 40,
				'language_id' => 1,
				'name' => 'iPhone',
				'description' => '&lt;p&gt;iPhone is a revolutionary new mobile phone that allows you to make a call by simply tapping a name or number in your address book, a favorites list, or a call log. It also automatically syncs all your contacts from a PC, Mac, or Internet service. And it lets you select and listen to voicemail messages in whatever order you want just like email.&lt;/p&gt;
',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			9 => 
			array (
				'product_id' => 41,
				'language_id' => 1,
				'name' => 'iMac',
				'description' => '&lt;p&gt;Just when you thought iMac had everything, now there´s even more. More powerful Intel Core 2 Duo processors. And more memory standard. Combine this with Mac OS X Leopard and iLife ´08, and it´s more all-in-one than ever. iMac packs amazing performance into a stunningly slim space.&lt;/p&gt;
',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			10 => 
			array (
				'product_id' => 42,
				'language_id' => 1,
				'name' => 'Apple Cinema 30&quot;',
				'description' => '&lt;p&gt;The 30-inch Apple Cinema HD Display delivers an amazing 2560 x 1600 pixel resolution. Designed specifically for the creative professional, this display provides more space for easier access to all the tools and palettes needed to edit, format and composite your work. Combine this display with a Mac Pro, MacBook Pro, or PowerMac G5 and there\'s no limit to what you can achieve.&lt;br&gt;
&lt;br&gt;
The Cinema HD features an active-matrix liquid crystal display that produces flicker-free images that deliver twice the brightness, twice the sharpness and twice the contrast ratio of a typical CRT display. Unlike other flat panels, it\'s designed with a pure digital interface to deliver distortion-free images that never need adjusting. With over 4 million digital pixels, the display is uniquely suited for scientific and technical applications such as visualizing molecular structures or analyzing geological data.&lt;br&gt;
&lt;br&gt;
Offering accurate, brilliant color performance, the Cinema HD delivers up to 16.7 million colors across a wide gamut allowing you to see subtle nuances between colors from soft pastels to rich jewel tones. A wide viewing angle ensures uniform color from edge to edge. Apple\'s ColorSync technology allows you to create custom profiles to maintain consistent color onscreen and in print. The result: You can confidently use this display in all your color-critical applications.&lt;br&gt;
&lt;br&gt;
Housed in a new aluminum design, the display has a very thin bezel that enhances visual accuracy. Each display features two FireWire 400 ports and two USB 2.0 ports, making attachment of desktop peripherals, such as iSight, iPod, digital and still cameras, hard drives, printers and scanners, even more accessible and convenient. Taking advantage of the much thinner and lighter footprint of an LCD, the new displays support the VESA (Video Electronics Standards Association) mounting interface standard. Customers with the optional Cinema Display VESA Mount Adapter kit gain the flexibility to mount their display in locations most appropriate for their work environment.&lt;br&gt;
&lt;br&gt;
The Cinema HD features a single cable design with elegant breakout for the USB 2.0, FireWire 400 and a pure digital connection using the industry standard Digital Video Interface (DVI) interface. The DVI connection allows for a direct pure-digital connection.&lt;/p&gt;

&lt;h3&gt;Features:&lt;/h3&gt;

&lt;p&gt;Unrivaled display performance&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;30-inch (viewable) active-matrix liquid crystal display provides breathtaking image quality and vivid, richly saturated color.&lt;/li&gt;
&lt;li&gt;Support for 2560-by-1600 pixel resolution for display of high definition still and video imagery.&lt;/li&gt;
&lt;li&gt;Wide-format design for simultaneous display of two full pages of text and graphics.&lt;/li&gt;
&lt;li&gt;Industry standard DVI connector for direct attachment to Mac- and Windows-based desktops and notebooks&lt;/li&gt;
&lt;li&gt;Incredibly wide (170 degree) horizontal and vertical viewing angle for maximum visibility and color performance.&lt;/li&gt;
&lt;li&gt;Lightning-fast pixel response for full-motion digital video playback.&lt;/li&gt;
&lt;li&gt;Support for 16.7 million saturated colors, for use in all graphics-intensive applications.&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;Simple setup and operation&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;Single cable with elegant breakout for connection to DVI, USB and FireWire ports&lt;/li&gt;
&lt;li&gt;Built-in two-port USB 2.0 hub for easy connection of desktop peripheral devices.&lt;/li&gt;
&lt;li&gt;Two FireWire 400 ports to support iSight and other desktop peripherals&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;Sleek, elegant design&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;Huge virtual workspace, very small footprint.&lt;/li&gt;
&lt;li&gt;Narrow Bezel design to minimize visual impact of using dual displays&lt;/li&gt;
&lt;li&gt;Unique hinge design for effortless adjustment&lt;/li&gt;
&lt;li&gt;Support for VESA mounting solutions (Apple Cinema Display VESA Mount Adapter sold separately)&lt;/li&gt;
&lt;/ul&gt;

&lt;h3&gt;Technical specifications&lt;/h3&gt;

&lt;p&gt;&lt;strong&gt;Screen size (diagonal viewable image size)&lt;/strong&gt;&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;Apple Cinema HD Display: 30 inches (29.7-inch viewable)&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;&lt;strong&gt;Screen type&lt;/strong&gt;&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;Thin film transistor (TFT) active-matrix liquid crystal display (AMLCD)&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;&lt;strong&gt;Resolutions&lt;/strong&gt;&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;2560 x 1600 pixels (optimum resolution)&lt;/li&gt;
&lt;li&gt;2048 x 1280&lt;/li&gt;
&lt;li&gt;1920 x 1200&lt;/li&gt;
&lt;li&gt;1280 x 800&lt;/li&gt;
&lt;li&gt;1024 x 640&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;&lt;strong&gt;Display colors (maximum)&lt;/strong&gt;&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;16.7 million&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;&lt;strong&gt;Viewing angle (typical)&lt;/strong&gt;&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;170° horizontal; 170° vertical&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;&lt;strong&gt;Brightness (typical)&lt;/strong&gt;&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;30-inch Cinema HD Display: 400 cd/m2&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;&lt;strong&gt;Contrast ratio (typical)&lt;/strong&gt;&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;700:1&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;&lt;strong&gt;Response time (typical)&lt;/strong&gt;&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;16 ms&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;&lt;strong&gt;Pixel pitch&lt;/strong&gt;&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;30-inch Cinema HD Display: 0.250 mm&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;&lt;strong&gt;Screen treatment&lt;/strong&gt;&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;Antiglare hardcoat&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;&lt;strong&gt;User controls (hardware and software)&lt;/strong&gt;&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;Display Power,&lt;/li&gt;
&lt;li&gt;System sleep, wake&lt;/li&gt;
&lt;li&gt;Brightness&lt;/li&gt;
&lt;li&gt;Monitor tilt&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;&lt;strong&gt;Connectors and cables&lt;/strong&gt;&lt;br&gt;
Cable&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;DVI (Digital Visual Interface)&lt;/li&gt;
&lt;li&gt;FireWire 400&lt;/li&gt;
&lt;li&gt;USB 2.0&lt;/li&gt;
&lt;li&gt;DC power (24 V)&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;Connectors&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;Two-port, self-powered USB 2.0 hub&lt;/li&gt;
&lt;li&gt;Two FireWire 400 ports&lt;/li&gt;
&lt;li&gt;Kensington security port&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;&lt;strong&gt;VESA mount adapter&lt;/strong&gt;&lt;br&gt;
Requires optional Cinema Display VESA Mount Adapter (M9649G/A)&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;Compatible with VESA FDMI (MIS-D, 100, C) compliant mounting solutions&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;&lt;strong&gt;Electrical requirements&lt;/strong&gt;&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;Input voltage: 100-240 VAC 50-60Hz&lt;/li&gt;
&lt;li&gt;Maximum power when operating: 150W&lt;/li&gt;
&lt;li&gt;Energy saver mode: 3W or less&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;&lt;strong&gt;Environmental requirements&lt;/strong&gt;&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;Operating temperature: 50° to 95° F (10° to 35° C)&lt;/li&gt;
&lt;li&gt;Storage temperature: -40° to 116° F (-40° to 47° C)&lt;/li&gt;
&lt;li&gt;Operating humidity: 20% to 80% noncondensing&lt;/li&gt;
&lt;li&gt;Maximum operating altitude: 10,000 feet&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;&lt;strong&gt;Agency approvals&lt;/strong&gt;&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;FCC Part 15 Class B&lt;/li&gt;
&lt;li&gt;EN55022 Class B&lt;/li&gt;
&lt;li&gt;EN55024&lt;/li&gt;
&lt;li&gt;VCCI Class B&lt;/li&gt;
&lt;li&gt;AS/NZS 3548 Class B&lt;/li&gt;
&lt;li&gt;CNS 13438 Class B&lt;/li&gt;
&lt;li&gt;ICES-003 Class B&lt;/li&gt;
&lt;li&gt;ISO 13406 part 2&lt;/li&gt;
&lt;li&gt;MPR II&lt;/li&gt;
&lt;li&gt;IEC 60950&lt;/li&gt;
&lt;li&gt;UL 60950&lt;/li&gt;
&lt;li&gt;CSA 60950&lt;/li&gt;
&lt;li&gt;EN60950&lt;/li&gt;
&lt;li&gt;ENERGY STAR&lt;/li&gt;
&lt;li&gt;TCO \'03&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;&lt;strong&gt;Size and weight&lt;/strong&gt;&lt;br&gt;
30-inch Apple Cinema HD Display&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;Height: 21.3 inches (54.3 cm)&lt;/li&gt;
&lt;li&gt;Width: 27.2 inches (68.8 cm)&lt;/li&gt;
&lt;li&gt;Depth: 8.46 inches (21.5 cm)&lt;/li&gt;
&lt;li&gt;Weight: 27.5 pounds (12.5 kg)&lt;/li&gt;
&lt;/ul&gt;

&lt;p&gt;&lt;strong&gt;System Requirements&lt;/strong&gt;&lt;/p&gt;

&lt;ul&gt;
&lt;li&gt;Mac Pro, all graphic options&lt;/li&gt;
&lt;li&gt;MacBook Pro&lt;/li&gt;
&lt;li&gt;Power Mac G5 (PCI-X) with ATI Radeon 9650 or better or NVIDIA GeForce 6800 GT DDL or better&lt;/li&gt;
&lt;li&gt;Power Mac G5 (PCI Express), all graphics options&lt;/li&gt;
&lt;li&gt;PowerBook G4 with dual-link DVI support&lt;/li&gt;
&lt;li&gt;Windows PC and graphics card that supports DVI ports with dual-link digital bandwidth and VESA DDC standard for plug-and-play setup&lt;/li&gt;
&lt;/ul&gt;
',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			11 => 
			array (
				'product_id' => 43,
				'language_id' => 1,
				'name' => 'MacBook',
				'description' => '&lt;p&gt;&lt;strong&gt;Intel Core 2 Duo processor&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;Powered by an Intel Core 2 Duo processor at speeds up to 2.16GHz, the new MacBook is the fastest ever.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;1GB memory, larger hard drives&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;The new MacBook now comes with 1GB of memory standard and larger hard drives for the entire line perfect for running more of your favorite applications and storing growing media collections.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Sleek, 1.08-inch-thin design&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;MacBook makes it easy to hit the road thanks to its tough polycarbonate case, built-in wireless technologies, and innovative MagSafe Power Adapter that releases automatically if someone accidentally trips on the cord.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Built-in iSight camera&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;Right out of the box, you can have a video chat with friends or family,2 record a video at your desk, or take fun pictures with Photo Booth&lt;/p&gt;
',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			12 => 
			array (
				'product_id' => 44,
				'language_id' => 1,
				'name' => 'MacBook Air',
				'description' => '&lt;p&gt;MacBook Air is ultrathin, ultraportable, and ultra unlike anything else. But you don’t lose inches and pounds overnight. It’s the result of rethinking conventions. Of multiple wireless innovations. And of breakthrough design. With MacBook Air, mobile computing suddenly has a new standard.&lt;/p&gt;
',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			13 => 
			array (
				'product_id' => 45,
				'language_id' => 1,
				'name' => 'MacBook Pro',
				'description' => '&lt;p&gt;&lt;strong&gt;Latest Intel mobile architecture&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;Powered by the most advanced mobile processors from Intel, the new Core 2 Duo MacBook Pro is over 50% faster than the original Core Duo MacBook Pro and now supports up to 4GB of RAM.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Leading-edge graphics&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;The NVIDIA GeForce 8600M GT delivers exceptional graphics processing power. For the ultimate creative canvas, you can even configure the 17-inch model with a 1920-by-1200 resolution display.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Designed for life on the road&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;Innovations such as a magnetic power connection and an illuminated keyboard with ambient light sensor put the MacBook Pro in a class by itself.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Connect. Create. Communicate.&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;Quickly set up a video conference with the built-in iSight camera. Control presentations and media from up to 30 feet away with the included Apple Remote. Connect to high-bandwidth peripherals with FireWire 800 and DVI.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Next-generation wireless&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;Featuring 802.11n wireless technology, the MacBook Pro delivers up to five times the performance and up to twice the range of previous-generation technologies.&lt;/p&gt;
&lt;!-- cpt_container_end --&gt;',
				'meta_description' => 'Latest Intel mobile architecture Powered by the most advanced mobile processors from Intel, the new Core 2 Duo MacBook Pro is over 50% faster than the original Core.',
				'meta_keyword' => 'mobile, intel, macbook, macbook pro',
			),
			14 => 
			array (
				'product_id' => 46,
				'language_id' => 1,
				'name' => 'Sony VAIO',
				'description' => '&lt;p&gt;Unprecedented power. The next generation of processing technology has arrived. Built into the newest VAIO notebooks lies Intel\'s latest, most powerful innovation yet: Intel® Centrino® 2 processor technology. Boasting incredible speed, expanded wireless connectivity, enhanced multimedia support and greater energy efficiency, all the high-performance essentials are seamlessly combined into a single chip.&lt;/p&gt;
',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			15 => 
			array (
				'product_id' => 47,
				'language_id' => 1,
				'name' => 'HP LP3065',
				'description' => '&lt;p&gt;Stop your co-workers in their tracks with the stunning new 30-inch diagonal HP LP3065 Flat Panel Monitor. This flagship monitor features best-in-class performance and presentation features on a huge wide-aspect screen while letting you work as comfortably as possible - you might even forget you\'re at the office&lt;/p&gt;
',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			16 => 
			array (
				'product_id' => 48,
				'language_id' => 1,
				'name' => 'iPod Classic',
				'description' => '&lt;p&gt;&lt;strong&gt;More room to move.&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;With 80GB or 160GB of storage and up to 40 hours of battery life, the new iPod classic lets you enjoy up to 40,000 songs or up to 200 hours of video or any combination wherever you go.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Cover Flow.&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;Browse through your music collection by flipping through album art. Select an album to turn it over and see the track list.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Enhanced interface.&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;Experience a whole new way to browse and view your music and video.&lt;/p&gt;

&lt;p&gt;&lt;strong&gt;Sleeker design.&lt;/strong&gt;&lt;/p&gt;

&lt;p&gt;Beautiful, durable, and sleeker than ever, iPod classic now features an anodized aluminum and polished stainless steel enclosure with rounded edges.&lt;/p&gt;
&lt;!-- cpt_container_end --&gt;',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			17 => 
			array (
				'product_id' => 49,
				'language_id' => 1,
				'name' => 'Samsung Galaxy Tab 10.1',
				'description' => '&lt;p&gt;Samsung Galaxy Tab 10.1, is the world’s thinnest tablet, measuring 8.6 mm thickness, running with Android 3.0 Honeycomb OS on a 1GHz dual-core Tegra 2 processor, similar to its younger brother Samsung Galaxy Tab 8.9.&lt;/p&gt;

&lt;p&gt;Samsung Galaxy Tab 10.1 gives pure Android 3.0 experience, adding its new TouchWiz UX or TouchWiz 4.0 – includes a live panel, which lets you to customize with different content, such as your pictures, bookmarks, and social feeds, sporting a 10.1 inches WXGA capacitive touch screen with 1280 x 800 pixels of resolution, equipped with 3 megapixel rear camera with LED flash and a 2 megapixel front camera, HSPA+ connectivity up to 21Mbps, 720p HD video recording capability, 1080p HD playback, DLNA support, Bluetooth 2.1, USB 2.0, gyroscope, Wi-Fi 802.11 a/b/g/n, micro-SD slot, 3.5mm headphone jack, and SIM slot, including the Samsung Stick – a Bluetooth microphone that can be carried in a pocket like a pen and sound dock with powered subwoofer.&lt;/p&gt;

&lt;p&gt;Samsung Galaxy Tab 10.1 will come in 16GB / 32GB / 64GB verities and pre-loaded with Social Hub, Reader’s Hub, Music Hub and Samsung Mini Apps Tray – which gives you access to more commonly used apps to help ease multitasking and it is capable of Adobe Flash Player 10.2, powered by 6860mAh battery that gives you 10hours of video-playback time. äö&lt;/p&gt;
',
				'meta_description' => '',
				'meta_keyword' => '',
			),
			18 => 
			array (
				'product_id' => 50,
				'language_id' => 1,
				'name' => 'Dais.io Live Conference 2015',
				'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus feugiat dui a odio facilisis porta commodo ut ligula. Nullam ligula urna, blandit vel justo eu, tristique tempor nisl. Nam ornare auctor enim vel venenatis. Duis et elit augue. Nulla auctor nunc et ultrices lobortis. &lt;div&gt;&lt;br&gt;&lt;/div&gt;&lt;div&gt;Donec ultricies, metus quis convallis tincidunt, nisl nibh molestie tortor, et accumsan turpis nulla rhoncus libero. Donec hendrerit enim ut lectus condimentum malesuada.&lt;/div&gt;',
				'meta_description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus feugiat dui a odio facilisis porta commodo ut ligula. Nullam ligula urna, blandit vel justo eu,.',
				'meta_keyword' => 'ligula',
			),
		));
	}

}
