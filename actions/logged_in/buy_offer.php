<?php
/*************************************************
* PluginLotto.com                                 *
* Copyrights (c) 2005-2010. iZAP                  *
* All rights reserved                             *
**************************************************
* @author iZAP Team "<support@izap.in>"
* @link http://www.izap.in/
* Under this agreement, No one has rights to sell this script further.
* For more information. Contact "Tarun Jangra<tarun@izap.in>"
* For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
* Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

$success = FALSE;
$offer = get_entity(get_input('guid'));
if($offer instanceof IzapRedeemOffer) {
  $user = get_loggedin_user();
  $codes = (array)$offer->codes;
  $generated_code = $offer->guid . '-' . substr(IzapBase::getUniqueId(), 0, 5) . '-' . substr(IzapBase::getUniqueId(), 20, 3);
  $codes[] = $generated_code;
  $updated = IzapBase::updateMetadata(array(
          'entity' => $offer,
          'metadata' => array(
                  'codes' => $codes
          ),
  ));
  if($updated) {
    $success = $offer->pushToSqlite(array(
            'guid' => $offer->guid,
            'code' => $generated_code,
            'user_guid' => $user->guid,
            'valid_till' => $offer->valid_till,
            'username' => $user->username
    ));

    if($success) {
      $user->izap_points = (int)$user->izap_points - (int)$offer->point_value;
      notify_user(
              $user->guid,
              $CONFIG->site->guid,
              elgg_echo('izap-user-points:offer_bought_subject'),
              sprintf(elgg_echo('izap-user-points:offer_bought_message'), $generated_code)
      );
    }
  }
}
if(!$success) {
  register_error(elgg_echo('izap-user-points:error_buying_offer'));
}else {
  system_messages(elgg_echo('izap-user-points:offer_bought'));
}
forward($_SERVER['HTTP_REFERER']);
exit;
