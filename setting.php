<!DOCTYPE html>
<html lang="en">

<?php require 'include/header.php';
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
?>
<body class="vertical-layout">    
    <!-- Start Infobar Setting Sidebar -->
    
    <div class="infobar-settings-sidebar-overlay"></div>
    <!-- End Infobar Setting Sidebar -->
    <!-- Start Containerbar -->
    <div id="containerbar">
        <!-- Start Leftbar -->
       <?php require 'include/sidebar.php';?>
        <!-- End Leftbar -->
        <!-- Start Rightbar -->
        <div class="rightbar">
            <!-- Start Topbar Mobile -->
            
            <!-- Start Topbar -->
            <?php require 'include/navbar.php';?>
            <!-- End Topbar -->
            <!-- Start Breadcrumbbar -->                    
            <div class="breadcrumbbar">
                <div class="row align-items-center">
                    <div class="col-md-8 col-lg-8">
                        <h4 class="page-title"><?php echo $set['d_title'];?></h4>
                        <div class="breadcrumb-list">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="dashboard.php">Home</a></li>
                                <li class="breadcrumb-item"><a href="#">Update Setting</a></li>
                               
                            </ol>
                        </div>
                    </div>
                   
                </div>          
            </div>
            <!-- End Breadcrumbbar -->
            <!-- Start Contentbar -->    
            <div class="contentbar">              
                <div class="row">
				<div class="col-lg-12">
                        <div class="card m-b-30">
                           
                            <div class="card-body">
                                
                                <form method="POST" enctype="multipart/form-data">
                                    <div class="row">
									<div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                                        <div class="form-group">
                                            <label>Website Title</label>
                                            <input type="text" class="form-control" name="dname" required="" value="<?php echo $set['d_title']; ?>">
                                        </div>
										</div>
										
										<div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
										<?php 
								$tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
								$limit =  count($tzlist);
								?>
								<div class="form-group">
									<label for="cname">Select Timezone</label>
									<select name="timezone" class="form-control" required>
									<option value="">Select Timezone</option>
									<?php 
									for($k=0;$k<$limit;$k++)
									{
									?>
									<option <?php echo $tzlist[$k];?> <?php if($tzlist[$k] == $set['timezone']) {echo 'selected';}?>><?php echo $tzlist[$k];?></option>
									<?php } ?>
									</select>
								</div>
								</div>
										
										<div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                                        <div class="form-group">
                                            <label>User App Onesignal App Id</label>
                                            <input type="text" class="form-control" name="okey" value="<?php echo $set['one_key']; ?>" required>
                                        </div>
										</div>
										<div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                                        <div class="form-group ">
                                            <label>User Boy App Onesignal Rest Api Key</label>
                                            <input type="text" class="form-control" name="ohash" value="<?php echo $set['one_hash']; ?>" required>
                                        </div>
										</div>
										<div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                                        <div class="form-group">
                                            <label>Delivery Boy App Onesignal App Id</label>
                                            <input type="text" class="form-control" name="r_key" value="<?php echo $set['r_key']; ?>" required>
                                        </div>
										</div>
										<div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                                        <div class="form-group ">
                                            <label>Delivery Boy Onesignal Rest Api Key</label>
                                            <input type="text" class="form-control" name="r_hash" value="<?php echo $set['r_hash']; ?>" required>
                                        </div>
										</div>
										
										<div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                                        <div class="form-group">
                                            <label>Sign Up Credit</label>
                                            <input type="number" class="form-control" name="signupcredit" value="<?php echo $set['signupcredit']; ?>" required>
                                        </div>
										</div>
										<div class="col-md-6 col-xs-12 col-sm-12 col-lg-6">
                                        <div class="form-group ">
                                            <label>Refer Credit</label>
                                            <input type="number" class="form-control" name="refercredit" value="<?php echo $set['refercredit']; ?>" required>
                                        </div>
										</div>
										
										<div class="col-md-3 col-xs-12 col-sm-12 col-lg-3">
										<div class="form-group ">
                                            <label>Set Currency</label>
                                            <input type="text" class="form-control" name="currency" value="<?php echo $set['currency']; ?>" required>
                                        </div>
										</div>
										<div class="col-md-3 col-xs-12 col-sm-12 col-lg-3">
										<div class="form-group">
                                            <label>Website Logo/Favicon</label>
                                            <input type="file" class="form-control" name="llogo">
											<br>
											<img src="<?php echo $set['logo']; ?>" width="100%" height="100"/>
											
                                        </div>
										</div>
										
										<div class="col-md-3 col-xs-12 col-sm-12 col-lg-3">
										<div class="form-group">
                                            <label>Website Short Logo</label>
                                            <input type="file" class="form-control" name="pdbanner">
											<br>
											<img src="<?php echo $set['pdbanner']; ?>" width="60" height="60"/>
											
                                        </div>
										</div>
										<div class="col-md-3 col-xs-12 col-sm-12 col-lg-3">
										<div class="form-group ">
                                            <label>Set Payout Limit</label>
                                            <input type="text" class="form-control" name="p_limit" required value="<?php echo $set['p_limit']; ?>">
                                        </div>
										</div>
								
								
										
								
								<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
										<div class="form-group">
                                            <label>Privacy Policy</label>
                                            <textarea class="form-control" id="policy" name="policy"><?php echo $set['policy'];?></textarea>
											
                                        </div>
										</div>
										
										<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
										<div class="form-group">
                                            <label>About Us</label>
                                            <textarea class="form-control" id="about" name="about"><?php echo $set['about'];?></textarea>
											
                                        </div>
										</div>
										
										<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
										<div class="form-group">
                                            <label>Contact Us</label>
                                            <textarea class="form-control" id="contact" name="contact"><?php echo $set['contact'];?></textarea>
											
                                        </div>
										</div>
										
										<div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
										<div class="form-group">
                                            <label>Terms & Conditions</label>
                                            <textarea class="form-control" id="terms" name="terms"><?php echo $set['terms'];?></textarea>
											
                                        </div>
										</div>
										
										<div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
										<div class="form-group">
                                            <label>Twilio ACCOUNT SID</label>
                                            <input type="text" class="form-control" name="asid" required value="<?php echo $set['asid']; ?>">
											
                                        </div>
										</div>
										
										<div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
										<div class="form-group">
                                            <label>Twilio AUTH TOKEN</label>
                                           <input type="text" class="form-control" name="token" required value="<?php echo $set['token']; ?>">
											
                                        </div>
										</div>
										
										<div class="col-md-4 col-xs-12 col-sm-12 col-lg-4">
										<div class="form-group">
                                            <label>Twilio Number</label>
                                           <input type="text" class="form-control" name="megic_Num" required value="<?php echo $set['megic_Num']; ?>">
											
                                        </div>
										</div>
										
										
                                    </div>
									
                                   
                                    <button type="submit" class="btn btn-primary" name="usetting">Update Setting</button>
                                </form>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
            <!-- End Contentbar -->
            <!-- Start Footerbar -->
           
            <!-- End Footerbar -->
        </div>
        <!-- End Rightbar -->
    </div>
    <!-- End Containerbar -->
    <!-- Start js -->        
    <?php require 'include/milklife.php';?>
	
	<?php 
		if(isset($_POST['usetting']))
		{
			$dname = $_POST['dname'];
			
			$okey = $_POST['okey'];
			$ohash = $_POST['ohash'];
			$r_key = $_POST['r_key'];
			$r_hash = $_POST['r_hash'];
			$signupcredit = $_POST['signupcredit'];
			$refercredit = $_POST['refercredit'];
			$asid = $_POST['asid'];
			$megic_Num = $_POST['megic_Num'];
			$token = $_POST['token'];
			$currency = $mysqli -> real_escape_string($_POST['currency']);
			$policy = $mysqli -> real_escape_string($_POST['policy']);
			$about = $mysqli -> real_escape_string($_POST['about']);
			$contact = $mysqli -> real_escape_string($_POST['contact']);
			$terms = $mysqli -> real_escape_string($_POST['terms']);
			$timezone = $mysqli -> real_escape_string($_POST['timezone']);
			$p_limit = $_POST['p_limit'];
			$id = 1;
			if($_FILES["llogo"]["name"] == '' and $_FILES["pdbanner"]["name"] == '')
			{
				$table="setting";
  $field = array('asid'=>$asid,'megic_Num'=>$megic_Num,'token'=>$token,'signupcredit'=>$signupcredit,'refercredit'=>$refercredit,'d_title'=>$dname,'one_key'=>$okey,'one_hash'=>$ohash,'r_key'=>$r_key,'r_hash'=>$r_hash,'currency'=>$currency,'policy'=>$policy,'about'=>$about,'contact'=>$contact,'terms'=>$terms,'timezone'=>$timezone,'p_limit'=>$p_limit);
  $where = "where id=".$id."";
$h = new Milkman();
	  $check = $h->Ins_milk_updata($field,$table,$where);
	  
if($check == 1)
{
?>
<script src="assets/izitoast/js/iziToast.min.js"></script>
 <script>
 iziToast.success({
    title: 'Setting Section!!',
    message: 'Setting Update Successfully!!',
    position: 'topRight'
  });
  </script>
  
<?php 
}

				
?>
<script>
setTimeout(function(){ window.location.href="setting.php";}, 3000);
</script>
<?php 
			}
			else if($_FILES["llogo"]["name"] == '' and $_FILES["pdbanner"]["name"] != '')
			{
				
				$target_dir = "setting/";
$target_file = $target_dir . basename($_FILES["pdbanner"]["name"]);
			
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   
				move_uploaded_file($_FILES["pdbanner"]["tmp_name"], $target_file);
				$table="setting";
  $field = array('asid'=>$asid,'megic_Num'=>$megic_Num,'token'=>$token,'signupcredit'=>$signupcredit,'refercredit'=>$refercredit,'d_title'=>$dname,'one_key'=>$okey,'one_hash'=>$ohash,'r_key'=>$r_key,'r_hash'=>$r_hash,'currency'=>$currency,'pdbanner'=>$target_file,'policy'=>$policy,'about'=>$about,'contact'=>$contact,'terms'=>$terms,'timezone'=>$timezone,'p_limit'=>$p_limit);
  $where = "where id=".$id."";
$h = new Milkman();
	  $check = $h->Ins_milk_updata($field,$table,$where);
	  
if($check == 1)
{
?>
<script src="assets/izitoast/js/iziToast.min.js"></script>
 <script>
 iziToast.success({
    title: 'Setting Section!!',
    message: 'Setting Update Successfully!!',
    position: 'topRight'
  });
  </script>
<?php 
}


?>
<script>
setTimeout(function(){ window.location.href="setting.php";}, 3000);
</script>
<?php
			
			}
			else if($_FILES["llogo"]["name"] != '' and $_FILES["pdbanner"]["name"] == '')
			{
				$target_dir = "setting/";
$target_file = $target_dir . basename($_FILES["llogo"]["name"]);
			
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   
				move_uploaded_file($_FILES["llogo"]["tmp_name"], $target_file);
				$table="setting";
  $field = array('asid'=>$asid,'megic_Num'=>$megic_Num,'token'=>$token,'signupcredit'=>$signupcredit,'refercredit'=>$refercredit,'d_title'=>$dname,'one_key'=>$okey,'one_hash'=>$ohash,'r_key'=>$r_key,'r_hash'=>$r_hash,'currency'=>$currency,'logo'=>$target_file,'policy'=>$policy,'about'=>$about,'contact'=>$contact,'terms'=>$terms,'timezone'=>$timezone,'p_limit'=>$p_limit);
  $where = "where id=".$id."";
$h = new Milkman();
	  $check = $h->Ins_milk_updata($field,$table,$where);
	  
if($check == 1)
{
?>
<script src="assets/izitoast/js/iziToast.min.js"></script>
 <script>
 iziToast.success({
    title: 'Setting Section!!',
    message: 'Setting Update Successfully!!',
    position: 'topRight'
  });
  </script>
<?php 
}


?>
<script>
setTimeout(function(){ window.location.href="setting.php";}, 3000);
</script>
<?php
			
			

		}
		else 
		{
		$target_dir = "setting/";
$target_file = $target_dir . basename($_FILES["llogo"]["name"]);
			
			$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
   
				move_uploaded_file($_FILES["llogo"]["tmp_name"], $target_file);
				
				$target_files = $target_dir . basename($_FILES["pdbanner"]["name"]);
			
			$imageFileType = strtolower(pathinfo($target_files,PATHINFO_EXTENSION));
   
				move_uploaded_file($_FILES["pdbanner"]["tmp_name"], $target_files);
				
				$table="setting";
  $field = array('asid'=>$asid,'megic_Num'=>$megic_Num,'token'=>$token,'signupcredit'=>$signupcredit,'refercredit'=>$refercredit,'d_title'=>$dname,'one_key'=>$okey,'one_hash'=>$ohash,'r_key'=>$r_key,'r_hash'=>$r_hash,'currency'=>$currency,'logo'=>$target_file,'pdbanner'=>$target_files,'policy'=>$policy,'about'=>$about,'contact'=>$contact,'terms'=>$terms,'timezone'=>$timezone,'p_limit'=>$p_limit);
  $where = "where id=".$id."";
$h = new Milkman();
	  $check = $h->Ins_milk_updata($field,$table,$where);
	  
if($check == 1)
{
?>
<script src="assets/izitoast/js/iziToast.min.js"></script>
 <script>
 iziToast.success({
    title: 'Setting Section!!',
    message: 'Setting Update Successfully!!',
    position: 'topRight'
  });
  </script>
<?php 
}


?>
<script>
setTimeout(function(){ window.location.href="setting.php";}, 3000);
</script>
<?php	
		}
		}
		?>
    <!-- End js -->
	<script type="text/javascript">

function validate(evt) {
  var theEvent = evt || window.event;

  // Handle paste
  if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
  } else {
  // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]/;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}

$(document).ready(function() {
	$('#policy').summernote({
		height: "500px",
		toolbar: [
    // [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']]
  ]
	});
	
	$('#about').summernote({
		height: "500px",
		toolbar: [
    // [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']]
  ]
	});
	
	$('#terms').summernote({
		height: "500px",
		toolbar: [
    // [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']]
  ]
	});
	
	$('#contact').summernote({
		height: "500px",
		toolbar: [
    // [groupName, [list of button]]
    ['style', ['bold', 'italic', 'underline', 'clear']],
    ['font', ['strikethrough', 'superscript', 'subscript']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['height', ['height']]
  ]
	});
	
});
var postForm = function() {
	 $('textarea[name="policy"]').html($('#policy').code());
	  $('textarea[name="about"]').html($('#about').code());
	   $('textarea[name="contact"]').html($('#contact').code());
	    $('textarea[name="terms"]').html($('#terms').code());
}
</script>
</body>


</html>