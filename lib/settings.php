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

/**
 *
 */
$INITIAL_URL = 'pg/' . GLOBAL_IZAP_USER_POINTS_PAGEHANDLER;

return array(
        'plugin' => array(
                'name' => 'izap-user-points',
                'url_title' => GLOBAL_IZAP_USER_POINTS_PAGEHANDLER,
                'layout' => 'two_column_left_sidebar',
                'objects' => array(
                        GLOBAL_IZAP_USER_POINTS_SUBTYPE => array(
                                'type' => 'object',
                                'class' => GLOBAL_IZAP_USER_POINTS_SUBTYPE,
                                'searchable' => FALSE,
                        ),
                ),

                'actions' => array(
                        GLOBAL_IZAP_USER_POINTS_ACTIONHANDLER . '/save_admin_settings' => array(
                                'file' => 'save_admin_settings.php',
                                'admin_only' => TRUE,
                        ),

                        GLOBAL_IZAP_USER_POINTS_ACTIONHANDLER . '/save_redeem_coupon' => array(
                                'file' => 'save_redeem_coupon.php',
                                'admin_only' => TRUE,
                        ),

                        GLOBAL_IZAP_USER_POINTS_ACTIONHANDLER . '/buy_offer' => array(
                                'file' => 'buy_offer.php',
                                'public' => FALSE,
                        ),

                        GLOBAL_IZAP_USER_POINTS_ACTIONHANDLER . '/mark_as_used' => array(
                                'file' => 'mark_as_used.php',
                                'admin_only' => TRUE,
                        ),
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

                'menu' => array(
                        $INITIAL_URL . '/site_offers/' => array(
                                'title' => elgg_echo('izap-user-points:redeem_offers'),
                                'active' => izap_active_site_offers_user_points(),
                        )
                ),

                'submenu' => array(
                        'admin' => array(
                                $INITIAL_URL . '/settings/' => array(
                                        'title' => elgg_echo('izap-user-points:admin_settings'),
                                        'admin_only' => TRUE,
                                        'groupby' => 'USER_POINTS'
                                ),

                                $INITIAL_URL . '/redeem_coupon/' => array(
                                        'title' => elgg_echo('izap-user-points:create_redeem_offer'),
                                        'admin_only' => TRUE,
                                        'groupby' => 'USER_POINTS'
                                ),

                                $INITIAL_URL . '/check_coupon/' => array(
                                        'title' => elgg_echo('izap-user-points:check_coupon'),
                                        'admin_only' => TRUE,
                                        'groupby' => 'USER_POINTS'
                                ),
                        ),

                        GLOBAL_IZAP_USER_POINTS_PAGEHANDLER => array(
                                $INITIAL_URL . '/site_offers/' => array(
                                        'title' => elgg_echo('izap-user-points:redeem_offers'),
                                        'public' => FALSE,
                                        'groupby' => 'USER_POINTS'
                                ),
                        ),
                ),

        ),

        'includes'=>array(
                dirname(__FILE__) . '/classes' => array('class.IzapUserPoints.php', 'IzapRedeemOffer.php'),
                dirname(__FILE__) . '/functions' => array('func.core.php'),
        ),

        'path' => array(

                'www' => array(
                        'page' => $CONFIG->wwwroot . 'pg/'.GLOBAL_IZAP_USER_POINTS_PAGEHANDLER.'/',
                        'images' => $CONFIG->wwwroot . 'mod/'.GLOBAL_IZAP_USER_POINTS_PLUGIN.'/_graphics/',
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