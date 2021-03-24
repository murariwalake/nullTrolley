<?php
require_once 'core/init.php';
require_once 'includes/head.php';
include_once 'includes/navbar.php';
echo " <br><br><br>";
$pass1='';
$pass2='';
$errors = array();

if($_POST){
  //password
  $pass1=check_validity($_POST['pass1'], "Please enter password");
  $pass2=check_validity($_POST['pass2'], "Please enter confirm password field");

  //pass must be more than 6 charecters
  if(strlen($pass1) < 6 || strlen($pass2) < 6){
      $errors[] .= "Password must be more than 6 charecters. ";
  }
  if($pass1 != $pass2){
    $errors[] .= "Password and confirm password are miss matching";
  }
  //check session person got cerified or not
  if(!isset($_SESSION['user_id'])){
    $errors[] .= "To change password either you need to verify your mobile number of login";
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
    //update password
    $password = password_hash($pass1, PASSWORD_DEFAULT );
    $u_id = $_SESSION['user_id'];
    if($db->query("UPDATE user SET password='$password' WHERE id='$u_id'") ){
      echo success_msg("Your password has updated");

    }else {
      echo fail_msg("Somthing went wrong password has not reset");
    }
    //unset($_SESSION['user_id']);

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
               <h2>Reset password</h2>
             </header>
               <br>
                 <div id="errors">

                 </div>
               <form class="form-signin form-group" action="resetpass.php" method="post">

                 <div class="form-group">
                   <label for="password-fiel" >Password<font style="color:red">*</font></label>
                   <input id="password-field" type="password" class="form-control" name="pass1" value="<?=$pass1;?>">
                    <span toggle="#password-field" class="glyphicon glyphicon-eye-close glyphicon-eye-open  field-icon toggle-password"></span>

                 </div>

                 <div class="form-group">
                   <label for="password-field2">Confirm Password<font style="color:red">*</font></label>
                   <input id="password-field2" type="password" class="form-control" name="pass2" value="<?=$pass2;?>">
                    <span toggle="#password-field2" class="glyphicon glyphicon-eye-close glyphicon-eye-open  field-icon toggle-password2"></span>

                 </div>

                 <a href="index.php" class="btn btn-warning"> Cancel</a>
                 <button class="btn  btn-success pull-right text-center" type="submit" name="user" value="user">Reset password</button>
               </form><br>
               <div class="text-center">
                 <a href="signup.php" class="text-center new-account">Create an account </a>
               </div>

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
