<?php

if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login.php','_self')</script>";

}

else {


?>

<?php

if(isset($_GET['delete_shipping_type'])){

$delete_id = $_GET['delete_shipping_type'];

$delete_shipping_type = "delete from shipping_type where type_id='$delete_id'";

$run_shipping_type = mysqli_query($con,$delete_shipping_type);

if($run_shipping_type){
	
$delete_shipping = "delete from shipping where shipping_type='$delete_id'";

$run_shipping = mysqli_query($con,$delete_shipping);	

echo "<script>alert('Your One Shipping Type Has Been Deleted.')</script>";

echo "<script>window.open('index.php?view_shipping_types','_self')</script>";

}

}

?>

<?php } ?>