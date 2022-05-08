<?php
//echo "update page";
function vendor_update(){
    //echo "update page in";
    $i=$_GET['id'];
    global $wpdb;
    $table_name = $wpdb->prefix . 'vendors';
    $vendors = $wpdb->get_results("SELECT id,name,officeAddress,contact,niche from $table_name where id=$i");
    echo $vendors[0]->id;
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
            <input type="hidden" name="id" value="<?= $vendors[0]->id; ?>">
            <tr>
                <td>Name:</td>
                <td><input type="text" name="nm" value="<?= $vendors[0]->name; ?>"></td>
            </tr>
            <tr>
                <td>Address:</td>
                <td><input type="text" name="adrs" value="<?= $vendors[0]->officeAddress; ?>"></td>
            </tr>
            <tr>
                <td>Niche:</td>
                <td><select name="des">
                        <option value="Marketing" <?php if($vendors[0]->niche=="Marketing"){echo "selected";} ?> >Marketing</option>
                        <option value="Design" <?php if($vendors[0]->niche=="Design"){echo "selected";} ?> >Design</option>
                        <option value="Programming and Tech" <?php if($vendors[0]->niche=="Programming and Tech"){echo "selected";} ?> >Programming and Tech</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Mob no:</td>
                <td><input type="number" name="mob" value="<?= $vendors[0]->contact; ?>"></td>
            </tr>
            <tr>
                <td></td>
                <td><input type="submit" value="Update" name="upd"></td>
            </tr>
        </form>
        </tbody>
    </table>
    <?php
}
if(isset($_POST['upd']))
{
    global $wpdb;
    $table_name=$wpdb->prefix.'vendors';
    $id=$_POST['id'];
    $nm=$_POST['nm'];
    $ad=$_POST['adrs'];
    $d=$_POST['des'];
    $m=$_POST['mob'];
    $wpdb->update(
        $table_name,
        array(
            'name'=>$nm,
            'officeAddress'=>$ad,
            'niche'=>$d,
            'contact'=>$m
        ),
        array(
            'id'=>$id
        )
    );

    ?>
    <meta http-equiv="refresh" content="1; url=<?php echo admin_url('admin.php?page=Vendors_Listing'); ?>" />
    <?php
}
?>
