<?php
include __SITE_PATH . '/core/helpers.php';
include __SITE_PATH . '/core/url.php';
include __SITE_PATH . '/core/string.php';
/*** include the controller class ***/
include __SITE_PATH . '/' . 'core/controller_base.class.php';
include __SITE_PATH . '/' . 'core/controller_base_admin.class.php';
include __SITE_PATH . '/core/' . 'exception.class.php';
include __SITE_PATH . '/core/' . 'database.class.php';
include __SITE_PATH . '/core/' . 'session.class.php';
/*** include the view class ***/
include __SITE_PATH . '/core/' . 'view_base.class.php';

/*** include the model class ***/
include __SITE_PATH . '/core/' . 'model_base.class.php';

/*** include the registry class ***/
include __SITE_PATH . '/core/' . 'registry.class.php';

/*** include the router class ***/
include __SITE_PATH . '/core/' . 'router.class.php';
?>