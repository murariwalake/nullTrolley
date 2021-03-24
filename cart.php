<?php
  require_once 'core/init.php';
  if(!is_loged_in()){
    login_error_redirect($_SERVER['REQUEST_URI']);
  }
  require_once 'includes/head.php';
  include_once 'includes/navbar.php';
  //fetch user cart data
   $cart = $db->query("SELECT * FROM cart WHERE u_id='$user_id' ORDER BY added_date");
   //remove product fron cart
   if(isset($_GET['remove']) && isset($_GET['size']) ){
     $remove_id = sanatize($_GET['remove']);
     $size = sanatize($_GET['size']);
     $db->query("DELETE FROM cart WHERE u_id='$user_id' AND p_id='$remove_id'AND size='$size'");
     echo("<script>location.href = 'http://".$host_name."/nullTrolley/cart.php';</script>");
   }



   $total_price=0;
   $total_products = 0;
?>
<br><br><br>
<div class="container">

  <div class="w3-panel w3-card w3-light-grey"><br>
    <header class=" text-center w3-container w3-blue-grey w3-card w3-borderes">
      <h2>CART <span class="glyphicon glyphicon-shopping-cart"></span></h2>
    </header>
    <div class="w3-panel w3-card w3-white"><br>
      <table class="table   w3-hoverable w3-borderes  w3-borderes">
        <tr class="w3-green">
          <td>Photo</td><td>Title</td><td>Size</td><td>Quantity</td><td>Price</td><td>Added date</td><td>Availability</td><td>Remove</td><td>View</td>
        </tr>
        <?php while($cart_row = $cart->fetch_assoc()):
          $pid = $cart_row['p_id'];
          $producr_size =$cart_row['size'];

          $pcountq = "SELECT SUM(quantity) FROM psize WHERE psize.pid = '$pid' AND size='$producr_size'";
          $pcount = $db->query($pcountq);
          $pcountrow = $pcount->fetch_assoc();

          $product = $db->query("SELECT * FROM products WHERE id='$pid'");
          $product_row = $product->fetch_assoc();
          $product_image = $db->query("SELECT * FROM pimage WHERE pid='$pid'");
          $product_image_row = $product_image->fetch_assoc();
          $total_price = $total_price + ($product_row['price']*$cart_row['quantity']);
          $total_products += $cart_row['quantity'];
           ?>

            <tr class="<?=(($product_row['deleted']==1 || $pcountrow['SUM(quantity)']==0 )?'w3-text-red':'');?>">
               <td><img src="<?=$product_image_row['image'];?>" alt="" width="50px" height="50px"></td>
               <td><?=$product_row['title'];?></td>
               <td><?=$cart_row['size'];?></td>
               <td><?=$cart_row['quantity'];?></td>
               <td><?=$product_row['price'];?></td>
               <?php if($product_row['deleted']==1 || $pcountrow['SUM(quantity)']==0): ?>
                 <td class="w3-text-red">Out of stock</td>
               <?php endif ?>
               <?php if($product_row['deleted']==0 && $pcountrow['SUM(quantity)']!=0): ?>
                 <td class="w3-text-green">In stock</td>
               <?php endif ?>
               <td><?=$cart_row['added_date'];?></td>
               <td><a href="cart.php?remove=<?=$cart_row['p_id']."&&size=".$cart_row['size'];?>" onclick="return confirm('Are you sure to remove the product from cart?')"><span class="glyphicon glyphicon-trash w3-text-red"></span></a></td>
               <td><a href="#" class="btn btn-success" onclick="detailsmodal(<?= $cart_row['p_id']; ?> )">View</a></td>
             </tr>



        <?php endwhile ?>
      </table>
      <div class="col-md-6">
        <p>Total Price: <?=money($total_price);?></p>
        <p>Total Number of Products:<?=$total_products;?></p>
      </div>

    </div>
</div>
</div>
<?php
include_once 'includes/footer.php';
include_once 'includes/scripts.php';
 ?>
