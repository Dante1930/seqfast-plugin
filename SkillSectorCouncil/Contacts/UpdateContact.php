<?php
function custom_contact_update()
{
    global $wpdb;
    $table_name = $wpdb->prefix . "sector_contact";
    $id = $_GET["id"];

    $contact_q = $wpdb->prepare("SELECT * from $table_name where id=%s", $id);
    $contact_single = $wpdb->get_row($contact_q, ARRAY_A );


    $validation_messages = [];
	$success_message = '';
	

	if ( isset( $_POST['update'] ) ) {

		//Sanitize the data
		$sector_id = isset( $_POST['sector_id'] ) ? $_POST['sector_id'] : '';
       
        $contact_name = isset( $_POST['contact_name'] ) ? sanitize_text_field( $_POST['contact_name'] ) : '';
		
        $email     = isset( $_POST['email'] ) ? sanitize_text_field( $_POST['email'] ) : '';
        // $contact_no = isset( $_POST['contact_no'] ) ? preg_replace('/[^0-9]/', '', $_POST['contact_no']) : '';
        $contact_no = isset( $_POST['contact_no'] ) ? $_POST['contact_no'] : '';


		$address   = isset( $_POST['address'] ) ? sanitize_textarea_field( $_POST['address'] ) : '';

            
        if ( $sector_id == '0' ) {
            $validation_messages[] = esc_html__( 'Please enter a valid selelct query.');
        }

        
        //Validate the data
		if ( strlen( $contact_name ) === 0 ) {
			$validation_messages[] = esc_html__( 'Please enter a contact name.');
		}

		if ( strlen( $email ) === 0 ) {
			$validation_messages[] = esc_html__( 'Please enter a valid email address.' );
		}

        if( strlen( $contact_no ) === 0 ){
            $validation_messages[] = esc_html__( 'Please enter a valid contact number.' );  
        }



		if ( strlen( $address ) === 0 ) {
			$validation_messages[] = esc_html__( 'Please enter a valid address.' );
		}

        if ( empty( $validation_messages ) ) {
            global $wpdb,$table_prefix;
            $wp_sector_contact = $table_prefix.'sector_contact';

            $data= array(
                'sector_id'=>$sector_id,
                'name'=>$contact_name,
                'email'=> $email,
                'contact_no'=> $contact_no,
                'address'=> $address,
                'created_at'=>date("Y-m-d H:i:s"),
                'updated_at'=>date("Y-m-d H:i:s")
            );

            // die(print_r($data));

            $where = array('id'=>$id);


            //die(print_r($data));
        
            $update_data = $wpdb->update($wp_sector_contact,$data,$where);


            $wp_sectors = $table_prefix.'sectors';
            $q = $wpdb->prepare("SELECT * from $wp_sectors where id=%s", $sector_id);
            $result = $wpdb->get_row($q, ARRAY_A );


            $success_message = esc_html__('Contact is successfully updated '.$result['sector_name'].' in this skill sector.' );



        }

         //Display the validation errors
        if ( ! empty( $validation_messages ) ) {
            foreach ( $validation_messages as $validation_message ) {
                echo '<div class="notice notice-error is-dismissible"><p>' . esc_html( $validation_message ) . '</p></div>';
            }
        }

        //Display the success message
        if ( strlen( $success_message ) > 0 ) {
            $contact_q = $wpdb->prepare("SELECT * from $table_name where id=%s", $id);
            $contact_single = $wpdb->get_row($contact_q, ARRAY_A );
            echo '<div class="updated"><p>' . esc_html( $success_message ) . '</p></div>';
        }




  

    }
?>
        <div class="wrap">
            <h2>Add New Contact </h2>
            <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
            <div id="universal-message-container">
                    <table class='wp-list-table form-table'>

                        <tr>
                            <th class="title">Skill Sector</th>
                            <td><select name="sector_id" class="large-text code" style="width:100%">
                            <option value="0">Select the Skill Sector</option>
                            <?php 
                    global $wpdb,$table_prefix;
                    $wp_emp = $table_prefix.'sectors';
                    $q = "SELECT * FROM `$wp_emp`;";
                    
                    $results = $wpdb->get_results($q);
                    ?>
                    <?php 
                    if(!empty($results)):
                    foreach($results as $row):
                        if($row->id == $contact_single['sector_id']):
                    ?>
                    
                     <option value="<?php echo $row->id; ?>" selected><?php echo $row->sector_name; ?> </option>
                    
                    <?php
                        else:
                    ?>
                        <option value="<?php echo $row->id; ?>"><?php echo $row->sector_name; ?> </option>
                    <?php        
                        endif;
                    endforeach;
                    endif;
                    ?>
                            </select></td>
                        </tr>
                        
                        <tr>
                            <th class="title">Contact Name</th>
                            <td><input type="text" class="large-text code" name="contact_name" value="<?php echo $contact_single['name'];?>" placeholder="Your Contact Name "/></td>
                        </tr>
                        <tr>
                            <th class="title"><?php echo esc_html( 'Email'); ?></th>
                            <td>
                                <input type="text" class="large-text code" id="email" name="email" value="<?php echo $contact_single['email'];?>" placeholder="Your Contact Email">
                            </td>
                            
                        </tr>
                        <tr>
                                <th class="title"><?php echo esc_html('Contact No.'); ?></th>
                                <td>
                                    <input type="text" class="large-text code" name="contact_no" value="<?php echo $contact_single['contact_no'];?>" placeholder="Your Contact Number"  />
                                </td>
                            
                        </tr>
                        <tr>
                        <th class="title"><?php echo esc_html('Address'); ?></th>
                        <td>
                            <textarea rows="3" class="large-text code"  name="address" ><?php echo $contact_single['address'];?></textarea>
                        </td>
                        </tr>
                    </table>
                </div>
                <input type='submit' name="update" value='Save' class='button'>
                <a class='button' href="<?php echo admin_url('admin.php?page=custom_contact_list'); ?>">Back To Contact List</a>
            </form>
        </div>
<?php
}