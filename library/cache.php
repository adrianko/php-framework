<?php

require_once("core/config.php");

class Cache {

    public $keys;
    public $cache_dir;

    public function __construct() {
        $this->keys = array();
        global $config;
        $this->cache_dir = $config['cache_dir'];
        if($h1 = opendir($this->cache_dir."/sys")) {
            while(false !== ($e1 = readdir($h1))) {
                if($e1 != "." && $e1 != ".." && is_dir($e1)) {
                    $this->keys[$e1] = array();
                    if($h2 = opendir($this->cache_dir."/sys/".$e1)) {
                        while(false !== ($e2 = readdir($h2))) {
                            if($e2 != "." && $e2 != ".." && !is_dir($e2)) {
                                $key = substr(substr($e2, 22), 0, -6);
                                $this->keys[$e1][$key] = new stdClass;
                                $this->keys[$e1][$key]->set = substr($e2, 0, 10);
                                $this->keys[$e1][$key]->expr = substr($e2, 11, 10);
                            }
                        }
                        closedir($h2);
                    }
                }
            }
            closedir($h1);
        }
    }

    public function check($type, $key) {
        if(array_key_exists($key, $this->keys[$type])) {
            return true;
        } else {
            return false;
        }
    }

    public function store($type, $key, $expr, $content) {
        $change = true;
        if($expr == 0) {
            $expr = 9999999999;
        }
        if(array_key_exists($key, $this->keys[$type])) {
            $c = file_get_contents($this->cache_dir."/sys/".$type."/".$this->keys[$type][$key]->set."-".$this->keys[$type][$key]->expr."-".$key.".cache");
            if($c == $content && $expr == $this->keys[$type][$key]->expr) {
                $change = false;
            } elseif($c == $content && $expr != $this->keys[$type][$key]->expr) {
                $this->keys[$type][$key] = new stdClass;
                $this->keys[$type][$key]->set = time();
                $this->keys[$type][$key]->expr = $expr;
                rename($this->cache_dir."/sys/".$type."/".$this->keys[$type][$key]->set."-".$this->keys[$type][$key]->expr."-".$key.".cache", $this->cache_dir."/sys/views/".time()."-".$expr."-".$key.".cache");
            } else {
                unlink($this->cache_dir."/sys/".$type."/".$this->keys[$type][$key]->set."-".$this->keys[$type][$key]->expr."-".$key.".cache");
                $this->keys[$type][$key] = new stdClass;
                $this->keys[$type][$key]->set = time();
                $this->keys[$type][$key]->expr = $expr;
                file_put_contents($this->cache_dir."/sys/".$type."/".$this->keys[$type][$key]->set."-".$this->keys[$type][$key]->expr."-".$key.".cache", $content);
            }
        } else {
            $this->keys[$type][$key] = new stdClass;
            $this->keys[$type][$key]->set = time();
            $this->keys[$type][$key]->expr = $expr;
            file_put_contents($this->cache_dir."/sys/".$type."/".time()."-".$this->keys[$type][$key]->expr."-".$key.".cache", $content);
        }
        return $change;
    }

    public function retrieve($type, $key) {
        if(array_key_exists($key, $this->keys[$type]) && $this->keys[$type][$key]->expr > time()) {
            return file_get_contents($this->cache_dir."/sys/".$type."/".$this->keys[$type][$key]->set."-".$this->keys[$type][$key]->expr."-".$key.".cache");
        } else {
            return false;
        }
    }

    public function clear($type, $key) {
        if(array_key_exists($key, $this->keys[$type])) {
            unlink($this->cache_dir."/sys/".$type."/".$this->keys[$type][$key]->set."-".$this->keys[$type][$key]->expr."-".$key.".cache");
            return true;
        } else {
            return false;
        }
    }

    public function clearAll($type) {
        foreach($this->keys[$type] as $key => $class) {
            unlink($this->cache_dir."/sys/".$type."/".$class->set."-".$class->expr."-".$key.".cache");
        }
        $this->keys[$type] = array();
        return true;
    }

}
