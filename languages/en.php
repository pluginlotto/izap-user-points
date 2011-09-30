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
 * For discussion about corresponding plugins, visit http://www.pluginlotto.com/pg/forums/
 * Follow us on http://facebook.com/PluginLotto and http://twitter.com/PluginLotto
 */

add_translation('en', array(
    'item:annotation' => 'Annotation (Comments, rating and all others)',
    'izap-user-points:go_to_admin_settings' => 'Edit user points',
    'izap-user-points:activate_site_offers' => 'Activate site offers',
    'izap-user-points:user_rank_rules' => 'Add rules for user ranks, add one rule per line
          {"name"|"for points less than"} i.e. <pre>New|100<br />Intermedate|1000</pre>',
    'izap-user-points:admin_settings' => 'User points settings',
    'izap-user-points:create_redeem_offer' => 'Create Redeem Offer',
    'izap-user-points:points' => 'Points',
    'izap-user-points:users_point' => 'Users point',
    'izap-user-points:total_points' => 'My points',
    'izap-user-points:login_point' => 'Point for every login',
    'izap-user-points:setting_saved' => 'Settings saved successfully.',
    'izap-user-points:setting_not_saved' => 'Error saving settings for the plugin.',
    // redeem form
    'izap-user-points:title' => 'Title',
    'izap-user-points:description' => 'Description',
    'izap-user-points:valid_till' => 'Valid till',
    'izap-user-points:point_value' => 'Points required',
    'izap-user-points:access_id' => 'Access id',
    'izap-user-points:success_creating_redeem_offer' => 'Offer Created successfully',
    'izap-user-points:error_creating_redeem_offer' => 'Error Creating offer',
    'izap-user-points:form_error:empty:per_unit_value'=>'Please choose per unit value',
    'izap-user-points:point_value_msg'=>'Set this field empty to publish this coupon free of cost',
    'izap-user-points:per_unit_value_msg'=>'This per unit value will calculate the monetary cost of the offer',
    'izap-user-points:allow_to_point_bank_msg'=>'yes is preferable',
    // site offers
    'izap-user-points:redeem_offers' => 'Site offers',
    'izap-user-points:form_error:empty:title' => 'Title can not be left blank',
    'izap-user-points:form_error:empty:description' => 'Description can not be left blank',
    'izap-user-points:site_offers' => 'Site Offers',
    'izap-user-point:image' => 'Image',
    'izap_userpoints:on' => 'On',
    'izap_userpoints:off' => 'Off',
    'izap-user-points:cash_required' => 'Cash required: ',
    'izap-user-points:points_required' => 'Points required',
    'izap-user-points:get_code' => 'Avail/Buy Offer',
    'izap-user-points:error_buying_offer' => 'Error Processing your Offer',
    'izap-user-points:offer_bought' => 'Offer Purchased Successfully',
    'izap-user-points:offer_bought_subject' => 'Your offer coupon code',
    'izap-user-points:offer_bought_message' => 'Your coupon code is "%s".',
    'izap-user-points:coupon_list' => 'Coupon List',
    'izap-user-points:check_coupon' => 'Check Coupon',
    'izap-user-points:cant buy' => "You don't have enough points to use",
    'izap-user-points:avail' => 'Buy',
    'izap-userpoints:points' => 'Use your points',
    'izap-userpoints:cash' => 'Use cash',
    'river:comment:object:IzapRedeemOffer' => '%s has commented on offer %s',
    // coupon search
    'izap-user-points:search_code' => 'Search',
    'izap-user-points:coupon_code' => 'Coupon details',
    'izap-user-points:username' => 'Username',
    'izap-user-points:time_registered' => 'Registerd on',
    'izap-user-points:used' => 'Used',
    'izap-user-points:mark_as_used' => 'Mark as used',
    'izap-user-points:mark_as_unused' => 'Mark as unused',
    'izap-user-points:points_used' => 'Points used',
    'izap-user-points:due_amount' => 'Due amount',
    'izap-user-points:coupon_price' => 'Coupon price',
    // coupon action
    'izap-user-points:marked_as_used' => 'Coupon marked as read.',
    'izap-user-points:error_updating_coupon_status' => 'Error updating coupon status. Might be
          Wrong Coupon code. Please contact site admin.',
    'izap-user-points:status_changed' => 'Coupon status changed successfully',
    'admin:utilities:izap-user-points' => 'User points',
    'item:object:IzapUserPoints' => 'izap-user-points',
    'menu:page:header:userpoints' => 'User points',
    'admin:izap-userpoints-section' => 'User Point',
    'admin:izap-userpoints-section:izap-user-points' => 'User point settings',
    'admin:izap-userpoints-section:redeem_coupon' => 'Create coupon',
    'admin:izap-userpoints-section:check_coupon' => 'Check coupon',
    'izap_user_points:site_offers' => 'site offers',
    'izap-user-points:add_new' => 'Add site offer',
    'izap-user:total_points' => '%s Points (%s)',
    'izap-user-points:user-points' => 'User Points',
    'izap-user-points:delete' => 'Delete',
    'izap-user-points:valid_till' => 'Valid till :',
    'izap-user-points:view_offer' => 'Offer: %s',
    'item:object:IzapRedeemOffer' => 'Coupon offers',
    'izap-user-point:top_users' => 'Top Users',
    'izap-user-points:my-points' => 'My points: ',
    'izap-user-points:per_unit_value'=>'Per Unit Value in',
    'izap-user-points:allow_to_point_bank'=>'Allow point Bank',
    'izap-user-points:partial_redemption_allowed'=>'Allow partial redemption ',

    //river

    'item:object:IzapRedeemOffer:singular' => 'Offer',
    //admin stats
    'izap-user-points' => 'Izap user points',
        )
);