<?php
$start_time = microtime(true);
/**
 * @NguyenPV
 */
/*** error reporting on ***/
//error_reporting(E_ALL);

/*** define the site path ***/
$site_path = realpath(dirname(dirname(dirname(__FILE__))));
define ('__SITE_PATH', $site_path);
include $site_path . '/app/common/function.php';
include $site_path . '/app/api/api_function.php';
/*** include the init.php file ***/
include $site_path . '/app/common/init.php';
/*** a new registry object ***/
$registry = new registry;
$registry->module = 'admin';
/*** include the config.php file ***/
$registry->config = array_merge(include $site_path.'/app/common/config.php', include $site_path.'/app/api/api_config.php');
/*** load the router ***/
$registry->router = new router($registry);
$registry->router->setPath($site_path . '/app/api/controller');
$registry->router->loader();
echo '<hr>';
echo (microtime(true) - $start_time).'s';
?>