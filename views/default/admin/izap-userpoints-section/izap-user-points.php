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


// this is form page for user points setting in the admin panel
$registered_objects = get_registered_entity_types('object');
$point_settings = get_entity(elgg_get_plugin_setting('setting_entity_guid', GLOBAL_IZAP_USER_POINTS_PLUGIN));
if ($point_settings) {
  $loaded_data = $point_settings;
} else {
  $loaded_data = new stdClass();
}
?>
<div class="contentWrapper">
  <form action="<?php echo izapbase::getFormAction('save_admin_settings', GLOBAL_IZAP_USER_POINTS_PLUGIN); ?>" method="POST">
    <?php echo elgg_view('input/securitytoken'); ?>
    <?php
    foreach ($registered_objects as $object_subtype):
      $activated_value = 'object_' . $object_subtype . '_activated';
      $points_value = 'object_' . $object_subtype . '_points';
      ?>
      <p>
        <label>
          <?php
          echo elgg_view('input/checkboxes', array(
              'name' => 'izap_points[object][' . $object_subtype . '][activated]',
              'value' => $loaded_data->$activated_value,
              'options' => array(
                  elgg_echo('item:object:' . $object_subtype) => 'yes',
              ),
          ));
          ?>
        </label>
        <?php
        echo elgg_view('input/text', array(
            'name' => 'izap_points[object][' . $object_subtype . '][points]',
            'value' => $loaded_data->$points_value,
            'class' => 'general-text'
                )
        );
        ?>
      </p>
      <?php
    endforeach;
    ?>
    <p>
      <label>
        <?php
        $activated_value = 'group_default_activated';
        $points_value = 'group_default_points';
        echo elgg_view('input/checkboxes', array(
            'name' => 'izap_points[group][default][activated]',
            'value' => $loaded_data->$activated_value,
            'options' => array(
                elgg_echo('item:group') => 'yes',
            ),
        ));
        ?>
      </label>
      <?php
      echo elgg_view('input/text', array(
          'name' => 'izap_points[group][default][points]',
          'value' => $loaded_data->$points_value,
          'class' => 'general-text'
              )
      );
      ?>
    </p>

    <p>
      <label>
        <?php
        $activated_value = 'annotation_default_activated';
        $points_value = 'annotation_default_points';
        echo elgg_view('input/checkboxes', array(
            'name' => 'izap_points[annotation][default][activated]',
            'value' => $loaded_data->$activated_value,
            'options' => array(
                elgg_echo('item:annotation') => 'yes',
            ),
        ));
        ?>
      </label>
      <?php
      echo elgg_view('input/text', array(
          'name' => 'izap_points[annotation][default][points]',
          'value' => $loaded_data->$points_value,
          'class' => 'general-text'
              )
      );
      ?>
    </p>

    <p>
      <label>
        <?php echo elgg_echo('izap-user-points:login_point'); ?>
      </label><br />
      <?php
      echo elgg_view('input/text', array(
          'name' => 'izap_points[login]',
          'value' => $loaded_data->login,
      ));
      ?>
    </p>

    <p>
      <label>
        <?php echo elgg_echo('izap-user-points:user_rank_rules'); ?>
      </label>
      <textarea name="izap_points[rank_rules]" cols="50" rows="7"><?php echo $loaded_data->rank_rules ?></textarea>
    </p>
    <?php
    echo elgg_view('input/hidden', array('name' => 'izap_points[guid]', 'value' => (int) $loaded_data->guid));
    echo elgg_view('input/submit', array('value' => elgg_echo('save')));
    ;
    ?>
  </form>
</div>