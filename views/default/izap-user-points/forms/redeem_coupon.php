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

global $IZAPTEMPLATE;

$form = '';
$form .= '<p><label>';
$form .= elgg_echo('izap-user-points:title') . '<br />';
$form .= $IZAPTEMPLATE->render('input/text', array('internalname' => 'attributes[_title]'));
$form .= '</label></p>';

$form .= '<p><label>';
$form .= elgg_echo('izap-user-points:description') . '<br />';
$form .= $IZAPTEMPLATE->render('input/longtext', array('internalname' => 'attributes[_description]'));
$form .= '</label></p>';


$form .= '<p><label>';
$form .= elgg_echo('izap-user-points:valid_till') . '<br />';
$form .= $IZAPTEMPLATE->render('input/date', array('internalname' => 'attributes[_valid_till]'));
$form .= '</label></p>';


$form .= '<p><label>';
$form .= elgg_echo('izap-user-points:point_value') . '<br />';
$form .= $IZAPTEMPLATE->render('input/text', array('internalname' => 'attributes[_point_value]'));
$form .= '</label></p>';

$form .= '<p><label>';
$form .= elgg_echo('izap-user-points:access_id') . '<br />';
$form .= $IZAPTEMPLATE->render('input/access', array('internalname' => 'attributes[access_id]'));
$form .= '</label></p>';

$form .= '<p><label>';
$form .= $IZAPTEMPLATE->render('input/submit', array('value' => elgg_echo('save')));
$form .= '</label></p>';

?>
<div class="contentWrapper">
  <?php
    echo $IZAPTEMPLATE->render('input/form', array('body' => $form, 'action' => func_get_actions_path_byizap(array(
      'plugin' => GLOBAL_IZAP_USER_POINTS_PLUGIN,
    )) . 'save_redeem_coupon'));
  ?>
</div>