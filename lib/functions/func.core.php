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

function func_izap_user_point_increment($event, $object_type, $object) {
  if($object) {
    $izap_user_point = new IzapUserPoints();
    $izap_user_point->increasePoint($object);
  }
}

function func_izap_user_point_decrement($event, $object_type, $object) {
  if($object) {
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
  
  $sqlite = new IzapSqlite($CONFIG->dataroot . '/' . GLOBAL_IZAP_USER_POINTS_PLUGIN . '/'.GLOBAL_IZAP_USER_POINTS_SQLITE_DB.'.db');
  $query = 'SELECT * FROM user_coupons WHERE expire_time > '.time().'';
  return $sqlite->execute($query);
}

function izap_update_coupon_status_user_points($coupon_code, $status = 'yes') {
  global $CONFIG;

  $sqlite = new IzapSqlite($CONFIG->dataroot . '/' . GLOBAL_IZAP_USER_POINTS_PLUGIN . '/'.GLOBAL_IZAP_USER_POINTS_SQLITE_DB.'.db');
  $query = 'UPDATE user_coupons SET used="'.$status.'" WHERE coupon_code = "'.$coupon_code.'"';
  return $sqlite->execute($query);
}