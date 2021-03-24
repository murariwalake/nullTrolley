<?php
 require_once '/opt/lampp/htdocs/nullTrolley/core/init.php';
 $oid=$_POST['id'];
 //echo $oid;
 $order_info=$db->query("SELECT * FROM `porder` WHERE id='$oid' and uid='$user_id'")->fetch_assoc();
 if(!$order_info){
   echo mysqli_error($db);
 }
 if($db->query("UPDATE porder set status='Return requested' WHERE  id='$oid' and uid='$user_id' ")){
   echo success_msg("Return requested  succesfully");
 }
 //var_dump($order_info);
?>
