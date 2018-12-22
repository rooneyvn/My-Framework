<?php

Class errorController Extends baseController {

    public function indexAction()
    {
        $this->view->data['blog_heading'] = 'This is the 404';
        $this->view->show('index');
    }
}
?>