<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Memcached settings
| -------------------------------------------------------------------------
| Your Memcached servers can be specified below.
|
|	See: https://codeigniter.com/user_guide/libraries/caching.html#memcached
|
*/
$config = array(
	'load' => 'default',
	'default' => array(
		'app_id' => 'EDropToo-EDrop-PRD-57879bc6b-a0e873e2',
		'dev_id' => '1c8ba249-0daa-4b37-8bbf-d646ae76950b',
		'cert_id' => 'PRD-7879bc6b7e27-767f-4491-967c-bad3',
		'ru_name' => 'EDrop_Tooldrops-EDropToo-EDrop--ohyok',
		'end_point' => 'https://api.ebay.com/ws/api.dll'
	),
	'test' => array(
		'app_id' => 'EDropToo-EDrop-SBX-d7879bc50-e2307064',
		'dev_id' => '1c8ba249-0daa-4b37-8bbf-d646ae76950b',
		'cert_id' => 'SBX-7879bc505d5a-1885-46a7-ae8c-8562',
		'ru_name' => 'EDrop_Tooldrops-EDropToo-EDrop--ohyok',
		'end_point' => 'https://api.sandbox.ebay.com/ws/api.dll'
	)
);
