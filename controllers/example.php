<?php

class Example extends Core {
	
	public function index() {
		$this->load_model('time_model');
		$this->data['time'] = $this->model->time_model->format(time());
		$this->load_view('example', $this->data);
	}
	
}

?>