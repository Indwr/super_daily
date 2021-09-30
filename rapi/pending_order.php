<?php 
require dirname( dirname(__FILE__) ).'/include/milkprams.php';
$data = json_decode(file_get_contents('php://input'), true);
if($data['rid'] == '')
{ 
 $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");    
}
else
{
 $rid =  strip_tags(mysqli_real_escape_string($mysqli,$data['rid']));
 $order_id =  strip_tags(mysqli_real_escape_string($mysqli,$data['order_id']));
 
  $sel = $mysqli->query("select * from tbl_normal_order where rid=".$rid." and id=".$order_id."  order by id desc");
  
  if($sel->num_rows != 0)
  {
  $result = array();
  $pp = array();
  while($row = $sel->fetch_assoc())
    {
		$pp['order_id'] = $row['id'];
		$pp['order_date'] = $row['odate'];
		$pname = $mysqli->query("select * from tbl_payment_list where id=".$row['p_method_id']."")->fetch_assoc();
		
		$pp['p_method_name'] = $pname['title'];
		$pp['customer_address'] = $row['address'];
		$pp['customer_name'] = $row['name'];
		$pp['customer_mobile'] = $row['mobile'];
		$pp['Delivery_charge'] = $row['d_charge'];
		$pp['Delivery_Timeslot'] = $row['tslot'];
		$pp['Coupon_Amount'] = $row['cou_amt'];
		$pp['Order_Total'] = $row['o_total'];
		$pp['Order_SubTotal'] = $row['subtotal'];
		$pp['Order_Transaction_id'] = $row['trans_id'];
		$pp['Additional_Note'] = $row['a_note'];
		$pp['Order_Status'] = $row['status'];
		$pp['Wallet_Amount'] = $row['wall_amt'];
		
		$fetchpro = $mysqli->query("select *  from tbl_normal_order_product where oid=".$row['id']."");
		$kop = array();
		$pdata = array();
		while($jpro = $fetchpro->fetch_assoc())
		{
			$kop['Product_quantity'] = $jpro['pquantity'];
			$kop['Product_name'] = $jpro['ptitle'];
			$kop['Product_discount'] = $jpro['pdiscount'];
			$kop['Product_image'] = $jpro['pimg'];
			$kop['Product_price'] = $jpro['pprice'];
			$kop['Product_variation'] = $jpro['ptype'];
			$discount = $jpro['pprice'] * $jpro['pdiscount']*$jpro['pquantity'] /100;
			
			$kop['Product_total'] = ($jpro['pprice'] * $jpro['pquantity']) - $discount;
			$pdata[] = $kop;
		}
		$pp['Order_Product_Data'] = $pdata;
		
	}
   
   
      
            
    $returnArr = array("order_data"=>$pp,"ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Order Get successfully!");
  }
  else 
  {
	$returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"No Pending Order Found!");   
  }
}
echo json_encode($returnArr);