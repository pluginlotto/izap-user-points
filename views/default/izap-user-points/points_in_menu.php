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
if($total_points && get_context() != 'profile') {
?>
<p class="user_menu_profile points_highlight_profile">
    <?php echo sprintf(elgg_echo('izap-user:total_points'),$user->izap_points,IzapUserPoints::getUserRank($points)); ?>
</p>
<?php
}
?>