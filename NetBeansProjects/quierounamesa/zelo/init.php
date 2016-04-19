<?php 
//error_reporting(E_ERROR | E_WARNING | E_NOTICE);
session_start();
include_once('config/vars.php');
include_once('config/config.php');
include_once('config/configDb.php');  
include_once('config/configMail.php');

date_default_timezone_set(_TIME_ZONE);
setlocale(LC_ALL,_LOCALE);

if(_VIEW_ERRORS){
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}else{
    error_reporting(E_ALL);
    ini_set('display_errors', '0');
}

switch (_ENVIRONMENT) {
    case _ENV_DEVELOPER:
        define('_ROOT_APP'          , _ROOT_FOLDER . _FOLDER_DEVELOPER);
        define('_APPLICACION_URL'   , (strpos(_URL_HOST, 'http') === false) ? 'http://' . _URL_HOST  . '/' . _FOLDER_DEVELOPER . '/':  _URL_HOST . '/' . _FOLDER_DEVELOPER . '/');
        define('_FOLDER'            , _FOLDER_DEVELOPER);
        define('_HOST_DB'           ,_HOST_DEVELOPER);
        define('_USER_DB'           ,_USER_DEVELOPER);
        define('_PASS_DB'           ,_PASS_DEVELOPER);
        define('_DB'                ,_DB_DEVELOPER);
    break;
    case _ENV_TEST:
        define('_ROOT_APP', _ROOT_FOLDER . _FOLDER_TEST);
        define('_APPLICACION_URL'   , (strpos(_URL_HOST, 'http') === false) ? 'http://' . _URL_HOST  . '/' . _FOLDER_TEST:  _URL_HOST . '/' . _FOLDER_TEST . '/');
        define('_FOLDER',   _FOLDER_TEST);
        define('_HOST_DB',  _HOST_TEST);
        define('_USER_DB',  _USER_TEST);
        define('_PASS_DB',  _PASS_TEST);
        define('_DB',       _DB_TEST);
    break;
    case _ENV_PRODUCTION:
        define('_ROOT_APP', _ROOT_FOLDER . _FOLDER_PRODUCTION);
        define('_APPLICACION_URL'   , (strpos(_URL_HOST, 'http') === false) ? 'http://' . _URL_HOST  . '/' . _FOLDER_PRODUCTION:  _URL_HOST . '/' . _FOLDER_PRODUCTION  . '/');
        define('_FOLDER',   _FOLDER_PRODUCTION);
        define('_HOST_DB',  _HOST_PRODUCTION);
        define('_USER_DB',  _USER_PRODUCTION);
        define('_PASS_DB',  _PASS_PRODUCTION);
        define('_DB',       _DB_PRODUCTION);
    break;
}

define('_ROOT_CONTROLLER'   ,_ROOT_APP . '/controller');
define('_ROOT_HELPER'       ,_ROOT_APP . '/helper');
define('_ROOT_MODEL'        ,_ROOT_APP . '/model');
define('_ROOT_DAO'          ,_ROOT_APP . '/dao');
define('_ROOT_VIEW'         ,_ROOT_APP . '/view');
define('_ZELO_ROOT'         ,_ROOT_APP . '/zelo');
define('_ZELO_FUNTIONS'     ,_ZELO_ROOT . '/functions');
define('_ZELO_CLASS'        ,_ZELO_ROOT . '/class');
define('_ZELO_TEMPLATES'    ,_ROOT_CONTROLLER . '/templates');
define('_ZELO_IMAGES'       ,_ROOT_APP . '/images');
define('_IMAGE_URL', _APPLICACION_URL . 'images/');

$zelo_functions = opendir(_ZELO_FUNTIONS);

while ($element = readdir($zelo_functions)){
    if( $element != "." && $element != ".."){
        if( !is_dir(_ZELO_FUNTIONS . '/' . $element) )
            include_once(_ZELO_FUNTIONS . '/' . $element);
    }
}

closedir($zelo_functions);

$uri        = str_replace('.html', '', str_replace(_FOLDER, '', _URL_URI));
$uri        = str_replace('.php', '', $uri);
$array_uri  = explode('/',$uri);
$array_get  = array();

if(count($array_uri) < 3){
    array_push($array_get, $array_uri[1]);
}else{
    $array_return = array();
    foreach ($array_uri as $variable) {
        if(($variable != "") && ($variable != " ")){
            array_push($array_return, $variable);
        }
    }
    $array_get = $array_return;
}

if($array_get)
{
    if(is_array($array_get))
    {
        $cont   = 0;
        $_GET = array();
        
        foreach ($array_get as $var)
        {
            if($cont != 0 && $cont != 1)
                $_GET[($cont-2)] = $var;

            $cont++;
        }
    }
}

//Limpiar metodos de sql injection
//array_walk($_POST, 'sanitize');
//array_walk($_GET, 'sanitize');

$class_uri  = (isset($array_get[0])) ? $array_get[0]: ((isset($_SESSION['menu_inicial'])) ? $_SESSION['menu_inicial'] : _CLASS_DEFAULT_URI) ;
$method_uri = (isset($array_get[1])) ? $array_get[1] : _METOD_DEFAULT_URI;

define('_CURRENT_CONTROLLER_CLASS' , $class_uri);
define('_CURRENT_CONTROLLER_METHOD' , $method_uri);

include_once(_ZELO_CLASS . '/Controller.class.php');
$zelo_templates = opendir(_ZELO_TEMPLATES);

while ($element = readdir($zelo_templates)){
    if( $element != "." && $element != ".."){
        if( !is_dir(_ZELO_TEMPLATES . '/' . $element) )
            include_once(_ZELO_TEMPLATES . '/' . $element);
    }
}

$class = instance_controller($class_uri);


//$zelo_class = opendir(_ZELO_CLASS);
//include_once(_ZELO_CLASS . '/AsyncOperation.class.php');
//include_once(_ZELO_CLASS . '/ConecOratDb.class.php');
include_once(_ZELO_CLASS . '/adodb5/adodb.inc.php');
include_once(_ZELO_CLASS . '/ConectDb.class.php');
include_once(_ZELO_CLASS . '/HelperDb.class.php');
include_once(_ZELO_CLASS . '/DaoDb.class.php');
include_once(_ZELO_CLASS . '/Model.class.php');
include_once(_ZELO_CLASS . '/PHPExcel/PHPExcel.php');
include_once(_ZELO_CLASS . '/mailer/class.phpmailer.php');
//include_once(_ZELO_CLASS . '/inputfilter/class.inputfilter.php');



/*while ($element = readdir($zelo_class)){
    if( $element != "." && $element != ".."){
        if( !is_dir(_ZELO_CLASS . '/' . $element) )
            include_once(_ZELO_CLASS . '/' . $element);
    }
}*/

//closedir($zelo_class);


if(method_exists($class, $method_uri)){
    
    $class->$method_uri();
}
else
    header("HTTP/1.0 404 Not Found");
?>