<?php
 require_once '/opt/lampp/htdocs/nullTrolley/core/init.php';

 $oid = $_POST['id'];
 $oid = (int)$oid;
/*sselsec products*/
  $user_orders = $db->query("SELECT * FROM porder WHERE id='$oid'")->fetch_assoc();
  $pid=$user_orders['pid'];
  $uid=$user_orders['uid'];
  $user = $db->query("SELECT * FROM user WHERE id='$uid'")->fetch_assoc();
  //print_r($user_orders);
  $product_info = $db->query("SELECT * FROM products WHERE id = '$pid'")->fetch_assoc();
  //fetch image
  $pimage=$db->query("SELECT * FROM pimage WHERE pid='$pid'");
  $pimage2=$db->query("SELECT * FROM pimage WHERE pid='$pid'")->fetch_assoc();
  $pimage1=$db->query("SELECT * FROM pimage WHERE pid='$pid'");
  /*find brand of that produt*/
   $pbrandid = $product_info['brand'];
   $pbrand = $db->query("SELECT * FROM brand WHERE id = '$pbrandid'")->fetch_assoc();


?>

<?php ob_start(); ?>
<!-- Modal -->
<div id="details-modal" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">

<!-- Modal content-->
<div class="modal-content">
  <div class="modal-header">
    <div id="errors">

    </div>
    <h3 class="modal-title text-center"><b> <?=  $product_info['title'];?></b></h3>
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

        <div class="col-lg-5">
          <table class="table   w3-hoverable  w3-borderes">
            <thead><b class="w3-green">Order details details</b></thead>
            <tr><td><b>OdredID:</b></td><td><?=$user_orders['id']?></td></tr>
            <tr><td><b>Status:</b></td><td><?=$user_orders['status']?></td></tr>
            <tr><td><b>Brand:</b></td><td><?= $pbrand['brand']; ?></td></tr>
            <tr><td><b>Size:</b></td><td><?= $user_orders['size']; ?></td></tr>
            <tr><td><b>Amount:</b></td><td><?=money($user_orders['amount']);?></td></tr>
            <tr><td><b>Payment:</b></td><td><?=$user_orders['payment']?></td></tr>
            <tr><td><b>Ordered date:</b></td><td><?=$user_orders['odate']?></td></tr>
            <tr><td><b >Description:</b></td><td><?= $product_info['description'];?></td></tr>
          </table>
          <table class="table   w3-hoverable  w3-borderes">
            <thead><b class="w3-green">User contact details</b></thead>
            <tr><td><b>Name:</b></td><td><?= $user['name'];?></td></tr>
            <tr><td><b>Mobile:</b></td><td><?= $user['mobile'];?></td></tr>
            <tr><td><b>Address:</b></td><td><?= $user['address'];?></td></tr>
            <tr><td><b>Zip:</b></td><td><?= $user['zip'];?></td></tr>
          </table>

         </div>
      </div>
    </div>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-warning" onclick="closeModal()">Close</button>
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
function cancelProduct(id){

  var data = {"id":id};
  jQuery.ajax({
    url :  '/nullTrolley/includes/cancelproduct.php',
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



function returnProduct(id){

  var data = {"id":id};
  jQuery.ajax({
    url :  '/nullTrolley/includes/returnproduct.php',
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
