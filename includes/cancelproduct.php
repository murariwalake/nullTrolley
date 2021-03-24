<?php
 require_once '/opt/lampp/htdocs/nullTrolley/core/init.php';
 $oid=$_POST['id'];
 $order_info=$db->query("SELECT * FROM `porder` WHERE id='$oid' and uid='$user_id'")->fetch_assoc();
 if(!$order_info){
   echo mysqli_error($db);
 }
 if(isset($_POST['id'])){
   $cancelid=sanatize($_POST['id']);
   $db->query("UPDATE porder set status='Product canceled' WHERE id='$cancelid'");
   echo success_msg("Product canceled successfully");
   $order = $db->query("SELECT * FROM porder WHERE id='$cancelid'")->fetch_assoc();
   $qty=$order['quantity'];
   $size=$order['size'];
   $pid=$order['pid'];
   if($db->query("UPDATE psize set quantity=quantity+'$qty' WHERE size='$size' AND pid='$pid'")){

   }
   //send_msg("")
 }
?>
