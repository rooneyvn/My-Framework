<p> >> <a href="<?php echo getPageLink(''); ?>">Home</a></p>
<h1><?php echo (isset($blog_heading)?$blog_heading:''); ?></h1>
<ul>
    <?php
    if(isset($blogs) && is_array($blogs) && count($blogs) > 0){ ?>
        <?php
            foreach($blogs as $blog){
                if(rand(1,3)==1) {
                    $url = getPageLink('tin-tuc/'.String::unsignString($blog['title'],'-') .'-p'. $blog['post_id']);
                }else if(rand(1,3)==2){
                    $url = getPageLink('tin-tuc/'. String::unsignString($blog['category_title'],'-') .'/'. String::unsignString($blog['title'],'-') .'-p'. $blog['post_id']);
                }else{
                    $url = getPageLink('blog/view', array('id' => $blog['post_id']));
                }
            ?>
                <li><a href="<?php echo $url; ?>"><?php echo htmlspecialchars($blog['title']); ?></a></li>
        <?php }
    }
    ?>
</ul>