<?php
function custom_contact_list(){
?>

    <div class="wrap">
    <h2 class="wp-heading-inline">Contact Details Based on Skill Sector</h2>
    <div class="tablenav top">
         <a class="page-title-action" href="<?php $url= admin_url('admin.php?page=custom_contact_create');  echo $url;  ?>">Add New</a>
        
    </div>
    
    <table class='wp-list-table widefat fixed striped table-view-list posts'>
        <tr>
            <th class="manage-column column-primary">S NO</th>
            <th class="manage-column ">Contact Name</th>
            <th class="manage-column ">Sector Name</th>
            <th class="manage-column ">Email Address</th>
            <th class="manage-column ">Contact Number</th>
            <th class="manage-column ">Address</th>
            <th class="manage-column ">Action</th>
        </tr>
        <?php
    global $wpdb;
    $table_name = $wpdb->prefix . "sector_contact";

    $rows = $wpdb->get_results("SELECT * from $table_name");
    $attachment = '';
    $count = 0;
    ?>
    <?php foreach ($rows as $row) { ?>
            <tr>
                <td class="manage-column ss-list-width"><?php echo ++$count; ?></td>
                <td class="manage-column ss-list-width"><?php echo $row->name; ?></td>
                <?php

                // if($row->announcement_url !== null){
                //   $attachment = $row->announcement_url;
                // }
                ?>
                <td class="manage-column ss-list-width"><?php 


                $wp_sectors = $wpdb->prefix.'sectors';
                $q = $wpdb->prepare("SELECT * from $wp_sectors where id=%s", $row->sector_id);
                $result = $wpdb->get_row($q, ARRAY_A );
                
                
                echo $result['sector_name']; ?></td>
                <td class="manage-column ss-list-width"><?php echo $row->email; ?></td>
                <td class="manage-column ss-list-width"><?php echo $row->contact_no; ?></td>
                <td class="manage-column ss-list-width"><?php echo $row->address; ?></td>
                <td>
                    <a href="<?php echo admin_url('admin.php?page=custom_contact_update&id=' . $row->id); ?>">Update</a>
                    <a href="<?php echo admin_url('admin.php?page=custom_contact_delete&id=' . $row->id); ?>">Delete</a>
                </td>

            </tr>
        <?php } ?>
    </table>
</div>
<?php
}