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
?>

<!--this page list of all valid offers-->
<div class="contentWrapper">
  <h3>
    <?php echo $vars['entity']->getLink(array('text' => $vars['entity']->getTitle())) ?></h3>
  <div class="user_points_offer_bottom" align="right">
    <?php
    //list of all offers available offers
    echo elgg_echo('izap-user-points:offer_valid_till') . ': <b>' . date('M-d-Y', $vars['entity']->valid_till) . '</b> | ';
    echo elgg_echo('izap-user-points:points_required') . ': <b>' . $vars['entity']->point_value . '</b>';

    if ($vars['entity']->canBeDeleted() && elgg_is_admin_logged_in()) {
      echo ' | ';
      echo IzapBase::deleteLink(array(
          'guid' => $vars['entity']->guid,
          'text' => elgg_echo('izap-user-points:delete'),
          'confirm' => 'Do you want to delete it',
      ));
    }
    echo ' | ';
    echo '<a href="' . $vars['entity']->geturl() . '"><b>';
    echo elgg_echo('izap-user-points:get_code');
    echo '</b></a>';
    ?>
  </div>
</div>