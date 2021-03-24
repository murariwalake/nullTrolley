<?php
  require_once '/opt/lampp/htdocs/nullTrolley/core/init.php';
  if(!is_admin_loged_in()){
    login_error_redirect($_SERVER['REQUEST_URI']);
  }
  require_once 'includes/head.php';
  include_once 'includes/navbar.php';
  //deliver the order
  if(isset($_GET['deliver'])){
    $deliverid=sanatize($_GET['deliver']);
    $db->query("UPDATE porder set status='Delivered' WHERE id='$deliverid'");
    echo success_msg("Product delivered successfully");
    //send_msg("")
  }


  $orders = $db->query("SELECT * FROM porder WHERE status='Order placed' ORDER BY odate");
  ?>
  <div class="container">

    <div class="w3-panel w3-card w3-light-grey"><br>
      <header class="text-center w3-container w3-blue-grey w3-cardr"><h2>List of orders</h2></header><br>
      <div class="w3-container w3-white"><br>
        <table class="table  w3-card-4  w3-hoverable w3-borderes  table-condensed">
          <thead class="w3-green">
            <th>Product</th><th>Customer</th><th>Ordered date</th> <th>Amount</th> <th>Delivery</th><th>Details</th>
          </thead>
          <?php while ($order = $orders->fetch_assoc()  ):
            $pid =$order['pid'];
            $uid =$order['uid'];
            $oid =$order['id'];
            $product =$db->query("SELECT * FROM products WHERE id='$pid'")->fetch_assoc() ;
            $user =$db->query("SELECT * FROM user WHERE id='$uid'")->fetch_assoc() ;
          ?>
            <tr>
              <td><?=$product['title'];?></td>
              <td><?=$user['name'];?></td>
              <td><?=$order['odate'] ;?></td>
              <td><?=$order['amount'] ;?></td>
              <td> <?=(($order['status']=="Order placed")?'<a href="orders.php?deliver='.$oid.'" class="btn btn-success">Deliver</a>':'');?></td>
              <td> <button class="btn btn-success" onclick="viewDetails(<?=$order['id'];?>)">View details</button> </td>
            </tr>


          <?php endwhile; ?>
        </table>
      </div>
      <br>
    </div>
  </div>


  <?php
    include_once 'includes/footer.php';
    include_once 'includes/scripts.php';
   ?>
