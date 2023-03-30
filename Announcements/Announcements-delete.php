<?php 

function custom_plugin_annoucncements_delete(){

    global $wpdb;
    $table_name = $wpdb->prefix . "announcements";
    $id = $_GET["id"];

    if (isset($_POST['delete'])) {

        $wpdb->query($wpdb->prepare("DELETE FROM $table_name WHERE id = %s", $id));
    }
    else{
       $announcements = $wpdb->get_results($wpdb->prepare("SELECT * from $table_name where id=%s", $id));
        foreach ($announcements as $s) {
            $announcement_text	 = $s->announcement_text;
            $announcement_url	 = $s->announcement_url;
        }
    }


?>
    <link type="text/css" href="<?php echo WP_PLUGIN_URL; ?>/sinetiks-schools/style-admin.css" rel="stylesheet" />
    <div class="wrap">
    <form method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data">
    <?php if (isset($_POST['delete'])) { ?>
            <div class="updated"><p>Announcement deleted</p></div>
            <a href="<?php echo admin_url('admin.php?page=custom_plugin_Announcements') ?>">&laquo; Back to Announcements list</a>
    <?php } else { ?>
    <h2>Delete Announcement </h2>
    <table class='wp-list-table form-table'>
                    <tr>
                        <th class="title">Announcement Text</th>
                        <td><?php echo  $announcement_text; ?></td>
                    </tr>
                    <tr>
                        <th class="title">Announcement Url</th>
                        <td><?php echo  $announcement_url; ?></td>
                    </tr>
                </table>
                <input type='submit' name="delete" value='Delete' class='button'>
                <a class='button' href="<?php echo admin_url('admin.php?page=custom_plugin_Announcements'); ?>">No</a>
            </form>
    <?php } ?>
    </div>
<?php 
}