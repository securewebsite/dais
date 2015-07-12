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

namespace App\Language\Admin\English\Module;

class Share {
	public static function lang() {
		// heading
		$_['lang_heading_title']     = 'Share Bar';

		// text
		$_['lang_text_success']      = 'You have successfully modified Share Bar settings.';

		// entry
		$_['lang_entry_facebook']    = 'Enable Facebook:<br><span class="help">Enable/disable Facebook in the Share Bar tool.</span>';
		$_['lang_entry_twitter']     = 'Enable Twitter:<br><span class="help">Enable/disable Twitter in the Share Bar tool.</span>';
		$_['lang_entry_google']      = 'Enable Google+:<br><span class="help">Enable/disable Google+ in the Share Bar tool.</span>';
		$_['lang_entry_linkedin']    = 'Enable LinkedIn:<br><span class="help">Enable/disable LinkedIn in the Share Bar tool.</span>';
		$_['lang_entry_pinterest']   = 'Enable Pinterest:<br><span class="help">Enable/disable Pinterest in the Share Bar tool.</span>';
		$_['lang_entry_tumblr']      = 'Enable Tumblr:<br><span class="help">Enable/disable Tumblr in the Share Bar tool.</span>';
		$_['lang_entry_digg']        = 'Enable Digg:<br><span class="help">Enable/disable Digg in the Share Bar tool.</span>';
		$_['lang_entry_stumbleupon'] = 'Enable StumbleUpon:<br><span class="help">Enable/disable StumbleUpon in the Share Bar tool.</span>';
		$_['lang_entry_delicious']   = 'Enable Delicious:<br><span class="help">Enable/disable Delicious in the Share Bar tool.</span>';

		$_['lang_error_permission']  = 'Warning: You do not have permission to modify Share Bar settings.';

		return $_;
	}
}
