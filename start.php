<?php

/* * ************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2010. iZAP                  *
 * All rights reserved                             *
 * **************************************************
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
define('GLOBAL_IZAP_USER_POINTS_SQLITE_DB', 'coupons02');

function func_izap_start_giving_points() {
  global $CONFIG;

  izap_plugin_init(GLOBAL_IZAP_USER_POINTS_PLUGIN);

  elgg_register_event_handler('create', 'all', 'func_izap_user_point_increment');
  elgg_register_event_handler('delete', 'all', 'func_izap_user_point_decrement');
  elgg_register_event_handler('login', 'user', 'func_izap_user_point_increment_on_login');


  $CONFIG->valid_types_for_points = array('object', 'group', 'annotation');

  elgg_register_plugin_hook_handler('register', 'menu:user_hover', 'func_user_points_in_main_profile');
//  elgg_register_plugin_hook_handler('register', 'menu:owner_block', 'func_user_points_in_main_profile');

  elgg_extend_view('user/status', GLOBAL_IZAP_USER_POINTS_PLUGIN . '/points_in_listing');

  elgg_register_page_handler(GLOBAL_IZAP_USER_POINTS_PAGEHANDLER, GLOBAL_IZAP_PAGEHANDLER);

  elgg_register_admin_menu_item('userpoints', 'izap-user-points', 'izap-userpoints-section');
  elgg_register_admin_menu_item('userpoints', 'redeem_coupon', 'izap-userpoints-section');
  elgg_register_admin_menu_item('userpoints', 'check_coupon', 'izap-userpoints-section');


  if(IzapBase::pluginSetting(array(
              'plugin' => GLOBAL_IZAP_USER_POINTS_PLUGIN,
              'name' => 'izap_activate_site_offers'))=='yes'){
  $menu_item = new ElggMenuItem('izap-user-points', elgg_echo('izap_user_points:site_offers'),
                  IzapBase::setHref(array(
                      'context' => GLOBAL_IZAP_USER_POINTS_PAGEHANDLER,
                      'action' => 'offers',
                      'page_owner' => false
                  )));
  elgg_register_menu_item('site', $menu_item);
              }

  $top_user = new ElggMenuItem('izap-top-users', elgg_echo('izap-user-point:top_users'),
                  IzapBase::setHref(array(
                      'context' => GLOBAL_IZAP_USER_POINTS_PAGEHANDLER,
                      'page_owner' =>false
                  )));
  elgg_register_menu_item('site', $top_user);
}

function izap_active_site_offers_user_points() {
  $activate_site_offers = IzapBase::pluginSetting(array(
              'plugin' => GLOBAL_IZAP_USER_POINTS_PLUGIN,
              'name' => 'izap_activate_site_offers',
              'value' => 'no',
          ));

  if ($activate_site_offers == 'yes') {
    return TRUE;
  }

  return FALSE;
}

elgg_register_event_handler('init', 'system', 'func_izap_start_giving_points');

function func_izap_user_point_increment($event, $object_type, $object) {
  global $CONFIG;
  if ($object && in_array($object_type, $CONFIG->valid_types_for_points)) {
    $izap_user_point = new IzapUserPoints();
    $izap_user_point->increasePoint($object);
  }
}

function func_izap_user_point_decrement($event, $object_type, $object) {
  global $CONFIG;
  if ($object && in_array($object_type, $CONFIG->valid_types_for_points)) {
    $izap_user_point = new IzapUserPoints();
    $izap_user_point->decreasePoint($object);
  }
}

function func_izap_user_point_increment_on_login($event, $object_type, $object) {
  $izap_user_point = new IzapUserPoints();
  $izap_user_point->eventBasedIncreasePoint($event);
}

function izap_get_offer_coupons() {
  global $CONFIG;

  $sqlite = new IzapSqlite($CONFIG->dataroot . '/' . GLOBAL_IZAP_USER_POINTS_PLUGIN . '/' . GLOBAL_IZAP_USER_POINTS_SQLITE_DB . '.db');
  $query = 'SELECT * FROM user_coupons WHERE expire_time > ' . time() . '';
  return $sqlite->execute($query);
}

function izap_update_coupon_status_user_points($coupon_code, $status = 'yes') {
  global $CONFIG;

  $sqlite = new IzapSqlite($CONFIG->dataroot . '/' . GLOBAL_IZAP_USER_POINTS_PLUGIN . '/' . GLOBAL_IZAP_USER_POINTS_SQLITE_DB . '.db');
  $query = 'UPDATE user_coupons SET used="' . $status . '" WHERE coupon_code = "' . $coupon_code . '"';
  return $sqlite->execute($query);
}

function func_user_points_in_main_profile($hook, $type, $return, $params) {
  
  $user = $params['entity'];
//  c($user);
//  echo $user->izap_points;exit;
  if (elgg_instanceof($user, 'user')) {;
     $point_str .= sprintf(elgg_echo('izap-user:total_points'), $user->izap_points,IzapUserPoints::getUserRank($user->izap_points));
//    $point_str .= elgg_echo('izap-user:total_points');
//    $point_str .= ' ('.IzapUserPoints::getUserRank($points).')';
    $item = new ElggMenuItem(GLOBAL_IZAP_USER_POINTS_PLUGIN, $point_str, '#');
    $return[] = $item;
  }
  return $return;
}
