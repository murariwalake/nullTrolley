<?php
  require_once 'core/init.php';
  echo "<br><br><br>";
  require_once 'includes/head.php';
  include_once 'includes/navbar.php';
  if(is_loged_in() || is_admin_loged_in()){
    echo fail_msg("Please logout to sign up for different account ");
  }else{// dont sho sign up form if person alredy exist
  $name='';$email='';$pass1=''; $pass2=''; $mobile=''; $zip=''; $address='';
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
    if(mysqli_num_rows($exist_email) > 0){
      $errors[] .= "Entered email id already has acount please sign in";
    }
    //is mobile alresy exisst
    $exist_email = $db->query("SELECT * FROM user WHERE mobile='$mobile'");
    if(mysqli_num_rows($exist_email) > 0){
      $errors[] .= "Entered mobile number already has acount please sign in";
    }
    if(!empty($errors)){
      echo display_errors($errors);
    }else {
      //hash password
      $password = password_hash($pass1, PASSWORD_DEFAULT );
      //insert data and log in
      $user_insert= $db->query("INSERT INTO user(name, email, password, mobile, address, zip ) VALUES('$name', '$email', '$password', '$mobile', '$address', '$zip') ");
      if($user_insert){
        $last_u_id = $db->insert_id;
        userLogin($last_u_id, "user");
        echo("<script>location.href = 'http://".$host_name."/nullTrolley/index.php';</script>");
      }else {
          fail_msg("Somthing went wrong please try again");
      }

    }

  }

  ?>
<div class="container">
  <div class="w3-panel w3-card w3-light-grey"><br>
    <header class=" text-center w3-container w3-blue-grey w3-card">
      <h2>Sign Up</h2>
    </header>
    <form class="form-signin form-group" action="signup.php" method="post">
      <div class="col-md-6">
        <div class="form-group">
          <label for="name">Name<font style="color:red">*</font></label>
          <input type="text" id="name" name="name" class="form-control" value="<?=$name;?>" placeholder="Full Name" >
        </div>

          <div class="form-group">
            <label for="email">Email<font style="color:red">*</font></label>
            <input type="text" id="email" name="email" class="form-control" value="<?=$email;?>" placeholder="Email" >
          </div>
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

      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="mobile">Mobile Number<font style="color:red">*</font></label><br>
          <div class="col-md-2">
            <a href="#" class="btn btn-default">+91</a>
          </div>
           <div class="col-md-10">
             <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Mobile number" value="<?=$mobile;?>"><br>
           </div>
         </div>
        <div class="form-group">
          <label for="zip">Zip</label>
          <input type="text" id="zip" name="zip" class="form-control"placeholder="Pin-code" value="<?=$zip;?>">
        </div>
        <div class="form-group">
          <label for="address">Address</label>
          <textarea id="address" name="address"  class="form-control" rows="4" placeholder="Enter compleate adrress"><?=$address;?></textarea>
        </div>
      </div>
      <div class="col-md-12">
        <div class="text-center">
          <a href="index.php" class="btn btn-warning pull-left"> Cancel</a>
          <button class="btn  btn-success " type="submit" name="user" value="user">Sign Up</button>
        </div>
        <div class="text-center">
          <p>Do you have account?<a href="login.php" class="text-center new-account">sign in </a></p>
        </div>
      </form>

      </div>

  </div>
</div>

  <?php
}//else part end
  include_once 'includes/footer.php';
  include_once 'includes/scripts.php';
   ?>
