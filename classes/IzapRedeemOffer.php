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
 * this is the page that performs the redeeming of offer that user bought
 */
class IzapRedeemOffer extends IzapObject {

  private $sqlite_file;

  protected function initialise_attributes() {
    parent::initializeAttributes();
  }

  public function __construct($guid = null) {
    global $CONFIG;
    parent::__construct($guid);

    $this->sqlite_file = $CONFIG->dataroot . '/' . GLOBAL_IZAP_USER_POINTS_PLUGIN . '/' . GLOBAL_IZAP_USER_POINTS_SQLITE_DB . '.db';
    @mkdir($CONFIG->dataroot . '/' . GLOBAL_IZAP_USER_POINTS_PLUGIN . '/');
  }

  /**
   * gets the attributes of the entity
   * @return type array
   */
  public function getAttributesArray() {
    return array(
        'title' => array(),
        'description' => array(),
        'access_id' => array(),
        'valid_till' => array(),
        'point_value' => array(),
        'total_offers' => array(),
        'per_unit_value' => array(),
        'point_bank_allowed' => array(),
        'partial_redemption_allowed' => array(),
        'comments_on' => array()
    );
  }

  /**
   * gets the url of the page
   * @return type array
   */
  public function getURL() {
    return IzapBase::setHref(array(
        'context' => GLOBAL_IZAP_USER_POINTS_PAGEHANDLER,
        'action' => 'view_offer',
        'page_owner' => $this->owner_username,
        'vars' => array($this->guid, $this->slug)
    ));
  }

  /**
   * calculates and checks if the user can buy a particular offer or not
   * @param type $user_guid
   * @return type boolean
   */
  public function canUserBuy($user_guid = 0) {
    if (!elgg_is_logged_in()) {
      return False;
    }

    if (!$user_guid) {
      $user_guid = get_loggedin_userid();
    }

    $user = get_user($user_guid);
    if (!($user instanceof ElggUser)) {
      return False;
    }

    $user_point = IzapUserPoints::getUserPoints($user);
    if ($user_point > $this->point_value) {
      return True;
    }

    return False;
  }

  /**
   * function to buy an offer
   * @param type $price
   * @return string 
   */
  public function buyHref($price) {
    $action = IzapBase::getFormAction('buy_offer', GLOBAL_IZAP_USER_POINTS_PLUGIN);

    $action_vars = array(
        'guid' => $this->guid,
        'to_be_paid' => 0,
        'price' => $price,
        'points' => $price
    );

    foreach ($action_vars as $var => $val) {
      $action_string .='attributes[' . $var . ']=' . $val . '&';
    }
    $action_string = substr($action_string, 0, -1);
    $action = $action . '?' . $action_string;
    return $action;
  }

  public function canBeDeleted() {
    $sqlite = new IzapSqlite($this->sqlite_file);

    $offer_bought = $sqlite->execute("SELECT * from user_coupons where guid='" . $this->guid . "'");
    if ($offer_bought)
      return False;
    else {
      if (elgg_is_admin_logged_in())
        return True;
    }
  }

  /**
   * this function creates a new table in the sqlite so that elgg is used only for the more
   * important data
   * @param type $array
   * @return type boolean
   */
  public function pushToSqlite($array) {
    $sqlite = new IzapSqlite($this->sqlite_file);
    try {
      $sqlite->execute("CREATE TABLE user_coupons(
                        guid INTEGER(10),
                        coupon_code INTEGER(10),
                        offer_title VARCHAR(50),
                        user_guid INTEGER(10),
                        username VARCHAR(255),
                        used VARCHAR(10),
                        expire_time INTEGER(10),
                        points_used INTEGER(10),
                        to_be_paid INTEGER(10),
                        coupon_price INTEGER(10),
                        time_registered INTEGER(10))");
    } catch (PDOException $e) {
      
    }

    $query = 'INSERT INTO user_coupons (guid, coupon_code,offer_title,user_guid, username, used, expire_time,points_used,to_be_paid,coupon_price,time_registered)
      VALUES (
      "' . $array['guid'] . '",
        "' . $array['code'] . '",
          "' . $array['offer_title'] . '",
          "' . $array['user_guid'] . '",
            "' . $array['username'] . '",
            "no",
            "' . $array['valid_till'] . '",
              "' . $array['points_used'] . '",
                "' . $array['to_be_paid'] . '",
                  "' . $array['coupon_price'] . '",
            "' . time() . '")
      ';

    try {
      $success = $sqlite->execute($query);
    } catch (PDOException $e) {
      
    }

    return $success;
  }

  /**
   * performs a delete function on coupons/offers
   * @return type boolean
   */
  public function delete() {
    $sqlite = new IzapSqlite($this->sqlite_file);
    try {
      $success = $sqlite->execute("DELETE from user_coupons where guid = '" . $this->guid . "'");
      delete_entity($this->guid, TRUE);
    } catch (PDOException $e) {
      register_error($e->getMessage());
    }
    return $success;
  }

  /**
   * gets the thumbnail of the offer created
   * @param type $size
   * @return string 
   */
  public function getThumb($size= 'small') {
    $image = '<img src = "' . $this->getIconURL($size) . '"/>';
    return $image;
  }

  /**
   * displays the image thumb of displayed image in the detail page coupon
   * @param type $size
   * @return type int size
   */
  public function getIconURL($size = 'small') {
    return IzapBase::setHref(array(
        'context' => GLOBAL_IZAP_USER_POINTS_PAGEHANDLER,
        'action' => 'icon',
        'page_owner' => FALSE,
        'vars' => array($this->guid, $size,)
    )) . $this->time_updated . ".jpg";
  }

}