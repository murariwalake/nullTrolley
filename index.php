<?php
  require_once 'core/init.php';
  require_once 'includes/head.php';
  include_once 'includes/navbar.php';
  include_once 'includes/offers.php';
  $productq = "SELECT * FROM products WHERE featured=1 AND deleted!=1"; //select products
  $product = $db->query($productq);//pass query for products

  include_once 'includes/leftbar.php';
?>
  <!--main bar-->
    <div class="col-md-8">
      <div class="row">
        <header class="text-center w3-container w3-blue-grey w3-cardr"><h2 class="text-center"><b>Featured produts</b></h2></header><br>

        <?php /*fetch items from db*/

          while($prows = $product->fetch_assoc()):
             //fetch all products
            $pid = $prows['id'];//store product id for next usages like fetching image and size size of product
            $pbrandid = $prows['brand'];

            $pimageq = "SELECT * FROM pimage WHERE pid = $pid"; //query to fetch images of perticular id product
            $pimage = $db->query($pimageq); //pass query for product image

            $pbrandq = "SELECT * FROM brand WHERE id = $pbrandid";
            $pbrand = $db->query($pbrandq);
            $pbrandrow = $pbrand->fetch_assoc();

            ?>
        <div  class="col-md-4">
         <div class="w3-panel w3-card w3-light-grey"><br>
           <header class="text-center w3-container w3-blue-grey w3-cardr"><h4 class="text-center"><b> <?=$prows['title'];?> </b></h4></header><br>

           <?php
                 $previousid = -1;
                 while($pimagerows = $pimage->fetch_assoc()): //fetch product imges
                   /*the bellow if statement is used for to display single images of each item*/
                   if( $previousid == $pimagerows['pid'])
                    continue;
                   $previousid = $pimagerows['pid'];
                   ?>
                   <div class="w3-container w3-white">
                  <img style="max-height:100%; max-width:100%;" src= <?= $pimagerows['image']; ?> alt= <?= $prows['title'];  ?> class="imgthumb center-block"/>
                  </div>
               <?php endwhile; ?>


          <p class="text-center">Brand: <?= $pbrandrow['brand'];?></p>
          <p class="list-price text-danger text-center">List price: <s>Rs <?= $prows['list_price'] ?></s></p>
          <p class="price text-center">Our price: <b>Rs <?=$prows['price']?></b></p>
          <!-- Trigger the modal with a button -->
         <button type="button" class="btn btn-success center-block" onclick="detailsmodal(<?= $prows['id']; ?> )">
          Check it</button><br>
        </div>
        </div>
        <?php endwhile; ?>
      </div><br><br>
    </div>

<?php
  include_once 'includes/rightbar.php';
  include_once 'includes/footer.php';
  include_once 'includes/scripts.php';
?>
