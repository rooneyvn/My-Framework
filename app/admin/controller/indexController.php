<?php
Class indexController Extends baseAdminController {
    public function indexAction() {
        /*** set a template variable ***/
        $this->view->data['welcome'] = 'Welcome to Admin';
        /*** load the index template ***/
        if(Url::isPost()){
            //code here...
        }
        $this->view->show('index');
    }

    public function test(){
        echo 'Test';
    }

}
?>