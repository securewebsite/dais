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
|	facade.
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
	'post_header'    => 'common/post_header',
	'column_left'    => 'common/column_left',
	'breadcrumb'     => 'common/bread_crumb',
	'content_top'    => 'common/content_top',
	'content_bottom' => 'common/content_bottom',
	'column_right'   => 'common/column_right',
	'pre_footer'     => 'common/pre_footer',
	'footer'         => 'content/footer',
);

$config[FRONT_FACADE]['pre_render'] = $front_controllers;

$admin_controllers = array(
	'header'     => 'common/header',
	'breadcrumb' => 'common/bread_crumb',
	'footer'     => 'common/footer',
);

$config[ADMIN_FACADE]['pre_render'] = $admin_controllers;

/*
|--------------------------------------------------------------------------
|	Front Pre-actions
|--------------------------------------------------------------------------
|
|	Set controller pre-actions based on facade. The actions will be run 
|	prior to the Front controller output.
|
*/

$front_actions = array(
    'common/maintenance',
    'common/javascript/runner',
    'common/router'
);

$config[FRONT_FACADE]['pre_actions'] = $front_actions;

$admin_actions = array(
    'common/javascript/runner',
    'common/dashboard/login',
    'common/dashboard/permission'
);

$config[ADMIN_FACADE]['pre_actions'] = $admin_actions;
