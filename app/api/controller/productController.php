<?php
class productController extends baseController{
    public function indexAction(){
        echo 'list product';
    }

    public function testAction(){
        dprint($_GET);
    }
}