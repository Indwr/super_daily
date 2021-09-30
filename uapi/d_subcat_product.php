<?php 
require dirname( dirname(__FILE__) ).'/include/milkprams.php';

header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
$catid = $data['catid'];
$cityid = $data['cityid'];
$uid = $data['uid'];
if($uid == '' or $cityid == '' or $catid == '')
{
	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went wrong  try again !");
}
else 
{
	$coll = $mysqli->query("select * from tbl_subcat where cid=".$catid." and status=1");
$collection = array();
$pop = array();
while($row = $coll->fetch_assoc())
{
	$collection['id'] = $row['id'];
	$collection['title'] = $row['title'];
	$collection['image'] = $row['cimg'];
	$plist = $mysqli->query("select * from tbl_product where cityid=".$cityid." and subcatid=".$row['id']." and status=1");
	$products = array();
	$lp = array();
	while($rows = $plist->fetch_assoc())
	{
	$products['product_id'] = $rows['id'];
	$products['cityid'] = $rows['cityid'];
	$products['catid'] = $rows['catid'];
	$catname = $mysqli->query("select * from tbl_cat where id=".$rows['catid']."")->fetch_assoc();
	$products['catname']= $catname['title'];
	$products['subcatid'] = $rows['subcatid'];
	$products['product_discount'] = $rows['pdisc'];
	$products['product_variation'] = $rows['pvariation'];
	$products['product_regularprice'] = $rows['price'];
	$products['product_subscribeprice'] = $rows['sprice'];
	$products['product_title'] = $rows['ptitle'];
	$products['product_img'] = $rows['pimg'];
    $lp[] = $products;
	}
	$collection['productdata'] = $lp;
	$pop[] = $collection;
}
if(empty($pop))
	{
	    
		$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Subcategory Not Found!!","subcatproductlist"=>$pop);
	}
	else 
	{
	$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Subcategory List Get Successfully!!","subcatproductlist"=>$pop);
	}
}
echo json_encode($returnArr);
mysqli_close($mysqli);	


