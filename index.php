<?php
if(!isset($_GET['ob'])) {
	ob_start();
}
require_once("core/core.php");
$c = new Core();
$c->load_controller(explode('/', isset($_GET['p']) ? $_GET['p'] : $config['default_controller']), 1);
if(!isset($_GET['ob'])) {
	ob_end_flush();
}
?>