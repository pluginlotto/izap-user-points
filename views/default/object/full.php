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


?>
<div class="contentWrapper">
  <h3>
<?php
echo $vars['entity']->getLink(array('text' => $vars['entity']->getTitle()))?></h3>

          <?php
          if ($vars['full_view']){echo $vars['entity']->getDescription(array(
    'mini' => TRUE,
    'max_length' => 500
  ));
  echo elgg_echo('izap-user-points:valid_till');
    echo $valid_time=date('j M y',$vars['entity']->valid_till);
          }
    ?>
  <div class="user_points_offer_bottom" align="right">
    <?php
    echo elgg_echo('izap-user-points:points_required') . ': ' . $vars['entity']->point_value;

    if($vars['entity']->canBeDeleted()){
       echo ' | ';
      echo IzapBase::deleteLink(array(
        'guid' => $vars['entity']->guid,
        'text' => elgg_echo('izap-user-points:delete'),
        'confirm' => 'DO you want to delete it',
      ));

    }

    if($vars['entity']->canUserBuy()) {
      echo ' | ';
      echo '<a href="'.$vars['entity']->buyHref().'"><b>';
      echo elgg_echo('izap-user-points:get_code');
      echo '</b></a>';
    }else{

    }
    ?>
  </div>
</div>