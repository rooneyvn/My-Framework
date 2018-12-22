<?php
class productController extends baseController{
    public function indexAction(){
        echo 'Manage product';
    }

    public function testAction(){
        dprint($_GET);
    }
}