<?php

class Gen extends Core {
    public function index() {
        $this->load_library('generate');
        echo $GLOBALS['lib']->generate->alphanumeric(10);
    }   
}