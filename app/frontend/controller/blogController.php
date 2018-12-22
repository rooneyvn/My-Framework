<?php
Class blogController Extends baseController {

    public function indexAction()
    {
        $rs = $this->model->get('blogModel')->get_blogs();
        $this->view->data['blogs'] = $rs->rows;
        $this->view->data['blog_heading'] = 'This is the blog Index';
        $this->view->show('blog_index');
    }

    public function viewAction(){
        $id_blog = (int)Url::getParam('id');
        if($id_blog<=0){
            $id_blog = isset($_GET['id'])?$_GET['id']:0;
        }
        $blog_detail = $this->model->get('blogModel')->get_blog_detail($id_blog);
        $this->view->data['blog_heading'] = $blog_detail['title'];
        $this->view->data['blog_content'] = $blog_detail['content'];
        $this->view->show('blog_view');
    }

}
?>