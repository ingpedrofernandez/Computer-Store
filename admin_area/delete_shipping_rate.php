<?php

session_start();

include("includes/db.php");

if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login.php','_self')</script>";

}else{
	
if(isset($_POST["delete_id"])){	

$delete_id = $_POST['delete_id'];

$type_id = $_POST['type_id'];

$delete_shipping_rate = "delete from shipping where shipping_id='$delete_id' and shipping_type='$type_id'";

$run_shipping_rate = mysqli_query($con,$delete_shipping_rate);

}

}

?>