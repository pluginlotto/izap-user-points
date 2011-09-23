<?php
/**************************************************
* PluginLotto.com                                 *
* Copyrights (c) 2005-2010. iZAP                  *
* All rights reserved                             *
***************************************************
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* Under this agreement, No one has rights to sell this script further.
* For more information. Contact "Tarun Jangra<tarun@izap.in>"
* For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
* Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

if(IzapBase::hasFormError()){
  if(sizeof(IzapBase::getFormErrors())) {
    foreach(IzapBase::getFormErrors() as $error) {
      register_error($error);
    }
  }
  forward(REFERRER);
  exit;
}

$posted_array = IzapBase::getPostedAttributes();
 
if(empty($posted_array['point_value'])){
IzapBase::updatePostedAttribute('point_value', '0');
}
if(empty($posted_array['per_unit_value'])){
IzapBase::updatePostedAttribute('per_unit_value', '0');
}
$redeem_offer = new IzapRedeemOffer($posted_array['guid']);
$time = split("[\/-]",$posted_array['valid_till']);
$time_str = mktime(23,59,59,$time[0],$time[1],$time[2]);
IzapBase::updatePostedAttribute('valid_till', $time_str);
$redeem_offer->setAttributes();
if($redeem_offer->save()) {
  IzapBase::saveImageFile(array('destination' =>'offer/'.$redeem_offer->guid.'/icon',
      'content' => file_get_contents($_FILES['image']['tmp_name']),
      'owner_guid' => $redeem_offer->owner_guid,
      'create_thumbs' => TRUE
      
  ));
  elgg_clear_sticky_form(GLOBAL_IZAP_USER_POINTS_PLUGIN);
  system_message(elgg_echo('izap-user-points:success_creating_redeem_offer'));

}else {
  register_error(elgg_echo('izap-user-points:error_creating_redeem_offer'));
}
forward($_SERVER['HTTP_REFERER']);
exit;