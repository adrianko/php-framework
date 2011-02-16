<?php

class A extends Core {
	
    public function index() {
        $this->load_view('sample', $this->data);
    }

}

?>