<div class="contents">
  <div class="container-fluid">
    <div class="col-md-2">

      <?php
      $selected_brands = '';
      if(isset($_POST['submitfilter'])){
        $filter_price =(isset($_POST['filter_price'])?$_POST['filter_price']:'');
        $total_brands=$db->query("SELECT COUNT(id) FROM brand")->fetch_assoc();
        for ($i=1; $i <= $total_brands['COUNT(id)'] ; $i++) {
          //echo $_POST['brand'.$i] ;
          if(isset($_POST['brand'.$i])){
            $selected_brands = $selected_brands.$_POST['brand'.$i].", ";
          }
        }

        $selected_brands= rtrim($selected_brands, ', ');//is needed fter the comma operator

        if($selected_brands!='' && $filter_price!=''){
          $product = $db->query("SELECT * FROM products WHERE deleted!=1 AND brand IN(".$selected_brands.") ORDER BY price ".$filter_price." ");
        }elseif ($selected_brands=='' && $filter_price!='') {
          $product = $db->query("SELECT * FROM products WHERE deleted!=1 ORDER BY price ".$filter_price);
        }elseif ($selected_brands!='' && $filter_price=='') {
          $product = $db->query("SELECT * FROM products WHERE deleted!=1 AND brand IN(".$selected_brands.") ");
        }



      }

       ?>

      <div class="container">
        <div class="col-sm-2">
          <div class="w3-panel w3-card w3-light-grey">
          <header class="text-center w3-container w3-blue-grey w3-cardr"><h4>Filter by</h4></header>
            <div class="w3-container w3-white">
              <form  action="index.php" method="post">
                <b>Price</b>
                <input type="submit" class="btn btn-success" name="submitfilter" value="Apply">
              <div class="radio">
                <label><input type="radio" name="filter_price" value="ASC" <?=((isset($_POST['filter_price']) && $_POST['filter_price']=="ASC")?'checked':'');?>>Low-high</label>
              </div>
              <div class="radio">
                <label><input type="radio" name="filter_price" value="DESC" <?=((isset($_POST['filter_price']) && $_POST['filter_price']=="DESC")?'checked':'');?> >Hihg-low</label>
              </div>
              <?php
                //grab brands
                $brands = $db->query("SELECT * FROM brand");
               ?>

                <b>Brands</b>
                <?php $i=1; while($brand = $brands->fetch_assoc()): ?>
                <div class="checkbox">
                  <label><input type="checkbox" value="<?=$brand['id'];?>" name="<?="brand".$i;?>" <?=((isset($_POST["brand".$i]))?'checked':'');?> ><?=$brand['brand'];?></label>
                </div>
                <?php $i++; endwhile; ?>
              </form>
          </div><br>
         </div>
      </div>
    </div>
  </div>
