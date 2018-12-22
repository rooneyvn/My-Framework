<?php
class Url {
    public static function addParam($base_url, $params){
        if($base_url == ""){
            $url = self::getCurrentAddress();
        }else{
            $url = $base_url;
        }
        $segments = explode('?', $url);
        if(count($segments) > 1){
            parse_str($segments[1], $current_params);
            foreach($params as $k => $v){
                $current_params[$k] = $v;
            }
            $query = $current_params;
        }else{
            $query = $params;
        }

        $final_params = array();
        if(count($query) > 0){
            foreach($query as $k => $v){
                if(is_array($v)){
                    foreach($v as $i){
                        $final_params[] = $k ."[]=". $i;
                    }
                }else{
                    $final_params[] = $k ."=". $v;
                }
            }
        }

        return $segments[0] . (count($final_params) > 0?"?". implode('&', $final_params):"");
    }

    public static function removeParam($url, $params){
        if($url == ''){
            $url = self::getCurrentAddress();
        }
        $segments = explode('?', $url);
        $query = array();
        if(count($segments) > 1){
            parse_str($segments[1], $current_params);
            foreach($params as $k){
                if(isset($current_params[$k])){
                    unset($current_params[$k]);
                }
            }
            $query = $current_params;
        }

        $final_params = array();
        if(count($query) > 0){
            foreach($query as $k => $v){
                if(is_array($v)){
                    foreach($v as $i){
                        $final_params[] = $k ."[]=". $i;
                    }
                }else{
                    $final_params[] = $k ."=". $v;
                }
            }
        }

        return $segments[0] . (count($final_params) > 0?"?". implode('&', $final_params):"");
    }
    public static function responseGifNull(){
        header('Content-Type: image/gif');
        die(base64_decode('R0lGODlhAQABAJAAAP8AAAAAACH5BAUQAAAALAAAAAABAAEAAAICBAEAOw=='));
    }
    public static function redirect($url){
        if($url != ""){
            @header("Location: ". $url);
        }else{
            @header("Location: ". getDomainUrl());
        }
    }


    public static function isPost(){
        if(sizeof($_POST) > 0 || $_SERVER['REQUEST_METHOD'] == 'POST'){
            return true;
        }else{
            return false;
        }
    }

    public static function isAjax(){
        if(self::getParam('_requestType') == 'ajax' || (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')){
            return true;
        }else{
            return false;
        }
    }

    public static function isJson(){
        if(self::getParam('_responseType') == 'json'){
            return true;
        }else{
            return false;
        }
    }

    public static function getCSRF(){
        return self::getParam('_CSRF');
    }

    public static function isValidCSRF(){
        if(self::getCSRF() != My_Session::getCSRF()){
            return false;
        }else{
            return true;
        }
    }

    public static function getRequestPath(){
        $currentAddress = self::getCurrentAddress();
        $path = substr($currentAddress, strlen(getDomainUrl()));
        $result = '';
        if (preg_match('#^/([^?]+)(\?|$)#U', $path, $match))
        {
            $result = urldecode($match[1]);
        }
        else if (preg_match('#\?([^=&]+)(&|$)#U', $path, $match))
        {
            $result = urldecode($match[1]);
        }
        if ($result !== null)
        {
            return ltrim($result, '/');
        }

        return '';
    }

    public static function getParams(){
        $params = self::getQueryString();
        if(is_array($params)){
            $params = array_merge($params,$_POST);
        }else{
            $params = $_POST;
        }
        return $params;
    }

    public static  function initParams(){
        $params = self::getParams();
        if(is_array($params)){
            set('request/params',$params);
            set('requestPaths',self::getRequestPath());
        }
    }

    public static function getQueryString(){
        if(sizeof(get('request/querystring')) > 0){
            return get('request/querystring');
        }else{
            $currentAddress = self::getCurrentAddress();
            $check = explode('?',$currentAddress);
            if(sizeof($check) > 1){
                $queryString = explode('#',$check[1]);
                $queryString = $queryString[0];
                parse_str($queryString, $output);
                if(sizeof($output) > 0){
                    set('request/querystring',$output);
                    return $output;
                }else{
                    return array();
                }
            }else{
                return array();
            }
        }
    }

    public static function getParam($key){
        if($key!=""){
            return get('request/params/'. $key);
        }else{
            return false;
        }
    }

    public static function setParam($key,$value){
        if($key!=""){
            set('request/params/'. $key,$value);
            return true;
        }else{
            return false;
        }
    }

    public static function getCurrentAddress(){
        $address = ( isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') ? 'https://' : 'http://';
        $address .= isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
        $address .= isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : getenv('REQUEST_URI');
        return $address;
    }
}