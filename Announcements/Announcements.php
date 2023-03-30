<?php

function custom_plugin_Announcements() {
?>

<div class="wrap">
        <h2 class="wp-heading-inline">Announcements</h2>
        <div class="tablenav top">
             <a class="page-title-action" href="<?php $url= admin_url('admin.php?page=custom_plugin_annoucncements_create');  echo $url;  ?>">Add New</a>
            
        </div>
        <?php
        global $wpdb;
        $table_name = $wpdb->prefix . "announcements";

        $rows = $wpdb->get_results("SELECT * from $table_name");
        $attachment = '';
        $count = 0;
        ?>
        <table class='wp-list-table widefat fixed striped table-view-list posts'>
            <tr>
                <th class="manage-column column-primary">ID</th>
                <th class="manage-column ">Name</th>
                <th class="manage-column ">Attachment</th>
                <th class="manage-column ">Action</th>
            </tr>
            
            <?php foreach ($rows as $row) { ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo ++$count; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->announcement_text; ?></td>
                    <?php

                    // if($row->announcement_url !== null){
                    //   $attachment = $row->announcement_url;
                    // }
                    ?>
                    <td class="manage-column ss-list-width"><?php 

                        $attachment =  $row->announcement_url;
                    
                    
                    echo $attachment; ?></td>
                    <td><a href="<?php echo admin_url('admin.php?page=custom_plugin_annoucncements_update&id=' . $row->id); ?>">Update</a>
                    <a href="<?php echo admin_url('admin.php?page=custom_plugin_annoucncements_delete&id=' . $row->id); ?>">Delete</a></td>

                </tr>
            <?php } ?>
        </table>
    </div>
    <?php
}



