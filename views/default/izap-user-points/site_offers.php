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


if(!izap_active_site_offers_user_points()) {
  forward();
}
gatekeeper();

$options = array(
        'type' => 'object',
//        'subtype' => GLOBAL_IZAP_USER_POINTS_SUBTYPE,
//        'full_view' => FALSE,
//        'metadata_name_value_pairs' => array(
//                'name' => 'valid_till',
//                'value' => time(),
//                'operand' => '>'
//        ),
//        'order_by_metadata' => array(
//                array(
//                        'name' => 'valid_till',
//                ),
//        ),
);
echo $area2 = elgg_list_entities_from_metadata($options);

//(array(
//  'title' => $title,
//  'area2' => $area2,
//));

