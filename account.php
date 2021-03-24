<?php
  require_once 'core/init.php';
  if(!is_loged_in()){
    login_error_redirect($_SERVER['REQUEST_URI']);
  }
  require_once 'includes/head.php';
  include_once 'includes/navbar.php';
  $errors = array();
  if($_POST){
    $name=check_validity($_POST['name'], "Please enter your full name");
    $name_test = explode(' ', $name);
    if(sizeof($name_test) < 2 && isset($name)){
      $errors[] .= "Please enter your full name";
    }
    //email
    $email = sanatize($_POST['email']);
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $errors[] .= "Please enter valid email id.";
    }

    //mobile
    $mobile = sanatize($_POST['mobile']);
    if(!is_numeric($_POST['mobile']) || strlen($mobile) != 10){
      $errors[] .= "Please provpid valid mobile number";
    }
    //zip
      $zip=sanatize($_POST['zip']);
    if($zip !=''){
      if ( !is_numeric($_POST['zip']) || strlen($zip) != 6) {
        $errors[] .= "Please provpid valid zip";
      }
    }
    //address
    $address=sanatize($_POST['address']);

     //email already registered?
    $exist_email = $db->query("SELECT * FROM user WHERE email='$email'");
    $exist_email_row = $exist_email->fetch_assoc();
    if(mysqli_num_rows($exist_email) > 0 && ($exist_email_row['id'] != $user_id)){
      $errors[] .= "Entered email id already has acount.";
    }
    //is mobile alresy exisst
    $exist_mobile = $db->query("SELECT * FROM user WHERE mobile='$mobile'");
    $exist_mobile_row = $exist_mobile->fetch_assoc();
    if(mysqli_num_rows($exist_mobile) > 0 && ($exist_mobile_row['id'] != $user_id)){
      $errors[] .= "Entered mobile number already has acount.";
    }


    if(!empty($errors)){
      $errors_display =  display_errors($errors);
      ?>
           <script>
           jQuery('document').ready(function(){
             jQuery('#errors').html('<?=$errors_display?>');
           });
           </script>
     <?php
    }else {
      $update_user_info = $db->query("UPDATE user set name='$name', email='$email', mobile='$mobile', zip='$zip', address='$address' WHERE id='$user_id'");
      if($update_user_info){
        $success_display = success_msg("Your data has updted");
        ?>
             <script>
             jQuery('document').ready(function(){
               jQuery('#errors').html('<?=$success_display?>');
             });
             </script>
       <?php
      }else {
        echo fail_msg("Somthing went wrong please try again!!");
      }
    }

  }
  $user_info = $db->query("SELECT * FROM user WHERE id='$user_id'");
  $user_info_row = $user_info->fetch_assoc();
  //print_r($user_info_row);
 ?>

 <br><br><br>
 <div class="container">

   <div class="w3-panel w3-card w3-light-grey"><br>
     <header class=" text-center w3-container w3-blue-grey w3-card">
       <h2><span class="glyphicon glyphicon-user"></span> ACCOUNT </h2>
     </header>
     <div class="w3-panel w3-card w3-white"><br>
       <div class="row">
        <div class="col-md-3 ">
         <a href="account.php?profile=1"><button class="btn btn-info btn-block"  ><b>Profile</b></button></a><br>
         <a href="account.php?orders=1"><button class="btn btn-info btn-block"  ><b>My orders</b></button></a><br>
         <a href="resetpass.php"><button class="btn btn-info btn-block"  ><b>Change password</b></button></a><br>

       </div>
       <div class="col-md-9">
         <?php if(isset($_GET['profile'])): ?>

             <header class="text-center w3-panel w3-green">
               <h2><span class="glyphicon glyphicon-user"></span> <?=" ".$user_info_row['name'];?></h2>
             </header>
             <div class="w3-panel w3-card w3-light-grey"><br>
               <table>
                 <tr>
                   <td><b>Name </b></td><td><b>: </b></td> <td> <?=$user_info_row['name'];?></td>
                 </tr>
                 <tr>
                   <td><b>Email </b></td><td><b>: </b></td> <td><?=$user_info_row['email'];?></td>
                 </tr>
                 <tr>
                   <td><b>Mobile </b></td> <td><b>: </b></td> <td><?=$user_info_row['mobile'];?></td>
                 </tr>
                 <tr>
                   <td><b>Zip </b></td><td><b>: </b></td> <td><?=$user_info_row['zip'];?></td>
                 </tr>
                 <tr>
                   <td><b>Address </b></td><td><b>: </b></td>  <td><?=$user_info_row['address'];?></td>
                 </tr>
               </table>
              <a href="account.php?editp=1" class="btn btn-info pull-right">Edit <span class="glyphicon glyphicon-pencil"></span></a>
            </div><br>

         <?php endif ?>

         <?php if(isset($_GET['editp'])): ?>

           <header class="text-center w3-panel w3-green">
             <h2><span class="glyphicon glyphicon-user"></span>Edit profile</h2>
           </header>
           <div class="w3-panel w3-card w3-light-grey"><br>
             <div id="errors">

             </div>
             <form  action="account.php?editp=1" method="post">
               <div class="row">
                 <div class="col-sm-6">
                   <div class="form-group">
                     <label for="name">Name<font style="color:red">*</font></label>
                     <input type="text" id="name" name="name" class="form-control" value="<?=$user_info_row['name'];?>" placeholder="Full Name" >
                   </div>

                   <div class="form-group">
                     <label for="email">Email<font style="color:red">*</font></label>
                     <input type="text" id="email" name="email" class="form-control" value="<?=$user_info_row['email'];?>" placeholder="Email" >
                   </div>

                   <div class="form-group">
                     <label for="mobile">Mobile Number<font style="color:red">*</font></label><br>
                       <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Mobile number" value="<?=$user_info_row['mobile'];?>"><br>
                   </div>
                 </div>

                <div class="col-sm-6">
                  <div class="form-group">
                    <label for="zip">Zip</label>
                    <input type="text" id="zip" name="zip" class="form-control"placeholder="Pin-code" value="<?=$user_info_row['zip'];?>">
                  </div>
                  <div class="form-group">
                    <label for="address">Address</label>
                    <textarea id="address" name="address"  class="form-control" rows="4" placeholder="Enter compleate adrress"><?=$user_info_row['address'];?></textarea>
                  </div>
                </div>

              </div>
               <input type="submit" name="updateprofile" value="Update" class="btn btn-success pull-right">
               <a href="account.php?profile=1" class="btn btn-warning pull-right">Cancel</a> 
             </form>
             </div><br>

         <?php endif; ?>

         <?php if(isset($_GET['orders'])): ?>

             <header class="text-center w3-panel w3-green">
               <h2>Orders </h2>
             </header>
              <div class="w3-panel w3-card w3-light-grey">
               <table class="table   w3-hoverable w3-borderes  w3-borderes">
                 <tr class="w3-green">
                   <td>Photo</td><td>Title</td><td>Size</td><td>Quantity</td> <td>Status</td> <td>View</td>
                 </tr>

               <?php
                  $user_orders = $db->query("SELECT * FROM porder WHERE uid='$user_id' ORDER BY odate DESC");
                   while ($user_orders_row=$user_orders->fetch_assoc()):
                     $pid=$user_orders_row['pid'];
                     //fetch product info
                     $product = $db->query("SELECT * FROM products WHERE id='$pid'");
                     $product_row = $product->fetch_assoc();
                     //fetch product image
                     $product_image = $db->query("SELECT * FROM pimage WHERE pid='$pid'");
                     $product_image_row = $product_image->fetch_assoc();
                ?>
                <tr class="<?=(($user_orders_row['status']=="delivered")?'w3-text-green':'');?>">
                   <td><img src="<?=$product_image_row['image'];?>" alt="" width="50px" height="50px"></td>
                   <td><?=$product_row['title'];?></td>
                   <td><?=$user_orders_row['size'];?></td>
                   <td><?=$user_orders_row['quantity'];?></td>
                   <td><?=$user_orders_row['status'];?></td>
                   <td><a href="#" class="btn btn-success" onclick="orderDetails(<?= $user_orders_row['id']; ?> )">View</a></td>
                 </tr>


              <?php endwhile; ?>
              </table>
            </div>

         <?php endif ?>
       </div>
    </div>
  </div>
 </div>
 </div>


<?php
  include_once 'includes/footer.php';
  include_once 'includes/scripts.php';
?>
