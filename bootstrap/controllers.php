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
|
|--------------------------------------------------------------------------
|	Pre-Render Controllers
|--------------------------------------------------------------------------
|
|	The pre-rendering of controllers helps ease the building and rendering
|	of common sub-controllers for each of your controller classes.
|
|	The controllers in the arrays below will automatically be rendered in
|	the Theme class anytime a controller is instantiated in the given
|	fascade.
|
|	To change this array dynamically use the {get|set|unset}_controller
|	method in the Theme class prior to setOutput().
|
|	Example: unset the Breadcrumb class:
|
|	$this->theme->unset_controller('breadcrumb');
|
*/

$front_controllers = array(
	'header'         => 'content/header',
	'post_header'    => 'common/postheader',
	'column_left'    => 'common/columnleft',
	'breadcrumb'     => 'common/breadcrumb',
	'content_top'    => 'common/contenttop',
	'content_bottom' => 'common/contentbottom',
	'column_right'   => 'common/columnright',
	'pre_footer'     => 'common/prefooter',
	'footer'         => 'content/footer',
);

$config[FRONT_FASCADE]['pre_render'] = $front_controllers;

$admin_controllers = array(
	'header'     => 'common/header',
	'breadcrumb' => 'common/breadcrumb',
	'footer'     => 'common/footer',
);

$config[ADMIN_FASCADE]['pre_render'] = $admin_controllers;

$install_controllers = array(
    'header' => 'header',
    'footer' => 'footer',
);

$config[INSTALL_FASCADE]['pre_render'] = $install_controllers;

/*
|--------------------------------------------------------------------------
|	Front Pre-actions
|--------------------------------------------------------------------------
|
|	Set controller pre-actions based on fascade. The actions will be run 
|	prior to the Front controller output.
|
*/

$front_actions = array(
    'common/maintenance',
    'common/javascript/runner',
    'common/router'
);

$config[FRONT_FASCADE]['pre_actions'] = $front_actions;

$admin_actions = array(
    'common/javascript/runner',
    'common/dashboard/login',
    'common/dashboard/permission'
);

$config[ADMIN_FASCADE]['pre_actions'] = $admin_actions;

$install_actions = array(
    'router'
);

$config[INSTALL_FASCADE]['pre_actions'] = $install_actions;
