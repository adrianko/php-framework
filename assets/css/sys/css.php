<?php
require_once('../../../core/config.php');
$css = true;
$rs = $_SERVER['QUERY_STRING'];
$qu = explode('&', $rs);
$file = substr(substr($qu[0], 2), 0, -4);
array_shift($qu);
$code = implode('&', $qu);
if(file_exists($file.".php")) {
    header('Content-type: text/css');
    if(file_exists("../../../cache/sys/css/".$code.".cache")) {
        $values = unserialize(file_get_contents("../../../cache/sys/css/".$code.".cache"));
    }
    include($file.".php");
} else {
    header('HTTP/1.0 404 Not Found');
    $_GET = array('c' => 404, 'ref' => 'index');
    include('../../../views/sys/httperror.php');
}
?>