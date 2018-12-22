<?php
class baseModel {
    private static $instance;
    protected $_db = null;

    function __construct() {

    }

    public static function getInstance() {
        if (!self::$instance)
        {
            self::$instance = new baseModel();
        }
        return self::$instance;
    }
    public function get($name){
        $file = __SITE_PATH.'/app/common/model/'.str_replace("model","",strtolower($name))."Model.php";

        if(file_exists($file))
        {
            include ($file);
            $class = str_replace("model","",strtolower($name))."Model";
            return new $class;
        }
        return NULL;
    }

    public function _getDb()
    {
        if ($this->_db === null)
        {
            global $registry;
            $registry->db = new My_Database();
            $this->_db = $registry->__get('db');
        }

        return $this->_db;
    }

    function __destruct() {
    }
} 