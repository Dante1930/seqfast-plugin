<?php
function custom_skill_sectorCouncil() {
?>
<div class="wrap">
        <h2 class="wp-heading-inline">Skill Sectors</h2>
        <div class="tablenav top">
             <a class="page-title-action" href="<?php $url= admin_url('admin.php?page=custom_skill_sector_create');  echo $url;  ?>">Add New</a>
            
        </div>
        
        <table class='wp-list-table widefat fixed striped table-view-list posts'>
            <tr>
                <th class="manage-column column-primary">S NO</th>
                <th class="manage-column ">Skill Sector Name</th>
                <th class="manage-column ">Image Url</th>
                <th class="manage-column ">External Url</th>
                <th class="manage-column ">Action</th>
            </tr>
            <?php
        global $wpdb;
        $table_name = $wpdb->prefix . "sectors";

        $rows = $wpdb->get_results("SELECT * from $table_name");
        $attachment = '';
        $count = 0;
        ?>
        <?php foreach ($rows as $row) { ?>
                <tr>
                    <td class="manage-column ss-list-width"><?php echo ++$count; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->sector_name; ?></td>
                    <?php

                    // if($row->announcement_url !== null){
                    //   $attachment = $row->announcement_url;
                    // }
                    ?>
                    <td class="manage-column ss-list-width"><?php 

                        $attachment =  $row->image_url;
                    
                    
                    echo $attachment; ?></td>
                    <td class="manage-column ss-list-width"><?php echo $row->external_url; ?></td>
                    <td>
                        <a href="<?php echo admin_url('admin.php?page=custom_skill_sector_update&id=' . $row->id); ?>">Update</a>
                        <a href="<?php echo admin_url('admin.php?page=custom_skill_sector_delete&id=' . $row->id); ?>">Delete</a>
                    </td>

                </tr>
            <?php } ?>
        </table>
</div>
<?php
}