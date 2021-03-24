<?php
  require_once 'core/init.php';
  session_destroy();
  header('Location:http://'.$host_name.'/nullTrolley/index.php');
 ?>
