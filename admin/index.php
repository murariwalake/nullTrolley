<?php
  require_once '/opt/lampp/htdocs/nullTrolley/core/init.php';
  if(!is_admin_loged_in()){
    login_error_redirect($_SERVER['REQUEST_URI']);
  }
  require_once 'includes/head.php';
  include_once 'includes/navbar.php';
  $errors = array();
  $fdate='';
  $tdate='';
  //form validtion for sorting
  $sold_products=$db->query("SELECT SUM(o.quantity), o.id AS 'oid', o.pid AS 'pid', p.title AS 'ptitle',
  o.odate AS 'odate', o.status AS 'status'
  FROM porder as o, products as p
  WHERE o.pid= p.id AND (o.status='Delivered' OR o.status='Return requested')
  group by pid  ORDER BY 	o.odate DESC");
  if($_POST){
    $fdate=check_validity($_POST['fdate'], "Please fill \"from\" field");
    $tdate=check_validity($_POST['tdate'], "Please fill \"To\" field");
    if(!isValidDate($fdate) || !isValidDate($fdate)){
      $errors[] .="Please enter the date in proper format(YYYY-MM-DD)";
  }

    if(!empty($errors)){
      echo display_errors($errors);
    }else {
      $sold_products=$db->query("SELECT SUM(o.quantity), o.id AS 'oid', o.pid AS 'pid', p.title AS 'ptitle',
      o.odate AS 'odate', o.status AS 'status' FROM porder as o, products as p
      WHERE o.pid= p.id AND (o.status='Delivered' OR o.status='Return requested')
      AND  o.odate >= '$fdate' AND o.odate <='$tdate' group by pid ORDER BY o.odate DESC ");

    }
  }
 ?>

  <div class="container">
    <div class="col-sm-6">
    <div class="w3-panel w3-card w3-light-grey">
      <header class="text-center w3-container w3-blue-grey w3-cardr"><h4>Filter by sold date</h4></header>
      <div class="w3-container w3-white">
        <form  action="index.php" method="post">
          <div class="col-sm-5">
              <div class="form-group">
                <label for="fdate">From</label>
                <input type="date" id="fdate" name="fdate" class="form-control" value="<?=$fdate;?>" placeholder="YYYY-MM-DD" >
              </div>
          </div>
          <div class="col-sm-5">
              <div class="form-group">
                <label for="tdate">To</label>
                <input type="date" id="tdate" name="tdate" class="form-control" value="<?=$tdate;?>" placeholder="YYYY-MM-DD" >
              </div>
          </div>
          <div class="col-sm-2"><br>
            <input type="submit" name="date" class="btn btn-success" value="Apply">
          </div>
      </form>
    </div><br>
  </div>
</div>
  </div>
  <div class="container">

    <div class="w3-panel w3-card w3-light-grey">
      <br>
      <header class="text-center w3-container w3-blue-grey w3-cardr"><h2>List of sold products</h2></header><br>
      <div class="w3-container w3-white"><br>
        <table class="table  w3-card-4  w3-hoverable w3-borderes  table-condensed">
          <thead class="w3-green">
            <th>Photo</th><th>Title</th><th>Sold date</th><th>Sold</th>
          </thead>
          <?php while ($sold_product = $sold_products->fetch_assoc()  ):
            $pid =$sold_product['pid'];
            $oid =$sold_product['oid'];
            $pimage =$db->query("SELECT * FROM pimage WHERE pid='$pid'")->fetch_assoc();
            $pcount = $db->query("SELECT SUM(quantity) FROM porder WHERE pid='$pid' AND (status='Delivered' OR status='Return requested') ")->fetch_assoc();
          ?>
            <tr>
              <td><img src="<?="../".$pimage['image'];?>" alt="<?=$sold_product['ptitle'];?>"  width="40px"></td>
              <td><?=$sold_product['ptitle'];?></td>
              <td><?=$sold_product['odate'];?></td>
              <td><?=$pcount['SUM(quantity)'] ;?></td>
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
