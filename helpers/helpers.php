<?php
/*errors listing*/
 function display_errors($errors){
    $display = '<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4 >ERROR</h4><ul>';

    foreach($errors as $error){
      $display .= '<li>'.$error.'</li>';
    }
    $display .= '</ul></div>';
    return $display;
  }

  //success msg
  function success_msg($data){
     $success_msg = '<div class="alert alert-success alert-dismissible fade in text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4 >'.$data.'</h4><ul></div>';

     return $success_msg;
 }
 //fail msg
 function fail_msg($data){
    $success_msg = '<div class="alert alert-danger alert-dismissible fade in text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><h4 >'.$data.'</h4><ul></div>';

    return $success_msg;
}
//YYYY-MM-DD validation
function isValidDate($date){
  if (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$date)) {
      return true;
  } else {
      return false;
  }
}
  /*function to check validity of imput values
  syntax check_validity(value, error if its not valid)*/
    function check_validity($value, $error){
      $value = trim($value);
      if( $value ==''){
        global  $errors;
        $errors[] .= "$error";
      }
      else{
        return htmlentities($value, ENT_QUOTES, "UTF-8");
      }
    }

    function sanatize($dirty){
      return htmlentities($dirty, ENT_QUOTES, "UTF-8");
    }


    function get_category($pid){
      global $db;
      $category_q = "SELECT p.id AS 'pid', p.category AS 'parent',c.id AS 'cid', c.category AS 'child'
                      FROM categories c
                      INNER JOIN categories p
                      ON  c.parent = p.id
                      WHERE c.id='$pid'";
      $category = $db->query($category_q);
      $category_row=$category->fetch_assoc();
      return $category_row;
    }

    /*number format*/
    function money($number){
      return "Rs: ".number_format($number, 2);
    }

    //login setup
    function userLogin($user_id, $who){
      global $db;
      $_SESSION['user_id'] = $user_id;
      $_SESSION['succes_flash'] = "You are loged in now";
      $_SESSION['user'] = $who;
      $date = date("Y-m-d H:i:s");
      $db->query("UPDATE admin SET last_login = '$date' WHERE id='$user_id'");
     }

     function adminLogin($user_id, $who){
       global $db;
       $_SESSION['user_id'] = $user_id;
       $_SESSION['succes_flash'] = "You are loged in now";
       $_SESSION['admin'] = $who;
       $date = date("Y-m-d H:i:s");
       $db->query("UPDATE admin SET last_login = '$date' WHERE id='$user_id'");
      }
     //check login
     function is_loged_in(){
       if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0 && isset($_SESSION['user']) && $_SESSION['user']=="user"){
         return true;
       }
       else {

         return false;
       }
     }

     function is_admin_loged_in(){
       if(isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0 && isset($_SESSION['admin']) && $_SESSION['admin']=="admin" ){
         return true;
       }
       else {

         return false;
       }
     }


     function login_error_redirect($ural){
       $_SESSION['error_flash'] = "You must login to eccess that page";
       header('Location:http://localhost/nullTrolley/login.php?location='.$ural);
     }

     //send massege
     function send_msg($number, $message){
       require('../textlocal.class.php');
       $numbers = array($number);
       $textlocal = new Textlocal(false, false, '/gpP61OoTjE-Mh03u8fiNXCpaZ6znPZ2JDK7VxURda');
       $sender = 'TXTLCL';

       try {
           $result = $textlocal->sendSms($numbers, $message, $sender);
       }catch (Exception $e) {
           die('Error: ' . $e->getMessage());
       }
     }

 ?>
