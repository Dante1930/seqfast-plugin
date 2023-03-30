<?php 

function custom_skill_sector_delete(){
    global $wpdb;
    $table_name = $wpdb->prefix . "sectors";
    $table_name_sector_contact = $wpdb->prefix . "sector_contact";
    $id = $_GET["id"];
    $success_message = '';

    $sector_q = $wpdb->prepare("SELECT * from $table_name where id=%s", $id);
    $sector_single = $wpdb->get_row($sector_q, ARRAY_A );

    if (isset($_POST['delete'])) {
        
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name_sector_contact WHERE sector_id = %s", $id));
        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %s", $id));

        $success_message = esc_html__('Skill Sector is successfully deleted.' );


                //Display the success message
        if ( strlen( $success_message ) > 0 ) {
            echo '<div class="updated"><p>' . esc_html( $success_message ) . '</p></div>';
        }
        

    }
?>
        <div class="wrap">
            <h2><?php echo esc_html('Delete Sector'); ?> </h2>
                <?php if (isset($_POST['delete'])) : ?>
                <a class='button' href="<?php echo admin_url('admin.php?page=custom_skill_sectorCouncil'); ?>">Back To Skill Sector List</a>
                <?php else: ?>
                    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
                        <div id="universal-message-container">
                            <table class='wp-list-table form-table'>
                                <tr>
                                    <th class="title"><?php echo esc_html('Skill Sector Heading'); ?> </th>
                                    <td><?php echo $sector_single['sector_name']; ?></td>
                                </tr>
                                <tr>
                                        <th class="title"><?php echo esc_html('Image Url');?></th>
                                        <td>
                                        <?php echo $sector_single['image_url']; ?>
                                        </td>
                                    
                                </tr>
                                <tr>
                                        <th class="title"><?php echo esc_html('External Url');?></th>
                                        <td><?php echo $sector_single['external_url']; ?>
                                        </td>
                                    
                                </tr>
                            </table>
                        </div>
                        <input type='submit' name="delete" value='Delete' class='button'>
                        <a class='button' href="<?php echo admin_url('admin.php?page=custom_skill_sectorCouncil'); ?>">Back To Skill Sector List</a>
                    </form>
            <?php endif;?>
        </div>
<?php
}
?>