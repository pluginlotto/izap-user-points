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

class IzapUserpointsController extends IzapController {


  public function  __construct($page) {
    parent::__construct($page);
$this->addWidget(GLOBAL_IZAP_USER_POINTS_PLUGIN.'/user-stats');
    $this->page_elements['filter']='';
  //  $this->page_elements['buttons']='';
      if(elgg_is_admin_logged_in()) {
      $this->addButton(array(
              'menu_name' => 'title',
              'title' => elgg_echo('izap-user-points:add_new'),
              'url' => 'admin/izap-userpoints-section/redeem_coupon'
      ));
    }
    else {
      $this->page_elements['buttons']='';
    }
  }


  public function actionIndex() {
    $title=elgg_echo('izap-user-points:user-points');
    $this->page_elements['title'] = $title;
    $options = array(
            'type' => 'user',
            'full_view' => FALSE,
            'metadata_name_value_pairs' => array(
                    'name' => 'izap_points',
                    'value' => 0,
                    'operand' => '>='
            ),
            'order_by_metadata' => array(
                    array(
                            'name' => 'izap_points',
                            'direction' => 'desc',
                            'as' => 'integer'
                    ),
            ),
            'order_by' => ''
    );

    $this->page_elements['content'] = elgg_list_entities_from_metadata($options);
    $this->drawPage();
  }

  public function actionView_offer() {
    $offer = get_entity($this->url_vars[2]);
    if(!elgg_instanceof($offer, 'object', GLOBAL_IZAP_USER_POINTS_SUBTYPE)) {
      forward();
    }
    
    $title=elgg_echo('izap-user-points:view_offer');
    $this->page_elements['title']=$title;
    $this->widgets = array();
    $this->addWidget(GLOBAL_IZAP_USER_POINTS_PLUGIN.'/user-stats',array('entity' => $offer));
    $content=elgg_view_entity($offer, array('full_view' => TRUE));
    $this->page_elements['content']=$content;
    $this->drawPage();
  }


  
  public function actionOffers() {
  

    $options = array(
            'type' => 'object',
            'subtype' => GLOBAL_IZAP_USER_POINTS_SUBTYPE,
            'full_view' => FALSE,
//            'metadata_name_value_pairs' => array(
//                    'name' => 'valid_till',
//                    'value' => time(),
//                    'operand' => '>'
//            ),
//            'order_by_metadata' => array(
//                    array(
//                            'name' => 'valid_till',
//                    ),
//            ),
    );
    $title = elgg_echo('izap-user-points:site_offers');
    $this->page_elements['title'] = $title;
    $this->page_elements['content'] = elgg_list_entities_from_metadata($options);

    $this->drawPage();
  }

  public function actionSettings(){
    $this->render(GLOBAL_IZAP_USER_POINTS_PLUGIN.'/forms/admin_settings');

  }
}

