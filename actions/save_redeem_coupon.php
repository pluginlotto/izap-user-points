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

if (!$CONFIG->post_byizap->form_validated) {
  register_error(elgg_echo("izap_elgg_bridge:error_empty_input_fields"));
  forward($_SERVER['HTTP_REFERER']);
  exit;
}

$redeem_offer = new IzapRedeemOffer($CONFIG->post_byizap->attributes['guid'],array('post'=>&$CONFIG->post_byizap));
if($redeem_offer->save()) {
  system_message(elgg_echo('izap-user-points:success_creating_redeem_offer'));
}else {
  register_error(elgg_echo('izap-user-points:error_creating_redeem_offer'));
}
forward($_SERVER['HTTP_REFERER']);
exit;