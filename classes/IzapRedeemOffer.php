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


class IzapRedeemOffer extends IzapObject {

  private $sqlite_file;

  protected function initialise_attributes() {
    parent::initialise_attributes();
  }

  public function __construct($guid = null) {
    global $CONFIG;
    parent::__construct($guid);

    $this->sqlite_file = $CONFIG->dataroot . '/' . GLOBAL_IZAP_USER_POINTS_PLUGIN . '/'.GLOBAL_IZAP_USER_POINTS_SQLITE_DB.'.db';
    @mkdir ($CONFIG->dataroot . '/' . GLOBAL_IZAP_USER_POINTS_PLUGIN . '/');
  }

  public function getAttributesArray() {
    return array(
            'title' => array(),
            'description' => array(),
            'access_id' => array(),
            'valid_till' => array(),
            'point_value' => array(),
            'total_offers' => array(),
    );
  }

  public function getURL() {
    return IzapBase::setHref(array(
            'context' => GLOBAL_IZAP_USER_POINTS_PAGEHANDLER,
            'action' => 'view_offer',
            'page_owner' => $this->owner_username,
            'vars' => array($this->guid, $this->slug)
    ));
  }

  public function canUserBuy($user_guid = 0) {
    if(!isloggedin()) {
      return FALSE;
    }

    if(!$user_guid) {
      $user_guid = get_loggedin_userid();
    }

    $user = get_user($user_guid);
    if(!($user instanceof ElggUser)) {
      return FALSE;
    }

    $user_point = IzapUserPoints::getUserPoints($user);
    if($user_point > $this->point_value) {
      return TRUE;
    }

    return FALSE;
  }

  public function buyHref() {
    $action =IzapBase::getFormAction('buy_offer', GLOBAL_IZAP_USER_POINTS_PLUGIN);

    $action_vars = array(
            'guid' => $this->guid,
    );

    foreach($action_vars as $var => $val) {
      $action_string .= $var . '=' . $val . '&';
    }
    $action_string = substr($action_string, 0, -1);

    $action = $action . '?' . $action_string;

    return elgg_add_action_tokens_to_url($action);
  }

  public function canBeDeleted() {
    $sqlite = new IzapSqlite($this->sqlite_file);
    try {
      $offer_bought = $sqlite->execute("SELECT * from user_coupons where guid='".$this->guid."'");
    }catch(PDOException $e) {
    }
    if($offer_bought)
      return FALSE;
    else
      return true;
  }
  
  public function pushToSqlite($array) {
    $sqlite = new IzapSqlite($this->sqlite_file);
    try {
      $sqlite->execute("CREATE TABLE user_coupons(
                        guid INTEGER(10),
                        coupon_code INTEGER(10),
                        user_guid INTEGER(10),
                        username VARCHAR(255),
                        used VARCHAR(10),
                        expire_time INTEGER(10),
                        time_registered INTEGER(10))");
    }catch(PDOException $e) {
    }

    $query = 'INSERT INTO user_coupons (guid, coupon_code, user_guid, username, used, expire_time, time_registered)
      VALUES (
      "'.$array['guid'].'",
        "'.$array['code'].'",
          "'.$array['user_guid'].'",
            "'.$array['username'].'",
            "no",
            "'.$array['valid_till'].'",
            "'.time().'")
      ';

    try {
      $success = $sqlite->execute($query);
    }catch (PDOException $e) {
    }

    return $success;
  }

  public function delete() {
    $sqlite = new IzapSqlite($this->sqlite_file);
    try {
      $success = $sqlite->execute("DELETE from user_coupons where guid = '".$this->guid."'");
      delete_entity($this->guid, TRUE);
    }
    catch(PDOException $e) {
      register_error($e->getMessage());
    }
    return $success;
  }
}