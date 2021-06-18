<?php
include('vendor/autoload.php');
require('connection.inc.php');
require('functions.inc.php');

if(!$_SESSION['ADMIN_LOGIN']){
	if(!isset($_SESSION['USER_ID'])){
		die();
	}
}

$order_id=get_safe_value($con,$_GET['id']);

$css=file_get_contents('css/bootstrap.min.css');
$css.=file_get_contents('style.css');
$css.=file_get_contents('pdf.css');



if(isset($_SESSION['ADMIN_LOGIN'])){
	$res=mysqli_query($con,"select distinct(order_detail.id) ,order_detail.*,product.name,product.image from order_detail,product ,`order` where order_detail.order_id='$order_id' and order_detail.product_id=product.id");
	$res2=mysqli_query($con,"select user_id from `orders` where order_id='$order_id'");
	$res3=mysqli_query($con,"select name from `users` where id='$res2'");
}else{
	$uid=$_SESSION['USER_ID'];
	$res=mysqli_query($con,"select distinct(order_detail.id) ,order_detail.*,product.name,product.image from order_detail,product ,`order` where order_detail.order_id='$order_id' and `order`.user_id='$uid' and order_detail.product_id=product.id");
	$res2=mysqli_query($con,"select user_id from `orders` where order_id='$order_id'");
	$res3=mysqli_query($con,"select name from `users` where id='$res2'");
}

$total_price=0;
if(mysqli_num_rows($res)==0){
	die();
}
while($row=mysqli_fetch_assoc($res)){
$total_price=$total_price+($row['qty']*$row['price']);
 $pp=$row['qty']*$row['price'];

$html='
<table class="body-wrap">
    <tbody><tr>
        <td></td>
        <td class="container" width="600">
            <div class="content">
                <table class="main" width="100%" cellpadding="0" cellspacing="0">
                    <tbody><tr>
                        <td class="content-wrap aligncenter">
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tbody><tr>
                                    <td class="content-block">
                                        <h2>Milky Mist </h2>
										<h4>Order Details </h4>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                        <table class="invoice">
                                            <tbody><tr>
                                                <td><br>Invoice #'.$_GET['id'].'<br>June 01 2015</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <table class="invoice-items" cellpadding="0" cellspacing="0">
                                                        <tbody><tr>
                                                            <td>Product Name</td>
                                                            <td class="alignright">'.$row['name'].'</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Quantity</td>
                                                            <td class="alignright">'.$row['qty'].'</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Price</td>
                                                            <td class="alignright">'.$row['price'].'</td>
                                                        </tr>
                                                        <tr class="total">
                                                            <td class="alignright" width="80%">Total Price</td>
                                                            <td class="alignright">'.$total_price.'</td>
                                                        </tr>
                                                    </tbody></table>
                                                </td>
                                            </tr>
                                        </tbody></table>
                                    </td>
                                </tr>
                                <tr>
                                </tr>
                                <tr>
                                    <td class="content-block">
                                    </td>
                                </tr>
                            </tbody></table>
                        </td>
                    </tr>
                </tbody></table>
                <div class="footer">
                    <table width="100%">
                        <tbody><tr>
                            <td class="aligncenter content-block">Questions? Email <a href="mailto:">milkymist@company.inc</a></td>
                        </tr>
                    </tbody></table>
                </div></div>
        </td>
        <td></td>
    </tr>
</tbody></table>
<div class="wishlist-table table-responsive">
   <table>
      <thead>
         <tr>
         </tr>
      </thead>
      <tbody>';
		
         $html.='<tr>
            
         </tr>';
		 }
		 $html.='<tr>
				
			</tr>';
		 
      $html.='</tbody>
   </table>
</div>';
$mpdf=new \Mpdf\Mpdf();
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($html,2);
$file=time().'.pdf';
$mpdf->Output($file,'D');
?>
