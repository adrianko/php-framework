<?php

class Load {

    public function css($sys_css) {
        global $config;
        if(isset($sys_css)) {
            foreach($sys_css as $f => $c) {
                echo "<link rel=\"stylesheet\" media=\"screen\" href=\"".($config['assets_sbd'] != '' ? "//".$config['assets_sbd'].".".$_SERVER['SERVER_NAME'] : (DOCUMENT_BASEPATH != '/' ? DOCUMENT_BASEPATH : '')."/assets/css")."/sys/".$f.".css".($c != '' ? "?".$c : '')."\">\n";
            }
        }
    }

    public function js($sys_js) {
        global $config;
        if(isset($sys_js)) {
            foreach($sys_js as $f => $c) {
                echo "<script src=\"".($config['assets_sbd'] != '' ? "//".$config['assets_sbd'].".".$_SERVER['SERVER_NAME'] : (DOCUMENT_BASEPATH != '/' ? DOCUMENT_BASEPATH : '')."/assets/js")."/core/".$f.".js".($c != '' ? "?".$c : '')."\"></script>\n";
            }
        }
    }

}

?>