<?php

if(!isset($_SESSION['admin_email'])){

echo "<script>window.open('login.php','_self')</script>";

}

else {
	
$admin_email = $_SESSION['admin_email'];

$select_admin = "select * from admins where admin_email='$admin_email'";

$run_admin = mysqli_query($con,$select_admin);

$row_admin = mysqli_fetch_array($run_admin);

$admin_id = $row_admin['admin_id'];

?>

<link rel="stylesheet" href="css/chosen.min.css">

<div class="row"><!-- 1 row Starts -->

<div class="col-lg-12"><!-- col-lg-12 Starts -->

<ol class="breadcrumb"><!-- breadcrumb Starts -->

<li class="active">

<i class="fa fa-dashboard"></i> Dashboard / Insert Shipping Zone

</li>

</ol><!-- breadcrumb Ends -->

</div><!-- col-lg-12 Ends -->

</div><!-- 1 row Ends -->

<div class="row"><!-- 2 row Starts -->

<div class="col-lg-12"><!-- col-lg-12 Starts -->

<div class="panel panel-default"><!-- panel panel-default Starts -->

<div class="panel-heading"><!-- panel-heading Starts -->

<h3 class="panel-title"><!-- panel-title Starts -->

<i class="fa fa-money fa-fw"> </i> Insert Shipping Zone

</h3><!-- panel-title Ends -->

</div><!-- panel-heading Ends -->

<div class="panel-body"><!-- panel-body Starts -->

<form class="form-horizontal" action="" method="post" enctype="multipart/form-data"><!-- form-horizontal Starts -->

<div class="form-group"><!-- form-group Starts -->

<label class="col-md-3 control-label"> Zone Name </label>

<div class="col-md-7">

<input type="text" name="zone_name" class="form-control" >

</div>

</div><!-- form-group Ends -->

<div class="form-group"><!-- form-group Starts -->

<label class="col-md-3 control-label"> Zone Regions </label>

<div class="col-md-7">

<select data-placeholder="Select Zone Regions" name="zone_countries[]" class="form-control chosen-select" multiple>

<?php

$get_countries = "select * from countries";

$run_countries = mysqli_query($con,$get_countries);

while($row_countries = mysqli_fetch_array($run_countries)) {

$country_id = $row_countries['country_id'];

$country_name = $row_countries['country_name'];

echo "<option value='$country_id'>$country_name</option>";

}

?>

</select>

</div>

</div><!-- form-group Ends -->

<div class="form-group"><!-- form-group Starts -->

<label class="col-md-3 control-label"> Limit To Specific ZIP/Postcodes </label>

<div class="col-md-7">

<textarea name="zone_post_codes" class="form-control" placeholder="List 1 Postcode Per Line" rows="5"></textarea>

</div>

</div><!-- form-group Ends -->

<div class="form-group"><!-- form-group Starts -->

<label class="col-md-3 control-label"> </label>

<div class="col-md-7">

<input type="submit" name="submit" class="form-control btn btn-primary" value="Insert Shipping Zone" >

</div>

</div><!-- form-group Ends -->

</form><!-- form-horizontal Ends -->

</div><!-- panel-body Ends -->

</div><!-- panel panel-default Ends -->

</div><!-- col-lg-12 Ends -->

</div><!-- 2 row Ends -->

<script src="js/jquery.min.js"></script>

<script src="js/chosen.jquery.min.js"></script>

<script>

$(".chosen-select").chosen();

</script>

<?php

if(isset($_POST['submit'])){

$zone_name = mysqli_real_escape_string($con,$_POST['zone_name']);

$get_zone_order = "select max(zone_order) AS zone_order from zones";

$run_zone_order = mysqli_query($con,$get_zone_order);

$row_zone_order = mysqli_fetch_array($run_zone_order);

$zone_order = $row_zone_order['zone_order'] + 1;

$zone_countries = $_POST['zone_countries'];

$insert_zone = "insert into zones (vendor_id,zone_name,zone_order) values ('admin_$admin_id','$zone_name','$zone_order')";

$run_zone = mysqli_query($con,$insert_zone);

$last_zone_id = mysqli_insert_id($con);

foreach($zone_countries as $country){
	
$country_code = mysqli_real_escape_string($con,$country);	

$insert_zone_location = "insert into zones_locations (zone_id,location_code,location_type) values ('$last_zone_id','$country_code','country')";
	
$run_zone_location = mysqli_query($con,$insert_zone_location);
        
}

if(!empty($_POST['zone_post_codes'])){

if(strpos($_POST['zone_post_codes'], "\n")){
	
$post_codes = explode("\n", $_POST['zone_post_codes']);

}else{ 

$post_codes = array($_POST['zone_post_codes']); 

}

foreach($post_codes as $post_code){
	
  $location_code = mysqli_real_escape_string($con,trim($post_code));	
	
  $insert_zone_location = "insert into zones_locations (zone_id,location_code,location_type) values ('$last_zone_id','$location_code','postcode')";
	
  $run_zone_location = mysqli_query($con,$insert_zone_location);

}

}

if($run_zone){

echo "<script>alert('New Shipping Zone Has Been Inserted.')</script>";

echo "<script>window.open('index.php?view_shipping_zones','_self')</script>";

}

}

?>

<?php } ?>