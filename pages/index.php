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

global $CONFIG;
$title = elgg_echo('izap-user-points:users_point');
$area2 = elgg_view_title($title);
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
$IZAPTEMPLATE->drawPage(array(
  'title' => $title,
  'area2' => $area2
));