<?php

class router
{
    /*
    * @the registry
    */
    private $registry;

    /*
    * @the controller path
    */
    private $path;

    private $args = array();

    public $file;

    public $module='';
    public $controller;

    public $action;

    function __construct($registry)
    {
        $this->registry = $registry;
    }

    /**
     *
     * @set controller directory path
     *
     * @param string $path
     *
     * @return void
     *
     */
    function setPath($path)
    {
        $o_path = trim(Url::getRequestPath(), '/');
        $module = explode("/", $o_path);
        $module = isset($module[0])?$module[0]:'';
        if(strtolower($module)=='api') {
            $this->module = 'api';
            $path = str_replace('frontend','api', $path);
        }else if(strtolower($module)=='admin'){
            $path = str_replace('frontend','admin', $path);
            $this->module = 'admin';
        }else{
            $this->module = 'frontend';
        }
        /*** check if path i sa directory ***/
        if (is_dir($path) == false) {
            throw new Exception ('Invalid controller path: <code>' . $path . '</code>');
        }
        /*** set the path ***/
        $this->path = $path;
    }

    /**
     *
     * @load the controller
     *
     * @access public
     *
     * @return void
     *
     */
    public function loader()
    {
        /*** check the route ***/
        $this->getController();
        /*** if the file is not there***/
        if (is_readable($this->file) == false) {
            global $registry;
            if (!$registry->config['debug']) {
                $this->file = $this->path . '/errorController.php';
                $this->controller = 'error';
            }
        }
        /*** include the controller ***/
        include $this->file;

        /*** a new controller class instance ***/
        $class = $this->controller . 'Controller';
        $controller = new $class($this->registry);
        /*** check if the action is callable ***/
        if (is_callable(array($controller, $this->action)) == false) {
            $action = 'indexAction';
        } else {
            $action = $this->action;
        }
        /*** run the action ***/
        if (!empty($this->args))
            $controller->$action($this->args);
        else
            $controller->$action();
    }

    /**
     *
     * @get the controller
     *
     * @access private
     *
     * @return void
     *
     */
    private function getController()
    {
        $isMatch = false;

        global $registry;
        $routeConfig = $registry->config['router'];
        $path = trim(Url::getRequestPath(), '/');
        $registry->router->module = $this->module;  //save to register

        if (sizeof($routeConfig) > 0) {                         //rewrite url for frontend
            foreach ($routeConfig as $key => $controllerAction) {
                $key = preg_quote($key, '/');
                $key = str_replace(array(
                    '\:',
                    '(',
                    ')'
                ), array(
                    ':',
                    '{',
                    '}'
                ), $key);
                $org_key = $key;
                $key = preg_replace('#\\\{([-a-z_]+):number\\\}#', '([0-9]+)', $key);
                $key = preg_replace('#\\\{([-a-z_]+):any\\\}#', '(.+)', $key);
                if (preg_match_all('#^' . $key . '$#', $path, $math_value)) {
                    // match
                    $isMatch = true;
                    preg_match_all('#\\\{([-a-z_]+):(any|number)\\\}#', $org_key, $math_key);
                    unset($math_value[0]);
                    $count = 0;
                    foreach($math_value as $value_item){
                        Url::setParam($math_key[1][$count],$value_item[0]);
                        $count++;
                    }

                    $requestControllerAction = explode('/', $controllerAction);
                    $this->controller = isset($requestControllerAction[0]) ? $requestControllerAction[0] : 'index';
                    $this->action = isset($requestControllerAction[1]) ? ($requestControllerAction[1] . 'Action') : 'indexAction';
                }
            }
        }
        if (!$isMatch) {
            /*** get the route from the url ***/
            $route = (empty($_GET['rt'])) ? '' : $_GET['rt'];
            if (empty($route)) {
                $route = 'index';
            } else {
                /*** get the parts of the route ***/
                $parts = explode('/', $route);
                if($this->module=='api' || $this->module=='admin'){     //admin, api
                    $this->controller = $parts[1];
                    if (isset($parts[2])) {
                        $this->action = $parts[2] . "Action";
                    }
                    if (isset($parts[3])) {
                        $count_args = count($parts);
                        $k = 1;
                        $args = array();
                        for ($i = 2; $i < $count_args; $i++)
                            $args[$k++] = $parts[$i];
                        $this->args = $args;
                    }
                }else{      //all
                    $this->controller = $parts[0];
                    if (isset($parts[1])) {
                        $this->action = $parts[1] . "Action";
                    }
                    if (isset($parts[2])) {
                        $count_args = count($parts);
                        $k = 1;
                        $args = array();
                        for ($i = 2; $i < $count_args; $i++)
                            $args[$k++] = $parts[$i];
                        $this->args = $args;
                    }
                }
            }

            if (empty($this->controller)) {
                $this->controller = 'index';
            }

            /*** Get action ***/
            if (empty($this->action)) {
                $this->action = 'indexAction';
            }
        }
        /*** set the file path ***/
        $this->file = $this->path . '/' . $this->controller . 'Controller.php';

    }
}