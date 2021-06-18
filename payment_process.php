<?php
require('top.php');
if(isset($_POST['amt']) && isset($_POST['name']) && isset($_POST['address']) && isset($_POST['city']) && isset($_POST['pincode'])){
	$address=get_safe_value($con,$_POST['address']);
	$city=get_safe_value($con,$_POST['city']);
	$pincode=get_safe_value($con,$_POST['pincode']);
	$payment_type="razorpay";
	$user_id=$_SESSION['USER_ID'];
    $amt=$_SESSION['total_price'];
	// foreach($_SESSION['cart'] as $key=>$val){
	// 	$productArr=get_product($con,'','',$key);
	// 	$price=$productArr[0]['price'];
	// 	$qty=$val['qty'];
	// 	$cart_total=$cart_total+($price*$qty);
		
	// }
	// $total_price=$cart_total;
	$payment_status='success';
	// if($payment_type=='cod'){
	// 	$payment_status='success';
	// }
	$order_status='1';
	$added_on=date('Y-m-d h:i:s');
	
	$txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
		
	
	mysqli_query($con,"insert into `order`(user_id,address,city,pincode,payment_type,payment_status,order_status,added_on,total_price,txnid) values('$user_id','$address','$city','$pincode','$payment_type','$payment_status','$order_status','$added_on','$total_price','$txnid')");
	
    $_SESSION['OID']=mysqli_insert_id($con);
	$order_id=mysqli_insert_id($con);
	
	foreach($_SESSION['cart'] as $key=>$val){
		$productArr=get_product($con,'','',$key);
		$price=$productArr[0]['price'];
		$qty=$val['qty'];
		
		mysqli_query($con,"insert into `order_detail`(order_id,product_id,qty,price) values('$order_id','$key','$qty','$price')");
	}
	
	unset($_SESSION['cart']);
	unset($_SESSION['total_price']);
}

/*
if(isset($_POST['amt']) && isset($_POST['name'])){
    $amt=$_POST['amt'];
    $name=$_POST['name'];
    $payment_status="pending";
    $added_on=date('Y-m-d h:i:s');
    mysqli_query($con,"insert into tbl_payment(name,amount,payment_status,added_on) values('$name','$amt','$payment_status','$added_on')");
    $_SESSION['OID']=mysqli_insert_id($con);
}*/


if(isset($_POST['payment_id']) && isset($_SESSION['OID'])){
    $payment_id=$_POST['payment_id'];
    mysqli_query($con,"update order set payment_status='complete',payment_id='$payment_id' where id='".$_SESSION['OID']."'");
}
?>