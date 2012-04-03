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

class IzapUserpointsController extends IzapController {

  /**
   * constructor of the user controller class
   * @param type $page 
   */
  public function __construct($page) {
    parent::__construct($page);
    if (elgg_is_logged_in())
      $this->addWidget(GLOBAL_IZAP_USER_POINTS_PLUGIN . '/user-stats');
    $this->page_elements['filter'] = '';
    if (elgg_is_admin_logged_in()) {
      $this->addButton(array(
          'menu_name' => 'title',
          'title' => elgg_echo('izap-user-points:add_new'),
          'url' => 'admin/izap-userpoints-section/redeem_coupon'
      ));
    }
  }

  /**
   * function calling the default action of the handler
   */
  public function actionIndex() {
    $title = elgg_echo('izap-user-point:top_users');
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

  /**
   * function that displays the offer details
   */
  public function actionView_offer() {
    $offer = get_entity($this->url_vars[2]);
    if (!elgg_instanceof($offer, 'object', GLOBAL_IZAP_USER_POINTS_SUBTYPE)) {
      forward();
    }

    $title = elgg_echo('izap-user-points:view_offer', array($offer->title));
    $this->page_elements['title'] = $title;

    $this->widgets = array();
    $this->addWidget(GLOBAL_IZAP_USER_POINTS_PLUGIN . '/user-stats', array('entity' => $offer));

    $content = elgg_view_entity($offer, array('full_view' => True));
    $this->page_elements['content'] = $content;
    $this->drawPage();
  }
  
  /**
   * displays the list of all valid site offers 
   */
  public function actionOffers() {

    $options = array(
        'type' => 'object',
        'subtype' => GLOBAL_IZAP_USER_POINTS_SUBTYPE,
        'full_view' => False,
        'metadata_name_value_pairs' => array(
            'name' => 'valid_till',
            'value' => time(),
            'operand' => '>'
        ),
        'order_by_metadata' => array(
            array(
                'name' => 'valid_till',
            ),
        ),
    );
    $title = elgg_echo('izap-user-points:site_offers');
    $this->page_elements['title'] = $title;
    $this->page_elements['content'] = elgg_list_entities_from_metadata($options);

    $this->drawPage();
  }

  /**
   *  displays list of all site offers including the invalid/outdated also
   */
  public function actionArchive() {
    if (!elgg_is_admin_logged_in()) {
      register_error(elgg_echo('izap-user-points:no_admin_permission'));
      forward();
    } else {
      $options = array(
          'type' => 'object',
          'subtype' => GLOBAL_IZAP_USER_POINTS_SUBTYPE,
          'full_view' => False,
          'order_by_metadata' => array(
              array(
                  'name' => 'valid_till',
              ),
          ),
      );
      $title = elgg_echo('izap-user-points:archive');
      $this->page_elements['title'] = $title;
      $this->page_elements['content'] = elgg_list_entities_from_metadata($options);

      $this->drawPage();
    }
  }

  /**
   * displays user points settings in admin panel
   */
  public function actionSettings() {
    $this->render(GLOBAL_IZAP_USER_POINTS_PLUGIN . '/forms/admin_settings');
  }

  public function actionIcon() {
    $offer = get_entity($this->url_vars[1]);
    $size = $this->url_vars[2];

    $image_name = 'offer/' . $offer->guid . '/icon' . (($size) ? $size : 'small') . '.jpg';
    $content = IzapBase::getFile(array(
                'source' => $image_name,
                'owner_guid' => $offer->owner_guid,
            ));


    if (empty($content)) {
      $content = file_get_contents(elgg_get_plugins_path() . GLOBAL_IZAP_ELGG_BRIDGE . '/_graphics/no-image-' . $size . '.jpg');
    }

    $header_array = array();
    $header_array['content_type'] = 'image/jpeg';
    $header_array['file_name'] = elgg_get_friendly_title($challenge->title);
    IzapBase::cacheHeaders($header_array);
    echo $content;
  }

  public function actionCoupons() {
    $this->render(GLOBAL_IZAP_USER_POINTS_PLUGIN . '/forms/coupons');
  }

}

