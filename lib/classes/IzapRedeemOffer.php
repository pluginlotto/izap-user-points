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

  public function __construct($guid = null, $params = array()) {
    global $CONFIG;
    parent::__construct($guid, $params);

    $this->sqlite_file = $CONFIG->dataroot . '/' . GLOBAL_IZAP_USER_POINTS_PLUGIN . '/'.GLOBAL_IZAP_USER_POINTS_SQLITE_DB.'.db';
    @mkdir ($CONFIG->dataroot . '/' . GLOBAL_IZAP_USER_POINTS_PLUGIN . '/');
  }

  public function get_attributes_array() {
    return array(
            'title' => array('type'=>"string",'required'=>true,),
            'description' => array('type'=>"text",'required'=>true),
            'access_id' => array('type'=>"numerical",'required'=>true,'default'=>ACCESS_PUBLIC),
            'valid_till' => array('type'=>"timestamp",'required'=>true, 'default'=>(time() + 10*24*60*60)),
            'point_value' => array('type'=>"numerical",'required'=>true),
            'total_offers' => array('type' => 'numerical', 'required' => true, 'default' => 1000),
    );
  }

  public function getURL() {
    return func_set_href_byizap(array(
            'pluign' => GLOBAL_IZAP_USER_POINTS_PLUGIN,
            'page' => 'view_offer',
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
    $action = func_get_actions_path_byizap(array(
            'plugin' => GLOBAL_IZAP_USER_POINTS_PLUGIN,
            )) . 'buy_offer';

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

    try{
     $success = $sqlite->execute($query);
    }catch (PDOException $e) {
    }

    return $success;
  }
}