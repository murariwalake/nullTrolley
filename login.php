<?php
  require_once 'core/init.php';

  require_once 'includes/head.php';
  include_once 'includes/navbar.php';
  echo "<br><br><br>";
  if(is_loged_in() || is_admin_loged_in()){
    echo fail_msg("You have already signed in please sign out to sign in for different account ");
    //echo("<script>location.href = 'http://localhost/nullTrolley/index.php';</script>");
  }else {
  $errors = array();
  $email = ''; $pass='';
  //if user or admin submitted
   if(isset($_POST['user']) || isset($_POST['admin']) ){
    $email = check_validity($_POST['email'], "Please enter email id.");
    $pass = check_validity($_POST['pass'], "Please enter password with more than 6 charecters.");
    $needypage = sanatize($_POST['needypage']);

    $who= ((isset($_POST['admin']))?"admin":"user");

    if($who == "user"){
      $user_q = "SELECT * FROM user WHERE email='$email'";
    }
    if($who == "admin"){
      $user_q = "SELECT * FROM admin WHERE email='$email'";
    }
    //validate email
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $errors[] .= "Please enter valid email id.";
    }
    //pass must be more than 6 charecters
    if(strlen($pass) < 6){
        $errors[] .= "Password must be more than 6 charecters. ";
    }
    if(!$user_row= $db->query($user_q)){
      die($db->error);
    }
    $user_row_result = $user_row->fetch_assoc();
    $count = mysqli_num_rows($user_row);

    //verify pass
    if($count == 1){
      if(!password_verify($pass,$user_row_result['password'] )){
        $errors[] .= "Wrong Password!!! please try again.";
      }
    }else {
      $errors[] .= "You does not have an account please sign up";
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
    }
    else {
      $user_id = $user_row_result['id'];
      if($who=="user"){
        userLogin($user_id, $who);
      }
      if($who=="admin"){
        adminLogin($user_id, $who);
      }
      if(strlen($needypage)>0) {
        //header("Location:http://localhost".$needypage);
        echo ( "<script>location.href ='http://".$host_name.$needypage."' ;</script>");
      }
      if($who=="user") {
       echo("<script>location.href = 'http://".$host_name."/nullTrolley/index.php';</script>");
      }
      if($who=="admin"){
       echo("<script>location.href = 'http://".$host_name."/nullTrolley/admin/index.php';</script>");
      }

    }
  }

 ?>
<br><br>
  <div class="container">
    <div class="row">
      <div class="col-md-3">

      </div>
      <div class="col-md-6">
        <div class="w3-panel w3-card w3-light-grey"><br>
              <header class=" text-center w3-container w3-blue-grey w3-card">
                <h2>Welcome! Back</h2>
              </header>
              <div id="errors">

              </div>
                <form class="form-signin form-group" action="login.php" method="post">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" class="form-control" value="<?=$email;?>" placeholder="Email" >
                  </div>
                  <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password-field" type="password" class="form-control" name="pass" value="<?=$pass;?>">
                     <span toggle="#password-field" class="glyphicon glyphicon-eye-close glyphicon-eye-open  field-icon toggle-password"></span>
                  </div>
                  <input type="hidden" name="needypage" value="<?=(( isset($_GET['location']) )?$_GET['location']:'');?>">
                  <a href="index.php" class="btn btn-warning pull-left"> Cancel</a>

                  <div class="pull-right">

                    <button class="btn  btn-success " type="submit" name="user" value="user">Sign in as User</button>
                    <button class="btn  btn-success " type="submit" name="admin" value="admin">Sign in as Admin</button>
                  </div>

                </form><br><hr>
                <div class=" ">
                  <a href="forgotpass.php">Forgot password?</a><br>
                  <a href="signup.php" class="text-center new-account">Create an account </a>
                </div>
        </div>
      </div>
      <div class="col-md-3">

      </div>
    </div>
</div>

  <?php
}//else part end
  include_once 'includes/footer.php';
  include_once 'includes/scripts.php';

   ?>
