<?php

Class baseView
{


    /*
     * @Variables array
     * @access public
     */
    public $data = array();
    private static $instance;

    /**
     *
     * @constructor
     *
     * @access public
     *
     * @return void
     *
     */
    function __construct()
    {

    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new baseView();
        }
        return self::$instance;
    }

    /**
     *
     * @set undefined vars
     *
     * @param string $index
     *
     * @param mixed $value
     *
     * @return void
     *
     */
    public function __set($index, $value)
    {
        $this->vars[$index] = $value;
    }


    function show($name, $layout = 'default')
    {
        global $registry;
        $content = $this->getViewContent($name);
        if ($layout != null) {
            $layoutPath = __SITE_PATH . '/app/'.$registry->router->module.'/views/layouts/' . $layout . '' . '.php';
            if (file_exists($layoutPath)) {
                include($layoutPath);
            } else {
                throw new My_Exception(__FILE__ . ' | Layout not exist');
            }
        }


    }

    public function show_partial($view)
    {
        global $registry;
        $viewPath = __SITE_PATH . '/app/'.$registry->router->module.'/views' .'/'.$registry->router->controller. '/'.$view . '.php';
        if (file_exists($viewPath)) {
            // Load variables
            foreach ($this->data as $key => $value) {
                $$key = $value;
            }
            include($viewPath);
        } else {
            throw new My_Exception(__FILE__ . ' | View not exist');
        }
    }

    private function getViewContent($view)
    {
        global $registry;
        $viewPath = __SITE_PATH . '/app/'.$registry->router->module.'/views' . '/'.$registry->router->controller. '/'.$view . '.php';
        if (file_exists($viewPath)) {
            ob_start();
            // Load variables
            foreach ($this->data as $key => $value) {
                $$key = $value;
            }
            include($viewPath);
            return ob_get_clean();
        } else {
            throw new My_Exception(__FILE__ . ' | View not exist');
        }
    }

}

?>