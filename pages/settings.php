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
set_context('admin');
admin_gatekeeper();
$title = elgg_echo('izap-user-points:admin_settings');
$area2 = elgg_view_title($title);
$area2 .= $IZAPTEMPLATE->render('forms/admin_settings');
$IZAPTEMPLATE->drawPage(array(
  'title' => $title,
  'area2' => $area2
));

