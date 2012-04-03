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
<div><!--this is details page for the selected offers-->
  <div class="userpoint-image">
    <?php echo $offer->getThumb('large') ?>
  </div>
  <div class="userpoint-right">
    <div class="valid-date">
      <?php
      //details of the selected offer begins
      echo elgg_echo('izap-user-points:valid_till');
      echo $valid_time = date('j M Y', $offer->valid_till);
      ?>
    </div>
    <?php
    if ($offer->point_bank_allowed == 'yes' && $offer->point_value > 0) { // if point bank is allowed
      if ($offer->partial_redemption_allowed == 'yes') {

        // can use both points and Money
        $points_text = elgg_view('input/text', array(
            ' name' => 'attributes[points]',
            ' id' => 'points_used',
            'value' => $points_can_be_used,
            'js' => 'style="width:50px;"'
                ));


        $form .= '<div class="buy_partial"> Use ' . $points_text . ' points and pay <span id="amount_to_pay">' . $more_requied * $unit . '</span> <br /></div>';
      } else if ($offer->partial_redemption_allowed == 'no' && $offer->point_value > 0) {

        // full money or full points
        $more_requied = $total_value;
        $form .='<div class="buy_partial">';
        $form .= elgg_view('input/radio', array(
                    'name' => 'attributes[mode]',
                    'id' => 'mode',
                    'options' => array(
                        elgg_echo('izap-userpoints:cash') => 'cash',
                        elgg_echo('izap-userpoints:points') => 'points',
                    ),
                    'value' => 'cash',
                        )
                ) . '</div>';
        $form .= elgg_view('input/hidden', array(
            ' name' => 'attributes[points]',
            'value' => 0,
            'id' => 'points_user_hidden'
                ));
      }
    } // if user has to buy (or pay in money)
    else if ($offer->point_bank_allowed == 'no' && $offer->point_value > 0) {
      $more_requied = $total_value;
      $form .= '<div class="buy_partial">Points not applicable to this offer</div>';
      $form .= elgg_view('input/hidden', array(
          'name' => 'attributes[points]',
          'value' => 0,
          'id' => 'points_user_hidden'
              ));
    } else if ($offer->point_value == 0) {
      $form = '<div class="buy_partial">Free of cost</div>';
    }

    $form .= elgg_view('input/hidden', array(
        'name' => 'attributes[to_be_paid]',
        'value' => $more_requied * $unit,
        'id' => 'point_to_paid_hidden'));
    $form .= elgg_view('input/hidden', array(
        'name' => 'attributes[guid]',
        'value' => $offer->guid,
            ));
    $form .= elgg_view('input/hidden', array(
        'name' => 'attributes[price]',
        'value' => (int) $offer->point_value
            ));
    $form .= elgg_view('input/submit', array(
        'value' => 'Buy',
        'id' => 'buy_button'
            ));
    $form = elgg_view('input/form', array(
        'action' => IzapBase::getFormAction('buy_offer', GLOBAL_IZAP_USER_POINTS_PLUGIN),
        'body' => $form,
        'id' => 'buy_offer'
            ));
    ?>


    <div class="buy_form">
      <?php echo $form; ?>
    </div>

  </div>
  <div class="clearfloat"></div>
  <div class="offerdesc">
    <?php
    echo $offer->getDescription(array(
        'mini' => True,
        'max_length' => 500
    ));
    ?>
  </div>
  <?php
  if ($offer->comments_on) {
    echo elgg_view_comments($offer);
  }
  ?>
</div>

<script type ="text/javascript">
  $('#points_used').keyup(function(){
    var total = '<?php echo $total_value < IzapUserPoints::getUserPoints() ? (int) $total_value : (int) IzapUserPoints::getUserPoints(); ?>';
    if(parseInt($('#points_used').val()) > parseInt(total)){
      $('#points_used').val(total);
    }
    var a = $('#points_used').val() * <?php echo $offer->per_unit_value ?>;
    var b = <?php echo $offer->per_unit_value * $offer->point_value ?>;
    var price = b-a;
    if(price<0){
      price=0;
    }
    $('#amount_to_pay').text(price);
    $('#point_to_paid_hidden').val(price);
  });


  $('#mode').change(function(){
    if($('input:[type=radio][checked]').val()=='points'){
      $('#points_user_hidden').val('<?php echo (int) $offer->point_value ?>');
      $('#point_to_paid_hidden').val('0');
    }
  });

<?php if (IzapUserPoints::getUserPoints() < $offer->point_value) { ?>
    $('#mode').change(function(){
      if($('input:[type=radio][checked]').val()=='points'){
        alert('You do not have enough points to buy');
        $('#mode-points').attr('disabled','disabled');
        $('#mode-cash').attr('checked', 'yes');
      }
    });
<?php } ?>
</script>