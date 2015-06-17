<?php

use Illuminate\Database\Seeder;

class EmailContentTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('email_content')->delete();
        
		\DB::table('email_content')->insert(array (
			0 => 
			array (
				'email_id' => 1,
				'language_id' => 1,
				'subject' => 'Forgotten Admin Email',
				'text' => 'Hi !fname!,

You, or someone claiming to be you has requested a new password for your customer account at !store_name!.

To reset your password click the link below:

!link!
',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hey !fname!,
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;p class=&quot;p1&quot;&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
You, or someone claiming to be you has requested a new password for your customer account at !store_name!.
&lt;/span&gt;
&lt;/p&gt;
&lt;p class=&quot;p2&quot;&gt;
&lt;/p&gt;
&lt;p class=&quot;p2&quot;&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
To reset your password, click the link below:&amp;nbsp;
&lt;/span&gt;
&lt;/p&gt;
&lt;p class=&quot;p2&quot;&gt;
&lt;a href=&quot;!link!&quot; target=&quot;_blank&quot; style=&quot;font-weight: bold;&quot;&gt;
!link!
&lt;/a&gt;
&lt;/p&gt;
&lt;p class=&quot;p2&quot;&gt;
&lt;br&gt;
&lt;/p&gt;',
			),
			1 => 
			array (
				'email_id' => 2,
				'language_id' => 1,
				'subject' => 'N/A',
				'text' => 'Hi !fname!,

!content!',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hi !fname!,
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;p class=&quot;p1&quot;&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
!content!
&lt;/span&gt;
&lt;/p&gt;
',
			),
			2 => 
			array (
				'email_id' => 3,
				'language_id' => 1,
				'subject' => 'You\'ve Been Added to an Event',
				'text' => 'Hi !fname!,

You\'ve been added to an event.

The event details are listed below:
---------------------------------------

!content!',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hi !fname!,
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;p&gt;
You\'ve been added to an event.
&lt;/p&gt;
&lt;p&gt;
The event details are listed below:
&lt;/p&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;div&gt;
!content!
&lt;/div&gt;',
			),
			3 => 
			array (
				'email_id' => 4,
				'language_id' => 1,
				'subject' => 'You\'ve Been Added to the Waitlist',
				'text' => 'Hi !fname!,

You\'ve been added to an event waitlist.

The event details are listed below:
---------------------------------------

!content!',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hi !fname!,
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;p&gt;
You\'ve been added to an event waitlist.
&lt;/p&gt;
&lt;p&gt;
The event details are listed below:
&lt;/p&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;div&gt;
!content!
&lt;/div&gt;',
			),
			4 => 
			array (
				'email_id' => 5,
				'language_id' => 1,
				'subject' => 'You\'ve Earned a Commission',
				'text' => 'Hi !fname!,

You\'ve just earned an affiliate commission.

Commission: !commission!

Total commission balance: !total!

Once the refund period of !days! days has elapsed, you\'ll be able to request payment of this commission from your member account.

Thanks for all your hard work, we really appreciate it.',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hi !fname!,
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;div&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
You\'ve just earned an affiliate commission.
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Commission: 
&lt;span style=&quot;font-weight: bold;&quot;&gt;
!commission!
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Total commission balance: 
&lt;span style=&quot;font-weight: bold;&quot;&gt;
!total!
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Once the refund period of !days! days has elapsed, you\'ll be able to request payment of this commission from your member account.
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Thanks for all your hard work, we really appreciate it.
&lt;/div&gt;',
			),
			5 => 
			array (
				'email_id' => 7,
				'language_id' => 1,
				'subject' => 'Your Customer Account Has Been Approved',
				'text' => 'Hey !fname!,

Your customer account has been approved and you can now login at:

!store_url!/login

Welcome to !store_name! and we look forward to serving you.
',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hi !fname!,
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;div&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
Your customer account has been approved and you can now login at:
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;a href=&quot;!store_url!/login&quot; target=&quot;_blank&quot;&gt;
!store_url!/login
&lt;/a&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Welcome to !store_name! and we look forward to serving you.
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;',
			),
			6 => 
			array (
				'email_id' => 8,
				'language_id' => 1,
				'subject' => 'Your Account Has Been Credited',
				'text' => 'Hey !fname!,

We\'ve added a store credit to your account.

Amount: !credit!

Total credit on your account: !total!

Have a great day.',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hi !fname!,
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;div&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
We\'ve added a store credit to your account.
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Amount: 
&lt;span style=&quot;font-weight: bold;&quot;&gt;
!credit!
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Total credit on your account: 
&lt;span style=&quot;font-weight: bold;&quot;&gt;
!total!
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Have a great day.
&lt;/div&gt;',
			),
			7 => 
			array (
				'email_id' => 9,
				'language_id' => 1,
				'subject' => 'You\'ve Earned Reward Points',
				'text' => 'Hi !fname!,

We just wanted to let you know you\'ve earned some reward points.

Points: !points!

Current total points: !total!

Have a great day.',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hi !fname!,
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;div&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
We just wanted to let you know you\'ve earned some reward points.
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Points: 
&lt;span style=&quot;font-weight: bold;&quot;&gt;
!points!
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Current total points: 
&lt;span style=&quot;font-weight: bold;&quot;&gt;
!total!
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Have a great day.
&lt;/div&gt;',
			),
			8 => 
			array (
				'email_id' => 10,
				'language_id' => 1,
				'subject' => 'Your Order Has Been Updated',
				'text' => 'Hi !fname!,

Your order number !order_id! has been updated to the following status:

Order Status: !status!

If you have an account with us you can view your order here:

!link!

Comments:

!comment!

Have a great day.',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hi !fname!,
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;div&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
Your order number 
&lt;span style=&quot;font-weight: bold;&quot;&gt;
!order_id!
&lt;/span&gt;
has been updated to the following status:
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Order Status: 
&lt;span style=&quot;font-weight: bold;&quot;&gt;
!status!
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
If you have an account with us you can view your order here:
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;a href=&quot;!link!&quot; target=&quot;_blank&quot;&gt;
!link!
&lt;/a&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Comments:
&lt;br&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;div style=&quot;padding: 15px;margin-bottom: 20px;border: 2px solid #faebcc;border-radius: 4px;background-color: #fcf8e3;color: #D7A663;&quot;&gt;
!comment!
&lt;/div&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Have a great day.
&lt;/div&gt;',
			),
			9 => 
			array (
				'email_id' => 11,
				'language_id' => 1,
				'subject' => 'Your Return Has Been Updated',
				'text' => 'Hi !fname!,

Your return number: !return_id! has been updated to the following status:

Return Status: !status!

If you have an account with us you can view your return here:

!link!

Comments:

!comment!

Have a great day.',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hi !fname!,
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;div&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
Your return number: 
&lt;span style=&quot;font-weight: bold;&quot;&gt;
!return_id!
&lt;/span&gt;
has been updated to the following status:
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Return Status: 
&lt;span style=&quot;font-weight: bold;&quot;&gt;
!status!
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
If you have an account with us you can view your return here:
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;a href=&quot;!link!&quot; target=&quot;_blank&quot;&gt;
!link!
&lt;/a&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Comments:
&lt;br&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;div style=&quot;padding: 15px;margin-bottom: 20px;border: 2px solid #faebcc;border-radius: 4px;background-color: #fcf8e3;color: #D7A663;&quot;&gt;
!comment!
&lt;/div&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Have a great day.
&lt;/div&gt;',
			),
			10 => 
			array (
				'email_id' => 12,
				'language_id' => 1,
				'subject' => 'You\'ve Received a Gift Card!',
				'text' => 'Hi !fname!,

Great news, you\'ve received a !store_name! gift card in the amount of !amount!

This gift card was sent to you by: 

!sender!
!sender_email!

!content!
To redeem this gift card, visit the !store_name! website here:

!store_url!

Select the items you\'d like to purchase, then apply the code below to your shopping cart.

Gift card code: !code!

Happy Shopping!',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hi !fname!,
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;div&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
Great news, you\'ve received a !store_name! gift card in the amount of 
&lt;span style=&quot;font-weight: bold;&quot;&gt;
!amount!
&lt;/span&gt;
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
This gift card was sent to you by: 
&lt;span style=&quot;font-weight: bold;&quot;&gt;
&lt;a href=&quot;mailto:!sender_email!&quot; target=&quot;_blank&quot;&gt;
!sender!
&lt;/a&gt;
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
!content!
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
To redeem this gift card, visit the !store_name! website here:
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;a href=&quot;!store_url!&quot; target=&quot;_blank&quot;&gt;
!store_url!
&lt;/a&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Select the items you\'d like to purchase, then apply the code below to your shopping cart.
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Gift card code: 
&lt;span style=&quot;font-weight: bold;&quot;&gt;
!code!
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;span style=&quot;font-weight: bold;&quot;&gt;
Happy Shopping!
&lt;/span&gt;
&lt;/div&gt;',
			),
			11 => 
			array (
				'email_id' => 14,
				'language_id' => 1,
				'subject' => 'You\'ve Been Added to the Waitlist',
				'text' => 'Hi !fname!,

The below listed event is currently sold out, so we\'ve added you to the waitlist.

If a seat becomes available, we\'ll contact you so that you can purchase a seat in this event.

The event details are listed below:
---------------------------------------

!content!',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hi !fname!,
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;p&gt;
The below listed event is currently sold out, so we\'ve added you to the waitlist.
&lt;/p&gt;
&lt;p&gt;
If a seat becomes available, we\'ll contact you so that you can purchase a seat in this event.
&lt;br&gt;
&lt;/p&gt;
&lt;p&gt;
The event details are listed below:
&lt;/p&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;p&gt;
!content!
&lt;/p&gt;
&lt;p&gt;
&lt;/p&gt;',
			),
			12 => 
			array (
				'email_id' => 15,
				'language_id' => 1,
				'subject' => 'Thank You for Your Order',
				'text' => 'Hi !fname!,

Thank so much for your order, we appreciate it a lot.

Below you\'ll find the details of your order.
--------------------------------
!content!

Thanks again and if you have any questions or problems feel free to email us or give us a call.
',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hi !fname!,
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;div&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
Thank so much for your order, we appreciate it a lot.
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Below you\'ll find the details of your order.
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;div&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
!content!
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;div&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
Thanks again and if you have any questions or problems feel free to email us or give us a call.
&lt;/span&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;',
			),
			13 => 
			array (
				'email_id' => 16,
				'language_id' => 1,
				'subject' => 'An Order Has Been Placed',
				'text' => 'Hey !fname!,

You have a new order on !store_name!.

Log into the admin area to view the details of this order.',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hey !fname!,
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;div&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
You have a new order on !store_name!.
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Log into the admin area to view the details of this order.
&lt;/div&gt;',
			),
			14 => 
			array (
				'email_id' => 18,
				'language_id' => 1,
				'subject' => 'Customer Password Reset',
				'text' => 'Hi !fname!,

You, or someone claiming to be you has requested a new password for your customer account at !store_name!.

To reset your password, click the link below:

!link!
',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hi !fname!
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;p class=&quot;p1&quot;&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
You, or someone claiming to be you has requested a new password for your customer account at !store_name!.
&lt;/span&gt;
&lt;/p&gt;
&lt;p class=&quot;p1&quot;&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
To reset your password, click the link below:
&lt;/span&gt;
&lt;/p&gt;
&lt;p class=&quot;p1&quot;&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
&lt;span style=&quot;font-weight: bold;&quot;&gt;
&lt;a href=&quot;!link!&quot; target=&quot;_blank&quot;&gt;
!link!
&lt;/a&gt;
&lt;/span&gt;
&lt;/span&gt;
&lt;/p&gt;
&lt;p class=&quot;p1&quot;&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
&lt;br&gt;
&lt;/span&gt;
&lt;/p&gt;',
			),
			15 => 
			array (
				'email_id' => 20,
				'language_id' => 1,
				'subject' => 'A Contact Request Has Been Sent',
				'text' => 'Hey !fname!,

You\'ve just received a contact form submission.

Here are the details:
-----------------------------------
Name: !name! 
Email: !email! 
Inquiry:

!inquiry!
----------------------------------- ',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hey !fname!,
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;div&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
You\'ve just received a contact form submission.
&lt;/span&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Here are the details:
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div style=&quot;padding: 15px;margin-bottom: 20px;border: 2px solid #faebcc;border-radius: 4px;background-color: #fcf8e3;color: #D7A663;&quot;&gt;
&lt;div&gt;
Name: !name!&amp;nbsp;
&lt;/div&gt;
&lt;div&gt;
Email: !email!&amp;nbsp;
&lt;/div&gt;
&lt;div&gt;
Inquiry:
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
!inquiry!
&lt;/div&gt;
&lt;/div&gt;',
			),
			16 => 
			array (
				'email_id' => 21,
				'language_id' => 1,
				'subject' => 'Your Contact Request Has Been Received',
				'text' => 'Hi !fname!,

Thanks for contacting us, we\'ve received your inquiry and we\'ll route it to the correct department right away.

Please allow us up to 48 hours to get back to you.',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hi !fname!,
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;div&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
Thanks for contacting us, we\'ve received your inquiry and we\'ll route it to the correct department right away.
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Please allow us up to 48 hours to get back to you.
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;',
			),
			17 => 
			array (
				'email_id' => 22,
				'language_id' => 1,
				'subject' => 'Your New Customer Account',
				'text' => 'Hi !fname!,

Welcome to !store_name!.

We’re really happy to have you as a customer and we look forward to serving you.

With your new !store_name! account you can track all your orders, re-order a previous order with a single click and if you didn’t do so when you signed up, you can enroll in our affiliate program and earn up to !percent!% on all the sales you refer to us.

If you have any question don’t be afraid to hit us up by email or by the telephone number below.',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hi !fname!
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;p class=&quot;p1&quot;&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
Welcome to !store_name!.
&lt;/span&gt;
&lt;/p&gt;
&lt;p class=&quot;p2&quot;&gt;
&lt;span class=&quot;s1&quot;&gt;
&lt;/span&gt;
&lt;/p&gt;
&lt;p class=&quot;p2&quot;&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
We’re really happy to have you as a customer and we look forward to serving you.
&lt;/span&gt;
&lt;br&gt;
&lt;span class=&quot;s1&quot;&gt;
&lt;/span&gt;
&lt;/p&gt;
&lt;p class=&quot;p2&quot;&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
With your new !store_name! account you can track all your orders, re-order a previous order with a single click and if you didn’t do so when you signed up, you can enroll in our affiliate program and earn up to !percent!% on all the sales you refer to us.
&lt;/span&gt;
&lt;br&gt;
&lt;span class=&quot;s1&quot;&gt;
&lt;/span&gt;
&lt;/p&gt;
&lt;p class=&quot;p2&quot;&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
If you have any question don’t be afraid to hit us up by email or by the telephone number below.
&lt;/span&gt;
&lt;br&gt;
&lt;span class=&quot;s1&quot;&gt;
&lt;/span&gt;
&lt;/p&gt;',
			),
			18 => 
			array (
				'email_id' => 23,
				'language_id' => 1,
				'subject' => 'New Customer Account Created',
				'text' => 'Hey !fname!,

You’ve had a new customer enrollment on !store_name!.

Here are the new customer’s details:

!customer_details!

To get further details, log in to the admin section of !store_name!.',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hey !fname!
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;p class=&quot;p1&quot;&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
You’ve had a new customer enrollment on !store_name!.
&lt;/span&gt;
&lt;br&gt;
&lt;/p&gt;
&lt;p class=&quot;p1&quot;&gt;
&lt;span class=&quot;s1&quot;&gt;
Here are the new customer’s details:
&lt;/span&gt;
&lt;/p&gt;
&lt;p class=&quot;p1&quot;&gt;
&lt;span class=&quot;s1&quot;&gt;
!customer_details!
&lt;/span&gt;
&lt;/p&gt;
&lt;p class=&quot;p2&quot;&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
To get further details, log in to the admin section of !store_name!.
&lt;/span&gt;
&lt;br&gt;
&lt;span class=&quot;s1&quot;&gt;
&lt;/span&gt;
&lt;/p&gt;',
			),
			19 => 
			array (
				'email_id' => 26,
				'language_id' => 1,
				'subject' => 'You\'ve Received a Gift Card!',
				'text' => 'Hi !fname!,

Great news, you\'ve received a !store_name! gift card in the amount of !amount!

This gift card was sent to you by: 

!sender!
!sender_email!

!content!
To redeem this gift card, visit the !store_name! website here:

!store_url!

Select the items you\'d like to purchase, then apply the code below to your shopping cart.

Gift card code: !code!

Happy Shopping!',
				'html' => '&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left:0 !important;padding-right: 32px&quot;&gt;
&lt;h1 style=&quot;margin-top: 0;color: #212425;font-weight: 700;font-size: 36px;margin-bottom: 18px;font-family: sans-serif;line-height: 44px&quot;&gt;
Hi !fname!,
&lt;/h1&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;div&gt;
&lt;span style=&quot;line-height: 1.428571429;&quot;&gt;
Great news, you\'ve received a !store_name! gift card in the amount of 
&lt;span style=&quot;font-weight: bold;&quot;&gt;
!amount!
&lt;/span&gt;
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
This gift card was sent to you by: 
&lt;span style=&quot;font-weight: bold;&quot;&gt;
&lt;a href=&quot;mailto:!sender_email!&quot; target=&quot;_blank&quot;&gt;
!sender!
&lt;/a&gt;
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
!content!
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
To redeem this gift card, visit the !store_name! website here:
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;a href=&quot;!store_url!&quot; target=&quot;_blank&quot;&gt;
!store_url!
&lt;/a&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;Select the items you\'d like to purchase, then apply the code below to your shopping cart.
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
Gift card code: 
&lt;span style=&quot;font-weight: bold;&quot;&gt;
!code!
&lt;/span&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;br&gt;
&lt;/div&gt;
&lt;div&gt;
&lt;span style=&quot;font-weight: bold;&quot;&gt;
Happy Shopping!
&lt;/span&gt;
&lt;/div&gt;',
			),
			20 => 
			array (
				'email_id' => 27,
				'language_id' => 1,
				'subject' => 'N/A',
				'text' => '!store_name!
========================================

!content!

!signature!

==========================
!store_name!
!store_url!

!store_address!
!store_phone!
-----------------------------------
You are receiving this because you\'re either a customer
or affiliate of !store_name!.

Change your preferences below:
!preference!

Unsubscribe:
!unsubscribe!
-----------------------------------
!twitter!
!facebook!',
				'html' => '    &lt;title&gt;
!subject!
&lt;/title&gt;
&lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;
&lt;meta name=&quot;viewport&quot; content=&quot;width=device-width&quot;&gt;
&lt;style type=&quot;text/css&quot;&gt;
body {
margin: 0;
mso-line-height-rule: exactly;
padding: 0;
min-width: 100%;
}
table {
border-collapse: collapse;
border-spacing: 0;
}
td {
padding: 0;
vertical-align: top;
}
.spacer,
.border {
font-size: 1px;
line-height: 1px;
}
.spacer {
width: 100%;
}
img {
border: 0;
-ms-interpolation-mode: bicubic;
}
.image {
font-size: 12px;
margin-bottom: 24px;
mso-line-height-rule: at-least;
}
.image img {
display: block;
}
.logo {
mso-line-height-rule: at-least;
}
.logo img {
display: block;
}
strong {
font-weight: bold;
}
h1,
h2,
h3,
p,
ol,
ul,
li {
margin-top: 0;
}
ol,
ul,
li {
padding-left: 0;
}
blockquote {
margin-top: 0;
margin-right: 0;
margin-bottom: 0;
padding-right: 0;
}
.column-top {
font-size: 32px;
line-height: 32px;
}
.column-bottom {
font-size: 8px;
line-height: 8px;
}
.column {
text-align: left;
}
.contents {
width: 100%;
}
.padded {
padding-left: 32px;
padding-right: 32px;
}
.wrapper {
display: table;
table-layout: fixed;
width: 100%;
min-width: 620px;
-webkit-text-size-adjust: 100%;
-ms-text-size-adjust: 100%;
}
table.wrapper {
table-layout: fixed;
}
.one-col,
.two-col,
.three-col {
margin-left: auto;
margin-right: auto;
width: 600px;
}
.centered {
margin-left: auto;
margin-right: auto;
}
.two-col .image {
margin-bottom: 23px;
}
.two-col .column-bottom {
font-size: 9px;
line-height: 9px;
}
.two-col .column {
width: 300px;
}
.three-col .image {
margin-bottom: 21px;
}
.three-col .column-bottom {
font-size: 11px;
line-height: 11px;
}
.three-col .column {
width: 200px;
}
.three-col .first .padded {
padding-left: 32px;
padding-right: 16px;
}
.three-col .second .padded {
padding-left: 24px;
padding-right: 24px;
}
.three-col .third .padded {
padding-left: 16px;
padding-right: 32px;
}
@media only screen and (min-width: 0), only screen and (min-device-width: 0) {
.wrapper {
text-rendering: optimizeLegibility;
}
}
@media only screen and (max-width: 620px), only screen and (max-device-width: 620px) {
[class=wrapper] {
min-width: 318px !important;
width: 100% !important;
}
[class=wrapper] .one-col,
[class=wrapper] .two-col,
[class=wrapper] .three-col {
width: 318px !important;
}
[class=wrapper] .column,
[class=wrapper] .gutter {
display: block;
float: left;
width: 318px !important;
}
[class=wrapper] .padded {
padding-left: 32px !important;
padding-right: 32px !important;
}
[class=wrapper] .block {
display: block !important;
}
[class=wrapper] .hide {
display: none !important;
}
[class=wrapper] .image {
margin-bottom: 24px !important;
}
[class=wrapper] .image img {
height: auto !important;
width: 100% !important;
}
}
.wrapper h1 {
font-weight: 700;
}
.wrapper h2 {
font-style: italic;
font-weight: normal;
}
.wrapper h3 {
font-weight: normal;
}
.one-col blockquote,
.two-col blockquote,
.three-col blockquote {
font-style: italic;
}
.one-col-feature h1 {
font-weight: normal;
}
.one-col-feature h2 {
font-style: normal;
font-weight: bold;
}
.one-col-feature h3 {
font-style: italic;
}
td.border {
width: 1px;
}
tr.border {
background-color: #e9e9e9;
height: 1px;
}
tr.border td {
line-height: 1px;
}
.one-col,
.two-col,
.three-col,
.one-col-feature {
background-color: #ffffff;
font-size: 14px;
}
.one-col,
.two-col,
.three-col,
.one-col-feature,
.preheader,
.header,
.footer {
margin-left: auto;
margin-right: auto;
}
.preheader table {
width: 602px;
}
.preheader .title,
.preheader .webversion {
padding-top: 10px;
padding-bottom: 12px;
font-size: 12px;
line-height: 21px;
}
.preheader .title {
text-align: left;
}
.preheader .webversion {
text-align: right;
width: 300px;
}
.header {
width: 602px;
}
.header .logo {
padding: 32px 0;
}
.header .logo div {
font-size: 26px;
font-weight: 700;
letter-spacing: -0.02em;
line-height: 32px;
}
.header .logo div a {
text-decoration: none;
}
.header .logo div.logo-center {
text-align: center;
}
.header .logo div.logo-center img {
margin-left: auto;
margin-right: auto;
}
.gmail {
width: 650px;
min-width: 650px;
}
.gmail td {
font-size: 1px;
line-height: 1px;
}
.wrapper a {
text-decoration: underline;
transition: all .2s;
}
.wrapper h1 {
font-size: 36px;
margin-bottom: 18px;
}
.wrapper h2 {
font-size: 26px;
line-height: 32px;
margin-bottom: 20px;
}
.wrapper h3 {
font-size: 18px;
line-height: 22px;
margin-bottom: 16px;
}
.wrapper h1 a,
.wrapper h2 a,
.wrapper h3 a {
text-decoration: none;
}
.one-col blockquote,
.two-col blockquote,
.three-col blockquote {
font-size: 14px;
border-left: 2px solid #e9e9e9;
margin-left: 0;
padding-left: 16px;
}
table.divider {
width: 100%;
}
.divider .inner {
padding-bottom: 24px;
}
.divider table {
background-color: #e9e9e9;
font-size: 2px;
line-height: 2px;
width: 60px;
}
.wrapper .gray {
background-color: #f7f7f7;
}
.wrapper .gray blockquote {
border-left-color: #dddddd;
}
.wrapper .gray .divider table {
background-color: #dddddd;
}
.padded .image {
font-size: 0;
}
.image-frame {
padding: 8px;
}
.image-background {
display: inline-block;
font-size: 12px;
}
.btn {
margin-bottom: 24px;
padding: 2px;
}
.btn a {
border: 1px solid #ffffff;
display: inline-block;
font-size: 13px;
font-weight: bold;
line-height: 15px;
outline-style: solid;
outline-width: 2px;
padding: 10px 30px;
text-align: center;
text-decoration: none !important;
}
.one-col .column table:nth-last-child(2) td h1:last-child,
.one-col .column table:nth-last-child(2) td h2:last-child,
.one-col .column table:nth-last-child(2) td h3:last-child,
.one-col .column table:nth-last-child(2) td p:last-child,
.one-col .column table:nth-last-child(2) td ol:last-child,
.one-col .column table:nth-last-child(2) td ul:last-child {
margin-bottom: 24px;
}
.one-col p,
.one-col ol,
.one-col ul {
font-size: 16px;
line-height: 24px;
}
.one-col ol,
.one-col ul {
margin-left: 18px;
}
.two-col .column table:nth-last-child(2) td h1:last-child,
.two-col .column table:nth-last-child(2) td h2:last-child,
.two-col .column table:nth-last-child(2) td h3:last-child,
.two-col .column table:nth-last-child(2) td p:last-child,
.two-col .column table:nth-last-child(2) td ol:last-child,
.two-col .column table:nth-last-child(2) td ul:last-child {
margin-bottom: 23px;
}
.two-col .image-frame {
padding: 6px;
}
.two-col h1 {
font-size: 26px;
line-height: 32px;
margin-bottom: 16px;
}
.two-col h2 {
font-size: 20px;
line-height: 26px;
margin-bottom: 18px;
}
.two-col h3 {
font-size: 16px;
line-height: 20px;
margin-bottom: 14px;
}
.two-col p,
.two-col ol,
.two-col ul {
font-size: 14px;
line-height: 23px;
}
.two-col ol,
.two-col ul {
margin-left: 16px;
}
.two-col li {
padding-left: 5px;
}
.two-col .divider .inner {
padding-bottom: 23px;
}
.two-col .btn {
margin-bottom: 23px;
}
.two-col blockquote {
padding-left: 16px;
}
.three-col .column table:nth-last-child(2) td h1:last-child,
.three-col .column table:nth-last-child(2) td h2:last-child,
.three-col .column table:nth-last-child(2) td h3:last-child,
.three-col .column table:nth-last-child(2) td p:last-child,
.three-col .column table:nth-last-child(2) td ol:last-child,
.three-col .column table:nth-last-child(2) td ul:last-child {
margin-bottom: 21px;
}
.three-col .image-frame {
padding: 4px;
}
.three-col h1 {
font-size: 20px;
line-height: 26px;
margin-bottom: 12px;
}
.three-col h2 {
font-size: 16px;
line-height: 22px;
margin-bottom: 14px;
}
.three-col h3 {
font-size: 14px;
line-height: 18px;
margin-bottom: 10px;
}
.three-col p,
.three-col ol,
.three-col ul {
font-size: 12px;
line-height: 21px;
}
.three-col ol,
.three-col ul {
margin-left: 14px;
}
.three-col li {
padding-left: 6px;
}
.three-col .divider .inner {
padding-bottom: 21px;
}
.three-col .btn {
margin-bottom: 21px;
}
.three-col .btn a {
font-size: 12px;
line-height: 14px;
padding: 8px 19px;
}
.three-col blockquote {
padding-left: 16px;
}
.one-col-feature .column-top {
font-size: 36px;
line-height: 36px;
}
.one-col-feature .column-bottom {
font-size: 4px;
line-height: 4px;
}
.one-col-feature .column {
text-align: center;
width: 600px;
}
.one-col-feature .image {
margin-bottom: 32px;
}
.one-col-feature .column table:nth-last-child(2) td h1:last-child,
.one-col-feature .column table:nth-last-child(2) td h2:last-child,
.one-col-feature .column table:nth-last-child(2) td h3:last-child,
.one-col-feature .column table:nth-last-child(2) td p:last-child,
.one-col-feature .column table:nth-last-child(2) td ol:last-child,
.one-col-feature .column table:nth-last-child(2) td ul:last-child {
margin-bottom: 32px;
}
.one-col-feature h1,
.one-col-feature h2,
.one-col-feature h3 {
text-align: center;
}
.one-col-feature h1 {
font-size: 52px;
margin-bottom: 22px;
}
.one-col-feature h2 {
font-size: 42px;
margin-bottom: 20px;
}
.one-col-feature h3 {
font-size: 32px;
line-height: 42px;
margin-bottom: 20px;
}
.one-col-feature p,
.one-col-feature ol,
.one-col-feature ul {
font-size: 21px;
line-height: 32px;
margin-bottom: 32px;
}
.one-col-feature p a,
.one-col-feature ol a,
.one-col-feature ul a {
text-decoration: none;
}
.one-col-feature p {
text-align: center;
}
.one-col-feature ol,
.one-col-feature ul {
margin-left: 40px;
text-align: left;
}
.one-col-feature li {
padding-left: 3px;
}
.one-col-feature .btn {
margin-bottom: 32px;
text-align: center;
}
.one-col-feature .divider .inner {
padding-bottom: 32px;
}
.one-col-feature blockquote {
border-bottom: 2px solid #e9e9e9;
border-left-color: #ffffff;
border-left-width: 0;
border-left-style: none;
border-top: 2px solid #e9e9e9;
margin-bottom: 32px;
margin-left: 0;
padding-bottom: 42px;
padding-left: 0;
padding-top: 42px;
position: relative;
}
.one-col-feature blockquote:before,
.one-col-feature blockquote:after {
background: -moz-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
background: -webkit-gradient(linear, left top, right top, color-stop(25%, #ffffff), color-stop(25%, #e9e9e9), color-stop(75%, #e9e9e9), color-stop(75%, #ffffff));
background: -webkit-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
background: -o-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
background: -ms-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
background: linear-gradient(to right, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
content: \'\';
display: block;
height: 2px;
left: 0;
outline: 1px solid #ffffff;
position: absolute;
right: 0;
}
.one-col-feature blockquote:before {
top: -2px;
}
.one-col-feature blockquote:after {
bottom: -2px;
}
.one-col-feature blockquote p,
.one-col-feature blockquote ol,
.one-col-feature blockquote ul {
font-size: 42px;
line-height: 48px;
margin-bottom: 48px;
}
.one-col-feature blockquote p:last-child,
.one-col-feature blockquote ol:last-child,
.one-col-feature blockquote ul:last-child {
margin-bottom: 0 !important;
}
.footer {
width: 602px;
}
.footer .padded {
font-size: 12px;
line-height: 20px;
}
.social {
padding-top: 32px;
padding-bottom: 22px;
}
.social img {
display: block;
}
.social .divider {
font-family: sans-serif;
font-size: 10px;
line-height: 21px;
text-align: center;
padding-left: 14px;
padding-right: 14px;
}
.social .social-text {
height: 21px;
vertical-align: middle !important;
font-size: 10px;
font-weight: bold;
text-decoration: none;
text-transform: uppercase;
}
.social .social-text a {
text-decoration: none;
}
.address {
width: 250px;
}
.address .padded {
text-align: left;
padding-left: 0;
padding-right: 10px;
}
.subscription {
width: 350px;
}
.subscription .padded {
text-align: right;
padding-right: 0;
padding-left: 10px;
}
.address,
.subscription {
padding-top: 32px;
padding-bottom: 64px;
}
.address a,
.subscription a {
font-weight: bold;
text-decoration: none;
}
.address table,
.subscription table {
width: 100%;
}
@media only screen and (max-width: 651px), only screen and (max-device-width: 651px) {
.gmail {
display: none !important;
}
}
@media only screen and (max-width: 620px), only screen and (max-device-width: 620px) {
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td h1:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td h1:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td h1:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td h1:last-child,
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td h2:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td h2:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td h2:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td h2:last-child,
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td h3:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td h3:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td h3:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td h3:last-child,
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td p:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td p:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td p:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td p:last-child,
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td ol:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td ol:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td ol:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td ol:last-child,
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td ul:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td ul:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td ul:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td ul:last-child {
margin-bottom: 24px !important;
}
[class=wrapper] .address,
[class=wrapper] .subscription {
display: block;
float: left;
width: 318px !important;
text-align: center !important;
}
[class=wrapper] .address {
padding-bottom: 0 !important;
}
[class=wrapper] .subscription {
padding-top: 0 !important;
}
[class=wrapper] h1 {
font-size: 36px !important;
line-height: 42px !important;
margin-bottom: 18px !important;
}
[class=wrapper] h2 {
font-size: 26px !important;
line-height: 32px !important;
margin-bottom: 20px !important;
}
[class=wrapper] h3 {
font-size: 18px !important;
line-height: 22px !important;
margin-bottom: 16px !important;
}
[class=wrapper] p,
[class=wrapper] ol,
[class=wrapper] ul {
font-size: 16px !important;
line-height: 24px !important;
margin-bottom: 24px !important;
}
[class=wrapper] ol,
[class=wrapper] ul {
margin-left: 18px !important;
}
[class=wrapper] li {
padding-left: 2px !important;
}
[class=wrapper] blockquote {
padding-left: 16px !important;
}
[class=wrapper] .two-col .column:nth-child(n + 3) {
border-top: 1px solid #e9e9e9;
}
[class=wrapper] .btn {
margin-bottom: 24px !important;
}
[class=wrapper] .btn a {
display: block !important;
font-size: 13px !important;
font-weight: bold !important;
line-height: 15px !important;
padding: 10px 30px !important;
}
[class=wrapper] .column-bottom {
font-size: 8px !important;
line-height: 8px !important;
}
[class=wrapper] .first .column-bottom,
[class=wrapper] .three-col .second .column-bottom {
display: none;
}
[class=wrapper] .second .column-top,
[class=wrapper] .third .column-top {
display: none;
}
[class=wrapper] .image-frame {
padding: 4px !important;
}
[class=wrapper] .header .logo {
padding-left: 10px !important;
padding-right: 10px !important;
}
[class=wrapper] .header .logo div {
font-size: 26px !important;
line-height: 32px !important;
}
[class=wrapper] .header .logo div img {
display: inline-block !important;
max-width: 280px !important;
height: auto !important;
}
[class=wrapper] table.border,
[class=wrapper] .header,
[class=wrapper] .webversion,
[class=wrapper] .footer {
width: 320px !important;
}
[class=wrapper] .preheader .webversion,
[class=wrapper] .header .logo a {
text-align: center !important;
}
[class=wrapper] .preheader table,
[class=wrapper] .border td {
width: 318px !important;
}
[class=wrapper] .border td.border {
width: 1px !important;
}
[class=wrapper] .image .border td {
width: auto !important;
}
[class=wrapper] .title {
display: none;
}
[class=wrapper] .footer .padded {
text-align: center !important;
}
[class=wrapper] .footer .subscription .padded {
padding-top: 20px !important;
}
[class=wrapper] .footer .social-link {
display: block !important;
}
[class=wrapper] .footer .social-link table {
margin: 0 auto 10px !important;
}
[class=wrapper] .footer .divider {
display: none !important;
}
[class=wrapper] .one-col-feature .btn {
margin-bottom: 28px !important;
}
[class=wrapper] .one-col-feature .image {
margin-bottom: 28px !important;
}
[class=wrapper] .one-col-feature .divider .inner {
padding-bottom: 28px !important;
}
[class=wrapper] .one-col-feature h1 {
font-size: 42px !important;
line-height: 48px !important;
margin-bottom: 20px !important;
}
[class=wrapper] .one-col-feature h2 {
font-size: 32px !important;
line-height: 36px !important;
margin-bottom: 18px !important;
}
[class=wrapper] .one-col-feature h3 {
font-size: 26px !important;
line-height: 32px !important;
margin-bottom: 20px !important;
}
[class=wrapper] .one-col-feature p,
[class=wrapper] .one-col-feature ol,
[class=wrapper] .one-col-feature ul {
font-size: 20px !important;
line-height: 28px !important;
margin-bottom: 28px !important;
}
[class=wrapper] .one-col-feature blockquote {
font-size: 18px !important;
line-height: 26px !important;
margin-bottom: 28px !important;
padding-bottom: 26px !important;
padding-left: 0 !important;
padding-top: 26px !important;
}
[class=wrapper] .one-col-feature blockquote p,
[class=wrapper] .one-col-feature blockquote ol,
[class=wrapper] .one-col-feature blockquote ul {
font-size: 26px !important;
line-height: 32px !important;
}
[class=wrapper] .one-col-feature blockquote p:last-child,
[class=wrapper] .one-col-feature blockquote ol:last-child,
[class=wrapper] .one-col-feature blockquote ul:last-child {
margin-bottom: 0 !important;
}
[class=wrapper] .one-col-feature .column table:last-of-type h1:last-child,
[class=wrapper] .one-col-feature .column table:last-of-type h2:last-child,
[class=wrapper] .one-col-feature .column table:last-of-type h3:last-child {
margin-bottom: 28px !important;
}
}
@media only screen and (max-width: 320px), only screen and (max-device-width: 320px) {
[class=wrapper] td.border {
display: none;
}
[class=wrapper] table.border,
[class=wrapper] .header,
[class=wrapper] .webversion,
[class=wrapper] .footer {
width: 318px !important;
}
}
&lt;/style&gt;
&lt;!--[if gte mso 9]&gt;
&lt;style&gt;
.column-top {
mso-line-height-rule: exactly !important;
}
&lt;/style&gt;
&lt;![endif]--&gt;
&lt;meta name=&quot;robots&quot; content=&quot;noindex,nofollow&quot;&gt;
&lt;meta property=&quot;og:title&quot; content=&quot;!subject!&quot;&gt;


&lt;style type=&quot;text/css&quot;&gt;
body,.wrapper,.emb-editor-canvas{background-color:#e9e8dd}.border{background-color:#d9d8ce}h1{color:#212425}.wrapper h1{}.wrapper h1{font-family:sans-serif}h1{}.one-col h1{line-height:44px}.two-col h1{line-height:32px}.three-col h1{line-height:26px}.wrapper .one-col-feature h1{line-height:58px}@media only screen and (max-width: 620px),only screen and (max-device-width: 620px){h1{line-height:44px !important}}h2{color:#212425}.wrapper h2{}.wrapper h2{font-family:sans-serif}h2{}.one-col h2{line-height:34px}.two-col h2{line-height:26px}.three-col h2{line-height:22px}.wrapper .one-col-feature h2{line-height:50px}@media only screen and (max-width: 620px), only screen and (max-device-width: 620px){h2{line-height:34px !important}}h3{color:#212425}.wrapper h3{}.wrapper h3{font-family:sans-serif}h3{}.one-col h3{line-height:26px}.two-col h3{line-height:22px}.three-col h3{line-height:20px}.wrapper .one-col-feature h3{line-height:40px}@media only screen and (max-width:620px), only screen and (max-device-width: 620px){h3{line-height:26px !important}}p,ol,ul{color:#212425}.wrapper p,.wrapper ol,.wrapper ul{}.wrapper p,.wrapper ol,.wrapper ul{font-family:sans-serif}p,ol,ul{}.one-col p,.one-col ol,.one-col ul{line-height:24px;margin-bottom:24px}.two-col p,.two-col ol,.two-col ul{line-height:22px;margin-bottom:22px}.three-col p,.three-col ol,.three-col ul{line-height:20px;margin-bottom:20px}.wrapper .one-col-feature p,.wrapper .one-col-feature ol,.wrapper .one-col-feature ul{line-height:29px}.one-col-feature blockquote p,.one-col-feature blockquote ol,.one-col-feature blockquote ul{line-height:48px}@media only screen and (max-width: 620px), only screen and (max-device-width: 620px){p,ol,ul{line-height:24px !important;margin-bottom:24px !important}}.image{color:#212425}.image{font-family:sans-serif}.wrapper a{color:#5ba4e5}.wrapper a:hover{color:#2f8cde !important}.wrapper .logo div{color:#41637e}.wrapper .logo div{font-family:sans-serif}@media only screen and (min-width: 0), only screen and (min-device-width: 0){.wrapper .logo div{font-family:sans-serif !important}}.wrapper .logo div a{color:#41637e}.wrapper .logo div a:hover{color:#41637e !important}.wrapper .one-col-feature p a,.wrapper .one-col-feature ol a,.wrapper .one-col-feature ul a{border-bottom:1px solid #5ba4e5}.wrapper .one-col-feature p a:hover,.wrapper .one-col-feature ol a:hover,.wrapper .one-col-feature ul a:hover{color:#2f8cde !important;border-bottom:1px solid #2f8cde !important}.btn a{}.wrapper .btn a{}.wrapper .btn a{font-family:sans-serif}.wrapper .btn a{background-color:#83969f;color:#fff !important;outline-color:#83969f;text-shadow:0 1px 0 #76878f}.wrapper .btn a:hover{background-color:#76878f !important;color:#fff !important;outline-color:#76878f !important}.preheader .title,.preheader .webversion,.footer .padded{color:#5e5e5e}.preheader .title,.preheader .webversion,.footer .padded{font-family:sans-serif}.preheader .title a,.preheader .webversion a,.footer .padded a{color:#5e5e5e}.preheader .title a:hover,.preheader .webversion a:hover,.footer .padded a:hover{color:#383838 !important}.footer .social .divider{color:#d9d8ce}.footer .social .social-text,.footer .social a{color:#5e5e5e}.wrapper .footer .social .social-text,.wrapper .footer .social a{}.wrapper .footer .social .social-text,.wrapper .footer .social a{font-family:sans-serif}.footer .social .social-text,.footer .social a{}.footer .social .social-text,.footer .social a{letter-spacing:0.05em}.footer .social .social-text:hover,.footer .social a:hover{color:#383838 !important}.image .border{background-color:#c8c8c8}.image-frame{background-color:#dadada}.image-background{background-color:#f7f7f7}@media only screen and (max-width: 620px), only screen and (max-device-width: 620px){[class=wrapper] h2.card-store{font-size:14px !important;top: 20px !important;right: 30px !important;}[class=wrapper] h3.card-text{font-size:12px !important;top: 40px !important;right: 30px !important;}[class=wrapper] h3.card-name{font-size:12px !important;bottom: 20px !important;right: 30px !important;}[class=wrapper] h3.card-code{font-size:12px !important;bottom: 6px !important;right: 30px !important;}}
&lt;/style&gt;
&lt;center class=&quot;wrapper&quot; style=&quot;display: table;table-layout: fixed;width: 100%;min-width: 620px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background-color: #e9e8dd&quot;&gt;
&lt;table class=&quot;gmail&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 650px;min-width: 650px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top;font-size: 1px;line-height: 1px&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;preheader centered&quot; style=&quot;border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;width: 602px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;title&quot; style=&quot;padding: 0;vertical-align: top;padding-top: 10px;padding-bottom: 12px;font-size: 12px;line-height: 21px;text-align: left;color: #5e5e5e;font-family: sans-serif&quot;&gt;
!subject!
&lt;/td&gt;
&lt;td class=&quot;webversion&quot; style=&quot;padding: 0;vertical-align: top;padding-top: 10px;padding-bottom: 12px;font-size: 12px;line-height: 21px;text-align: right;width: 300px;color: #5e5e5e;font-family: sans-serif&quot;&gt;
No Images? 
&lt;a href=&quot;!webversion!&quot; class=&quot;webversion&quot; style=&quot;font-weight:bold;text-decoration:none;&quot;&gt;
Click here
&lt;/a&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;header centered&quot; style=&quot;border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto;width: 602px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;border&quot; style=&quot;padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #d9d8ce;width: 1px&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;tr&gt;
&lt;td class=&quot;logo&quot; style=&quot;padding: 32px 0;vertical-align: top;mso-line-height-rule: at-least&quot;&gt;
&lt;div class=&quot;logo-center&quot; style=&quot;font-size: 26px;font-weight: 700;letter-spacing: -0.02em;line-height: 32px;color: #41637e;font-family: sans-serif;text-align: center&quot; align=&quot;center&quot; id=&quot;emb-email-header&quot;&gt;
&lt;a style=&quot;text-decoration: none;transition: all .2s;color: #41637e&quot; href=&quot;!store_url!&quot;&gt;
&lt;img style=&quot;border: 0;-ms-interpolation-mode: bicubic;display: block;margin-left: auto;margin-right: auto;max-width: 405px&quot; src=&quot;!store_url!/image/data/email/logo.png&quot; alt=&quot;!store_url!&quot; width=&quot;405&quot; height=&quot;98&quot;&gt;
&lt;/a&gt;
&lt;/div&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;

&lt;table class=&quot;border&quot; style=&quot;border-collapse: collapse;border-spacing: 0;font-size: 1px;line-height: 1px;background-color: #d9d8ce;margin-left: auto;margin-right: auto&quot; width=&quot;602&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
​
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;

&lt;table class=&quot;centered&quot; style=&quot;border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;border&quot; style=&quot;padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #d9d8ce;width: 1px&quot;&gt;
​
&lt;/td&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&lt;table class=&quot;one-col&quot; style=&quot;border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto;width: 600px;background-color: #ffffff;font-size: 14px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;column&quot; style=&quot;padding: 0;vertical-align: top;text-align: left&quot;&gt;
&lt;div&gt;
&lt;div class=&quot;column-top&quot; style=&quot;font-size: 32px;line-height: 32px&quot;&gt;
&amp;nbsp;
&lt;/div&gt;
&lt;/div&gt;




&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;

&lt;div style=&quot;margin-top: 0;color: #212425;font-family: sans-serif;font-size: 16px;line-height: 24px;margin-bottom: 24px&quot;&gt;
!content!
&lt;/div&gt;

&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;

&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;

&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;

&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;

&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
!signature!
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;

&lt;div class=&quot;column-bottom&quot; style=&quot;font-size: 8px;line-height: 8px&quot;&gt;
&amp;nbsp;
&lt;/div&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;td class=&quot;border&quot; style=&quot;padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #d9d8ce;width: 1px&quot;&gt;
​
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;

&lt;table class=&quot;border&quot; style=&quot;border-collapse: collapse;border-spacing: 0;font-size: 1px;line-height: 1px;background-color: #d9d8ce;margin-left: auto;margin-right: auto&quot; width=&quot;602&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
​
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;

&lt;div class=&quot;spacer&quot; style=&quot;font-size: 1px;line-height: 32px;width: 100%&quot;&gt;
&amp;nbsp;
&lt;/div&gt;
&lt;table class=&quot;footer centered&quot; style=&quot;border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto;width: 602px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;social&quot; style=&quot;padding: 0;vertical-align: top;padding-top: 32px;padding-bottom: 22px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;social-link&quot; style=&quot;padding: 0;vertical-align: top&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&lt;fblike style=&quot;text-decoration:none;&quot;&gt;
&lt;img style=&quot;border: 0;-ms-interpolation-mode: bicubic;display: block&quot; src=&quot;!store_url!/image/data/email/facebook-dark.png&quot; width=&quot;26&quot; height=&quot;21&quot;&gt;
&lt;/fblike&gt;
&lt;/td&gt;
&lt;td class=&quot;social-text&quot; style=&quot;padding: 0;vertical-align: middle !important;height: 21px;font-size: 10px;font-weight: bold;text-decoration: none;text-transform: uppercase;color: #5e5e5e;letter-spacing: 0.05em;font-family: sans-serif&quot;&gt;
&lt;a href=&quot;!facebook!&quot; class=&quot;fblike&quot; style=&quot;text-decoration:none;&quot;&gt;
Like
&lt;/a&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;td class=&quot;divider&quot; style=&quot;padding: 0;vertical-align: top;font-family: sans-serif;font-size: 10px;line-height: 21px;text-align: center;padding-left: 14px;padding-right: 14px;color: #d9d8ce&quot;&gt;
&lt;img style=&quot;border: 0;-ms-interpolation-mode: bicubic;display: block&quot; src=&quot;!store_url!/image/data/email/diamond.png&quot; width=&quot;5&quot; height=&quot;21&quot; alt=&quot;&quot;&gt;
&lt;/td&gt;
&lt;td class=&quot;social-link&quot; style=&quot;padding: 0;vertical-align: top&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&lt;tweet style=&quot;text-decoration:none;&quot;&gt;
&lt;img style=&quot;border: 0;-ms-interpolation-mode: bicubic;display: block&quot; src=&quot;!store_url!/image/data/email/twitter-dark.png&quot; width=&quot;26&quot; height=&quot;21&quot;&gt;
&lt;/tweet&gt;
&lt;/td&gt;
&lt;td class=&quot;social-text&quot; style=&quot;padding: 0;vertical-align: middle !important;height: 21px;font-size: 10px;font-weight: bold;text-decoration: none;text-transform: uppercase;color: #5e5e5e;letter-spacing: 0.05em;font-family: sans-serif&quot;&gt;
&lt;a href=&quot;!twitter!&quot; class=&quot;tweet&quot; style=&quot;text-decoration:none;&quot;&gt;
Tweet
&lt;/a&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;

&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;tr&gt;
&lt;td class=&quot;border&quot; style=&quot;padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #d9d8ce;width: 1px&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;address&quot; style=&quot;padding: 0;vertical-align: top;width: 250px;padding-top: 32px;padding-bottom: 64px&quot;&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 0;padding-right: 10px;text-align: left;font-size: 12px;line-height: 20px;color: #5e5e5e;font-family: sans-serif&quot;&gt;
&lt;div&gt;
!store_name!
&lt;br&gt;
!store_address!
&lt;br&gt;
!store_phone!
&lt;/div&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;td class=&quot;subscription&quot; style=&quot;padding: 0;vertical-align: top;width: 350px;padding-top: 32px;padding-bottom: 64px&quot;&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 10px;padding-right: 0;font-size: 12px;line-height: 20px;color: #5e5e5e;font-family: sans-serif;text-align: right&quot;&gt;
&lt;div&gt;
You\'re receiving this email because you\'re either a customer or affiliate of !store_name!. Change your preferences below.
&lt;/div&gt;
&lt;div&gt;
&lt;span class=&quot;block&quot;&gt;
&lt;span&gt;
&lt;a href=&quot;!preference!&quot; class=&quot;preferences&quot; style=&quot;font-weight:bold;text-decoration:none;&quot; lang=&quot;en&quot;&gt;
Preferences
&lt;/a&gt;
&lt;span class=&quot;hide&quot;&gt;
&amp;nbsp;&amp;nbsp;|&amp;nbsp;&amp;nbsp;
&lt;/span&gt;
&lt;/span&gt;
&lt;/span&gt;
&lt;span class=&quot;block&quot;&gt;
&lt;a href=&quot;!unsubscribe!&quot; class=&quot;unsubscribe&quot; style=&quot;font-weight:bold;text-decoration:none;&quot;&gt;
Unsubscribe
&lt;/a&gt;
&lt;/span&gt;
&lt;/div&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/center&gt;

',
			),
			21 => 
			array (
				'email_id' => 28,
				'language_id' => 1,
				'subject' => 'N/A',
				'text' => '!store_name!
========================================

!content!

!signature!

==========================
!store_name!
!store_url!

!store_address!
!store_phone!
-----------------------------------
You are receiving this because you\'re either a customer
or affiliate of !store_name!.

Change your preferences below:
!preference!
-----------------------------------
!twitter!
!facebook!',
				'html' => '    &lt;title&gt;
!subject!
&lt;/title&gt;
&lt;meta http-equiv=&quot;Content-Type&quot; content=&quot;text/html; charset=utf-8&quot;&gt;
&lt;meta name=&quot;viewport&quot; content=&quot;width=device-width&quot;&gt;
&lt;style type=&quot;text/css&quot;&gt;
body {
margin: 0;
mso-line-height-rule: exactly;
padding: 0;
min-width: 100%;
}
table {
border-collapse: collapse;
border-spacing: 0;
}
td {
padding: 0;
vertical-align: top;
}
.spacer,
.border {
font-size: 1px;
line-height: 1px;
}
.spacer {
width: 100%;
}
img {
border: 0;
-ms-interpolation-mode: bicubic;
}
.image {
font-size: 12px;
margin-bottom: 24px;
mso-line-height-rule: at-least;
}
.image img {
display: block;
}
.logo {
mso-line-height-rule: at-least;
}
.logo img {
display: block;
}
strong {
font-weight: bold;
}
h1,
h2,
h3,
p,
ol,
ul,
li {
margin-top: 0;
}
ol,
ul,
li {
padding-left: 0;
}
blockquote {
margin-top: 0;
margin-right: 0;
margin-bottom: 0;
padding-right: 0;
}
.column-top {
font-size: 32px;
line-height: 32px;
}
.column-bottom {
font-size: 8px;
line-height: 8px;
}
.column {
text-align: left;
}
.contents {
width: 100%;
}
.padded {
padding-left: 32px;
padding-right: 32px;
}
.wrapper {
display: table;
table-layout: fixed;
width: 100%;
min-width: 620px;
-webkit-text-size-adjust: 100%;
-ms-text-size-adjust: 100%;
}
table.wrapper {
table-layout: fixed;
}
.one-col,
.two-col,
.three-col {
margin-left: auto;
margin-right: auto;
width: 600px;
}
.centered {
margin-left: auto;
margin-right: auto;
}
.two-col .image {
margin-bottom: 23px;
}
.two-col .column-bottom {
font-size: 9px;
line-height: 9px;
}
.two-col .column {
width: 300px;
}
.three-col .image {
margin-bottom: 21px;
}
.three-col .column-bottom {
font-size: 11px;
line-height: 11px;
}
.three-col .column {
width: 200px;
}
.three-col .first .padded {
padding-left: 32px;
padding-right: 16px;
}
.three-col .second .padded {
padding-left: 24px;
padding-right: 24px;
}
.three-col .third .padded {
padding-left: 16px;
padding-right: 32px;
}
@media only screen and (min-width: 0), only screen and (min-device-width: 0) {
.wrapper {
text-rendering: optimizeLegibility;
}
}
@media only screen and (max-width: 620px), only screen and (max-device-width: 620px) {
[class=wrapper] {
min-width: 318px !important;
width: 100% !important;
}
[class=wrapper] .one-col,
[class=wrapper] .two-col,
[class=wrapper] .three-col {
width: 318px !important;
}
[class=wrapper] .column,
[class=wrapper] .gutter {
display: block;
float: left;
width: 318px !important;
}
[class=wrapper] .padded {
padding-left: 32px !important;
padding-right: 32px !important;
}
[class=wrapper] .block {
display: block !important;
}
[class=wrapper] .hide {
display: none !important;
}
[class=wrapper] .image {
margin-bottom: 24px !important;
}
[class=wrapper] .image img {
height: auto !important;
width: 100% !important;
}
}
.wrapper h1 {
font-weight: 700;
}
.wrapper h2 {
font-style: italic;
font-weight: normal;
}
.wrapper h3 {
font-weight: normal;
}
.one-col blockquote,
.two-col blockquote,
.three-col blockquote {
font-style: italic;
}
.one-col-feature h1 {
font-weight: normal;
}
.one-col-feature h2 {
font-style: normal;
font-weight: bold;
}
.one-col-feature h3 {
font-style: italic;
}
td.border {
width: 1px;
}
tr.border {
background-color: #e9e9e9;
height: 1px;
}
tr.border td {
line-height: 1px;
}
.one-col,
.two-col,
.three-col,
.one-col-feature {
background-color: #ffffff;
font-size: 14px;
}
.one-col,
.two-col,
.three-col,
.one-col-feature,
.preheader,
.header,
.footer {
margin-left: auto;
margin-right: auto;
}
.preheader table {
width: 602px;
}
.preheader .title,
.preheader .webversion {
padding-top: 10px;
padding-bottom: 12px;
font-size: 12px;
line-height: 21px;
}
.preheader .title {
text-align: left;
}
.preheader .webversion {
text-align: right;
width: 300px;
}
.header {
width: 602px;
}
.header .logo {
padding: 32px 0;
}
.header .logo div {
font-size: 26px;
font-weight: 700;
letter-spacing: -0.02em;
line-height: 32px;
}
.header .logo div a {
text-decoration: none;
}
.header .logo div.logo-center {
text-align: center;
}
.header .logo div.logo-center img {
margin-left: auto;
margin-right: auto;
}
.card-center {
text-align: center;
}
.card-center img {
margin-left: auto;
margin-right: auto;
}
.gmail {
width: 650px;
min-width: 650px;
}
.gmail td {
font-size: 1px;
line-height: 1px;
}
.wrapper a {
text-decoration: underline;
transition: all .2s;
}
.wrapper h1 {
font-size: 36px;
margin-bottom: 18px;
}
.wrapper h2 {
font-size: 26px;
line-height: 32px;
margin-bottom: 20px;
}
.wrapper h3 {
font-size: 18px;
line-height: 22px;
margin-bottom: 16px;
}
.wrapper h1 a,
.wrapper h2 a,
.wrapper h3 a {
text-decoration: none;
}
.one-col blockquote,
.two-col blockquote,
.three-col blockquote {
font-size: 14px;
border-left: 2px solid #e9e9e9;
margin-left: 0;
padding-left: 16px;
}
table.divider {
width: 100%;
}
.divider .inner {
padding-bottom: 24px;
}
.divider table {
background-color: #e9e9e9;
font-size: 2px;
line-height: 2px;
width: 60px;
}
.wrapper .gray {
background-color: #f7f7f7;
}
.wrapper .gray blockquote {
border-left-color: #dddddd;
}
.wrapper .gray .divider table {
background-color: #dddddd;
}
.padded .image {
font-size: 0;
}
.image-frame {
padding: 8px;
}
.image-background {
display: inline-block;
font-size: 12px;
}
.btn {
margin-bottom: 24px;
padding: 2px;
}
.btn a {
border: 1px solid #ffffff;
display: inline-block;
font-size: 13px;
font-weight: bold;
line-height: 15px;
outline-style: solid;
outline-width: 2px;
padding: 10px 30px;
text-align: center;
text-decoration: none !important;
}
.one-col .column table:nth-last-child(2) td h1:last-child,
.one-col .column table:nth-last-child(2) td h2:last-child,
.one-col .column table:nth-last-child(2) td h3:last-child,
.one-col .column table:nth-last-child(2) td p:last-child,
.one-col .column table:nth-last-child(2) td ol:last-child,
.one-col .column table:nth-last-child(2) td ul:last-child {
margin-bottom: 24px;
}
.one-col p,
.one-col ol,
.one-col ul {
font-size: 16px;
line-height: 24px;
}
.one-col ol,
.one-col ul {
margin-left: 18px;
}
.two-col .column table:nth-last-child(2) td h1:last-child,
.two-col .column table:nth-last-child(2) td h2:last-child,
.two-col .column table:nth-last-child(2) td h3:last-child,
.two-col .column table:nth-last-child(2) td p:last-child,
.two-col .column table:nth-last-child(2) td ol:last-child,
.two-col .column table:nth-last-child(2) td ul:last-child {
margin-bottom: 23px;
}
.two-col .image-frame {
padding: 6px;
}
.two-col h1 {
font-size: 26px;
line-height: 32px;
margin-bottom: 16px;
}
.two-col h2 {
font-size: 20px;
line-height: 26px;
margin-bottom: 18px;
}
.two-col h3 {
font-size: 16px;
line-height: 20px;
margin-bottom: 14px;
}
.two-col p,
.two-col ol,
.two-col ul {
font-size: 14px;
line-height: 23px;
}
.two-col ol,
.two-col ul {
margin-left: 16px;
}
.two-col li {
padding-left: 5px;
}
.two-col .divider .inner {
padding-bottom: 23px;
}
.two-col .btn {
margin-bottom: 23px;
}
.two-col blockquote {
padding-left: 16px;
}
.three-col .column table:nth-last-child(2) td h1:last-child,
.three-col .column table:nth-last-child(2) td h2:last-child,
.three-col .column table:nth-last-child(2) td h3:last-child,
.three-col .column table:nth-last-child(2) td p:last-child,
.three-col .column table:nth-last-child(2) td ol:last-child,
.three-col .column table:nth-last-child(2) td ul:last-child {
margin-bottom: 21px;
}
.three-col .image-frame {
padding: 4px;
}
.three-col h1 {
font-size: 20px;
line-height: 26px;
margin-bottom: 12px;
}
.three-col h2 {
font-size: 16px;
line-height: 22px;
margin-bottom: 14px;
}
.three-col h3 {
font-size: 14px;
line-height: 18px;
margin-bottom: 10px;
}
.three-col p,
.three-col ol,
.three-col ul {
font-size: 12px;
line-height: 21px;
}
.three-col ol,
.three-col ul {
margin-left: 14px;
}
.three-col li {
padding-left: 6px;
}
.three-col .divider .inner {
padding-bottom: 21px;
}
.three-col .btn {
margin-bottom: 21px;
}
.three-col .btn a {
font-size: 12px;
line-height: 14px;
padding: 8px 19px;
}
.three-col blockquote {
padding-left: 16px;
}
.one-col-feature .column-top {
font-size: 36px;
line-height: 36px;
}
.one-col-feature .column-bottom {
font-size: 4px;
line-height: 4px;
}
.one-col-feature .column {
text-align: center;
width: 600px;
}
.one-col-feature .image {
margin-bottom: 32px;
}
.one-col-feature .column table:nth-last-child(2) td h1:last-child,
.one-col-feature .column table:nth-last-child(2) td h2:last-child,
.one-col-feature .column table:nth-last-child(2) td h3:last-child,
.one-col-feature .column table:nth-last-child(2) td p:last-child,
.one-col-feature .column table:nth-last-child(2) td ol:last-child,
.one-col-feature .column table:nth-last-child(2) td ul:last-child {
margin-bottom: 32px;
}
.one-col-feature h1,
.one-col-feature h2,
.one-col-feature h3 {
text-align: center;
}
.one-col-feature h1 {
font-size: 52px;
margin-bottom: 22px;
}
.one-col-feature h2 {
font-size: 42px;
margin-bottom: 20px;
}
.one-col-feature h3 {
font-size: 32px;
line-height: 42px;
margin-bottom: 20px;
}
.one-col-feature p,
.one-col-feature ol,
.one-col-feature ul {
font-size: 21px;
line-height: 32px;
margin-bottom: 32px;
}
.one-col-feature p a,
.one-col-feature ol a,
.one-col-feature ul a {
text-decoration: none;
}
.one-col-feature p {
text-align: center;
}
.one-col-feature ol,
.one-col-feature ul {
margin-left: 40px;
text-align: left;
}
.one-col-feature li {
padding-left: 3px;
}
.one-col-feature .btn {
margin-bottom: 32px;
text-align: center;
}
.one-col-feature .divider .inner {
padding-bottom: 32px;
}
.one-col-feature blockquote {
border-bottom: 2px solid #e9e9e9;
border-left-color: #ffffff;
border-left-width: 0;
border-left-style: none;
border-top: 2px solid #e9e9e9;
margin-bottom: 32px;
margin-left: 0;
padding-bottom: 42px;
padding-left: 0;
padding-top: 42px;
position: relative;
}
.one-col-feature blockquote:before,
.one-col-feature blockquote:after {
background: -moz-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
background: -webkit-gradient(linear, left top, right top, color-stop(25%, #ffffff), color-stop(25%, #e9e9e9), color-stop(75%, #e9e9e9), color-stop(75%, #ffffff));
background: -webkit-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
background: -o-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
background: -ms-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
background: linear-gradient(to right, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
content: \'\';
display: block;
height: 2px;
left: 0;
outline: 1px solid #ffffff;
position: absolute;
right: 0;
}
.one-col-feature blockquote:before {
top: -2px;
}
.one-col-feature blockquote:after {
bottom: -2px;
}
.one-col-feature blockquote p,
.one-col-feature blockquote ol,
.one-col-feature blockquote ul {
font-size: 42px;
line-height: 48px;
margin-bottom: 48px;
}
.one-col-feature blockquote p:last-child,
.one-col-feature blockquote ol:last-child,
.one-col-feature blockquote ul:last-child {
margin-bottom: 0 !important;
}
.footer {
width: 602px;
}
.footer .padded {
font-size: 12px;
line-height: 20px;
}
.social {
padding-top: 32px;
padding-bottom: 22px;
}
.social img {
display: block;
}
.social .divider {
font-family: sans-serif;
font-size: 10px;
line-height: 21px;
text-align: center;
padding-left: 14px;
padding-right: 14px;
}
.social .social-text {
height: 21px;
vertical-align: middle !important;
font-size: 10px;
font-weight: bold;
text-decoration: none;
text-transform: uppercase;
}
.social .social-text a {
text-decoration: none;
}
.address {
width: 250px;
}
.address .padded {
text-align: left;
padding-left: 0;
padding-right: 10px;
}
.subscription {
width: 350px;
}
.subscription .padded {
text-align: right;
padding-right: 0;
padding-left: 10px;
}
.address,
.subscription {
padding-top: 32px;
padding-bottom: 64px;
}
.address a,
.subscription a {
font-weight: bold;
text-decoration: none;
}
.address table,
.subscription table {
width: 100%;
}
@media only screen and (max-width: 651px), only screen and (max-device-width: 651px) {
.gmail {
display: none !important;
}
}
@media only screen and (max-width: 620px), only screen and (max-device-width: 620px) {
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td h1:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td h1:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td h1:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td h1:last-child,
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td h2:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td h2:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td h2:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td h2:last-child,
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td h3:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td h3:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td h3:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td h3:last-child,
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td p:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td p:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td p:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td p:last-child,
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td ol:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td ol:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td ol:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td ol:last-child,
[class=wrapper] .one-col .column:last-child table:nth-last-child(2) td ul:last-child,
[class=wrapper] .two-col .column:last-child table:nth-last-child(2) td ul:last-child,
[class=wrapper] .three-col .column:last-child table:nth-last-child(2) td ul:last-child,
[class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td ul:last-child {
margin-bottom: 24px !important;
}
[class=wrapper] .address,
[class=wrapper] .subscription {
display: block;
float: left;
width: 318px !important;
text-align: center !important;
}
[class=wrapper] .address {
padding-bottom: 0 !important;
}
[class=wrapper] .subscription {
padding-top: 0 !important;
}
[class=wrapper] h1 {
font-size: 36px !important;
line-height: 42px !important;
margin-bottom: 18px !important;
}
[class=wrapper] h2 {
font-size: 26px !important;
line-height: 32px !important;
margin-bottom: 20px !important;
}
[class=wrapper] h3 {
font-size: 18px !important;
line-height: 22px !important;
margin-bottom: 16px !important;
}
[class=wrapper] p,
[class=wrapper] ol,
[class=wrapper] ul {
font-size: 16px !important;
line-height: 24px !important;
margin-bottom: 24px !important;
}
[class=wrapper] ol,
[class=wrapper] ul {
margin-left: 18px !important;
}
[class=wrapper] li {
padding-left: 2px !important;
}
[class=wrapper] blockquote {
padding-left: 16px !important;
}
[class=wrapper] .two-col .column:nth-child(n + 3) {
border-top: 1px solid #e9e9e9;
}
[class=wrapper] .btn {
margin-bottom: 24px !important;
}
[class=wrapper] .btn a {
display: block !important;
font-size: 13px !important;
font-weight: bold !important;
line-height: 15px !important;
padding: 10px 30px !important;
}
[class=wrapper] .column-bottom {
font-size: 8px !important;
line-height: 8px !important;
}
[class=wrapper] .first .column-bottom,
[class=wrapper] .three-col .second .column-bottom {
display: none;
}
[class=wrapper] .second .column-top,
[class=wrapper] .third .column-top {
display: none;
}
[class=wrapper] .image-frame {
padding: 4px !important;
}
[class=wrapper] .header .logo {
padding-left: 10px !important;
padding-right: 10px !important;
}
[class=wrapper] .header .logo div {
font-size: 26px !important;
line-height: 32px !important;
}
[class=wrapper] .header .logo div img {
display: inline-block !important;
max-width: 280px !important;
height: auto !important;
}
[class=wrapper] table.border,
[class=wrapper] .header,
[class=wrapper] .webversion,
[class=wrapper] .footer {
width: 320px !important;
}
[class=wrapper] .preheader .webversion,
[class=wrapper] .header .logo a {
text-align: center !important;
}
[class=wrapper] .preheader table,
[class=wrapper] .border td {
width: 318px !important;
}
[class=wrapper] .border td.border {
width: 1px !important;
}
[class=wrapper] .image .border td {
width: auto !important;
}
[class=wrapper] .title {
display: none;
}
[class=wrapper] .footer .padded {
text-align: center !important;
}
[class=wrapper] .footer .subscription .padded {
padding-top: 20px !important;
}
[class=wrapper] .footer .social-link {
display: block !important;
}
[class=wrapper] .footer .social-link table {
margin: 0 auto 10px !important;
}
[class=wrapper] .footer .divider {
display: none !important;
}
[class=wrapper] .one-col-feature .btn {
margin-bottom: 28px !important;
}
[class=wrapper] .one-col-feature .image {
margin-bottom: 28px !important;
}
[class=wrapper] .one-col-feature .divider .inner {
padding-bottom: 28px !important;
}
[class=wrapper] .one-col-feature h1 {
font-size: 42px !important;
line-height: 48px !important;
margin-bottom: 20px !important;
}
[class=wrapper] .one-col-feature h2 {
font-size: 32px !important;
line-height: 36px !important;
margin-bottom: 18px !important;
}
[class=wrapper] .one-col-feature h3 {
font-size: 26px !important;
line-height: 32px !important;
margin-bottom: 20px !important;
}
[class=wrapper] .one-col-feature p,
[class=wrapper] .one-col-feature ol,
[class=wrapper] .one-col-feature ul {
font-size: 20px !important;
line-height: 28px !important;
margin-bottom: 28px !important;
}
[class=wrapper] .one-col-feature blockquote {
font-size: 18px !important;
line-height: 26px !important;
margin-bottom: 28px !important;
padding-bottom: 26px !important;
padding-left: 0 !important;
padding-top: 26px !important;
}
[class=wrapper] .one-col-feature blockquote p,
[class=wrapper] .one-col-feature blockquote ol,
[class=wrapper] .one-col-feature blockquote ul {
font-size: 26px !important;
line-height: 32px !important;
}
[class=wrapper] .one-col-feature blockquote p:last-child,
[class=wrapper] .one-col-feature blockquote ol:last-child,
[class=wrapper] .one-col-feature blockquote ul:last-child {
margin-bottom: 0 !important;
}
[class=wrapper] .one-col-feature .column table:last-of-type h1:last-child,
[class=wrapper] .one-col-feature .column table:last-of-type h2:last-child,
[class=wrapper] .one-col-feature .column table:last-of-type h3:last-child {
margin-bottom: 28px !important;
}
}
@media only screen and (max-width: 320px), only screen and (max-device-width: 320px) {
[class=wrapper] td.border {
display: none;
}
[class=wrapper] table.border,
[class=wrapper] .header,
[class=wrapper] .webversion,
[class=wrapper] .footer {
width: 318px !important;
}
}
&lt;/style&gt;
&lt;!--[if gte mso 9]&gt;
&lt;style&gt;
.column-top {
mso-line-height-rule: exactly !important;
}
&lt;/style&gt;
&lt;![endif]--&gt;
&lt;meta name=&quot;robots&quot; content=&quot;noindex,nofollow&quot;&gt;
&lt;meta property=&quot;og:title&quot; content=&quot;!subject!&quot;&gt;


&lt;style type=&quot;text/css&quot;&gt;
body,.wrapper,.emb-editor-canvas{background-color:#e9e8dd}.border{background-color:#d9d8ce}h1{color:#212425}.wrapper h1{}.wrapper h1{font-family:sans-serif}h1{}.one-col h1{line-height:44px}.two-col h1{line-height:32px}.three-col h1{line-height:26px}.wrapper .one-col-feature h1{line-height:58px}@media only screen and (max-width: 620px),only screen and (max-device-width: 620px){h1{line-height:44px !important}}h2{color:#212425}.wrapper h2{}.wrapper h2{font-family:sans-serif}h2{}.one-col h2{line-height:34px}.two-col h2{line-height:26px}.three-col h2{line-height:22px}.wrapper .one-col-feature h2{line-height:50px}@media only screen and (max-width: 620px), only screen and (max-device-width: 620px){h2{line-height:34px !important}}h3{color:#212425}.wrapper h3{}.wrapper h3{font-family:sans-serif}h3{}.one-col h3{line-height:26px}.two-col h3{line-height:22px}.three-col h3{line-height:20px}.wrapper .one-col-feature h3{line-height:40px}@media only screen and (max-width:620px), only screen and (max-device-width: 620px){h3{line-height:26px !important}}p,ol,ul{color:#212425}.wrapper p,.wrapper ol,.wrapper ul{}.wrapper p,.wrapper ol,.wrapper ul{font-family:sans-serif}p,ol,ul{}.one-col p,.one-col ol,.one-col ul{line-height:24px;margin-bottom:24px}.two-col p,.two-col ol,.two-col ul{line-height:22px;margin-bottom:22px}.three-col p,.three-col ol,.three-col ul{line-height:20px;margin-bottom:20px}.wrapper .one-col-feature p,.wrapper .one-col-feature ol,.wrapper .one-col-feature ul{line-height:29px}.one-col-feature blockquote p,.one-col-feature blockquote ol,.one-col-feature blockquote ul{line-height:48px}@media only screen and (max-width: 620px), only screen and (max-device-width: 620px){p,ol,ul{line-height:24px !important;margin-bottom:24px !important}}.image{color:#212425}.image{font-family:sans-serif}.wrapper a{color:#5ba4e5}.wrapper a:hover{color:#2f8cde !important}.wrapper .logo div{color:#41637e}.wrapper .logo div{font-family:sans-serif}@media only screen and (min-width: 0), only screen and (min-device-width: 0){.wrapper .logo div{font-family:sans-serif !important}}.wrapper .logo div a{color:#41637e}.wrapper .logo div a:hover{color:#41637e !important}.wrapper .one-col-feature p a,.wrapper .one-col-feature ol a,.wrapper .one-col-feature ul a{border-bottom:1px solid #5ba4e5}.wrapper .one-col-feature p a:hover,.wrapper .one-col-feature ol a:hover,.wrapper .one-col-feature ul a:hover{color:#2f8cde !important;border-bottom:1px solid #2f8cde !important}.btn a{}.wrapper .btn a{}.wrapper .btn a{font-family:sans-serif}.wrapper .btn a{background-color:#83969f;color:#fff !important;outline-color:#83969f;text-shadow:0 1px 0 #76878f}.wrapper .btn a:hover{background-color:#76878f !important;color:#fff !important;outline-color:#76878f !important}.preheader .title,.preheader .webversion,.footer .padded{color:#5e5e5e}.preheader .title,.preheader .webversion,.footer .padded{font-family:sans-serif}.preheader .title a,.preheader .webversion a,.footer .padded a{color:#5e5e5e}.preheader .title a:hover,.preheader .webversion a:hover,.footer .padded a:hover{color:#383838 !important}.footer .social .divider{color:#d9d8ce}.footer .social .social-text,.footer .social a{color:#5e5e5e}.wrapper .footer .social .social-text,.wrapper .footer .social a{}.wrapper .footer .social .social-text,.wrapper .footer .social a{font-family:sans-serif}.footer .social .social-text,.footer .social a{}.footer .social .social-text,.footer .social a{letter-spacing:0.05em}.footer .social .social-text:hover,.footer .social a:hover{color:#383838 !important}.image .border{background-color:#c8c8c8}.image-frame{background-color:#dadada}.image-background{background-color:#f7f7f7}@media only screen and (max-width: 620px), only screen and (max-device-width: 620px){[class=wrapper] h2.card-store{font-size:14px !important;top: 20px !important;right: 30px !important;}[class=wrapper] h3.card-text{font-size:12px !important;top: 40px !important;right: 30px !important;}[class=wrapper] h3.card-name{font-size:12px !important;bottom: 20px !important;right: 30px !important;}[class=wrapper] h3.card-code{font-size:12px !important;bottom: 6px !important;right: 30px !important;}}
&lt;/style&gt;
&lt;center class=&quot;wrapper&quot; style=&quot;display: table;table-layout: fixed;width: 100%;min-width: 620px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background-color: #e9e8dd&quot;&gt;
&lt;table class=&quot;gmail&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 650px;min-width: 650px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top;font-size: 1px;line-height: 1px&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;preheader centered&quot; style=&quot;border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;width: 602px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;title&quot; style=&quot;padding: 0;vertical-align: top;padding-top: 10px;padding-bottom: 12px;font-size: 12px;line-height: 21px;text-align: left;color: #5e5e5e;font-family: sans-serif&quot;&gt;
!subject!
&lt;/td&gt;
&lt;td class=&quot;webversion&quot; style=&quot;padding: 0;vertical-align: top;padding-top: 10px;padding-bottom: 12px;font-size: 12px;line-height: 21px;text-align: right;width: 300px;color: #5e5e5e;font-family: sans-serif&quot;&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;table class=&quot;header centered&quot; style=&quot;border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto;width: 602px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;border&quot; style=&quot;padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #d9d8ce;width: 1px&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;tr&gt;
&lt;td class=&quot;logo&quot; style=&quot;padding: 32px 0;vertical-align: top;mso-line-height-rule: at-least&quot;&gt;
&lt;div class=&quot;logo-center&quot; style=&quot;font-size: 26px;font-weight: 700;letter-spacing: -0.02em;line-height: 32px;color: #41637e;font-family: sans-serif;text-align: center&quot; align=&quot;center&quot; id=&quot;emb-email-header&quot;&gt;
&lt;a style=&quot;text-decoration: none;transition: all .2s;color: #41637e&quot; href=&quot;!store_url!&quot;&gt;
&lt;img style=&quot;border: 0;-ms-interpolation-mode: bicubic;display: block;margin-left: auto;margin-right: auto;max-width: 405px&quot; src=&quot;!store_url!/image/data/email/logo.png&quot; alt=&quot;!store_url!&quot; width=&quot;405&quot; height=&quot;98&quot;&gt;
&lt;/a&gt;
&lt;/div&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;

&lt;table class=&quot;border&quot; style=&quot;border-collapse: collapse;border-spacing: 0;font-size: 1px;line-height: 1px;background-color: #d9d8ce;margin-left: auto;margin-right: auto&quot; width=&quot;602&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
​
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;

&lt;table class=&quot;centered&quot; style=&quot;border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;border&quot; style=&quot;padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #d9d8ce;width: 1px&quot;&gt;
​
&lt;/td&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&lt;table class=&quot;one-col&quot; style=&quot;border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto;width: 600px;background-color: #ffffff;font-size: 14px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;column&quot; style=&quot;padding: 0;vertical-align: top;text-align: left&quot;&gt;
&lt;div&gt;
&lt;div class=&quot;column-top&quot; style=&quot;font-size: 32px;line-height: 32px&quot;&gt;
&amp;nbsp;
&lt;/div&gt;
&lt;/div&gt;


&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;

&lt;div style=&quot;margin-top: 0;color: #212425;font-family: sans-serif;font-size: 16px;line-height: 24px;margin-bottom: 24px&quot;&gt;
!content!
&lt;/div&gt;

&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;

&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;

&lt;table class=&quot;divider&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;inner&quot; style=&quot;padding: 0;vertical-align: top;padding-bottom: 24px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0;background-color: #e9e9e9;font-size: 2px;line-height: 2px;width: 60px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;

&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;

&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px&quot;&gt;
!signature!
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;

&lt;div class=&quot;column-bottom&quot; style=&quot;font-size: 8px;line-height: 8px&quot;&gt;
&amp;nbsp;
&lt;/div&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;td class=&quot;border&quot; style=&quot;padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #d9d8ce;width: 1px&quot;&gt;
​
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;

&lt;table class=&quot;border&quot; style=&quot;border-collapse: collapse;border-spacing: 0;font-size: 1px;line-height: 1px;background-color: #d9d8ce;margin-left: auto;margin-right: auto&quot; width=&quot;602&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
​
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;

&lt;div class=&quot;spacer&quot; style=&quot;font-size: 1px;line-height: 32px;width: 100%&quot;&gt;
&amp;nbsp;
&lt;/div&gt;
&lt;table class=&quot;footer centered&quot; style=&quot;border-collapse: collapse;border-spacing: 0;margin-left: auto;margin-right: auto;width: 602px&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;social&quot; style=&quot;padding: 0;vertical-align: top;padding-top: 32px;padding-bottom: 22px&quot; align=&quot;center&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;social-link&quot; style=&quot;padding: 0;vertical-align: top&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&lt;fblike style=&quot;text-decoration:none;&quot;&gt;
&lt;img style=&quot;border: 0;-ms-interpolation-mode: bicubic;display: block&quot; src=&quot;!store_url!/image/data/email/facebook-dark.png&quot; width=&quot;26&quot; height=&quot;21&quot;&gt;
&lt;/fblike&gt;
&lt;/td&gt;
&lt;td class=&quot;social-text&quot; style=&quot;padding: 0;vertical-align: middle !important;height: 21px;font-size: 10px;font-weight: bold;text-decoration: none;text-transform: uppercase;color: #5e5e5e;letter-spacing: 0.05em;font-family: sans-serif&quot;&gt;
&lt;a href=&quot;!facebook!&quot; class=&quot;fblike&quot; style=&quot;text-decoration:none;&quot;&gt;
Like
&lt;/a&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;td class=&quot;divider&quot; style=&quot;padding: 0;vertical-align: top;font-family: sans-serif;font-size: 10px;line-height: 21px;text-align: center;padding-left: 14px;padding-right: 14px;color: #d9d8ce&quot;&gt;
&lt;img style=&quot;border: 0;-ms-interpolation-mode: bicubic;display: block&quot; src=&quot;!store_url!/image/data/email/diamond.png&quot; width=&quot;5&quot; height=&quot;21&quot; alt=&quot;&quot;&gt;
&lt;/td&gt;
&lt;td class=&quot;social-link&quot; style=&quot;padding: 0;vertical-align: top&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&lt;tweet style=&quot;text-decoration:none;&quot;&gt;
&lt;img style=&quot;border: 0;-ms-interpolation-mode: bicubic;display: block&quot; src=&quot;!store_url!/image/data/email/twitter-dark.png&quot; width=&quot;26&quot; height=&quot;21&quot;&gt;
&lt;/tweet&gt;
&lt;/td&gt;
&lt;td class=&quot;social-text&quot; style=&quot;padding: 0;vertical-align: middle !important;height: 21px;font-size: 10px;font-weight: bold;text-decoration: none;text-transform: uppercase;color: #5e5e5e;letter-spacing: 0.05em;font-family: sans-serif&quot;&gt;
&lt;a href=&quot;!twitter!&quot; class=&quot;tweet&quot; style=&quot;text-decoration:none;&quot;&gt;
Tweet
&lt;/a&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;

&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;tr&gt;
&lt;td class=&quot;border&quot; style=&quot;padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #d9d8ce;width: 1px&quot;&gt;
&amp;nbsp;
&lt;/td&gt;
&lt;/tr&gt;
&lt;tr&gt;
&lt;td style=&quot;padding: 0;vertical-align: top&quot;&gt;
&lt;table style=&quot;border-collapse: collapse;border-spacing: 0&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;address&quot; style=&quot;padding: 0;vertical-align: top;width: 250px;padding-top: 32px;padding-bottom: 64px&quot;&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 0;padding-right: 10px;text-align: left;font-size: 12px;line-height: 20px;color: #5e5e5e;font-family: sans-serif&quot;&gt;
&lt;div&gt;
!store_name!
&lt;br&gt;
!store_address!
&lt;br&gt;
!store_phone!
&lt;/div&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;td class=&quot;subscription&quot; style=&quot;padding: 0;vertical-align: top;width: 350px;padding-top: 32px;padding-bottom: 64px&quot;&gt;
&lt;table class=&quot;contents&quot; style=&quot;border-collapse: collapse;border-spacing: 0;width: 100%&quot;&gt;
&lt;tbody&gt;
&lt;tr&gt;
&lt;td class=&quot;padded&quot; style=&quot;padding: 0;vertical-align: top;padding-left: 10px;padding-right: 0;font-size: 12px;line-height: 20px;color: #5e5e5e;font-family: sans-serif;text-align: right&quot;&gt;
&lt;div&gt;
You\'re receiving this email because you\'re either a customer or affiliate of !store_name!. Change your preferences below.
&lt;/div&gt;
&lt;div&gt;
&lt;span class=&quot;block&quot;&gt;
&lt;span&gt;
&lt;a href=&quot;!preference!&quot; class=&quot;preferences&quot; style=&quot;font-weight:bold;text-decoration:none;&quot; lang=&quot;en&quot;&gt;
Preferences
&lt;/a&gt;
&lt;/span&gt;
&lt;/span&gt;
&lt;/div&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/td&gt;
&lt;/tr&gt;
&lt;/tbody&gt;
&lt;/table&gt;
&lt;/center&gt;

',
			),
		));
	}

}
