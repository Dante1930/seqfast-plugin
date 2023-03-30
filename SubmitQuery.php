<?php


add_action( 'wp_enqueue_scripts', 'add_custom_captcha_script' );
//add_action( 'init', 'add_custom_captcha_script' );
function add_custom_captcha_script(){
    
    
    wp_enqueue_script( 'jquery-captcha',plugins_url('js/captcha/js/jquery-captcha.min.js',__FILE__), array(), '', true );
	wp_enqueue_script( 'Custom-Captchafile',plugins_url('js/CustomCaptchafile.js',__FILE__), array( 'jquery','jquery-captcha'),
    filemtime(plugin_dir_path(__FILE__).'js/CustomCaptchafile.js'), 
    true);

    $translation_array = array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
        'ajax_nonce ' => wp_create_nonce( 'secure_nonce_name' )
    );
    wp_localize_script( 'Custom-Captchafile', 'cpm_object', $translation_array );
     

}


function display_submit_query_form() {
    ob_start();
?>

<div class="alert alert-danger display-error" style="display: none">
</div>  
<div id="msg"></div>
<form id="query-form" class="ajax"  action="" >

        <!-- <input type="hidden" name="query_form"> -->

        <input name="my_aiowz_update_setting" type="hidden" value="<?=wp_create_nonce('aiowz-update-setting');?>" />

        <div class="form-section">
            <label for="full-name"><?php echo esc_html( 'Name', 'Divi' ); ?> *</label>
            <input type="text" id="full-name" name="full_name" placeholder="Your Full Name">
        </div>

        <div class="form-section">
            <label for="email"><?php echo esc_html( 'Email', 'Divi' ); ?> *</label>
            <input type="text" id="email" name="email" placeholder="Your Current Email">
        </div>

        <div class="form-section">
            <label for="queryType"><?php echo esc_html( 'Type of Query', 'Divi' ); ?> *</label>
                <select class="form-control QueryType" name="query_type" id="queryType">
                    <option value="0">Select the Query</option>
                    <?php 
                    global $wpdb,$table_prefix;
                    $wp_emp = $table_prefix.'submitquery';
                    $q = "SELECT * FROM `$wp_emp`;";
                    
                    $results = $wpdb->get_results($q);
                    ?>
                    <?php 
                    foreach($results as $row):
                    ?>
                    <option value="<?php echo $row->id; ?>"><?php echo $row->query_message; ?> </option>
                    
                    <?php
                    endforeach;
                    ?>

                </select>
        </div>

        <div class="row">
            <div class="form-group">
                <label for="message"><?php echo esc_html( 'Message', 'Divi' ); ?> *</label>
                <textarea id="message" name="message" rows="3" class="form-control" ></textarea>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-6">
                <label>Enter Captcha</label>
                <input name="code" class="form-control"/>
                <input type="hidden" name="CaptchaUser" id="CaptchaUser"/>
            </div> 
            <div class="form-group col-6">
                <label>Captcha Code</label>
                <canvas id="canvas"></canvas>
            </div>
        </div>

        <div class="row">
            <a href="javascript:void(0)" id="refreshCapta">Click here to refesh Captcha</a>
        </div>
		
        <input type="submit" id="query-form-submit" value="<?php echo esc_attr( 'Submit', 'Divi' ); ?>">



    </form>


<?php

    return ob_get_clean();
 }


add_shortcode( 'custom-query-form', 'display_submit_query_form' );

?>