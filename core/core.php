<?php

require_once("core/config.php");
require_once("core/load.php");

class Core {

    public $model;
    public $library;
    public $controller;
    public $data = array();
    public $load;

    public function __construct() {
        $this->model = new stdClass;
        $this->library = new stdClass;
        $this->controller = new stdClass;
        $this->load = new Load();
        if(!isset($GLOBALS['lib'])) {
        	$GLOBALS['lib'] = new stdClass;
        }
    }

    public function load_view($v, $data = array()) {
        if(file_exists("views/".$v.".php")) {
            foreach($data as $key => $value) {
                $$key = $value;
            }
            include("views/".$v.".php");
        } else {
            self::not_found();
        }
    }

    public function load_model($m, $construct = array()) {
        if(file_exists("models/".$m.".php")) {
            include("models/".$m.".php");
            $this->model->$m = new $m(count($construct) > 0 ? $construct : '');
            $this->model->$m->library = new stdClass;
            foreach($GLOBALS['lib'] as $lib => $library) {
            	$this->model->$m->library->$lib = $GLOBALS['lib']->$lib;
            }
        } else{
            self::not_found();
        }
    }

    public function load_library($l, $construct = array()) {
        if(file_exists("library/".$l.".php")) {
            include("library/".$l.".php");
            if($l == 'db') {
            	$GLOBALS['lib']->db = new stdClass;
            	$db = "db_".$construct[0];
            	$GLOBALS['lib']->db->$db = new $l($construct[0]);
            } else {
            	$GLOBALS['lib']->$l = new $l(count($construct) > 0 ? $construct : '');
            }
        } else {
            self::not_found();
        }
    }

    public function load_controller($p, $index = 0) {
        global $config;
        $controller = $method = $parameter = null;
        $l = count($p);
        if(file_exists("controllers/".$p[0].".php")) {
        	include("controllers/".$p[0].".php");
        	$controller = $p[0];
        } else {
        	if($config['parentless'] == true) {
        		include("controllers/".$config['parentless_controller'].".php");
        		$controller = $config['parentless_controller'];
        	} else {
				$l -= 1;
			}
        }
        if($controller != null) {
        	$this->controller->$controller = new $controller();
			if(isset($p[1])) {
				if(method_exists($controller, $p[1])) {
					$method = $p[1];
				} elseif(property_exists($controller, '_methodless')) {
					$method = $this->controller->$controller->_methodless;
					$parameter = $p[1];
					$l += 1;
				}
			}
			if(isset($p[2]) && $method != null) {
				$rm = new ReflectionMethod($controller, $method);
				if($rm->getNumberOfParameters() != 0) {
					$parameter = $p[2];
				}
			}
		}
        if($controller != null) {
	        switch($l) {
	        	case 1:
	        		if($index != 0) {
	        			method_exists($controller, 'index') ? $this->controller->$controller->index() : self::error(0);
	        		}
	        		break;
	        	case 2:
	        		$method != null ? $this->controller->$controller->$method() : self::error(1);
	        		break;
	        	case 3:
	        		$parameter != null ? $this->controller->$controller->$method($parameter) : self::error(2);
	        		break;
	        	default:
	        		$parameter != null ? $this->controller->$controller->$method($parameter, array_slice($p, 3)) : self::error(2);
	        		break;
	        }
        } else {
        	self::not_found();
        }  
    }

    public static function not_found() {
        header('HTTP/1.0 404 Not Found');
        $_GET = array('c' => 404, 'ref' => 'index');
        include('views/sys/httperror.php');
    }
    
    public static function error($msg) {
    	switch($msg) {
    		case 0:
    			$msg_text = "Missing index method";
    			break;
    		case 1:
    			$msg_text = "Method not found";
    			break;
    		case 2:
    			$msg_text = "Missing parameters";
    			break;
    			
    	}	
    	echo $msg_text;
    }

}

?>