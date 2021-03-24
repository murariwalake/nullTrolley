<?php
  require_once '../core/init.php';
  $errors = array();
  if(!is_loged_in()){
     $errors[] .= "Please <a href=\"http://".$host_name."/nullTrolley/login.php\" class=\"w3-text-blue\">login</a> or <a href=\"http://".$host_name."/nullTrolley/signup.php\" class=\"w3-text-blue\">sign up</a> to add products to cart ";
  }
  $qty = check_validity($_POST['qty'], "Plese enter quantity");
  $size = check_validity($_POST['size'], "Plese enter size");
  $pid = check_validity($_POST['id'], "Somthing went wrong please try again");
  //expload size and maximum avalable value
  if(isset($size)){
    $sq_array = explode(':', $size);//$size = L:8 size:avalable qauntity
    if($qty > $sq_array[1] ){
      $errors[] .= "You have entered higher quantity than avaible quantity please choose properly";
    }
    $size=$sq_array[0];
  }



  if(!empty($errors)){
    echo display_errors($errors);
  }else {
    //check wheather the same produc with same size is awailable in correct
    $product_exist_q= "SELECT * FROM cart WHERE p_id='$pid' AND u_id='$user_id' AND size='$size'";
    $existproduct = $db->query($product_exist_q);
    $count = mysqli_num_rows($existproduct);
    if($count > 0){
       $db->query( "UPDATE cart SET quantity='$qty', size='$size'" );
       echo success_msg("Product updated in cart");
    }else{
      if($db->query( "INSERT INTO cart(u_id, p_id, quantity,size) values('$user_id','$pid','$qty','$size')" ))
       echo success_msg("Product added to cart succefully");

    }

  }
 ?>
