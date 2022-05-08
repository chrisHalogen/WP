<?php

function vendor_insert()
{
    //echo "insert page";
    ?>
<table>
    <thead>
    <tr>
        <th></th>
        <th></th>
    </tr>
    </thead>
    <tbody>
    <form name="frm" action="#" method="post">
    <tr>
        <td>Name:</td>
        <td><input type="text" name="nm"></td>
    </tr>
    <tr>
        <td>Office Address:</td>
        <td><input type="text" name="adrs"></td>
    </tr>
    <tr>
        <td>Niche:</td>
        <td><select name="niche">
                <option value="Marketing">Marketing</option>
                <option value="Design">Design</option>
                <option value="Programming and Tech">Programming and Tech</option>
            </select>
        </td>
    </tr>
    <tr>
        <td>Mob no:</td>
        <td><input type="number" name="mob"></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" value="Insert" name="ins"></td>
    </tr>
    </form>
    </tbody>
</table>
<?php
    if(isset($_POST['ins'])){
        global $wpdb;
        $nm=$_POST['nm'];
        $ad=$_POST['adrs'];
        $d=$_POST['niche'];
        $m=$_POST['mob'];
        $table_name = $wpdb->prefix . 'vendors';

        $wpdb->insert(
            $table_name,
            array(
                'name' => $nm,
                'officeAddress' => $ad,
                'niche' => $d,
                'contact'=>$m
            )
        );
        echo "inserted\n";
        ?>
        <a href="<?php echo admin_url('admin.php?page=Vendors_Listing'); ?>">Click Here to View All Vendors</a>
        <?php

        exit;
    }
}

?>
