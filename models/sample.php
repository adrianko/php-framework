<?php

class Sample extends Core{

    public function s() {
        return $data = $GLOBALS['lib_db']->query("SELECT * FROM bio WHERE id = :id", 'object', array('id' => 3));
    }

    public function t() {
        return $data = $GLOBALS['lib_db']->query("SELECT * FROM bio WHERE id = :id", 'object', array('id' => 2));
    }

    public function c() {
        return $GLOBALS['lib_format']->prettyTime(1234567890);
    }
    
    public function r() {
    	return $GLOBALS['lib_db']->db_0->query("SHOW TABLES", 'object');
    }

}
?>