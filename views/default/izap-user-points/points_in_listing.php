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

$total_points = IzapUserPoints::getUserPoints($vars['entity']);
if(get_context() == 'members' || get_context() == 'admin' || get_context() == GLOBAL_IZAP_USER_POINTS_PAGEHANDLER) {
  ?>
<div  class="points_highlight_list">
    <?php echo elgg_echo('izap-user-points:total_points') . ': <b>' . $total_points . '</b>' . '&nbsp "'.IzapUserPoints::getUserRank($total_points).'"';?>
</div>
<?php
}
?>