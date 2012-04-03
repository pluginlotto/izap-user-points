<?php
/* * ************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2010. iZAP                  *
 * All rights reserved                             *
 * **************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

// this is the form to create a new Site Offer from the admin panel
$coupon = get_entity(get_input('guid'));
$form_values = IzapBase::getFormValues(array('entity' => $coupon, 'plugin' => GLOBAL_IZAP_USER_POINTS_PLUGIN));
$form = '';
$form .= IzapBase::input('text', array(
            'input_title' => elgg_echo('izap-user-points:title'),
            'name' => 'attributes[_title]',
            'value' => $form_values->title
        ));

$form .= IzapBase::input('longtext', array(
            'input_title' => elgg_echo('izap-user-points:description'),
            'name' => 'attributes[_description]',
            'value' => $form_values->description
        ));

$form .= IzapBase::input('file', array(
            'input_title' => elgg_echo('izap-user-point:image'),
            'name' => 'image',
        ));

$form .= '<p><label>';
$form .= elgg_echo('izap-user-points:valid_till') . '<br />';
$form.=elgg_view('input/date', array('name' => 'attributes[_valid_till]',
    'value' => $form_values->valid_till
        ));

$form .= '</label></p>';

$form.=IzapBase::input('text', array(
            'input_title' => elgg_echo('izap-user-points:point_value'),
            'name' => 'attributes[point_value]',
            'value' => $form_values->point_value
        ));

$form.= '<p>' . elgg_echo('izap-user-points:point_value_msg') . '</p>';

$form .= IzapBase::input('text', array(
            'input_title' => elgg_echo('izap-user-points:per_unit_value') . " " . $CONFIG->site_currency_name,
            'name' => 'attributes[per_unit_value]',
            'value' => $form_values->per_unit_value
        ));
$form.= '<p>' . elgg_echo('izap-user-points:per_unit_value_msg') . '</p>';

$form .='<p> <label>' . elgg_echo('izap-user-points:allow_to_point_bank') . '<br/>';

$form .= elgg_view('input/dropdown', array(
    'name' => 'attributes[point_bank_allowed]',
    'value' => $form_values->point_bank_allowed,
    'id' => "point_bank",
    'options_values' => array(
        'yes' => elgg_echo('izap-elgg-bridge:yes'),
        'no' => elgg_echo('izap-elgg-bridge:no')
    )
        ));

$form .= '</label></p>';
$form.= '<p>' . elgg_echo('izap-user-points:allow_to_point_bank_msg') . '</p>';
$form .= '<p> <label>' . elgg_echo('izap-user-points:partial_redemption_allowed') . '<br/>';
$form .= elgg_view('input/dropdown', array(
    'name' => 'attributes[partial_redemption_allowed]',
    'value' => $form_values->partial_redemption_allowed,
    'id' => 'partial_redemption',
    'options_values' => array(
        'yes' => elgg_echo('izap-elgg-bridge:yes'),
        'no' => elgg_echo('izap-elgg-bridge:no')
    )
        ));

$form .='</lebel></p>';

$form .= IzapBase::input('dropdown', array(
            'input_title' => elgg_echo('izap-elgg-bridge:comments'),
            'name' => 'attributes[comments_on]',
            'value' => $form_values->comments_on,
            'options_values' => array('1' => elgg_echo('izap_userpoints:on'), '0' => elgg_echo('izap_userpoints:off'))
        ));
$form .= IzapBase::input('access', array(
            'input_title' => elgg_echo('izap-user-points:access_id'),
            'name' => 'attributes[access_id]',
            'value' => ($form_values->access_id ? $form_values->access_id : ACCESS_DEFAULT)
        ));

$form .= IzapBase::input('submit', array(
            'value' => elgg_echo('save')
        ));

$form .= elgg_view('input/hidden', array(
    'name' => 'attributes[plugin]',
    'value' => GLOBAL_IZAP_USER_POINTS_PLUGIN,
        ));

$form .= elgg_view('input/hidden', array(
    'name' => 'attributes[guid]',
    'value' => $form_values->guid,
        ));
?>
<div class="contentWrapper">
  <?php
  echo elgg_view('input/form', array('body' => $form, 'action' => IzapBase::getFormAction('save_redeem_coupon', GLOBAL_IZAP_USER_POINTS_PLUGIN), 'enctype' => "multipart/form-data"));
  ?>
</div>
<script type="text/javascript">
  $( ".elgg-input-date" ).datepicker({minDate: 0});
  $("#point_bank").change(function(){
    if($('select#point_bank option:selected').val()=='no'){
      $('select#partial_redemption').attr('disabled', true)
    }
    else
      if($('select#point_bank option:selected').val()=='yes'){
        $('select#partial_redemption').attr('disabled', false);
      }
  })
</script>