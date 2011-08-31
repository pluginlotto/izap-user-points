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

class IzapUserPoints {
  private $point_array;

  public function __construct() {
  }

  public function getPointArray() {
    $point_settings = get_entity(get_plugin_setting('setting_entity_guid', 'izap-user-points'));
    if(!$point_settings) {
      return FALSE;
    }

    $metadata = get_metadata_for_entity($point_settings->guid);
    foreach($metadata as $meta) {
      $this->point_array[$meta->name] = $meta->value;
    }
  }

  public function increasePoint($object) {
    $this->getPointArray();
    $point = (int)$this->point_array[$this->makePointString($object->getType(), $object->getSubtype())];
    if($point) {
      if(method_exists($object, 'getOwnerEntity')) {
        $user = $object->getOwnerEntity();
      }else {
        $user = get_loggedin_user();
      }
      $object->points_added = $point;
      $user->izap_points = (int)($user->izap_points) + (int) ($object->points_added);
    }
  }

  public function eventBasedIncreasePoint($event, $user = FALSE) {
    $this->getPointArray();
    $point = (int) $this->point_array[$event];
    if($point) {
      if(!$user) {
        $user = get_loggedin_user();
      }
     
      $user->izap_points = (int)($user->izap_points) + $point;
    }
  }

  public function decreasePoint($object) {
    if((int)($object->points_added)) {
      if(method_exists($object, 'getOwnerEntity')) {
        $user = $object->getOwnerEntity();
      }else {
        $user = get_loggedin_user();
      }
      $user->izap_points = (int)($user->izap_points) - (int)($object->points_added);
    }
  }

  public function makePointString($object_type, $object_subtype) {
    return self::makeVarString($object_type, $object_subtype, 'points');
  }

  public function makeActivatedString($object_type, $object_subtype) {
    return self::makeVarString($object_type, $object_subtype, 'activated');
  }

  public function makeVarString($object_type, $object_subtype, $extra) {
    if($object_type == 'annotation' || $object_type == 'group') {
      $object_subtype = 'default';
    }
    return $object_type . '_' . (($object_subtype) ? $object_subtype : 'default') . '_' . $extra;
  }

  public function calculatePoints($operand = '+') {
    $this->getPointArray();
    $point = (int)$this->point_array[$this->makePointString($object_type, $object_subtype)];
    if($point) {
      $user = get_loggedin_user();
      if($operand == '+') {
        $user->izap_points = (int)($user->izap_points) + 1;
      }else {
        $user->izap_points = (int)($user->izap_points) - 1;
      }
    }
  }

  public static function getUserPoints(ElggUser $user = null) {
    if(!elgg_instanceof($user, 'user')) {
      $user = elgg_get_logged_in_user_entity();
    }

    if(!$user) {
      return 0;
    }
    
    $points = (int)$user->izap_points;
    return (($points < 0) ? 0 : $points);
  }

  public static function getRanks() {
    $point_settings = get_entity(elgg_get_plugin_setting('setting_entity_guid', 'izap-user-points'));
    $admin_rules = $point_settings->rank_rules;
    $tmp_array = explode("\n", $admin_rules);
    if(sizeof($tmp_array)) {
      foreach($tmp_array as $rule) {
        $tmp_rule_array = explode('|', $rule);
        $rules_array[(int)$tmp_rule_array[1]] = $tmp_rule_array[0];
      }
    }

    return $rules_array;
  }

  public static function getUserRank($total_points = 0) {
    $ranks = self::getRanks();
    ksort($ranks);
    if($ranks) {
      foreach($ranks as $point => $label) {
        if($total_points <= $point) {
          $return = $label;
          break;
        }
      }
    }

    if(!$return) {
      $return = (end($ranks)) ? end($ranks) : 'unknown';
    }

    return $return;
  }

  public function __toString() {
    return (int) get_loggedin_user()->izap_points;
  }

}
