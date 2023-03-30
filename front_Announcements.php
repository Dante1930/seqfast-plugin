<?php 
function display_announcements() {
    global $wpdb;
    $table_name = $wpdb->prefix . "announcements";

    $rows = $wpdb->get_results("SELECT * from $table_name");
    ob_start();

    function isexternal($url) {
       
        // die(print_r($components));
        $homeurl = site_url();
        // die(print_r($homeurl));
        $url_host = parse_url($url, PHP_URL_HOST);
        $base_url_host = parse_url(site_url(), PHP_URL_HOST);

        //die($base_url_host);
         
        if($url_host == $base_url_host || empty($url_host))
        {
          // internal link ...
          return false;
        }
        else
        {
          // external link ...
          return true;
        }
      }
?>
<div class="whats_new_action">
<input type="button" class="stop_mrq" value="" onClick="document.getElementById('whatsNew').stop();"/>
<input type="button" class="start_mrq"value="" onClick="document.getElementById('whatsNew').start();"/>
</div>
<marquee id="whatsNew" class="whats_new_scroll" direction="up" scrollamount="3" >
<ul>
    <?php 
    foreach ($rows as $row) { 
        if(!empty($row->announcement_url)){
        
            if(isexternal($row->announcement_url)){
                $class = "external_link";
            }else{
                $class = "";
            }
            
            if($class !== ""){ ?>
                <li><a class="<?php echo $class; ?>" href="<?php echo $row->announcement_url; ?>"><?php echo $row->announcement_text; ?></a></li>
            <?php }else{ ?>
                <li><a class="<?php echo $class; ?>" href="javascript:gourl('<?php echo $row->announcement_url; ?>')"><?php echo $row->announcement_text; ?></a></li>
            <?php
            }
        }else{
            ?>
            <li><?php echo $row->announcement_text; ?></li>
        <?php
        }

        ?>
        

    <?php } ?>	
</ul>
</marquee>
<script>
    function gourl(url){
        window.open(url, "_blank");
    }
</script>
<?php
return ob_get_clean();
}


add_shortcode( 'custom-announcements', 'display_announcements' );
