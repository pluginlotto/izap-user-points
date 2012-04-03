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

/**
 * this page displays the option of 'mark as used' in the check coupon page in the admin panel
 */
$coupon_code = get_input('coupon');
$status = get_input('status', 'yes');
if (izap_update_coupon_status_user_points($coupon_code, $status)) {
  system_message(elgg_echo('izap-user-points:status_changed'));
} else {
  register_error(elgg_echo('izap-user-points:error_updating_coupon_status'));
}
forward($_SERVER['HTTP_REFERER']);
exit;