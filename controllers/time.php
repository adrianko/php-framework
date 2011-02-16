<?php

class Time extends Core {
	
	public function index() {
		$this->load_library('format');
		$this->load_model('time_model');
		$time = strtotime('16 February 2013 23:59');
		$this->model->time_model->format($time);
	}
	
}

?>