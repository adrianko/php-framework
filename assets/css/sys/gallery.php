<?php
if(!isset($css)) { exit; }
$def_values = array('spacer' => 3, 'width' => 600);
foreach($def_values as $k => $v ) {
    $$k = (isset($values[$k]) ? $values[$k] : $v);
}
?>
.peally-gallery-row {
    margin: 0;
    padding: 0 0 <?=$spacer?>px 0;
    width: <?=$width?>px;
    display: block;
}
.peally-gallery-row a, .peally-gallery-row img {
    text-decoration: none;
    padding: 0 <?=$spacer?>px 0 0;
    border: none;
    vertical-align: middle;
}
.peally-gallery-row:last-child, .peally-gallery-row a:last-child, .peally-gallery-row img:last-child {
    margin: 0;
    padding: 0;
}