<?php
//echo "vendor delete";
function vendor_delete(){
    echo "vendor delete\n";
    if(isset($_GET['id'])){
        global $wpdb;
        $table_name=$wpdb->prefix.'vendors';
        $i=$_GET['id'];
        $wpdb->delete(
            $table_name,
            array('id'=>$i)
        );
        echo "deleted";
    }

    ?>
    <meta http-equiv="refresh" content="1; url=<?php echo admin_url('admin.php?page=Vendors_Listing'); ?>" />
    <?php

}
?>
