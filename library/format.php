<?php

require_once("core/config.php");

class Format {
	
	public $tis = array('yr' => array('secs' => 31536000, 'single' => 'a', 'full' => 'year'), 'mth' => array('secs' => 2592000, 'single' => 'a', 'full' => 'month'), 'wk' => array('secs' => 604800, 'single' => 'a', 'full' => 'week'), 'dy' => array('secs' => 86400, 'single' => 'a', 'full' => 'day'), 'hr' => array('secs' => 3600, 'single' => 'an', 'full' => 'hour'), 'min' => array('secs' => 60, 'single' => 'a', 'full' => 'minute'), 'sec' => array('secs' => 0, 'single' => 'a', 'full' => 'second'));
		
    public function timeDiff($time) {
        $time_all = array('yr' => 0, 'mth' => 0, 'wk' => 0, 'dy' => 0, 'hr' => 0, 'min' => 0, 'sec' => 0);
        $total = 0;
        foreach($time_all as $k => $v) {
        	$t = ($time - $total) / ($this->tis[$k]['secs'] == 0 ? 1 : $this->tis[$k]['secs']);
        	$time_all[$k] = floor($t > 0 ? $t : 0);
        	$total += $this->tis[$k]['secs'] * $time_all[$k];
        }
        return $time_all;
    }
    
    public function timeUntil($time, $acr, $abr) {
    	$timeDiff = $time - time();
    	$return = null;
    	if($timeDiff > 0) {
    		$time_all = $this->timeDiff($timeDiff);
    		$keys = array_keys($time_all);
    		$notp = 0;
    		foreach($time_all as $k => $v) {
    			if(($v == 0 && $return != null) || $v != 0) {
    				$return .= $v." ".($abr == 1 ? $k : $this->tis[$k]['full']).($v == 1 ? '' : 's')." ";
    				$notp++;
    			}
    			if($k == $acr) {
    				if($return == null) {
    					$return = "less than ".$this->tis[$k]['single']." ".$this->tis[$k]['full'];
    				} elseif($notp == 1) {
    					$return = "about ".$return;
    				}
    				$return .= " remaining";
    				break;
    			}
 				
 			}
    	} else {
    		$return = 'now';
    	}
    	return $return;
    }
    
    public function timeSince($time, $acr, $abr) {
    	$timeDiff = time() - $time;
    	$return = null;
    	if($acr == 'full') {
    	} else {
	    	$time_all = $this->timeDiff($timeDiff);
    		$keys = array_keys($time_all);
    		$notp = 0;
    		foreach($time_all as $k => $v) {
    			if(($v == 0 && $return != null) || $v != 0) {
    				$return .= $v." ".($abr == 1 ? $k : $this->tis[$k]['full']).($v == 1 ? '' : 's')." ";
    				$notp++;
    			}
    			if($k == $acr) {
    				if($return == null) {
    					$return = "less than ".$this->tis[$k]['single']." ".$this->tis[$k]['full'];
    				} elseif($notp == 1) {
    					$return = "about ".$return;
    				}
    				$return .= " ago";
    				break;
    			}
 				
 			}
    	}
    	return $return;
    }

}
