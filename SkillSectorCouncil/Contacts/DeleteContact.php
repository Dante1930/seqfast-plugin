<?php 

function custom_contact_delete(){

    global $wpdb,$table_prefix;
    $table_name = $wpdb->prefix . "sector_contact";
    $id = $_GET["id"];
    $success_message = '';

    if (isset($_POST['delete'])) {
            $wp_sectors = $table_prefix.'sectors';
            
            $contact_q = $wpdb->prepare("SELECT * from $table_name where id=%s", $id);
            $contact_single = $wpdb->get_row($contact_q, ARRAY_A );

            $q = $wpdb->prepare("SELECT * from $wp_sectors where id=%s", $contact_single['sector_id']);
            $result = $wpdb->get_row($q, ARRAY_A );
            
            $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %s", $id));

         
         $success_message = esc_html__('Contact is successfully deleted '.$result['sector_name'].' in this skill sector.' );

        //Display the success message
        if ( strlen( $success_message ) > 0 ) {
            echo '<div class="updated"><p>' . esc_html( $success_message ) . '</p></div>';
        }


    }else{

        $contact_q = $wpdb->prepare("SELECT * from $table_name where id=%s", $id);
        $contact_single = $wpdb->get_row($contact_q, ARRAY_A );

    }

?>

<div class="wrap">
    <h2><?php echo esc_html('Delete Contact'); ?></h2>
<?php if (isset($_POST['delete'])) : ?>
    <a class='button' href="<?php echo admin_url('admin.php?page=custom_contact_list'); ?>">Back To Contact List</a>
<?php else: ?>
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">

    <div id="universal-message-container">
            <table class='wp-list-table form-table'>

                <tr>
                    <th class="title">Skill Sector</th>
                    <td>
            <?php 
            global $wpdb,$table_prefix;
            $wp_emp = $table_prefix.'sectors';
            $q = "SELECT * FROM `$wp_emp`;";
            
            $results = $wpdb->get_results($q);
            if(!empty($results)):
            foreach($results as $row):
                if($row->id == $contact_single['sector_id']):
            
                echo "<b>".$row->sector_name."</b>";         
                endif;
            endforeach;
            endif;
            ?>
                    </td>
                </tr>
                
                <tr>
                    <th class="title">Contact Name</th>
                    <td><?php echo $contact_single['name'];?></td>
                </tr>
                <tr>
                    <th class="title"><?php echo esc_html( 'Email'); ?></th>
                    <td><?php echo $contact_single['email'];?>
                    </td>
                    
                </tr>
                <tr>
                        <th class="title"><?php echo esc_html('Contact No.'); ?></th>
                        <td>
                        <?php echo $contact_single['contact_no'];?>
                        </td>
                    
                </tr>
                <tr>
                <th class="title"><?php echo esc_html('Address'); ?></th>
                <td>
                    <?php echo $contact_single['address'];?>
                </td>
                </tr>
            </table>
        </div>
        <input type='submit' name="delete" value='Delete' class='button'>
        <a class='button' href="<?php echo admin_url('admin.php?page=custom_contact_list'); ?>">Back To Contact List</a>
    </form>
<?php endif;?>

</div>
<?php
}
?>