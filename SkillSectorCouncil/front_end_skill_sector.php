<?php 


function display_sector_contacts(){

    global $wpdb;
    $table_name = $wpdb->prefix . "sectors";

    $rows = $wpdb->get_results("SELECT * from $table_name");
    ob_start();



if(!empty($rows)):
    foreach ($rows as $row):
?>
        <div class="ssc">
            <a class="external_link" href="<?php echo $row->external_url; ?>">
                <img class="img-fluid " alt="<?php echo $row->sector_name; ?>" title="<?php echo $row->sector_name; ?>" src="<?php echo $row->image_url; ?>"/>
            </a>
            <h3 class="ssc-heading"><?php echo $row->sector_name; ?></h3>
            <div class="ssc_action">
                <a class="visit-btn external_link" href="<?php echo $row->external_url; ?>" >Visit</a>
                <button type="button" class="contact-btn contact_sector_data" data-id="<?php echo $row->id;?>" id="sector_<?php echo $row->id;?>">Contact</button>
            </div>
        </div>
<?php
    endforeach;
endif;
?>
<div id="sector_contact" style="display: none;" class="modal ssc-modal hide fade in" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Contact Details</h5>
            </div>
            <div class="modal-body">
                <div class="sectorTableContact"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary CloseContact">Close</button>
            </div>
        </div>
    </div>
</div>



<?php


return ob_get_clean();
}

add_shortcode( 'custom-sector-contacts', 'display_sector_contacts' );
?>
