<?php
  require_once '/opt/lampp/htdocs/nullTrolley/core/init.php';
  if(!is_admin_loged_in()){
    login_error_redirect($_SERVER['REQUEST_URI']);
  }
  require_once 'includes/head.php';
  include_once 'includes/navbar.php';
  /*query to fetch brand table data*/
  $brandq="SELECT * FROM brand group by brand";
  $brand=$db->query($brandq);

  /*delete brand from bran table*/
  if(isset($_GET['delete']) && !empty($_GET['delete'])){
    $delete_brand_id = (int)sanatize($_GET['delete']);
    $delete_brand_q = "DELETE FROM brand WHERE id = '$delete_brand_id'";
    $db->query($delete_brand_q);
    header('Location: brands.php');
  }

  /*edit brand from bran table*/
  if(isset($_GET['edit']) && !empty($_GET['edit'])){
    $edit_brand_id = (int)sanatize($_GET['edit']);
    $edit_brand_q = "SELECT * FROM brand WHERE id='$edit_brand_id'";
    $edit_brand = $db->query($edit_brand_q);
    $edit_brand_row = $edit_brand->fetch_assoc();
    $edit_brand = $edit_brand_row['brand'];



  }

  /*array for errors*/
   $errors = array();

  /*check all possible errors while adding the brand*/
  /*if add button is submitted*/
  if(isset($_POST['submit_brand'])){
    /*defined in helpers.php*/
    $brandname = check_validity($_POST['brand'], "You must enter a brand!");


    //check if brand is already exit in db
    $existbrandq = "SELECT * FROM brand WHERE brand='$brandname'";
    if(isset($_GET['edit'])){
      $existbrandq = "SELECT * FROM brand WHERE brand='$brandname' AND id != '$edit_brand_id'";
    }
    $existbrand = $db->query($existbrandq);
    $bcount = mysqli_num_rows($existbrand);

    if($bcount > 0){
      //if brand exist then display error msg
      $errors[] .= "<b>".$brandname."</b> brand is already exist please enter some other brand";
    }

    //pass the error array to helpers/helpers.php
    if(!empty($errors)){
      $errors_display = display_errors($errors);//defined in helpers.php
      ?>
           <script>
           jQuery('document').ready(function(){
             jQuery('#errors').html('<?=$errors_display?>');
           });
           </script>
     <?php
    }
    else{
      $insertbrandq = "INSERT INTO brand (brand) VALUES('$brandname')";
      if(isset($_GET['edit'])){
        $insertbrandq = "UPDATE brand SET brand = '$brandname' WHERE id = '$edit_brand_id'";
      }
      $db->query($insertbrandq);
      header('Location: brands.php');

      //add brand
    }
  }
 ?>
  <div class="w3-container">
    <div class="container">
      <header class=" text-center w3-container w3-blue-grey w3-card">
        <h2>Brands</h2>
      </header>
    </div><hr>
    <div class="row">
      <div class="col-md-3">

      </div>

    <div class="col-md-6">
      <div id="errors">

      </div>

    <div class="text-center">
      <div class="w3-panel w3-card w3-light-grey">
    <form class="form-inline" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_brand_id:'');?>" method="post">
      <div class="form-group ">
        <?php
          $brand_value = '';
          if(isset($_GET['edit'])){
            $brand_value = $edit_brand_row['brand'];
          }
          else{
            if(isset($_POST['brand']))
              $brand_value=sanatize($_POST['brand']);
          }
        ?>
        <label for="brand"><h3><?=((isset($_GET['edit']))?'Edit ':'Add ');?>brand: </h3></label>
        <input type="text" class="form-control" id="brand" placeholder="New brand" name="brand" value="<?=$brand_value; ?>">
        <input type="submit" name="submit_brand" value="<?=((isset($_GET['edit']))?'Edit ':'Add ');?> brand" class="btn btn-success">
        <?php if(isset($_GET['edit'])):?>
          <a href="brands.php" class="btn btn-warning">Cancel</a>
        <?php endif; ?>
      </div>
    </form>
  </div>
</div>
<div class="w3-panel w3-card w3-light-grey"><br>
  <div class="w3-container w3-white">
  <div class="w3-panel w3-card w3-light-grey"><br>

  <input class="w3-input w3-border w3-padding" type="text" placeholder="Search for brands.." id="myInput" onkeyup="myFunction()">
  <br>
</div>
   <table class="table w3-striped w3-card-4  w3-hoverable w3-borderes  table-condensed" id="myTable">
     <thead >
       <tr class="w3-green">
         <th></th>
         <th>Brands</th>
         <th>Edit</th>
         <th>Delete</th>
       </tr>
     </thead>
     <tbody>
       <?php while($brandrow=$brand->fetch_assoc()): ?>
       <tr>
         <th></th>

         <td class="text-left"><?=$brandrow['brand']?></td>
         <td><a href="brands.php?edit=<?=$brandrow['id']?>" ><font color = "blue"><span class="glyphicon glyphicon-pencil"></span></font></a></td>
         <td><a href="brands.php?delete=<?=$brandrow['id']?>" onclick="return confirm('Are you sure to delete brand permenently?')"><font color = "red"><span class="glyphicon glyphicon-trash"></span></font></a></td>
       </tr>
     <?php endwhile; ?>
     </tbody>
   </table>
     </div>
   </div>
   </div>
     <div class="col-md-3">

     </div>
   </div>
</div>





 <?php
 include_once 'includes/footer.php';
 include_once 'includes/scripts.php';

  ?>
