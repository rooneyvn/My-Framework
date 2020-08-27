<?php

Class blogModel Extends baseModel {
    public function get_blogs($skip=0,$limit=10)
    {
        $res = $this->_getDb()->fetchAll("SELECT p.*, c.`title` as 'category_title' 
                    FROM #__blog_post p INNER JOIN #__blog_category c ON p.`category_id` = c.`category_id`  
                    WHERE p.`deleted` = 0 LIMIT ".(int)$skip.",".(int)$limit." ");
        $count = $this->_getDb()->fetchRow("SELECT COUNT(*) AS 'total'
                    FROM #__blog_post p INNER JOIN #__blog_category c ON p.`category_id` = c.`category_id`  
                    WHERE p.`deleted` = 0 ");
        return [
            'total' =>  isset($count['total'])?$count['total']:0,
            'items' =>  $res
        ];
    }
    public function get_blog_detail($id)
    {
        $res = $this->_getDb()->fetchRow("SELECT * FROM #__blog_post where `post_id` = '".(int)$id."' ");
        return $res;
    }
}
?>