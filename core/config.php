<?php

date_default_timezone_set('Europe/London');
define('ABSOLUTE_BASEPATH', str_replace("\\", "/", realpath(dirname(__FILE__))));
define('DOCUMENT_BASEPATH', substr(str_replace($_SERVER['DOCUMENT_ROOT'], '', ABSOLUTE_BASEPATH), 0, -5));
global $config;
$config = array();
$config['databases'][0]['db_driver'] = 'mysql';
$config['databases'][0]['db_host'] = 'localhost';
$config['databases'][0]['db_user'] = 'root';
$config['databases'][0]['db_pass'] = '';
$config['databases'][0]['db_name'] = 'name';

$config['session_name'] = 'PHPSESSID';
$config['base_title'] = 'Peally framework';
$config['site_logo'] = '';
$config['cache_dir'] = 'cache';

$config['default_controller'] = 'a';
$config['parentless'] = true;
$config['parentless_controller'] = 'b';

$config['assets_sbd'] = '';
$config['images_sbd'] = '';
$config['cache_sbd'] = '';
$config['media_sbd'] = '';

?>