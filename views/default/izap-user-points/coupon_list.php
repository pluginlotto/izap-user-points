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
$coupons = izap_get_offer_coupons();
?>
<script type="text/javascript" src="<?php echo $vars['url'] . 'mod/' . GLOBAL_IZAP_USER_POINTS_PLUGIN . '/vendors/jquery.quicksearch.js'?>"></script>
<div class="admin_statistics">
  <div align="right" class="search_input">
  <?php echo elgg_echo('izap-user-points:search_code');?><input type="text" id="id_search" />
  </div>
  <table id="data">
    <thead>
      <tr >
        <td><?php echo elgg_echo('izap-user-points:coupon_code')?></td>
        <td><?php echo elgg_echo('izap-user-points:username')?></td>
        <td><?php echo elgg_echo('izap-user-points:time_registered')?></td>
        <td><?php echo elgg_echo('izap-user-points:used')?></td>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach($coupons as $coupon) {
        ?>
      <tr>
        <td><?php echo $coupon['coupon_code']?></td>
        <td><?php echo $coupon['username']?></td>
        <td><?php echo date('d M, Y', $coupon['time_registered']);?></td>
        <td>
          <?php echo $coupon['used'];
          if($coupon['used'] == 'no') {
          ?>
          <span id="used_<?php echo $coupons['coupon_code']?>">
            <a
              href="<?php echo elgg_add_action_tokens_to_url(func_get_actions_path_byizap(array(
                'plugin' => GLOBAL_IZAP_USER_POINTS_PLUGIN
              )) . 'mark_as_used?coupon='.$coupon['coupon_code'].'');?>"
              title="<?php echo elgg_echo('izap-user-points:mark_as_used');?>"
              rel="used_<?php echo $coupons['coupon_code']?>"><img src="<?php echo func_get_www_path_byizap(array(
            'plugin' => GLOBAL_IZAP_USER_POINTS_PLUGIN,
            'type' => 'images'
          )) . 'mark_used.gif'?>"/></a></span>
          <?php }else{?>
          <span id="used_<?php echo $coupons['coupon_code']?>">
            <a
              onclick="return confirm('<?php echo elgg_echo('izap-user-points:mark_as_unused')?>');"
              href="<?php echo elgg_add_action_tokens_to_url(func_get_actions_path_byizap(array(
                'plugin' => GLOBAL_IZAP_USER_POINTS_PLUGIN
              )) . 'mark_as_used?coupon='.$coupon['coupon_code'].'&status=no');?>"
              title="<?php echo elgg_echo('izap-user-points:mark_as_unused');?>"
              rel="used_<?php echo $coupons['coupon_code']?>"><img src="<?php echo func_get_www_path_byizap(array(
            'plugin' => GLOBAL_IZAP_USER_POINTS_PLUGIN,
            'type' => 'images'
          )) . 'used.gif'?>"/></a></span>
          <?php }?>
        </td>
      </tr>
        <?php
      }
      ?>
    </tbody>
  </table>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('input#id_search').focus();
    $('input#id_search').quicksearch('table#data tbody tr');
  });
</script>