<?php
return array(
    'router' => array(
        'tin-tuc' => 'blogController/index',
        'tin-tuc/(slug:any)' => 'blog/category',        //controller/action
        'tin-tuc/(slug:any)/(post_slug:any)-p(id:number)' => 'blog/view',
        'tin-tuc/(post_slug:any)-p(id:number)' => 'blog/view',
    )
);
?>