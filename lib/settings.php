<?php
/**************************************************
* PluginLotto.com                                 *
* Copyrights (c) 2005-2010. iZAP                  *
* All rights reserved                             *
***************************************************
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* @version {version} $Revision: {revision}
* Under this agreement, No one has rights to sell this script further.
* For more information. Contact "Tarun Jangra<tarun@izap.in>"
* For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
* Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

global $CONFIG;

return array(
        'plugin' => array(
                'name' => 'izap-user-points',

                'url_title' => 'userpoints',

                'actions' => array(
                        GLOBAL_IZAP_USER_POINTS_ACTIONHANDLER . '/save_admin_settings' => array(
                                'file' => 'save_admin_settings.php',
                                'admin_only' => TRUE,
                        )
                ),

                'events' => array(
                        'create' => array(
                                'all' => array(
                                        'func_izap_user_point_increment',
                                ),
                        ),

                        'delete' => array(
                                'all' => array(
                                        'func_izap_user_point_decrement',
                                ),
                        ),

                        'login' => array(
                                'user' => array(
                                        'func_izap_user_point_increment_on_login',
                                ),
                        ),
                ),

                'extend' => array(
                        'profile/menu/links' => array(
                                'izap-user-points/points_in_menu' => array(
                                        'priority' => 1
                                ),
                        ),

                        'profile/profilelinks' => array(
                                'izap-user-points/points_in_main_profile' => array(
                                        'priority' => 1,
                                ),
                        ),

                        'profile/status' => array(
                                'izap-user-points/points_in_listing' => array(
                                ),
                        ),
                ),

                'submenu' => array(
                        'admin' => array(
                                'pg/userpoints/settings/' => array('title' => up_echo('admin_settings'), 'admin_only' => TRUE),
                        ),
                ),

        ),

        'includes'=>array(
                dirname(__FILE__) . '/classes' => array('class.IzapUserPoints.php'),
                dirname(__FILE__) . '/functions' => array('func.core.php'),
        ),

        'path' => array(

                'www' => array(
                        'page' => $CONFIG->wwwroot . 'pg/userpoints/',
                        'images' => $CONFIG->wwwroot . 'mod/izap-user-points/_graphics/',
                        'action' => $CONFIG->wwwroot . 'action/' . GLOBAL_IZAP_USER_POINTS_ACTIONHANDLER . '/',
                ),

                'dir' => array(
                        'plugin' => dirname(dirname(__FILE__))."/",
                        'actions' => $CONFIG->pluginspath."izap-user-points/actions/",
                        'class' => dirname(__FILE__)."/classes/",
                        'functions' => dirname(__FILE__)."/functions/",
                        'lib' => dirname(__FILE__) . '/',
                        'views' => array(
                                'home' => 'izap-user-points/',
                                'forms' => 'izap-user-points/forms/',
                        ),
                ),
        ),
);