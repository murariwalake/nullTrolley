<?php
/*database connection */
/*object orientiented msqli*/
$db = new mysqli('127.0.0.1', 'root', '', 'nullTrolley');
session_start();
//$host_name = gethostname();
$host_name ="localhost";
if($db->connect_error){
  die('connection failed '.$db->connect_error);
}
 require_once '/opt/lampp/htdocs/nullTrolley/config.php';
 require_once BASEURL.'helpers/helpers.php';
 //session_destroy();
  if(is_loged_in()  || is_admin_loged_in()){
    $user_id = $_SESSION['user_id'];
    if(isset($_SESSION['admin'])) {
      $user_info = $db->query("SELECT * FROM admin WHERE id='$user_id' ");
    }
    if(isset($_SESSION['user'])) {
      $user_info = $db->query("SELECT * FROM user WHERE id='$user_id' ");
    }

    $user = $user_info->fetch_assoc();
    $full_name = explode(' ', $user['name']);
    $user['fname']=$full_name[0];
    $user['lname']=$full_name[1];
   }

//login failure message
 if(isset($_SESSION['error_flash'])){
   echo '<br><br><br><div class=" text-center alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4 >'.$_SESSION["error_flash"].'</h4><ul></div>';
   unset($_SESSION['error_flash']);
 }
//session_destroy();
?>
