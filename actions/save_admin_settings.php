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


admin_gatekeeper();

$posted_data = $_POST['izap_points'];
$point_settings = new ElggObject((int)$posted_data['guid']);
$point_settings->access_id = ACCESS_PUBLIC;
$point_settings->subtype = 'IzapUserPoints';
$point_settings->title = 'Point data for the user';

foreach($posted_data as $type => $values) {
  if(is_array($values)) {
    foreach ($values as $object_subtype => $value) {
      $activated_value = IzapUserPoints::makeActivatedString($type, $object_subtype);
      $points_value = IzapUserPoints::makePointString($type, $object_subtype);
      if(isset($value['activated'])) {
        foreach($value as $key => $val) {
          if($key == 'activated' && $val[0] == 'yes') {
            $point_settings->$activated_value = 'yes';
            $point_settings->$points_value = $value['points'];
            $activated_array[$type][$object_subtype]['activated'] = $point_settings->$activated_value;
            $activated_array[$type][$object_subtype]['points'] = $point_settings->$points_value;
          }
        }
      }else {
        $point_settings->$activated_value = 'no';
        $point_settings->$points_value = 0;
      }
    }
  }else{
    $point_settings->$type = $posted_data[$type];
  }
}

//var_dump($posted_data['rank_rules']);
$point_settings->description = serialize($activated_array);
if($point_settings->save()) {
  system_message(elgg_echo('izap-user-points:setting_saved'));
}else {
  register_error(elgg_echo('izap-user-points:setting_not_saved'));
}

// now finally save everything to the admin_settings
set_plugin_setting('setting_entity_guid', $point_settings->guid, 'izap-user-points');
forward($_SERVER['HTTP_REFERER']);
exit;
