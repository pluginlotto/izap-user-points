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

define('GLOBAL_IZAP_USER_POINTS_PLUGIN', 'izap-user-points');
define('GLOBAL_IZAP_USER_POINTS_ACTIONHANDLER', 'izap_user_points');
define('GLOBAL_IZAP_USER_POINTS_PAGEHANDLER', 'userpoints');
define('GLOBAL_IZAP_USER_POINTS_SUBTYPE', 'IzapRedeemOffer');
define('GLOBAL_IZAP_USER_POINTS_SQLITE_DB', 'coupons002');

function func_izap_start_giving_points() {
  if(is_plugin_enabled('izap-elgg-bridge')) {
    func_init_plugin_byizap(array('plugin' => array('name' => GLOBAL_IZAP_USER_POINTS_PLUGIN)));
  }else{
    register_error('This plugin needs izap-elgg-bridge');
    disable_plugin(GLOBAL_IZAP_USER_POINTS_PLUGIN);
  }
}

function izap_active_site_offers_user_points() {
  $activate_site_offers = izap_plugin_settings(array(
    'plugin' => GLOBAL_IZAP_USER_POINTS_PLUGIN,
    'setting_name' => 'izap_activate_site_offers',
    'value' => 'no',
  ));

  if($activate_site_offers == 'yes') {
    return TRUE;
  }

  return FALSE;
}

register_elgg_event_handler('init', 'system', 'func_izap_start_giving_points');