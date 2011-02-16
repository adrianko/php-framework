<?php

class B extends Core {

    public $c = 'hello';
    public $_methodless = '_mtd';

    public function index($p = null) {
        print_r($p);
        echo "hello";
    }
    
    public function _mtdlss($p) {
    	echo $p;
    }

    public function e() {
        $this->load_library('db');
        $this->load_model('sample');
        $this->data['stuff'] = $this->model->sample->t();
        $this->load_view('sample', $this->data);
    }

    public function gallery() {
        $images = array(
            array('http://farm8.staticflickr.com/7090/7329059744_1c68a164b6_b.jpg', 1024, 683),
            array('http://farm8.staticflickr.com/7072/7329064314_04d89f1051_b.jpg', 1024, 683),
            array('http://farm8.staticflickr.com/7214/7329099652_135b405b12_b.jpg', 1024, 683),
            array('http://farm9.staticflickr.com/8148/7329108554_5ee58bfdd7_b.jpg', 1024, 683),
            array('http://farm8.staticflickr.com/7071/7329083482_b8e39ea2ff_b.jpg', 683, 1024),
            array('http://farm8.staticflickr.com/7080/7329119544_d6f438614a_b.jpg', 1024, 683),
            array('http://farm8.staticflickr.com/7226/7329095964_f79aee5f08_b.jpg', 1024, 683),
            array('http://farm8.staticflickr.com/7078/7329112534_46cbc96ac5_b.jpg', 1024, 683),
            array('http://farm8.staticflickr.com/7081/7328602498_6732c99539_b.jpg', 683, 1024),
            array('http://farm8.staticflickr.com/7230/7328658244_9dd200be71_b.jpg', 1024, 683),
            array('http://farm8.staticflickr.com/7072/7328671784_1c2740afb0_b.jpg', 1024, 683),
            array('http://farm8.staticflickr.com/7071/7328639792_925b413076_b.jpg', 1024, 683),
            array('http://farm8.staticflickr.com/7096/7328727304_16b0523e23_b.jpg', 1024, 683),
            array('http://farm8.staticflickr.com/7089/7328720996_1407ebbbdd_b.jpg', 1024, 683)
        );
        $this->load_library('media');
        $GLOBALS['lib_media']->max_width = 900;
        $GLOBALS['lib_media']->elements = $images;
        $GLOBALS['lib_media']->factor = 7;
        $GLOBALS['lib_media']->spacer = 3;
        $GLOBALS['lib_media']->parse();
        $GLOBALS['lib_media']->gallery('justified');
        $this->data['gallery'] = $GLOBALS['lib_media']->gallery;
        $opts = serialize(array('width' => 900));
        $code = md5($opts);
        if(!file_exists("cache/sys/css/".$code.".cache")) {
            file_put_contents("cache/sys/css/".$code.".cache", $opts);
        }
        $this->data['sys_css'] = array('gallery' => $code);
        $this->load_view('b', $this->data);
    }

}
