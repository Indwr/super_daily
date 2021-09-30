 <?php 
require dirname( dirname(__FILE__) ).'/include/milkprams.php';
require dirname( dirname(__FILE__) ).'/include/Milkman.php';
header('Content-type: text/json');
$data = json_decode(file_get_contents('php://input'), true);
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
function siteURL() {
  $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || 
    $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
  $domainName = $_SERVER['HTTP_HOST'];
  return $protocol.$domainName;
}

if($data['uid'] == '')
{
 $returnArr = array("ResponseCode"=>"401","Result"=>"false","ResponseMsg"=>"Something Went Wrong!");    
}
else
{
	if($data['type'] == 'Normal')
	{
$uid =  $data['uid'];

$p_method_id = $data['p_method_id'];
$full_address = $data['full_address'];
$d_charge = number_format((float)$data['d_charge'], 2, '.', '');
$cou_id = $data['cou_id'];
$landmark = $data['landmark'];
$wall_amt = number_format((float)$data['wall_amt'], 2, '.', '');
$cou_amt = number_format((float)$data['cou_amt'], 2, '.', '');	
$sdate = explode('-',$data['ndate']);
$sdates = $sdate[2].'-'.$sdate[1].'-'.$sdate[0];
$tslot = $data['tslot'];
$transaction_id = $data['transaction_id'];
$product_total = number_format((float)$data['product_total'], 2, '.', '');
$product_subtotal = number_format((float)$data['product_subtotal'], 2, '.', '');
$a_note = mysqli_real_escape_string($mysqli,$data['a_note']);
$name = mysqli_real_escape_string($mysqli,$data['name']);
$mobile = mysqli_real_escape_string($mysqli,$data['mobile']);
$table="tbl_normal_order";
  $field_values=array("uid","odate","p_method_id","address","d_charge","cou_id","cou_amt","o_total","subtotal","trans_id","a_note","wall_amt","name","mobile","status","landmark","tslot");
  $data_values=array("$uid","$sdates","$p_method_id","$full_address","$d_charge","$cou_id","$cou_amt","$product_total","$product_subtotal","$transaction_id","$a_note","$wall_amt","$name","$mobile",'Pending',"$landmark","$tslot");
  
      $h = new Milkman();
	  $oid = $h->Ins_Milk_Api_id($field_values,$data_values,$table);
	  
	   $adata = $mysqli->query("select * from admin where id=1")->fetch_assoc();
	  $idp = $set['asid'];
$token = $set['token'];
$url = "https://api.twilio.com/2010-04-01/Accounts/$idp/SMS/Messages";
$from = $set['megic_Num'];
$to = $adata['mobile']; // twilio trial verified number
$body = "New Normal Order Id #".$oid." Received";
$datavp = array (
    'From' => $from,
    'To' => $to,
    'Body' => $body,
);
$post = http_build_query($datavp);
$x = curl_init($url );
curl_setopt($x, CURLOPT_POST, true);
curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($x, CURLOPT_USERPWD, "$idp:$token");
curl_setopt($x, CURLOPT_POSTFIELDS, $post);
$y = curl_exec($x);
curl_close($x);


	  $ProductData = $data['ProductData'];
for($i=0;$i<count($ProductData);$i++)
{

$title = mysqli_real_escape_string($mysqli,$ProductData[$i]['title']);
$type = mysqli_real_escape_string($mysqli,$ProductData[$i]['variation']);
$cost = $ProductData[$i]['price'];
$qty = $ProductData[$i]['qty'];
$discount = $ProductData[$i]['discount'];
$image = $ProductData[$i]['image'];

$table="tbl_normal_order_product";
  $field_values=array("oid","pquantity","ptitle","pdiscount","pimg","pprice","ptype");
  $data_values=array("$oid","$qty","$title","$discount","$image","$cost","$type");
  
      $h = new Milkman();
	   $h->Ins_milk_latest_Api($field_values,$data_values,$table);
}
if($wall_amt != 0)
{
 $vp = $mysqli->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
	  $mt = intval($vp['wallet'])-intval($wall_amt);
  $table="tbl_user";
  $field = array('wallet'=>"$mt");
  $where = "where id=".$uid."";
$h = new Milkman();
	  $check = $h->Ins_milk_updata_Api($field,$table,$where);
	  
	  $table="wallet_report";
  $field_values=array("uid","message","status","amt");
  $data_values=array("$uid",'Wallet Used in Order Id#'.$oid,'Debit',"$wall_amt");
   
      $h = new Milkman();
	  $checks = $h->Ins_milk_latest_Api($field_values,$data_values,$table);
}

$udata = $mysqli->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
$name = $udata['name'];

	   


$content = array(
       "en" => $name.', Your Order #'.$oid.' Has Been Received.'
   );
$heading = array(
   "en" => "Order Received!!"
);

$fields = array(
'app_id' => $set['one_key'],
'included_segments' =>  array("Active Users"),
'data' => array("order_id" =>$oid,"type"=>'normal'),
'filters' => array(array('field' => 'tag', 'key' => 'userid', 'relation' => '=', 'value' => $uid)),
'contents' => $content,
'headings' => $heading,
'big_picture' => siteURL().'/order_process_img/received.png'
);
$fields = json_encode($fields);

 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
curl_setopt($ch, CURLOPT_HTTPHEADER, 
array('Content-Type: application/json; charset=utf-8',
'Authorization: Basic '.$set['one_hash']));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
 
$response = curl_exec($ch);
curl_close($ch);

$timestamp = date("Y-m-d H:i:s");

$title_main = "Order Received!!";
$description = $name.', Your Order #'.$oid.' Has Been Received.';

$table="tbl_notification";
  $field_values=array("uid","datetime","title","description");
  $data_values=array("$uid","$timestamp","$title_main","$description");
  
  
  
      $h = new Milkman();
	   $h->Ins_milk_latest_Api($field_values,$data_values,$table);
	   
	   $tbwallet = $mysqli->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Order Placed Successfully!!!","wallet"=>$tbwallet['wallet']);
	}
	else 
	{
		$uid =  $data['uid'];

$p_method_id = $data['p_method_id'];
$full_address = $data['full_address'];
$d_charge = number_format((float)$data['d_charge'], 2, '.', '');
$cou_id = $data['cou_id'];
$wall_amt = number_format((float)$data['wall_amt'], 2, '.', '');
$cou_amt = number_format((float)$data['cou_amt'], 2, '.', '');	

$landmark = $data['landmark'];
$transaction_id = $data['transaction_id'];
$product_total = number_format((float)$data['product_total'], 2, '.', '');
$product_subtotal = number_format((float)$data['product_subtotal'], 2, '.', '');
$a_note = mysqli_real_escape_string($mysqli,$data['a_note']);
$name = mysqli_real_escape_string($mysqli,$data['name']);
$mobile = mysqli_real_escape_string($mysqli,$data['mobile']);
$timestamp = date("Y-m-d");
$table="tbl_subscribe_order";
  $field_values=array("uid","odate","p_method_id","address","d_charge","cou_id","cou_amt","o_total","subtotal","trans_id","a_note","wall_amt","name","mobile","status","landmark");
  $data_values=array("$uid","$timestamp","$p_method_id","$full_address","$d_charge","$cou_id","$cou_amt","$product_total","$product_subtotal","$transaction_id","$a_note","$wall_amt","$name","$mobile",'Pending',"$landmark");
  
      $h = new Milkman();
	  $oid = $h->Ins_Milk_Api_id($field_values,$data_values,$table);
	  
	  	   $adata = $mysqli->query("select * from admin where id=1")->fetch_assoc();
	  $idp = $set['asid'];
$token = $set['token'];
$url = "https://api.twilio.com/2010-04-01/Accounts/$idp/SMS/Messages";
$from = $set['megic_Num'];
$to = $adata['mobile']; // twilio trial verified number
$body = "New Subscription Order Id #".$oid." Received";
$datavp = array (
    'From' => $from,
    'To' => $to,
    'Body' => $body,
);
$post = http_build_query($datavp);
$x = curl_init($url );
curl_setopt($x, CURLOPT_POST, true);
curl_setopt($x, CURLOPT_RETURNTRANSFER, true);
curl_setopt($x, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($x, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($x, CURLOPT_USERPWD, "$idp:$token");
curl_setopt($x, CURLOPT_POSTFIELDS, $post);
$y = curl_exec($x);
curl_close($x); 

	  $ProductData = $data['ProductData'];
for($i=0;$i<count($ProductData);$i++)
{

$title = mysqli_real_escape_string($mysqli,$ProductData[$i]['title']);
$type = mysqli_real_escape_string($mysqli,$ProductData[$i]['variation']);
$cost = $ProductData[$i]['sprice'];
$qty = $ProductData[$i]['qty'];
$discount = $ProductData[$i]['discount'];
$image = $ProductData[$i]['image'];
$sdate = explode('-',$ProductData[$i]['startdate']);
$sdates = $sdate[2].'-'.$sdate[1].'-'.$sdate[0];
$array = explode(',',$ProductData[$i]['select_days']);
$sday = $ProductData[$i]['select_days'];
$delivery = $ProductData[$i]['total_deliveries'];
$tslot = $ProductData[$i]['tslot'];
$dates = array();
$pol = array();
$date = new DateTime($sdates);
for($ip=0;$ip<count($array);$ip++)
{
	$pol[] = $array[$ip] + 1; 
}

while (count($dates)< $delivery)
{
    $date->add(new DateInterval('P1D'));
    if (in_array($date->format('N'),$pol)) 
        $dates[]=$date->format('Y-m-d');
}

$rdate = implode(',',$dates);

$table="tbl_subscribe_order_product";
  $field_values=array("oid","pquantity","ptitle","pdiscount","pimg","pprice","ptype","startdate","totaldelivery","totaldates","selectday","tslot");
  $data_values=array("$oid","$qty","$title","$discount","$image","$cost","$type","$sdates","$delivery","$rdate","$sday","$tslot");
  
      $h = new Milkman();
	   $h->Ins_milk_latest_Api($field_values,$data_values,$table);
}
if($wall_amt != 0)
{
 $vp = $mysqli->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
	  $mt = intval($vp['wallet'])-intval($wall_amt);
  $table="tbl_user";
  $field = array('wallet'=>"$mt");
  $where = "where id=".$uid."";
$h = new Milkman();
	  $check = $h->Ins_milk_updata_Api($field,$table,$where);
	  
	  $table="wallet_report";
  $field_values=array("uid","message","status","amt");
  $data_values=array("$uid",'Wallet Used in Order Id#'.$oid,'Debit',"$wall_amt");
   
      $h = new Milkman();
	  $checks = $h->Ins_milk_latest_Api($field_values,$data_values,$table);
}	  

$udata = $mysqli->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
$name = $udata['name'];

$content = array(
       "en" => $name.', Your Subscribe Order #'.$oid.' Has Been Received.'
   );
$heading = array(
   "en" => "Subscribe Order Received!!"
);

$fields = array(
'app_id' => $set['one_key'],
'included_segments' =>  array("Active Users"),
'data' => array("order_id" =>$oid,"type"=>'normal'),
'filters' => array(array('field' => 'tag', 'key' => 'userid', 'relation' => '=', 'value' => $uid)),
'contents' => $content,
'headings' => $heading,
'big_picture' => siteURL().'/order_process_img/received.png'
);
$fields = json_encode($fields);

 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
curl_setopt($ch, CURLOPT_HTTPHEADER, 
array('Content-Type: application/json; charset=utf-8',
'Authorization: Basic '.$set['one_hash']));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($ch, CURLOPT_HEADER, FALSE);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
 
$response = curl_exec($ch);
curl_close($ch);

$timestamp = date("Y-m-d H:i:s");

$title_main = "Subscribe Order Received!!";
$description = $name.', Your Order #'.$oid.' Has Been Received.';

$table="tbl_notification";
  $field_values=array("uid","datetime","title","description");
  $data_values=array("$uid","$timestamp","$title_main","$description");
  
  
  
      $h = new Milkman();
	   $h->Ins_milk_latest_Api($field_values,$data_values,$table);

	    $tbwallet = $mysqli->query("select * from tbl_user where id=".$uid."")->fetch_assoc();
$returnArr = array("ResponseCode"=>"200","Result"=>"true","ResponseMsg"=>"Subscribe Order Placed Successfully!!!","wallet"=>$tbwallet['wallet']);
	}
}

echo json_encode($returnArr);