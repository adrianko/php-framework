<?php

class Time_model extends Core {
	
	public function format($time) {
		echo $this->library->format->timeUntil($time, 'sec', 1);
		echo "<br />";
		echo $this->library->format->timeUntil($time, 'min', 1);
		echo "<br />";
		echo $this->library->format->timeUntil($time, 'hr', 1);
		echo "<br />";
		echo $this->library->format->timeUntil($time, 'dy', 1);
		echo "<br />";
		echo $this->library->format->timeUntil($time, 'wk', 1);
		echo "<br />";
		echo $this->library->format->timeUntil($time, 'mth', 1);
		echo "<br />";
		echo $this->library->format->timeUntil($time, 'yr', 1);
		echo "<br />";
		echo "<br />";
		echo $this->library->format->timeSince(strtotime('15 February 2013 17:00'), 'sec', 1);
	}
	
}

?>