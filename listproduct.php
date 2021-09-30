<!DOCTYPE html>
<html lang="en">

<?php require 'include/header.php';?>
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
                                <li class="breadcrumb-item"><a href="#">List Product</a></li>
                               
                            </ol>
                        </div>
                    </div>
					
					<div class="col-md-4 col-lg-4">
                        <div class="widgetbar">
                            <a href="addproduct.php"><button class="btn btn-primary-rgba"><i class="feather icon-plus mr-2"></i>Add Product</button></a>
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
                                
                                <div class="table-responsive">
                                    <div id="default-datatable_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4"><div class="row">
									<div class="col-sm-12 col-md-12">
									<div class="row">
									<div class="col-sm-12">
									<table id="data" class="display table  table-bordered dataTable dtr-inline" role="grid" aria-describedby="default-datatable_info">
                                        <thead>
                                            <tr>
											<th>Sr No </th>
											<th>Product Title(Discount)</th>
											<th>Product Image</th>
											<th>Product City</th>
											<th>Product Category</th>
											<th>Product Subcategory</th>
											
											<th>Product Variation</th>
											
											<th>Product Price</th>
											<th>Product Subcription Price</th>
											
												<th>Product Status</th>
												<th>Action</th>
									</tr>
                                        </thead>
                                        <tbody>
										<?php 
											
											 $stmt = $mysqli->query("SELECT * FROM `tbl_product`");
$i = 0;
while($row = $stmt->fetch_assoc())
{
	$i = $i + 1;
											?>
                                                <tr>
                                                <td>
                                                    <?php echo $i; ?>
                                                </td>
												<td> <?php echo $row['ptitle'].'('.$row['pdisc'].' % )'; ?></td>
                                                
                                                <td class="align-middle">
                                                   <img src="<?php echo $row['pimg']; ?>" width="60" height="60"/>
                                                </td>
												
												<td class="align-middle">
                                                  <?php 
												  $city = $mysqli->query("select * from tbl_city where id=".$row['cityid']."")->fetch_assoc();
												  echo $city['title'];
												  ?>
                                                </td>
												
												<td class="align-middle">
                                                  <?php 
												  $city = $mysqli->query("select * from tbl_cat where id=".$row['catid']."")->fetch_assoc();
												  echo $city['title'];
												  ?>
                                                </td>
												
												<td class="align-middle">
                                                  <?php 
												  $city = $mysqli->query("select * from tbl_subcat where id=".$row['subcatid']."")->fetch_assoc();
												  echo $city['title'];
												  ?>
                                                </td>
                                                
                                               <td> <?php echo $row['pvariation']; ?></td>
											   <td> <?php echo $row['price']; ?></td>
											   <td> <?php echo $row['sprice']; ?></td>
												<?php if($row['status'] == 1) { ?>
                                                <td><div class="badge badge-success">Publish</div></td>
												<?php } else { ?>
												<td><div class="badge badge-danger">Unpublish</div></td>
												<?php } ?>
                                                <td style="min-width: 100px;"><a href="addproduct.php?productid=<?php echo $row['id']; ?>" class="btn btn-info"><i class="fa fa-edit" ></i></a>
												<a href="?did=<?php echo $row['id']; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
												</td>
                                                </tr>
<?php } ?> 
                                            </tbody>
                                        
                                    </table></div></div>
                                </div>
                            </div>
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
	<script>
	$("#data").dataTable();
	</script>
	
	<?php 
if(isset($_GET['did']))
{
	$id = $_GET['did'];

$table="tbl_product";
$where = "where id=".$id."";
$h = new Milkman();
	$check = $h->Ins_milk_deldata($where,$table);

if($check == 1)
{
?>
<script src="assets/modules/izitoast/js/iziToast.min.js"></script>
 <script>
 iziToast.error({
    title: 'Product Section!!',
    message: 'Product Delete Successfully!!',
    position: 'topRight'
  });
  </script>
  
<?php 
}
?>
<script>
setTimeout(function(){ window.location.href="listproduct.php";}, 3000);
</script>
<?php 
}
?>
    <!-- End js -->
</body>


</html>