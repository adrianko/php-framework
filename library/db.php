<?php

require_once("core/config.php");

class DB {

    public $con;
    private $host;
    private $user;
    private $pass;
    private $db;
    private $driver;

    public function __construct($num) {
        global $config;
        $this->host = $config['databases'][$num]['db_host'];
        $this->user = $config['databases'][$num]['db_user'];
        $this->pass = $config['databases'][$num]['db_pass'];
        $this->db = $config['databases'][$num]['db_name'];
        $this->driver = $config['databases'][$num]['db_driver'];
        $dbconstr = null;
        switch($this->driver) {
            case "mysql":
                $dbconstr = "mysql:dbname=".$this->db.";host=".$this->host;
                break;
            case "sqlite":
                $dbconstr = "sqlite:".$this->db;
                break;
            case "postgresql":
                $dbconstr = "pgsql:host=".$this->host." dbname=".$this->db;
                break;
            case "mssql":
                $dbconstr = "mssql:host=".$this->host.";dbname=".$this->db;
                break;
            case "oracle":
                $dbconstr = "oci:dbname=".$this->db;
                break;
            case "firebird":
                $this->db = str_replace("\\", "\\\\", $this->db);
                $dbconstr = "firebird:dbname=".$this->host.":".$this->db;
                break;
            default:
                break;
        }
        try {
            $this->con = new PDO($dbconstr, $this->user, $this->pass);
        } catch(PDOException $e) {
            echo "Connection failed: ".$e->getMessage();
        }
    }

    public function query($query, $return, $values = array()) {
        $res = $this->con->prepare($query);
        $res->execute($values);
        $rows = array();
        $type = null;
        if(is_array($return) == true) {
            $rows = $res->fetchAll(PDO::FETCH_CLASS, $return[1]);
        } else {
            switch($return) {
                case "object":
                    $type = PDO::FETCH_OBJ;
                    break;
                case "assoc":
                    $type = PDO::FETCH_ASSOC;
                    break;
                case "num":
                    $type = PDO::FETCH_NUM;
                    break;
                case "both":
                    $type = PDO::FETCH_BOTH;
                    break;
                default:
                    $type = PDO::FETCH_OBJ;
            }
            $rows = $res->fetchAll($type);
        }
        return $rows;
    }

    public function write($query, $values = array(), $ret_ins_id = false) {
        $return = (Object)array('success' => false, 'insert_id' => 0);
        $res = $this->con->prepare($query);
        $res->execute($values);
        if($res) {
            $return->success = true;
            if($ret_ins_id == true) {
                $return->insert_id = $this->con->lastInsertId();
            }
        }
        //print_r($res->errorInfo()); //remove
        return $return;
    }

}

?>