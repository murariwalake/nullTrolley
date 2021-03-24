<?php
 //require_once '..core/init.php';

 /*database connection */
 /*object orientiented msqli*/
 $db = new mysqli('127.0.0.1', 'root', '', 'nullTrolley');

 if($db->connect_error){
   die('connection failed '.$db->connect_error);
 }

 $pid = $_POST['id'];
 $pid = (int)$pid;
/*sselsec products*/
 $productq = "SELECT * FROM products WHERE id = '$pid'";
 $product = $db->query($productq);
 $productrow = $product->fetch_assoc();
/*select imaeges of perticulare product*/
 $pimageq = "SELECT * FROM pimage WHERE pid = '$pid' ";
 $pimage = $db->query($pimageq);
 $pimageq1 = "SELECT * FROM pimage WHERE pid = '$pid' ";
 $pimage1 = $db->query($pimageq1);
/*find brand of that produt*/
 $pbrandid = $productrow['brand'];
 $pbrandq = "SELECT * FROM brand WHERE id = '$pbrandid'";
 $pbrand = $db->query($pbrandq);
 $pbrandrow = $pbrand->fetch_assoc();
/*find  product's sizes*/
 $psizeq = "SELECT * FROM psize WHERE psize.pid = '$pid'";
 $psize = $db->query($psizeq);
/*count number of  product of pertucular id*/
 $pcountq = "SELECT SUM(quantity) FROM psize WHERE psize.pid = '$pid'";
 $pcount = $db->query($pcountq);
 $pcountrow = $pcount->fetch_assoc();

?>

<?php ob_start();  ?>
<!-- Modal -->
<div id="details-modal" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">

<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <div id="errors">

    </div>
    <h3 class="modal-title text-center"><b> <?=  $productrow['title'];?></b></h3>
  </div>
  <div class="modal-body">
    <div class="container">
      <div class="row">
        <div class="col-lg-4 center-block">
          <div id="details">
            <!--product image slide show in model -->
            <?php include 'productimage.php'; ?>
          </div>
        </div>

        <div class="col-lg-6">

          <h5><b>Details:</b></h5>
          <p><?= $productrow['description'];?></p><br>
          <p><b>Brand:</b> <?= $pbrandrow['brand']; ?></p>
          <p class="list-price text-danger"><b>List price:  </b>Rs <s><?= $productrow['list_price'];?></s></p>
          <p class="price"><b>Our prise:</b> Rs <?= $productrow['price'];?></p>
            <?php
            /*check Availability of product*/
              if($pcountrow['SUM(quantity)']<1)
                echo '<div class="text-danger">
                        <b>Availability: Out of stock</b>
                      </div>';
              else
                echo "Available: ".$pcountrow['SUM(quantity)'];
              ?>
              <br><br>
         <?php
          /*allow user to select sizes only when that product is awailable*/
            if($pcountrow['SUM(quantity)']>0):
          ?>
          <form class="form-group form-inline" action="#" method="post">
            <div class="col-md-3">
              <label for="size">Size: </label>
              <select class="selectpicker" id="size">
                <option value="">Select size</option>
                <?php
                /*drop down for size selection*/
                while($psizerow = $psize->fetch_assoc()): ?>

                  <?php
                  if($psizerow['quantity']>0)
                  echo "<option value=".$psizerow['size'].":".$psizerow['quantity'].">".$psizerow['size'].": ".$psizerow['quantity']."</option>";
                  ?>

              <?php endwhile; ?>
            </select>
            </div>
            <div class="col-md-3">
              <label for="quantity">Quantity:</label>
              <input type="number" name="quantity" class="form-control" value="" placeholder="Quantity" id="quantity" min="1" max="<?=$pcountrow['SUM(quantity)']?>">
            </div>

          </form>
          <?php endif;  ?>

        </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-warning" onclick="closeModal()">Close</button>
    <?php
    //user can add to cart or buy product only when it is exist
     $product_stock = $db->query("SELECT SUM(quantity) FROM psize, products WHERE pid='$pid' AND products.deleted!=1")->fetch_assoc();
          if($product_stock['SUM(quantity)']>0): ?>
    <button type="submit" class="btn btn-success" onclick="addToCart(<?=$pid;?>); return 0;">Add to cart<span class="glyphicon glyphicon-shopping-cart"></span> </button>
    <button type="submit" class="btn btn-success" onclick="buyNow(<?=$pid;?>); return 0;">Buy now</button>
  <?php endif; ?>
  </div>
</div>

</div>
</div>

<script>

//to close the model by dismissing current product
function closeModal(){
  jQuery('#details-modal').modal('hide');
  setTimeout(function(){
    jQuery('#details-modal').remove();
  },500);

}

//add to cart
function addToCart(id){
  var qty = jQuery('#quantity').val();
  var size = jQuery('#size').val();
  var data = {"id":id, "qty":qty, "size":size};
  jQuery.ajax({
    url :  '/nullTrolley/includes/addtocart.php',
    method : "post",
    data : data,
    success: function(data){
      jQuery('document').ready(function(){
        jQuery('#errors').html(data);
      });
    //  alert("Product added to cart succesfully");
    },
    error: function(){
      alert("Somthing went wrong!");
    }
  });
}

//add to cart
function buyNow(id){
  var qty = jQuery('#quantity').val();
  var size = jQuery('#size').val();
  var data = {"id":id, "qty":qty, "size":size};
  jQuery.ajax({
    url :  '/nullTrolley/includes/buynow.php',
    method : "post",
    data : data,
    success: function(data){
      jQuery('document').ready(function(){
        jQuery('#errors').html(data);
      });
    //  alert("Product added to cart succesfully");
    },
    error: function(){
      alert("Somthing went wrong!");
    }
  });
}


var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
     dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
  }
  x[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " w3-opacity-off";
}

</script>
<?php echo ob_get_clean(); ?>
