<?php
/*$memcache = new Memcache(); // instantiating memcache extension class
$memcache->connect("localhost",11211);

echo "Server's version: " . $memcache->getVersion() . "<br />\n";*/



$keywords = '4';
?>
<?=($keywords)?>
<?php
/*$err_msg = '';
$err_msg = "<li>Could not update track clip. Missing Clip ID.</li>";
$err_msg .= '<li>Please enter valid clip title.</li>';
$err_msg .= '<li>Please enter a valid clip number.</li>';
$err_msg .= "Invalid Duration Format.";*/
//$err_msg = "<li>Could not update track clip. Missing Clip ID.</li><li>Please enter valid clip title.</li><li>Please enter a valid clip number.</li><li>Invalid Duration Format.</li>"
$err_msg = $_GET['error_msg'];
?>
<?=stripslashes($err_msg)?>


<?php echo "<br>";
$label_status = '';
echo $sql = 'UPDATE vendor SET status = ?, last_modified_by = ?' . ($label_status == 'signed' ? ', date_signed = NOW()' : '') . ' WHERE vendor_id = ?';
echo "<br>";
$params = array();
$vendor_id = 18183;
$params = array_fill(0,3,$vendor_id);
echo "<pre>";
var_dump($params);
