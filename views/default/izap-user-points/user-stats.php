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
?>
<div class="point-required">
      <?php
      $user= elgg_get_logged_in_user_entity();
      echo elgg_echo('izap-user-points:user-points');
      echo IzapUserPoints::getUserPoints($user);
      if(elgg_instanceof($vars['entity'], 'object',GLOBAL_IZAP_USER_POINTS_SUBTYPE)){
              echo'<br/>';
      echo elgg_echo('izap-user-points:points_required') . ': ' . $vars['entity']->point_value;
      echo '('.$CONFIG->site_currency_sign.' '.$vars['entity']->point_value * $vars['entity']->per_unit_value.')';
      }
?>
      </div>