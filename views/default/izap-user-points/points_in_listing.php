<?php

/* * ************************************************
 * PluginLotto.com                                 *
 * Copyrights (c) 2005-2010. iZAP                  *
 * All rights reserved                             *
 * **************************************************
 * @author iZAP Team "<support@izap.in>"
 * @link http://www.izap.in/
 * @version {version} $Revision: {revision}
 * Under this agreement, No one has rights to sell this script further.
 * For more information. Contact "Tarun Jangra<tarun@izap.in>"
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

// list the total points of the user
$total_points = IzapUserPoints::getUserPoints($vars['entity']);
if (elgg_get_context() == 'members' || elgg_get_context() == 'admin' ||
        elgg_get_context() == GLOBAL_IZAP_USER_POINTS_PAGEHANDLER) {
  echo sprintf(elgg_echo('izap-user:total_points'), $total_points, IzapUserPoints::getUserRank($total_points));
}