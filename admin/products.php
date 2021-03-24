<?php
  require_once '/opt/lampp/htdocs/nullTrolley/core/init.php';
  if(!is_admin_loged_in()){
    login_error_redirect($_SERVER['REQUEST_URI']);
  }
  require_once 'includes/head.php';
  include_once 'includes/navbar.php';
  if(isset($_GET['delete']) ){
    $delete_id=(int)sanatize($_GET['delete']);
    //$delete_product_q = "DELETE FROM products WHERE id='$delete_id'";
    $delete_product_q = "UPDATE products SET deleted=1 WHERE id='$delete_id' ";
    if(!$db->query($delete_product_q)){
      die($db->error);
    }
    header('Location:products.php');

  }

  if(isset($_GET['add']) || isset($_GET['edit'])){
    $errors = array();
    $photo = array(); $name = array(); $fileName = array(); $fileExt = array(); $mimeExt=array(); $mimeType = array();
     $path= array(); $tempLoc=array(); $uploadPhotoPath = ''; $uploadPath = array(); $uploadName= array(); $dbPath= array();$dbPhotoPath='';
     $required =array("title", "brand", "parent_category", "child_category", "price","size_and_quantity", "discription");
     $errorTxt = array("Please provide Title","Please choose Brand","Please choose Parent category", "please chhose child catogory", "Please enter Price", "please provide size and quantities", "please provide discription");
     $proFld = array();
    //brands query
    $brands = $db->query("SELECT * FROM brand ORDER BY brand");
    $parent_category = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
    //grab edit id
    if(isset($_GET['edit'])){
      $edit_id = sanatize($_GET['edit']);
      $product_info = $db->query("SELECT * FROM products WHERE id='$edit_id'");
      $product_info_row = $product_info->fetch_assoc();
      $title=$product_info_row['title'];
      $price=$product_info_row['price'];
      $list_price=$product_info_row['list_price'];
      $brand=$product_info_row['brand'];
      $category=$product_info_row['categories'];
      $discription=$product_info_row['description'];

    }
    //size model values remins back
    if ($_POST) {

      if($_POST['size_and_quantity'] != "size not yet selected"){
        $sqString = rtrim(sanatize($_POST['size_and_quantity']), ',');//remove last comma
        $sqString = str_replace(",",":", $sqString );//replace all commas with collons
        $sqArray = explode(':',$sqString);//split it by colons so iven index = size odd index = quantity
      }else {$sqArray = array();}

      $title = check_validity($_POST['title'],"Please provide Title");
      $price = check_validity($_POST['price'],"Please enter Price");
      $list_price = sanatize(trim($_POST['list_price']));
      $brand = check_validity($_POST['brand'],"Please choose Brand");
      $pcategory = check_validity($_POST['parent_category'],"please chhose parent catogory");
      $category = check_validity($_POST['child_category'],"please chhose child catogory");
      $size_and_qty = check_validity($_POST['size_and_quantity'],"please provide size and quantities");
      $description = check_validity($_POST['discription'],"please provide description");

      //file validation
      if(!empty($_FILES)){
        //Set uppload loacation
        if($_POST['parent_category'] !='' &&  $_POST['child_category']!=''){
          $par_id = (int)$_POST['parent_category'];
          $child_id = (int)$_POST['child_category'];
          $category_for_fu = $db->query("SELECT * FROM categories WHERE id IN ($par_id, $child_id)");

          while($category_for_fu_row = $category_for_fu->fetch_assoc()){
            $path[] .= strtolower($category_for_fu_row['category'] );
          }
          $uploadPhotoPath = BASEURL.'images/products/'.$path[0].'/'.$path[1].'/';
          $dbPhotoPath = 'images/products/'.$path[0].'/'.$path[1].'/';
        }
        //for 3 files make validation
          for ($i=0; $i <=2; $i++) {
          $photo[$i] = $_FILES["photo$i"];
          $name[$i] = $photo[$i]["name"];
          //if file is choosen
           if($name[$i] != ''){
             $nameArray = explode('.', $name[$i]);
             $fileName[$i] = $nameArray[0];
             $fileExt[$i] = $nameArray[1];

             $mime = explode('/', $photo[$i]['type']);
             $mimeType[$i] = $mime[0];
             $mimeExt[$i] = $mime[1];

             $tempLoc[$i] = $photo[$i]['tmp_name'];
             $fileSize[$i] = $photo[$i]['size'];

             $allowed = array('png', 'jpg', 'jpeg', 'gif');
             $n=$i+1;
             $uploadName[$i] = md5(microtime()).'.'.$fileExt[$i];
             $dbPath[$i] = $dbPhotoPath.$uploadName[$i];
             $uploadPath[$i] = $uploadPhotoPath.$uploadName[$i];

             if($mimeType[$i] != 'image' ){
               $errors[] .= "Photo $n : must be image";
             }
             if( !in_array(  sizeof($nameArray) == 2 && $fileExt[$i], $allowed)   ){
               $errors[] .= "Photo $n : Only png, jpg, jpeg and gif file extenstions are allowed ";
             }
             if( $fileSize[$i] > 15000000 ){
               $errors[] .= "Photo $n It must be bellow 15MB ";
             }
             /*if( sizeof($mime) == 2  &&  $fileExt[$i] != $mimeExt[$i] && ($mimeExt[$i] == 'jpeg' && $fileExt[$i]=='jpg')  ){
               $errors[] .= "Photo $n File extensions are not matching may be extenstions are forcibaly chanched";
             }*/
           }

        }
        //at least one photo is needed
        if($name[0] =='' && $name[1] =='' && $name[2] ==''){
            $errors[] .= "Please provpide at least one photo of the product";
        }
      }

      //disply errors
      if(!empty($errors)){
        $errors_display =  display_errors($errors);
   ?>
        <script>
        jQuery('document').ready(function(){
          jQuery('#errors').html('<?=$errors_display?>');
        });
        </script>
  <?php
      }
      else{
        //insert data into products

        $insert_product_q = "INSERT INTO products(title,price,list_price,brand,categories,description) VALUES('$title','$price', '$list_price', '$brand','$category','$description')";
        if(isset($_GET['edit'])){
          $insert_product_q = "UPDATE products SET title ='$title', price='$price', list_price='$list_price', brand='$brand', categories='$category', description='$description' WHERE id=$edit_id ";
        }
        $db->query($insert_product_q);
        $last_id = $db->insert_id;

        //uplaod/udate photo and insert photo path into db
        for ($i=0; $i <=2 ; $i++) {
          if($name[$i] != ''){
            move_uploaded_file($tempLoc[$i], $uploadPath[$i]);
            $photo_insert_q = "INSERT INTO pimage(pid, image) VALUES('$last_id', '$dbPath[$i]')";
            if(isset($_GET['edit'])){
              $photo_insert_q = "UPDATE pimage SET image='$dbPath[$i]' WHERE pid=$edit_id"; //......................
            }
            if(!$db->query($photo_insert_q)){
              die($db->error);
            }
          }
        }
        //insert/udate sizes of the product
        for ($i=0; $i < sizeof($sqArray); $i += 2) {
          $n=$i+1;
           $insert_size = "INSERT INTO psize(pid, size, quantity) VALUES('$last_id','$sqArray[$i]', '$sqArray[$n]' )";
           if(isset($_GET['edit'])){
             $insert_size ="UPDATE psize SET size='$sqArray[$i]', quantity='$sqArray[$n]' WHERE pid='$edit_id'"; //....................
           }
           if(!$db->query($insert_size)){
             die($db->error);
           }
        }
        header('Location:products.php');

      }
    }
  ?>
  <div class="container">

    <div class="w3-panel w3-card w3-light-grey"><br>
      <header class=" text-center w3-container w3-blue-grey w3-card">
        <h2><?=((isset($_GET['edit']))?'Edit':'Add A New');?> Product</h2>
      </header>
        <div class="w3-panel w3-card w3-white">
          <div id="errors">

          </div>
          <form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="post" enctype="multipart/form-data">
            <div class="form-group col-md-3">
              <label for="title">Title<font style="color:red">*</font></label>
              <input class="form-control" id="title" type="text" name="title" value="<?=((isset($_POST['title']) || isset($_GET['edit']) )?$title:'');?>" placeholder="Title">
            </div>

            <div class="form-group col-md-3">
              <label for="brand">Brand<font style="color:red">*</font></label>
               <select class="form-control" id="brand" name="brand">
                 <option value="" <?=((isset($_POST['brand']) && $_POST['brand'] == '' )?' Selected':'') ;?>>Select brand</option>
                 <?php while($brands_row = $brands->fetch_assoc()): ?>
                   <option value="<?=$brands_row['id'];?>"<?=((isset($_POST['brand']) && $_POST['brand'] == $brands_row['id'] )?' Selected':'') ;?>><?=$brands_row['brand'];?></option>
                 <? endwhile;?>
               </select>
            </div>

            <div class="form-group col-md-3">
              <label for="parent_category">Parent category<font style="color:red">*</font></label>
               <select class="form-control" id="parent_category" name="parent_category">
                 <option value="" <?=((isset($_POST['parent_category']) && $_POST['parent_category'] == '' )?' Selected':'') ;?>>Select parent category</option>
                 <?php while($parent_category_row = $parent_category->fetch_assoc()): ?>
                   <option value="<?=$parent_category_row['id'];?>"<?=((isset($_POST['parent_category']) && $_POST['parent_category'] == $parent_category_row['id'] )?' Selected':'') ;?>><?=$parent_category_row['category'];?></option>
                 <? endwhile;?>
               </select>
            </div>

            <div class="form-group col-md-3">
              <label for="child_category">Child category<font style="color:red">*</font></label>
               <select class="form-control" id="child_category" name="child_category">
                 <option value="" <?=((isset($_POST['child_category']) && $_POST['child_category'] == "" )?' Selected':'') ;?>>Select child category</option>
               </select>
            </div>

            <div class="form-group col-md-3">
              <label for="price">Price<font style="color:red">*</font></label>
              <input class="form-control" id="price" type="text" name="price" value="<?=((isset($_POST['price']) || isset($_GET['edit']) )?$price:'');?>" placeholder="Price">
            </div>

            <div class="form-group col-md-3">
              <label for="list_price">List price</label>
              <input class="form-control" id="list_price" type="text" name="list_price" value="<?=((isset($_POST['list_price']) || isset($_GET['edit']) )?$list_price:'');?>" placeholder="List price">
            </div>

            <div class="form-group col-md-3">
              <label for="size_and_quantities">Size and Quantity<font style="color:red">*</font></label>
               <button id="size_and_quantities" class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle'); return false;">Size and Quantity</button>
            </div>

            <div class="form-group col-md-3">
              <label for="size_and_quantity_preview">Size and Quantity preview</label>
              <input id="size_and_quantity_preview" class="form-control" type="text" name="size_and_quantity" value="<?=((isset($_POST['size_and_quantity']))?$_POST['size_and_quantity']:'size not yet selected');?>" readonly>
            </div>

            <div class="form-group col-md-6">
              <label for="photos">Product Photos</label>
              <table>
                <tr>
                  <td>Photo 1:</td><td><input type="file" name="photo0" class="form-contol"  id="photos" value=""></td>
                </tr>
                <tr>
                  <td>Photo 2:</td><td><input type="file" name="photo1" class="form-contol"  id="photos"  value=""></td>
                </tr>
                <tr>
                  <td>Photo 3:</td><td><input type="file" name="photo2" class="form-contol"  id="photos"  value=""></td>
                </tr>
              </table>

            </div>


            <div class="form-group col-md-6">
              <label for="discription">Discription<font style="color:red">*</font></label>
              <textarea id="discription" class="form-control"   name="discription" value="" rows="3" placeholder="Some discription about product" ><?=((isset($_POST['discription']) || isset($_GET['edit']) )?$discription:'');?></textarea>
            </div>
            <div class="col-md-10">
                <a href="products.php" class="btn btn-warning pull-right">Cancel</a>
            </div>
            <div class="col-md-2" >
                <input class="btn btn-success pull-left" type="submit" name="add_product" value="<?=((isset($_GET['edit']))?'Edit':'Add');?> Product">
            </div>


          </form><hr>

        </div>

    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade " id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <h4 class="modal-title" id="sizesModalLabel">Sizes and Quantity </h4>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <?php for ($i=1; $i <=12 ; $i++): ?>
              <div class="form-group col-md-3">
                <label for="size<?=$i;?>">Size</label>
                <input class="form-control" id="size<?=$i;?>" type="text" name="size<?=$i;?>" value="<?=((!empty($sqArray[2*($i-1)]))?$sqArray[2*($i-1)]:'');?>" >
              </div>
              <div class="form-group col-md-3">
                <label for="quantity<?=$i;?>">Quantity</label>
                <input class="form-control" id="quantity<?=$i;?>" type="number" name="quantity<?=$i;?>" value="<?=((!empty($sqArray[(2*($i-1))+1]))?$sqArray[(2*($i-1))+1]:'');?>"  min="0">
              </div>
            <?php endfor; ?>
          </div>
         </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success" onclick="updateSizes(); jQuery('#sizesModal').modal('toggle'); return false;">Save changes</button>
        </div>
      </div>
    </div>
  </div>
<!--model ends-->
  <?php
  }else{

  /*Queries*/
  $products_q = "SELECT * FROM products WHERE deleted = 0";
  $products = $db->query($products_q);

  /*add and remove from featured*/
  if(isset($_GET['featured']) && isset($_GET['product_id'])){
    $featured_value = $_GET['featured'];
    $featured_product_id = $_GET['product_id'];

    $update_featured_q = "UPDATE products set featured = '$featured_value' WHERE id='$featured_product_id'";
    $db->query($update_featured_q);
    header('Location:products.php');

  }


?>

<div class="container">
  <a class="btn btn-lg btn-success pull-right" href="products.php?add=1">Add Product</a><br><br>

  <div class="w3-panel w3-card w3-light-grey"><br>
    <header class="text-center w3-container w3-blue-grey w3-cardr"><h2>List of Products</h2></header><br>
    <div class="w3-container w3-white"><br>
      <table class="table  w3-card-4  w3-hoverable w3-borderes  table-condensed">
        <thead class="w3-green">
          <th>Edit</th><th>Remove</th><th>Products</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th><th>Stock</th>
        </thead>
        <?php while ($products_row = $products->fetch_assoc()  ):
          $child_category_id =$products_row['categories'];
          $child_category_q = "SELECT * FROM categories WHERE id='$child_category_id'";
          $child_category = $db->query($child_category_q);
          $child_category_row = $child_category->fetch_assoc();

          $parent_category_id =$child_category_row['parent'];
          $parent_category_q = "SELECT * FROM categories WHERE id='$parent_category_id'";
          $parent_category = $db->query($parent_category_q);
          $parent_category_row = $parent_category->fetch_assoc();
          $pid=$products_row['id'];
          $psold = $db->query("SELECT SUM(quantity) FROM porder WHERE pid='$pid' AND (status='Delivered' OR status='Return requested' )")->fetch_assoc();
          $pstock = $db->query("SELECT SUM(quantity) FROM psize WHERE pid='$pid' ")->fetch_assoc();
           ?>
          <tr class="<?=(($pstock['SUM(quantity)']==0)?'alert-danger':(($pstock['SUM(quantity)']<=10)?'alert-success':''));?>">
            <td><a href="products.php?edit=<?=$products_row['id'] ;?>"><font color = "blue"> <span class="glyphicon glyphicon-pencil"></span></font></a></td>
            <td><a href="products.php?delete=<?=$products_row['id'] ;?>" onclick="return confirm('Are you sure to move product to tarsh?')"><font color = "red"> <span class="glyphicon glyphicon-trash"></span></font></a></td>
            <td><?=$products_row['title'] ;?></td>
            <td><?=money($products_row['price'] );?></td>
            <td><?=$parent_category_row['category']." ~ ".$child_category_row['category'] ;?></td>
            <td> <a class="btn btn-default" href="products.php?featured=<?=(($products_row['featured']==0)?'1':'0') ;?>&product_id=<?=$products_row['id'];?>">
            <span class="glyphicon glyphicon-<?=(($products_row['featured']==1)?'minus':'plus') ;?> "></span></a><?=(($products_row['featured']==0)?'':' Featured product') ;?></td>
            <td><?=(($psold['SUM(quantity)']>0)?$psold['SUM(quantity)']:'0');?></td>
            <td><?=(($pstock['SUM(quantity)']>0)?$pstock['SUM(quantity)']:'0');?></td>

          </tr>

        <?php endwhile; ?>
      </table>
    </div>
    <br>
  </div>
</div>

<?php
}//else part of isset[$_GET['add']] ends here

include_once 'includes/footer.php';
include_once 'includes/scripts.php';

 ?>
