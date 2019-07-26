<?php
/* configuracion.php */
if (version_compare(PHP_VERSION, "7.0") <= 0) {
	die("Necesitas PHP en su versión 7 a lo menos. Ahora usas " . PHP_VERSION . "\n");
}
date_default_timezone_set("Chile/Continental");
define('BLOCKPC_CL', 'blockpc.cl');

if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
	$uri = 'https://';
	define('SESION_SEGURA', 1);
} else {
	$uri = 'http://';
	define('SESION_SEGURA', 0);
}
define('DOMINIO', $_SERVER['SERVER_NAME']);
$uri .= DOMINIO . '/';

if ( DOMINIO == 'localhost' ) {
	define('SESION_PATH', '/base.local/');
	define('SESION_DOMAIN', '/');
	define('URL_BASE', $uri . 'base.local/');
	define('PRODUCCION', false); # En Desarrollo, se establece en FALSE
} else {
	define('SESION_PATH', '/');
	define('SESION_DOMAIN', DOMINIO);
	define('URL_BASE', $uri);
	define('PRODUCCION', true); # En Producción, se establece en TRUE
}

if(!PRODUCCION) {
	ini_set('error_reporting', E_ALL | E_NOTICE | E_STRICT);
	ini_set('display_errors', 1);
} else {
	ini_set('display_errors', 0);
}

mb_internal_encoding('UTF-8');
header('Content-Type: text/html; charset=UTF-8');

# Definir constantes para el envió de correo
define('CORREO_CONTACTO', 'soporte@blockpc.cl');
define('NOMBRE_CONTACTO', 'Soporte BlockPC');

# Definimos constantes globales generales
define('APP_NAME', 'BlockPC Base');
define('TIEMPO_SESION', 60); # Tiempo en minutos
define('MODULO_POR_DEFECTO', 'index');
define('CONTROLADOR_POR_DEFECTO', 'index');
define('METODO_POR_DEFECTO', 'index');
define('PLANTILLA_POR_DEFECTO', 'frontend');
define('PLANTILLA_ADMINISTRADOR', 'backend');

# Definimos Rutas para la aplicación
define('RUTA_PLANTILLAS', RUTA . 'plantillas' . DS);
define('RUTA_ARCHIVOS', RUTA . 'archivos' . DS);
define('RUTA_ARCHIVOS_USUARIOS', RUTA_ARCHIVOS . 'usuarios' . DS);

# Definimos URLs para la aplicación
define('URL_PLANTILLAS', URL_BASE . 'plantillas/');
define('URL_ARCHIVOS', URL_BASE . 'archivos/');
define('URL_ARCHIVOS_USUARIOS', URL_ARCHIVOS . 'usuarios/');

# Definimos acceso a BD
define('DB_DSN', false);
define('ACL', false); # Si no se necesita ACL asignar 'false'

# Versión del framework
defined('APP_VERSION') OR define('APP_VERSION', '1.2.1');
defined('APP_SISTEMA') OR define('APP_SISTEMA', 'Framework Blockpc');
defined('APP_CODIGO') OR define('APP_CODIGO', 1);
defined('APP_FECHA') OR define('APP_FECHA', 'Julio &copy; 2019');