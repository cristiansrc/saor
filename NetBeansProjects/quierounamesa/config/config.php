<?php
//FOLDER INI
define('_FOLDER_DEVELOPER', 'developer');
define('_FOLDER_TEST', '');
define('_FOLDER_PRODUCTION', '');
define('_VIEW_ERRORS', true);
//Ambiente de despliegue
define('_ENVIRONMENT',_ENV_DEVELOPER);
//Clase por defecto
define('_CLASS_DEFAULT_URI', 'persona');
//Metodo por defecto
define('_METOD_DEFAULT_URI', 'init');
//Zona horarioa
define("_TIME_ZONE", "America/Bogota");
//Zona horarioa
define("_LOCALE", "es_CO");
//etiquetas html permitidas para recibir por get o por post
define("_TAGS_PERM_POST_GET", "strong,em");

//Atributos html permitidas para recibir por get o por post
define("_ATRR_PERM_POST_GET", "href,dir");
?>