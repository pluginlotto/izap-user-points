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

set_context('admin');
$title = elgg_echo('izap-user-points:create_redeem_offer');
$body = elgg_view_title($title);
$body .= $IZAPTEMPLATE->render('forms/redeem_coupon');
$IZAPTEMPLATE->drawPage(array(
  'area2' => $body,
  'title' => $title,
));
