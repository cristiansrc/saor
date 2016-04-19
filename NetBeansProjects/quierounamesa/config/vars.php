<?php
//Ambientes
define('_ENV_DEVELOPER','ordermanager');
define('_ENV_TEST','');
define('_ENV_PRODUCTION','');

//Root
define('_ROOT_FOLDER', $_SERVER['DOCUMENT_ROOT'] . '/');

//Folders
define('FOLDER_CLASS', 'class');
define('FOLDER_CONFIG', 'config');
define('FOLDER_CONTROLLER', 'controller');
define('FOLDER_VIEW', 'view');
define('FOLDER_ZELO', 'zelo');
//Url
define('_URL_HOST', $_SERVER['HTTP_HOST']);
//URI
define('_URL_URI', $_SERVER['REQUEST_URI']);
?>