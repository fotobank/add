<?php
$leo_routes = array(
	'/' => array( // Default controller
		'controller' => 'welcome',
		'method' => 'index',
		'number' => 'id',
		'param' => 'opt_param'
	),
	'admin/index' => array(
		'controller' => 'admin',
		'method' => 'index',
		'number' => 'id',
		'param' => 'opt_param'
	),
	'admin/page' => array(
		'controller' => 'admin',
		'method' => 'page',
		'number' => 'id',
		'param' => 'opt_param'
	),
	'admin/authService' => array(
		'controller' => 'admin',
		'method' => 'authService',
		'number' => 'id',
		'param' => 'opt_param'
	),
	'admin' => array(
		'controller' => 'admin',
		'method' => 'index',
		'number' => 'id',
		'param' => 'opt_param'
	),
	'welcome/index' => array(
		'controller' => 'welcome',
		'method' => 'index',
		'number' => 'id',
		'param' => 'opt_param'
	),
  'error404' => array(
    'controller' => 'errors',
    'method' => 'error404'
  )
);