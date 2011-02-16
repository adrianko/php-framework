<?php
header('Content-type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
<?php
    $this->load->css($sys_css);
?>
</head>
<body>
<?php
foreach($gallery as $row) {
    echo "<div class=\"peally-gallery-row\">";
    foreach($row as $ele) {
        echo "<img src=\"".$ele[0]."\" width=\"".$ele[1]."\" height=\"".$ele[2]."\">";
    }
    echo "</div>";
}
?>
</body>
</html>