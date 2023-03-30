<?php 

function custom_skill_sector_create(){

    $validation_messages = [];
    $optional_validation_messages = [];
    $success_message = '';
    $image_url = '';
    if (isset($_POST['insert'])) {

        $sector_name = isset( $_POST['sector_name'] ) ? sanitize_text_field( $_POST['sector_name'] ) : '';
        $image_url = isset( $_POST['image_url'] ) ? $_POST['image_url'] : '' ;
        $external_url = isset( $_POST['external_url'] ) ? filter_var( $_POST['external_url'],FILTER_VALIDATE_URL ) : '';

        //Validate the data
		if ( strlen( $sector_name ) === 0 ) {
			$validation_messages[] = esc_html__( 'Please enter a sector name.');
		}

        //Validate the data
		if ( strlen( $image_url ) === 0 ) {
			$validation_messages[] = esc_html__( 'Please enter a image url name.');            
        }

        if ( strlen( $external_url ) === 0 ) {
            $validation_messages[] = esc_html__( 'Please enter a external url.');
        }


        if ( empty( $validation_messages ) ) {
            global $wpdb,$table_prefix;
            $wp_sectors = $table_prefix.'sectors';




            $data= array(
                'sector_name'=>$sector_name,
                'image_url'=>$image_url,
                'external_url'=> $external_url,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            );

            // die(print_r($data));


            $new_data = $wpdb->insert($wp_sectors,$data); 

            //die(var_dump($wpdb->last_error));



            $success_message = esc_html__( 'Skill Sector is successfully inserted.' );

        }

         //Display the validation errors
        if ( ! empty( $validation_messages ) ) {
            foreach ( $validation_messages as $validation_message ) {
                echo '<div class="notice notice-error is-dismissible"><p>' . esc_html( $validation_message ) . '</p></div>';
            }
        }

        //Display the success message
        if ( strlen( $success_message ) > 0 ) {
            echo '<div class="updated"><p>' . esc_html( $success_message ) . '</p></div>';
        }



    }


?>
        
        <div class="wrap">
            <h2>Add New Skill Sector </h2>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
            <div id="universal-message-container">
                    <table class='wp-list-table form-table'>
                        <tr>
                            <th class="title">Skill Sector Heading</th>
                            <td><input type="text" name="sector_name" size="100"  placeholder="Enter Sector Name" /></td>
                        </tr>
                        <tr>
                                <th class="title">Image Url</th>
                                <td>
                                    <input type="text" name="image_url" size="100"  placeholder="Enter Image Url"   />
                                </td>
                            
                        </tr>
                        <tr>
                                <th class="title">External Url</th>
                                <td>
                                    <input type="text" name="external_url" size="100" placeholder="Enter External Url"  />
                                </td>
                            
                        </tr>
                    </table>
                </div>
                <input type='submit' name="insert" value='Save' class='button'>
                <a class='button' href="<?php echo admin_url('admin.php?page=custom_skill_sectorCouncil'); ?>">Back To Skill Sector List</a>
            </form>
        </div>
<?php
}