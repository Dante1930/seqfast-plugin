<?php
/**
 * Plugin Name
 *
 * @package           SeqfastPlugin
 * @author            Sahil Bhatia
 * @copyright         2023 seqfast.com
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Seqfast Plugin
 * Plugin URI:        https://seqfast.com
 * Description:       This is a Seqfast Plugin for our own use.
 * Version:           1.1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Sahil Bhatia
 * Author URI:        https://seqfast.com
 * Text Domain:       seqfast_plugin
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI:        https://seqfast.com
 */

 if( ! defined('ABSPATH')){
    header("Location:".site_url());
    die("can't access");
}


function seqfast_plugin_activation(){
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
}

register_activation_hook(__FILE__, 'seqfast_plugin_activation');


function seqfast_plugin_deactivation(){

}

register_deactivation_hook(__FILE__, 'seqfast_plugin_deactivation');

//styles
add_action( 'wp_enqueue_scripts', 'add_custom_translate_script' );


function add_custom_translate_script(){
	wp_register_script( 'jquery-cookie','https://cdnjs.cloudflare.com/ajax/libs/jquery-cookie/1.4.1/jquery.cookie.js', array(), '', true );
	wp_enqueue_script( 'customMainfile',plugins_url('js/main.js',__FILE__), array( 'jquery','jquery-cookie'),
    filemtime(plugin_dir_path(__FILE__).'js/main.js'), true );	
	wp_enqueue_script( 'googletranslate','//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit', array(), '', true );
	wp_enqueue_style( 'customfile',plugins_url('css/customfile.css',__FILE__), array(  ), '');

    $translation_array = array(
        'path' => COOKIEPATH,
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'ajax_nonce ' => wp_create_nonce( 'secure_nonce_name' )
    );
    wp_localize_script( 'customMainfile', 'skillSector_object', $translation_array );

}



//menus
add_filter( 'wp_nav_menu_items', 'add_custom_trans_link', 10, 2 );
function add_custom_trans_link( $items, $args ) {
    //die($args->theme_location);
    if ($args->theme_location == 'secondary-menu') {
		// $menus = wp_get_nav_menus();
		// $locations = get_nav_menu_locations();
        $items .= '<li class="hindi"><a href="javascript:void(0)" class="changeLanguageByButtonClick notranslate hindi" data-lang="hi">हिंदी</a></li>';
        $items .= '<li class="english" style="display:none;"><a href="javascript:void(0)" class="changeLanguageByButtonClick notranslate english" data-lang="en">English</a></li>';
		$items .= '<li><a href="#a" class="notranslate fontdecre">A-</a></li>';
		$items .= '<li><a href="#a" class="notranslate fontActual">A</a></li>';
		$items .= '<li><a href="#a" class="notranslate fontIncre">A+</a></li>';
    }

    return $items;
}

//FOOTER MENU

add_filter( 'wp_nav_menu_items', 'add_footer_link', 10, 2 );

function getImage(){
    return site_url().'/wp-content/uploads/2023/01/india-gov-in-logo.jpg';
} 
function add_footer_link( $items, $args ) {
    //die($args->theme_location);
    if ($args->theme_location == 'footer-menu') {
		// $menus = wp_get_nav_menus();
		// $locations = get_nav_menu_locations();
        $items .= '</ul><div class="gov_logos">
                   Visitor\'s Counter: &nbsp;<b>'.do_shortcode( "[jp_all_time_stats]" ).'</b>
                </div>';

    }

    return $items;
}


//last footer menu

function get_latest_update_date() {
    global $wpdb;
    $thelatest = $wpdb->get_var("SELECT max(post_modified) FROM wp_posts WHERE post_type IN ('post', 'page');");
    //returns formatted date like 13.08.2001
    return "Content last updated on ".date_i18n('j/m/Y', strtotime($thelatest));
}


    //external_link
    

if( ! function_exists( 'et_get_footer_credits' ) ) :
    function et_get_footer_credits()
    {
        global $items;

        $items .= '<ul class="bottom-nav">';
        $items .= '<li>©'.date('Y').' '.get_bloginfo( 'name' ).' All Rights Reserved.</li>';
        $items .= '<li>'.get_latest_update_date().'</li>';
        $items .= '<li><a href="https://seqfast.com" class="external_link">Sequoia Fitness and Sports Technology</a></li>';
		//$items .= '<li>'.do_shortcode( "[jp_post_view]" ).'</li>';
        $items .= '</ul>';
        echo  $items;
        

    //   echo sprintf('
    //     <li>
    //       Copyright %1$s %2$s. All rights reserved.
    //     </li>',
    //       date('Y'),
    //       get_bloginfo( 'name' )
    //       );
      }
endif;


//contact form 
define('ROOTDIR', plugin_dir_path(__FILE__));
require_once(ROOTDIR . 'customContactus.php');


//submit form
require_once(ROOTDIR . 'SubmitQuery.php');


// THE AJAX ADD ACTIONS
add_action( 'wp_ajax_submit_query', 'ajax_set_form' );    //execute when wp logged in
add_action( 'wp_ajax_nopriv_submit_query', 'ajax_set_form'); //execute when logged out


function ajax_set_form(){
    // if (!wp_verify_nonce($_POST['my_aiowz_update_setting'],'aiowz-update-setting')) {
    //     $validation_messages[] = esc_html__( 'No csrf token send.', 'Divi' );
    //     echo json_encode(['code'=>404, 'validation_msg'=>$validation_messages ]);        
    // }
    if(isset($_POST['submit_query'])){

        $arr = array();
        $validation_messages = array();
        $success_message = '';
        wp_parse_str( $_POST['submit_query'], $arr);
        $full_name = $arr['full_name'];
        $email = $arr['email'];
        $query_type   = $arr['query_type'];
        $captcha = $arr["CaptchaUser"];
        $code = $arr["code"];
        $message   = isset( $arr['message'] ) ? sanitize_textarea_field( $arr['message'] ) : '';
    
            //Validate the data
            if ( strlen( $full_name ) === 0 ) {
                $validation_messages[] = esc_html__( 'Please enter a valid name.', 'Divi' );
            }
    
            if ( strlen( $email ) === 0 or ! is_email( $email ) ) {
              $validation_messages[] = esc_html__( 'Please enter a valid email address.', 'Divi' );
            }
    
            if ( $query_type == '0' ) {
              $validation_messages[] = esc_html__( 'Please enter a valid selelct query.', 'Divi' );
            }
    
            if(empty($code)) {
                $validation_messages[] = esc_html__( 'Please enter the captcha.', 'Divi' );
            }
            else if($captcha != $code){
                $validation_messages[] = esc_html__( 'Captcha is invalid.', 'Divi' );
    
            } 
    
            if ( strlen( $message ) === 0 ) {
              $validation_messages[] = esc_html__( 'Please enter a valid message.', 'Divi' );
            }
    
    
    
            if(empty($validation_messages)){
                global $wpdb,$table_prefix;
                $submitquery_details = $table_prefix.'submitquery_details';
    
    
                $data= array(
                    'name'=>$full_name,
                    'email'=>$email,
                    'queryType'=>$query_type,
                    'message'=>$message,
                    'status'=> 0,
                    'created_at'=>date("Y-m-d H:i:s")
                );
    
    
                $wpdb->insert($submitquery_details,$data);			
                $msg = esc_html__( 'Your message has been successfully sent.', 'Divi' );
                echo json_encode(['code'=>200, 'msg'=>$msg]);
            }
    
            
    
               //Display the validation errors
            if ( ! empty( $validation_messages ) ) {
                echo json_encode(['code'=>404, 'validation_msg'=>$validation_messages]);
            }
    
    
    
        wp_die();

    }




}


//submit form
add_action('admin_menu', 'addAdminPageContent');
function addAdminPageContent() {
    add_menu_page('Announcements',
            'Announcements',
            'manage_options',
            'custom_plugin_Announcements',
            'custom_plugin_Announcements',
            'dashicons-wordpress');

        //this is a submenu
        add_submenu_page('custom_plugin_Announcements', //parent slug
        'Add New Announcement', //page title
        'Add New Announcement', //menu title
        'manage_options', //capability
        'custom_plugin_annoucncements_create', //menu slug
        'custom_plugin_annoucncements_create'); //function

        	//this submenu is HIDDEN, however, we need to add it anyways
	    add_submenu_page(null, //parent slug
	    'Update Announcement', //page title
	    'Update Announcement', //menu title
	    'manage_options', //capability
	    'custom_plugin_annoucncements_update', //menu slug
	    'custom_plugin_annoucncements_update'); //function


                	//this submenu is HIDDEN, however, we need to add it anyways
	    add_submenu_page(null, //parent slug
	    'Delete Announcement', //page title
	    'Delete Announcement', //menu title
	    'manage_options', //capability
	    'custom_plugin_annoucncements_delete', //menu slug
	    'custom_plugin_annoucncements_delete'); //function

}
require_once(ROOTDIR . 'Announcements/Announcements.php');
require_once(ROOTDIR . 'Announcements/Announcements-create.php');
require_once(ROOTDIR . 'Announcements/Announcements-update.php');
require_once(ROOTDIR . 'Announcements/Announcements-delete.php');


require_once(ROOTDIR . 'front_Announcements.php');


add_action('admin_menu', 'addAdminSkillSector');
function addAdminSkillSector() {
    add_menu_page('SkillSectorCouncil',
            'SkillSectorCouncil',
            'manage_options',
            'custom_skill_sectorCouncil',
            'custom_skill_sectorCouncil',
            'dashicons-portfolio');

        //this is a submenu
        add_submenu_page(null, //parent slug
        'Add New Skill Sector', //page title
        'Add New Skill Sector', //menu title
        'manage_options', //capability
        'custom_skill_sector_create', //menu slug
        'custom_skill_sector_create'); //function

        //this is a submenu
        add_submenu_page(null, //parent slug
        'Update Skill Sector', //page title
        'Update Skill Sector', //menu title
        'manage_options', //capability
        'custom_skill_sector_update', //menu slug
        'custom_skill_sector_update'); //function

        //this is a submenu
        add_submenu_page(null, //parent slug
        'Deletew Skill Sector', //page title
        'Delete Skill Sector', //menu title
        'manage_options', //capability
        'custom_skill_sector_delete', //menu slug
        'custom_skill_sector_delete'); //function

        //this is a submenu
        add_submenu_page('custom_skill_sectorCouncil', //parent slug
        'Contacts List', //page title
        'Contacts List', //menu title
        'manage_options', //capability
        'custom_contact_list', //menu slug
        'custom_contact_list'); //function

        //this is a submenu
        add_submenu_page(null, //parent slug
        'Contact Add', //page title
        'Contact Add', //menu title
        'manage_options', //capability
        'custom_contact_create', //menu slug
        'custom_contact_create'); //function


        //this is a submenu
        add_submenu_page(null, //parent slug
        'Contact Update', //page title
        'Contact Update', //menu title
        'manage_options', //capability
        'custom_contact_update', //menu slug
        'custom_contact_update'); //function

        //this is a submenu
        add_submenu_page(null, //parent slug
        'Contact Delete', //page title
        'Contact Delete', //menu title
        'manage_options', //capability
        'custom_contact_delete', //menu slug
        'custom_contact_delete'); //function
}
require_once(ROOTDIR . 'SkillSectorCouncil/SkillSectorCouncil.php');
require_once(ROOTDIR . 'SkillSectorCouncil/SkillSectorCouncil-create.php');
require_once(ROOTDIR . 'SkillSectorCouncil/SkillSectorCouncil-update.php');
require_once(ROOTDIR . 'SkillSectorCouncil/SkillSectorCouncil-delete.php');

// Contacts
require_once(ROOTDIR . 'SkillSectorCouncil/Contacts/ContactList.php');
require_once(ROOTDIR . 'SkillSectorCouncil/Contacts/AddContact.php');
require_once(ROOTDIR . 'SkillSectorCouncil/Contacts/UpdateContact.php');
require_once(ROOTDIR . 'SkillSectorCouncil/Contacts/DeleteContact.php');


require_once(ROOTDIR . 'SkillSectorCouncil/front_end_skill_sector.php');


// THE AJAX ADD ACTIONS
add_action( 'wp_ajax_so_wp_ajax', 'so_wp_ajax_function' );    //execute when wp logged in
add_action( 'wp_ajax_nopriv_so_wp_ajax', 'so_wp_ajax_function'); //execute when logged out

function so_wp_ajax_function(){
  //DO whatever you want with data posted
  //To send back a response you have to echo the result!

  if(isset($_POST['id'])){
    $id = $_POST['id'];
    global $wpdb;
    $table_name = $wpdb->prefix . "sector_contact";

    $data = $wpdb->get_results("SELECT * from $table_name where sector_id=$id");

    echo json_encode(['code'=>200, 'msg'=>$data]);


  }

 wp_die(); // ajax call must die to avoid trailing 0 in your response
}