<?php

function vendor_list() {
    ?>
    <style>
        table {
            border-collapse: collapse;


        }

        table, td, th {
            border: 1px solid black;
            padding: 20px;
            text-align: center;
        }
    </style>
    <div class="wrap">
        <table>
            <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Office Address</th>
                <th>Niche</th>
                <th>Contact</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
            </thead>
            <tbody>
            <?php
            global $wpdb;
            $table_name = $wpdb->prefix . 'vendors';
            $all_vendors = $wpdb->get_results("SELECT id,name,officeAddress,contact,niche from $table_name");
            foreach ($all_vendors as $current_vendor) {
                ?>
                <tr>
                    <td><?= $current_vendor->id; ?></td>
                    <td><?= $current_vendor->name; ?></td>
                    <td><?= $current_vendor->officeAddress; ?></td>
                    <td><?= $current_vendor->niche; ?></td>
                    <td><?= $current_vendor->contact; ?></td>
                    <td><a href="<?php echo admin_url('admin.php?page=Vendor_Update&id=' . $current_vendor->id); ?>">Update</a> </td>
                    <td><a href="<?php echo admin_url('admin.php?page=Vendor_Delete&id=' . $current_vendor->id); ?>"> Delete</a></td>
                </tr>
            <?php } ?>

            </tbody>
            <!-- <tbody>
            <tr>
                <td>1</td>
                <td>Hardik K. Vyas</td>
                <td>Php Developer</td>
                <td>+91 940894578</td>
            </tr>
            <tr>
                <td>2</td>
                <td>Mark M. Knight</td>
                <td>Blog Writer</td>
                <td>630-531-9601</td>
            </tr>
            <tr>
                <td>3</td>
                <td>Annie D. Naccarato</td>
                <td>Project Leader</td>
                <td>144-54-XXXX</td>
            </tr>
            <tr>
                <td>4</td>
                <td>Jayesh P. Patel</td>
                <td>Web Designer</td>
                <td>+91 98562315</td>
            </tr>
            <tr>
                <td>5</td>
                <td>Alvin B. Reddick</td>
                <td>ifone Developer</td>
                <td>619-11-XXXX</td>
            </tr>
            </tbody> -->
        </table>
    </div>
    <?php

}
add_shortcode('all_vendors_list', 'vendor_list');
?>
