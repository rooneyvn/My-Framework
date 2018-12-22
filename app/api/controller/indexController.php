<?php
Class indexController Extends baseController {
    public function indexAction() {
        /*** set a template variable ***/
        $this->view->data['welcome'] = 'API..';
        /*** load the index template ***/
        $this->view->show('index');
    }

    public function testAction(){
        dprint($_GET);
    }

}
?>