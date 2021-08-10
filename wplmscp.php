<?php
/**
 * @package wpLMSCP
 */
/*
 * Plugin Name: WP LMS Customer Panel
 * Description: LMS customer panel, getting data from LMS through REST
 * Author: Sylwester Zdanowski
 * Author URI: 
 * Version: 1
 * Plugin URI: 
 * License: GNU
 */

##

define( 'WP_DEBUG', false );
define( 'WP_DEBUG_DISPLAY', false );
define( 'WP_DISABLE_FATAL_ERROR_HANDLER', false );
define( 'WP_DEBUG_LOG', '/var/log/apache2/wp-errors.log' );

define( 'LMS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( LMS_PLUGIN_DIR. '/lib/definitions.php' );

require_once( LMS_PLUGIN_DIR. '/lib/RESTInterface.class.php' );
require_once( LMS_PLUGIN_DIR. '/lib/REST.class.php' );
require_once( LMS_PLUGIN_DIR. '/lib/RESTLMS.class.php' );
require_once( LMS_PLUGIN_DIR. '/lib/Session.class.php' );

require_once( LMS_PLUGIN_DIR. '/lib/LMSInterface.class.php' );
require_once( LMS_PLUGIN_DIR. '/lib/LMS.class.php' );

require_once( LMS_PLUGIN_DIR. '/lib/LMSDefault.class.php' );

require_once( LMS_PLUGIN_DIR. '/configuration.php' );

$REST = new RESTLMS();
$SESSION = new Session($REST);

$class=get_option('lms_class');

if(!$class)
    $class='LMSDefault';

$LMS = new $class($SESSION,$REST);

$LMS->InitPlugin();  
$LMS->lms_finances();

?>
