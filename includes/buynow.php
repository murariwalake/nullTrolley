<?php
  require_once '/opt/lampp/htdocs/nullTrolley/core/init.php';
  $errors = array();
  if(!is_loged_in()){
    $errors[] .= "Please <a href=\"http://localhost/nullTrolley/login.php\" class=\"w3-text-blue\">login</a> or <a href=\"http://localhost/nullTrolley/signup.php\" class=\"w3-text-blue\">sign up</a> to buy products.";
 }

  $qty = check_validity($_POST['qty'], "Plese enter quantity");
  $size = check_validity($_POST['size'], "Plese enter size");
  $pid = check_validity($_POST['id'], "Somthing went wrong please try again");
  //expload size and maximum avalable value
  if($qty <= 0){
    $errors[] .="Invalid quantity";
  }
  if(isset($size)){
    $sq_array = explode(':', $size);//$size = L:8 size:avalable qauntity
    if($qty > $sq_array[1] ){
      $errors[] .= "You have entered higher quantity than avaible quantity please choose properly";
    }
    $size=$sq_array[0];
  }
  //check adress and zip feilds
  if(is_loged_in()){
     $user_info = $db->query("SELECT * FROM user WHERE id='$user_id'");
     $user_info_row=$user_info->fetch_assoc();
     if($user_info_row['zip'] == '' ){
       $errors[] .="Please update you zip at profile section <a href=\"http://localhost/nullTrolley/account.php?editp=1\" class=\"w3-text-blue\">click here</a>";
     }
     if($user_info_row['address'] == '' ){
       $errors[] .="Please update you address at profile section <a href=\"http://localhost/nullTrolley/account.php?editp=1\" class=\"w3-text-blue\">click here</a>";
     }

  }


  if(!empty($errors)){
    echo display_errors($errors);
  }else {
    // place oder
    $product_info = $db->query("SELECT * FROM products WHERE id = '$pid'")->fetch_assoc();
    $amount = $qty * $product_info['price'];
    $place_order = $db->query("INSERT INTO porder(uid, pid, size, quantity, payment, status, amount) VALUES('$user_id', '$pid', '$size', '$qty', 'POD(pay on delivery)', 'Order placed', '$amount')");
    if($place_order){
       $last_id = $db->insert_id;
       $product_title = $product_info['title'];
       $user_info = $db->query("SELECT * FROM user WHERE id='$user_id'")->fetch_assoc();
       $msg = "From: nullTrolley\nHello ".$user_info['name']." Your order has been succesfully placed\nDetails:\nTitle:".$product_title."\nOrderID:".$last_id."\nPayment method:pay on delivery.\nDelivery address:".$user_info['address']."\nDelivery date: Within 3 working days from date of ordered.\nThank you for shopping with us.";
       //send ploduct placed massege
      send_msg($user_info['mobile'], $msg);
      echo success_msg("<div class=\"text-left\" ><h3>Order placed succesfully</h3><b>Details</b><br>Order Number:".$last_id."<br>Quantity:".$qty."<br>Title:".$product_title."</div>");

      //deduct placed product from db
      $db->query("UPDATE psize set quantity=quantity-'$qty' WHERE pid='$pid' AND size='$size'");
      //if it exist in cart then remove it
    if( $db->query("DELETE FROM cart WHERE u_id='$user_id' AND p_id='$pid' AND size='$size'")){

    }
  }else {
  echo  mysqli_error($db );
    echo fail_msg("faled to place the order please try again!!");
  }
  }
  ?>
