<?php
Abstract Class baseController {

    /*
     * @registry object
     */
    protected $registry;
    protected $module='';
    protected $model;
    protected $view;

    function __construct($registry) {
        $this->registry = $registry;
        $this->module  = $registry->module;
        $this->model = new baseModel();
        $this->view  = new baseView();
    }


    /**
     * @all controllers must contain an index method
     */
    abstract function indexAction();
}
?>