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
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/forums/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */
?>
<p>
  <label>
    <?php
    // this is the plugin settings page in the admin controls
    echo elgg_echo('izap-user-points:activate_site_offers');
    echo elgg_view('input/dropdown', array(
        'name' => 'params[izap_activate_site_offers]',
        'value' => IzapBase::pluginSetting(array(
            'plugin' => GLOBAL_IZAP_USER_POINTS_PLUGIN,
            'name' => 'izap_activate_site_offers',
            'value' => 'no',
        )),
        'options_values' => array(
            'no' => elgg_echo('izap-elgg-bridge:no'),
            'yes' => elgg_echo('izap-elgg-bridge:yes'),
        ),
    ));
    ?>
  </label>
</p>


<h1><!--this is the link to admin user points settings-->
  <a href="/admin/izap-userpoints-section/<?= GLOBAL_IZAP_USER_POINTS_PLUGIN; ?>">
    <?php echo elgg_echo('izap-user-points:go_to_admin_settings'); ?></a>
</h1>
</br>