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


$coupon=elgg_extract('entity',$vars);
$form_values=IzapBase::getFormValues(array('entity'=>$coupon,'plugin'=>GLOBAL_IZAP_USER_POINTS_PLUGIN));
$form = '';
$form .= IzapBase::input('text', array(
  'input_title' => elgg_echo('izap-user-points:title'),
  'internalname' => 'attributes[_title]',
  'value'=>$form_values->title
));

$form .= IzapBase::input('longtext', array(
  'input_title' => elgg_echo('izap-user-points:description'),
  'internalname' => 'attributes[_description]',
  'value'=>$form_values->description
));


$form .= '<p><label>';
$form .= elgg_echo('izap-user-points:valid_till') . '<br />';
$form.=elgg_view('input/date',array('internalname' => 'attributes[_valid_till]',
        'value'=>$form_values->valid_till
        ));

$form .= '</label></p>';

$form.=IzapBase::input('text',array(
  'input_title'=>elgg_echo('izap-user-points:point_value'),
  'internalname'=>'attributes[_point_value]',
  'value'=>$form_values->point_value
));
$form .= IzapBase::input('access',array(
  'input_title'=>elgg_echo('izap-user-points:access_id'),
  'internalname'=>'attributes[access_id]',
  'value'=>($form_values->access_id?$form_values->access_id:ACCESS_DEFAULT)
  ));

$form .= IzapBase::input('submit',array(
    'value' => elgg_echo('save')
  ));

$form .= elgg_view('input/hidden', array(
        'internalname' => 'attributes[plugin]',
        'value' => GLOBAL_IZAP_USER_POINTS_PLUGIN,
));

$form .= elgg_view('input/hidden', array(
        'internalname' => 'attributes[guid]',
        'value' => $form_values->guid,
));


?>
<div class="contentWrapper">
  <?php
    echo elgg_view('input/form', array('body' => $form, 'action' => IzapBase::getFormAction('save_redeem_coupon', GLOBAL_IZAP_USER_POINTS_PLUGIN)));
  ?>
</div>
