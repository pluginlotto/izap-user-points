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

$registered_objects = get_registered_entity_types('object');
$point_settings = get_entity(get_plugin_setting('setting_entity_guid', 'izap-user-points'));
if($point_settings) {
  $loaded_data = $point_settings;
} else {
  $loaded_data = new stdClass();
}
?>
<div class="contentWrapper">
  <form action="<?php echo func_get_actions_path_byizap(array('plugin' => 'izap-user-points'))?>save_admin_settings" method="POST">
    <?php echo elgg_view('input/securitytoken');?>
    <?php
    foreach($registered_objects as $object_subtype):
      $activated_value = 'object_' . $object_subtype . '_activated';
      $points_value = 'object_' . $object_subtype . '_points';
      ?>
    <p>
      <label>
          <?php echo elgg_view('input/checkboxes', array(
          'internalname' => 'izap_points[object]['.$object_subtype.'][activated]',
          'value' => $loaded_data->$activated_value,
          'options' => array(
                  elgg_echo('item:object:' . $object_subtype) => 'yes',
          ),
          ));
          //echo elgg_echo('izap-user-points:points');
          ?>
      </label>
        <?php
        echo elgg_view('input/text', array(
        'internalname' => 'izap_points[object]['.$object_subtype.'][points]',
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
        'internalname' => 'izap_points[group][default][activated]',
        'value' => $loaded_data->$activated_value,
        'options' => array(
                elgg_echo('item:group') => 'yes',
        ),
        ));
        //echo elgg_echo('izap-user-points:points');
        ?>
      </label>
      <?php
      echo elgg_view('input/text', array(
      'internalname' => 'izap_points[group][default][points]',
      'value' => $loaded_data->$points_value,
      'class' => 'general-text'
      )
      );?>
    </p>

    <p>
      <label>
        <?php
        $activated_value = 'annotation_default_activated';
        $points_value = 'annotation_default_points';
        echo elgg_view('input/checkboxes', array(
        'internalname' => 'izap_points[annotation][default][activated]',
        'value' => $loaded_data->$activated_value,
        'options' => array(
                elgg_echo('item:annotation') => 'yes',
        ),
        ));
        ?>
      </label>
      <?php
      echo elgg_view('input/text', array(
      'internalname' => 'izap_points[annotation][default][points]',
      'value' => $loaded_data->$points_value,
      'class' => 'general-text'
      )
      );?>
    </p>

    <p>
      <label>
        <?php echo elgg_echo('izap-user-points:login_point');?>
      </label><br />
      <?php
        echo elgg_view('input/text', array(
          'internalname' => 'izap_points[login]',
          'value' => $loaded_data->login,
        ));
      ?>
    </p>
    
    <p>
      <label>
        <?php echo elgg_echo('izap-user-points:user_rank_rules');?>
      </label>
      <textarea name="izap_points[rank_rules]" cols="50" rows="7"><?php echo $loaded_data->rank_rules?></textarea>
    </p>
    <?php
    echo elgg_view('input/hidden', array('internalname' => 'izap_points[guid]', 'value' => (int) $loaded_data->guid));
    echo elgg_view('input/submit', array('value' =>  elggb_echo('save')));
    ;?>
  </form>
</div>