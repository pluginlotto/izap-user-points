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
<div class="contentWrapper">
  <h3>
    <?php
    echo $vars['entity']->getLink(array('text' => $vars['entity']->getTitle()))?></h3>
  <div class="user_points_offer_bottom" align="right">
    <?php
    echo elgg_echo('izap-user-points:points_required') . ': ' . $vars['entity']->point_value;

    if($vars['entity']->canBeDeleted() && elgg_is_admin_logged_in()) {
      echo ' | ';
      echo IzapBase::deleteLink(array(
      'guid' => $vars['entity']->guid,
      'text' => elgg_echo('izap-user-points:delete'),
      'confirm' => 'Do you want to delete it',
      ));

    }

    //if($vars['entity']->canUserBuy()) {
      echo ' | ';
     // echo '<a href="'.$vars['entity']->buyHref().'"><b>';
       echo '<a href="'.$vars['entity']->geturl().'"><b>';
      echo elgg_echo('izap-user-points:get_code');
      echo '</b></a>';
//    }else {
//
//    }
    ?>
  </div>
</div>