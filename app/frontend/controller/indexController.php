<?php
Class indexController Extends baseController {
    public function indexAction() {
        /*** set a template variable ***/
        $this->view->data['welcome'] = 'Welcome to My Blog!';
        /*** load the index template ***/
        $this->view->show('index');
    }

    public function test(){
        echo 'Test';
    }

}
?>