<?php
function custom_plugin_annoucncements_update() {
    global $wpdb;
    $table_name = $wpdb->prefix . "announcements";
    $id = $_GET["id"];
    // $name = $_POST["name"];
    $validation_messages = [];
	$success_message = '';
    $announcements = $wpdb->get_results($wpdb->prepare("SELECT * from $table_name where id=%s", $id));
    foreach ($announcements as $s) {
        $announcement_text	 = $s->announcement_text;
        $announcement_url	 = $s->announcement_url;
    }
	
//update
    if (isset($_POST['update'])) {

        $message   = isset( $_POST['name'] ) ? sanitize_textarea_field( $_POST['name'] ) : '';
        $url   = $_POST['url'];

        if ( strlen( $message ) === 0 ) {
            $validation_messages[] = esc_html__( 'Please enter a valid Announcement Text.', 'Divi' );
        }

        // if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) {
        //     $validation_messages[] = esc_html__( 'Not a valid URL', 'Divi' );   
        // }



        if ( empty( $validation_messages ) ) {
            global $wpdb,$table_prefix;
            $wp_emp = $table_prefix.'announcements';




            $data= array(
                'announcement_text'=>$message,
                'announcement_url'=>$url,
                'status'=> 0,
                'created_at'=>date("Y-m-d H:i:s")
            );

            $where = array('id'=>$id);


            //die(print_r($data));
        
            $wpdb->update(
                $wp_emp,
                $data,
                $where
            );

            $success_message = esc_html__( 'Your announcements is successfully updated.', 'Divi' );
      
        }

        //Display the validation errors
        if ( ! empty( $validation_messages ) ) {
            foreach ( $validation_messages as $validation_message ) {
                echo '<div class="notice notice-error is-dismissible"><p>' . esc_html( $validation_message ) . '</p></div>';
            }
        }

        //Display the success message
        if ( strlen( $success_message ) > 0 ) {
            $announcements = $wpdb->get_results($wpdb->prepare("SELECT * from $table_name where id=%s", $id));
            foreach ($announcements as $s) {
                $announcement_text	 = $s->announcement_text;
                $announcement_url	 = $s->announcement_url;
            }
            echo '<div class="updated"><p>' . esc_html( $success_message ) . '</p></div>';
        }
        


    }
?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/sinetiks-schools/style-admin.css" rel="stylesheet" />
    <div class="wrap">
            <h2>Update Announcements </h2>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
                <table class='wp-list-table form-table'>
                    <tr>
                        <th class="title">Announcement Text</th>
                        <td><textarea  name="name" class="large-text code"  rows="3"><?php echo $announcement_text; ?></textarea></td>
                    </tr>

                    <tr>
                        <th class="title">Url</th>
                        <td>
                            <input type="text" name="url" value="<?php echo $announcement_url;?>"/>
                        </td>

                    </tr>
                </table>
                <input type='submit' name="update" value='Save' class='button'>
                <a class='button' href="<?php echo admin_url('admin.php?page=custom_plugin_Announcements'); ?>">Back To Annocements List</a>
            </form>
    </div>
<?php    

}
?>