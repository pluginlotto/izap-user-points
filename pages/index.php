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

admin_gatekeeper();
global $CONFIG;
set_context('admin');
$title = up_echo('users_point');
$area2 = elgg_view_title($title);
//$area2 .= func_izap_bridge_view('home/list');
$options = array(
        'type' => 'user',
        'full_view' => FALSE,
        'metadata_name_value_pairs' => array(
                'name' => 'izap_points',
                'value' => '0',
                'operand' => '>='
        ),
        'order_by_metadata' => array(
                array(
                        'name' => 'izap_points',
                        'direction' => 'desc',
                ),
        ),
);
$area2 .= elgg_list_entities_from_metadata($options);
$body = elgg_view_layout('two_column_left_sidebar', '', $area2);
page_draw($title, $body);