<?php
Class baseAdminController extends baseController{
    function __construct($registry) {
        $this->registry = $registry;
        $this->module  = $registry->module;
        $this->model = new baseModel();
        $this->view  = new baseView();
        $rs = is_supper_admin();
        if(!$rs){
            die ('Access denied');
        }
    }

    public function indexAction(){

    }
}
?>