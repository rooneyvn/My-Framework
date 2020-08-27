<?php
Class blogController Extends baseController {

    public function indexAction()
    {
        $page = isset($_GET['page'])?$_GET['page']:1;
        $page = max(1,$page);
        $limit=10;
        $skip = ($page - 1) * $limit;
        $rs = $this->model->get('blogModel')->get_blogs($skip,$limit);
        $total = $rs['total'];
        $total_page = ceil($total/$limit);
        if($page > $total_page){
            Url::redirect(url('blog'));
        }
        $this->view->data['page'] = $page;
        $this->view->data['skip'] = $skip;
        $this->view->data['limit'] = $limit;
        $this->view->data['total_page'] = $total_page;
        $this->view->data['blogs'] = $rs['items'];
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