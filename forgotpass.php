<?php
  require_once 'core/init.php';
  require_once 'includes/head.php';
  include_once 'includes/navbar.php';
  echo " <br><br><br>";
  $errors=array();

  $mobile=((isset($_POST['mobile']))?$_POST['mobile']:'');
  $otp='';
  if(isset($_POST['resetpass'])){
    //mobile
    $mobile = sanatize($_POST['mobile']);
    if(!is_numeric($_POST['mobile']) || strlen($mobile) != 10){
      $errors[] .= "Please provpid valid mobile number";
    }
    $search_mobile = $db->query("SELECT * FROM user WHERE mobile='$mobile'");
    if(mysqli_num_rows($search_mobile) <= 0){
      $errors[] .= "Entered mobile number does not have any account";
    }

    //disply errors
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
    //massege sending code goese here
    $search_mobile = $db->query("SELECT * FROM user WHERE mobile='$mobile'");
    $user_info = $search_mobile->fetch_assoc();
    $user_name = $user_info['name'];

    require('textlocal.class.php');

    $textlocal = new Textlocal(false, false, '/gpP61OoTjE-Mh03u8fiNXCpaZ6znPZ2JDK7VxURda');

    $numbers = array($user_info['mobile']);
    $sender = 'TXTLCL';
    $sent_otp = mt_rand(10000, 99999);
    $message = 'Hello '.$user_name.' it is your otp:'.$sent_otp.' enter this otp to change your password';

    try {
        $result = $textlocal->sendSms($numbers, $message, $sender);
        $_SESSION['sent_otp'] = $sent_otp;
        $_SESSION['user_id'] = $user_info['id'];
       $success= success_msg("otp has sent succesfully");
       ?>
            <script>
            jQuery('document').ready(function(){
              jQuery('#errors').html('<?=$success?>');
            });
            </script>
      <?php

    } catch (Exception $e) {
        die('Error: ' . $e->getMessage());
    }
  }
}

//veryfy otp and get him to change pass page
 if(isset($_POST['otpsubmit'])){
   $otp = sanatize($_POST['otp']);
   if(!is_numeric($otp) || strlen($otp) != 5 || $otp != $_SESSION['sent_otp']){
     $errors[] .= "Please enter valid otp";
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
    //send him to reset pass
     echo("<script>location.href = 'http://localhost/nullTrolley/resetpass.php';</script>");
  }
 }

 ?>

 <div class="container">
   <div class="row">
     <div class="col-md-3">

     </div>
     <div class="col-md-6">


   <div class="w3-panel w3-card w3-light-grey"><br>
     <header class=" text-center w3-container w3-blue-grey w3-card">
       <h2>Forgot Password?</span></h2>
     </header><br>
       <form class="" action="forgotpass.php" method="post">
         <div id="errors">

         </div>
            <div class="col-md-6">
             <div class="form-group">
               <label for="mobile">Mobile number<font style="color:red">*</font></label>
               <input type="text" id="mobile" name="mobile" value="<?=$mobile;?>" class="form-control" placeholder="Enter mobile number">
             </div>
             <div class="form-group">
               <input type="submit" class="btn btn-success" name="resetpass" value="<?=((isset($_POST['resetpass']) || isset($_POST['opt']))?'Resend OTP':'Send OTP');?>">
             </div>
           </div>
           <div class="col-md-6">
               <div class="form-group">
                <label for="otp">Enter OTP<font style="color:red">*</font></label>
                <input type="text" id="otp" name="otp" value="<?=$otp;?>" class="form-control" placeholder="Enter 5 digit otp">
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-success" name="otpsubmit" value="Veryfy OTP">
              </div>
          </div>

         </form>
 </div>
 </div>
 <div class="col-md-3">

 </div>
</div>
 </div>
 <?php
   include_once 'includes/footer.php';
   include_once 'includes/scripts.php';

  ?>
