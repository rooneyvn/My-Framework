<?php
if (!function_exists('dd')) {
    function dd($var, $debug = false)
    {
        echo '<xmp>';
        if ($debug) {
            var_dump($var);
        } else {
            print_r($var);
        }
        echo '</xmp>';
        die;
    }
}

if (!function_exists('dprint')) {
    function dprint($var)
    {
        echo '<xmp>';
        print_r($var);
        echo '</xmp>';
    }
}

if (!function_exists('get')) {
    function get($key, $group = null)
    {
        global $_ENV;
        $k = explode('/', $group === null ? $key : $group . '/' . $key);
        switch (count($k)) {
            case 1:
                return isset($_ENV[$k[0]]) ? $_ENV[$k[0]] : null;
                break;
            case 2:
                return isset($_ENV[$k[0]][$k[1]]) ? $_ENV[$k[0]][$k[1]] : null;
                break;
            case 3:
                return isset($_ENV[$k[0]][$k[1]][$k[2]]) ? $_ENV[$k[0]][$k[1]][$k[2]] : null;
                break;
            case 4:
                return isset($_ENV[$k[0]][$k[1]][$k[2]][$k[3]]) ? $_ENV[$k[0]][$k[1]][$k[2]][$k[3]] : null;
                break;
            case 5:
                return isset($_ENV[$k[0]][$k[1]][$k[2]][$k[3]][$k[4]]) ? $_ENV[$k[0]][$k[1]][$k[2]][$k[3]][$k[4]] : null;
                break;
        }
        return null;
    }
}
if (!function_exists('set')) {

    function set($key, $value, $group = null)
    {
        global $_ENV;
        $k = explode('/', $group === null ? $key : $group . '/' . $key);
        if (in_array($k[0], array('config', 'options', 'db', 'session', 'cache'))) {
            return false;
        }
        switch (count($k)) {
            case 1:
                $_ENV[$k[0]] = $value;
                break;
            case 2:
                $_ENV[$k[0]][$k[1]] = $value;
                break;
            case 3:
                $_ENV[$k[0]][$k[1]][$k[2]] = $value;
                break;
            case 4:
                $_ENV[$k[0]][$k[1]][$k[2]][$k[3]] = $value;
                break;
            case 5:
                $_ENV[$k[0]][$k[1]][$k[2]][$k[3]][$k[4]] = $value;
                break;
        }
        return true;
    }
}
if (!function_exists('getPageLink')) {
    function getPageLink($alias = '', $params = array())
    {
        $queryString = '';
        $segment = array();
        if (count($params) > 0) {
            foreach ($params as $k => $v) {
                $segment[] = urlencode($k) . '=' . urlencode($v);
            }
            $queryString = '?' . implode('&', $segment);
        }
        return getDomainUrl() . '/' . $alias . $queryString;
    }
}
if (!function_exists('getDomainUrl')) {
    function getDomainUrl()
    {
        global $registry;
        return $registry->config['domain'];
    }
}

if (!function_exists('is_login')) {
    function is_login()
    {
        return (My_Session::get('user_id') > 0) ? true : false;
    }
}

if (!function_exists('is_supper_admin')) {
    function is_supper_admin()
    {
        global $registry;
        $superAdmins = preg_split(
            '#\s*,\s*#', $registry->config['superAdmins'],
            -1, PREG_SPLIT_NO_EMPTY
        );
        $user_id = My_Session::get('user_id');
        return in_array($user_id, $superAdmins);
    }
}
if(!function_exists('buildPagination')){
    function buildPagination($baseUrl, $totalPage, $currentPage, $offsetPage = 5, $addClass = ''){
        if(strpos($baseUrl,'?') > 1){
            $indicate = '&';
        }else{
            $indicate = '?';
        }
        if($totalPage > 1){
            $output = "<div class='mava_pagination'><div class='mava_pagination_inner ". $addClass ."'>";
            $page = max($currentPage,1);
            $start = $page - $offsetPage;
            if($start < 1){
                $start = 1;
            }

            $end = $page + $offsetPage;
            if($end > $totalPage){
                $end = $totalPage;
            }

            if($page > 1){
                $output .= "<a href='". $baseUrl . $indicate .'page='. ($page-1) ."' class='prev' title='". __('prev_page') ."'><span class='prev_page_icon'></span>". __('prev_page') ."</a> ";
            }else{
                $output .= "<a href='javascript:void(0);' class='prev disabled' title='". __('prev_page') ."'><span class='prev_page_icon'></span>". __('prev_page') ."</a> ";
            }


            if($page-$offsetPage > 1){
                $output .= " <a href='". $baseUrl ."'>1</a> ";
            }

            if($page > ($offsetPage+2)){
                $output .= "<a href='javascript:void(0);' class='disabled' style='border: 0;background: none;'>...</a>";
            }

            for($i=$start;$i<= $end; $i++){
                if($i == $page){
                    $output .= " <a href='javascript:void(0);' class='selected'>". $i ."</a> ";
                }else{
                    $output .= " <a href='". $baseUrl . $indicate .'page='. $i ."'>". $i ."</a> ";
                }

            }

            if($page < ($totalPage-$offsetPage-1)){
                $output .= "<a href='javascript:void(0);' class='disabled' style='border: 0;background: none;'>...</a>";
            }


            if($page+$offsetPage < $totalPage){
                $output .= " <a href='". $baseUrl . $indicate .'page='. $totalPage ."'>". $totalPage ."</a> ";
            }

            if($page < $totalPage){
                $output .= "<a href='". $baseUrl . $indicate .'page='. ($page+1) ."' class='next' title='". __('next_page') ."'>". __('next_page') ."<span class='next_page_icon'></span></a> ";
            }else{
                $output .= "<a href='javascript:void(0);' class='next disabled' title='". __('next_page') ."'>". __('next_page') ."<span class='next_page_icon'></span></a> ";
            }

            $output .= '</div></div>';
            return $output;
        }else{
            return '';
        }
    }
}

if(!function_exists('url')){
    function url($path, $params = array())
    {
        return Url::buildLink(ltrim($path, '/'), $params);
    }
}

if (!function_exists('__')) {
    function __($key, $params = array(), $returnKeyIfNotExist = true)
    {
        return $key;
    }
}