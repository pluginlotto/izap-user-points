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
$offer = $vars['entity'];
//c($offer->per_unit_value);
$unit = $offer->per_unit_value;
$total_available_points = IzapUserPoints::getUserPoints();
$total_value = $offer->point_value;

// check how many points can be used
if ($total_value > $total_available_points) {
  $points_can_be_used = $total_available_points;
  $more_requied = $total_value - $total_available_points;
} else {
  $points_can_be_used = $total_value;
}
?>
<div class="userpoint-Wrapper">
  <div class="userpoint-title"><h3>
      <?php echo $offer->getLink(array('text' => $offer->getTitle())) ?></h3>
  </div>
  <div class="userpoint-content">
    <div class="userpoint-desc">
      <div class="offerdesc">
        <?php
        if ($vars['full_view']) {
          echo $offer->getDescription(array(
              'mini' => TRUE,
              'max_length' => 500
          ));
        ?></div></div>
      <div class="userpoint-bottom">
      <?php
          $edit_img = '<img src="' . $vars['url'] . '/mod/' . GLOBAL_IZAP_ELGG_BRIDGE . '/_graphics/edit.png" align="right"/>';
          if ($offer->canedit()) {
      ?>
            <a href ="<?php
            echo IzapBase::setHref(array(
                'context' => 'admin',
                'action' => 'izap-userpoints-section',
                'page_owner' => false,
                'vars' => array('redeem_coupon'),
                'trailing_slash' => false,
            )) . '?guid=' . $offer->guid ?>">  <?php echo $edit_img ?></a><?php
          }
          $delete_img = '<img src="' . $vars['url'] . '/mod/' . GLOBAL_IZAP_ELGG_BRIDGE . '/_graphics/delete.png" align="right"/>  ';
          if ($offer->canBeDeleted()) {
            echo IzapBase::deleteLink(array(
                'guid' => $offer->guid,
                'text' => $delete_img,
                'confirm' => elgg_Echo('izap-user-points:wana delete'),
            ));
          }
      ?>
       <div class="valid-date">
<?php
          echo elgg_echo('izap-user-points:valid_till');
          echo $valid_time = date('j M y', $offer->valid_till);
        }
?>
      </div>
<?php
//      if ($offer->canUserBuy()) {
//        echo ' | ';
//        echo '<a href="' . $offer]->buyHref() . '"><b>';
//        echo elgg_echo('izap-user-points:get_code');
//        echo '</b></a>';
//      } else {
//
//      }

        if ($offer->point_bank_allowed == 'yes') { // if point bank is allowed
          if ($offer->partial_redemption_allowed == 'yes') {
            // can use both points and Money
            $points_text = elgg_view('input/text', array(
                        'internalname' => 'attributes[points]',
                        'internalid' => 'points_used',
                        'value' => $points_can_be_used,
                        'js' => 'style="width:50px;"'
                    ));


            $form .= '<div class="buy_partial"> Use ' . $points_text . ' points and pay <span id="amount_to_pay">' . $more_requied * $unit . '</span> <br /></div>';
          } else if ($offer->partial_redemption_allowed == 'no') {
            // full money or full points
            if ($offer->point_value <= IzapUserPoints::getUserPoints()) {
              $more_requied = $total_value;
              echo '<a href="' . $offer->buyHref($total_value) . '" class="elgg-button elgg-button-action userpoint-buypoint"><b>';
              echo elgg_echo('izap-user-points:avail');
              echo '</b></a>';

            }
?>

      <?php
      $form .= elgg_view('input/hidden',array(
          'internalname' => 'attributes[points]',
                        'value' => 0,
      ));
          }
        } // if user has to buy (or pay in money)
        else if($offer->point_bank_allowed == 'no'){
          //echo $total_value;echo $unit;exit;
          // can use money only
          $more_requied = $total_value;
          $form .= elgg_view('input/hidden',array(
          'internalname' => 'attributes[points]',
                        'value' => 0,
      ));
        }
        
        $form .= elgg_view('input/hidden', array(
                    'internalname' => 'attributes[to_be_paid]',
                    'value' => $more_requied * $unit,
                    'internalid' => 'points_user_hidden'));
        $form .= elgg_view('input/hidden', array(
                    'internalname' => 'attributes[guid]',
                    'value' => $offer->guid,
                ));
        $form .= elgg_view('input/hidden', array(
                    'internalname' => 'attributes[price]',
                    'value' => $offer->point_value
                ));
        $form .= elgg_view('input/submit', array(
                    'value' => 'Buy with cash',
                    'js' => 'style="width:120px;height:27px;margin-left:35px;position:absolute;top:180px"'
                ));
        $form = elgg_view('input/form', array(
                    'action' => IzapBase::getFormAction('buy_offer', GLOBAL_IZAP_USER_POINTS_PLUGIN),
                    'body' => $form
                ));
      ?>

      <?php echo $form; ?>
      </div>
      <div class="clearfloat"></div></div>
  </div>

  <script type ="text/javascript">
    $('#points_used').keyup(function(){
      var a = $('#points_used').val() * <?php echo $offer->per_unit_value ?>;
      var b = <?php echo $offer->per_unit_value * $offer->point_value ?>;
    var price = b-a;
    if(price<0){
      price=0;
    }
    $('#amount_to_pay').text(price);
    $('#points_user_hidden').val(price);
  });
</script>