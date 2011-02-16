<?php
(!isset($_GET['ref']) ? require_once('../../core/config.php'): '');
$e = 404;
if(isset($_GET['c'])) {
    $e = $_GET['c'];
}
switch($e) {
    case 404:
        $e_msg = "Not Found";
        break;
    case 500:
        $e_msg = "Server error";
        break;
    default:
        break;
}
?>
<!DOCTYPE html>
<html>
<head>
<title><?=$e?> <?=$e_msg?> | <?=$config['base_title']?></title>
</head>
<body>
<?=$e_msg?>
</body>
</html>