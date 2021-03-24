<?php
  require_once '/opt/lampp/htdocs/nullTrolley/core/init.php';
  if(!is_admin_loged_in()){
    login_error_redirect($_SERVER['REQUEST_URI']);
  }
  require_once 'includes/head.php';
  include_once 'includes/navbar.php';
  /*Queries*/
  $parent_categoryq = "SELECT * FROM categories WHERE parent=0 GROUP BY category";
  $parent_category = $db->query($parent_categoryq);


  $errors = array();

  /*Delete category*/
  if(isset($_GET['delete']) && !empty($_GET['delete'])) {
    $delete_category_id = (int)check_validity($_GET['delete'], "click on delete icon to dalete"); //(int)check_validity($_GET['delet'], "click on trash box to delete");
    $delete_category_q = "DELETE FROM categories WHERE (id='$delete_category_id' OR parent='$delete_category_id')";
    $db->query($delete_category_q);
    header('Location:categories.php');
  }

  //edit category
  if(isset($_GET['edit']) && !empty($_GET['edit'])) {
    $edit_category_id = (int)check_validity($_GET['edit'],"click on edit icon to edit");
    $edit_catogory_q = "SELECT * FROM categories WHERE id='$edit_category_id'";
    $edit_catogory = $db->query($edit_catogory_q);
    $edit_catogory_row =   $edit_catogory->fetch_assoc();



  }

  //form validation
  if(isset($_POST['submit_cotegory']) && !empty($_POST['submit_cotegory'])){

    $parent_id = check_validity($_POST['parent'], "Please select parent category!");
    $catogory_value = check_validity($_POST['category'], "Category cannot left blank!");

    //if exist in db
    $check_catogory_existance_q = "SELECT * FROM categories WHERE category='$catogory_value' AND parent='$parent_id'";
    if(isset($_GET['edit'])){
      $check_catogory_existance_q = "SELECT * FROM categories WHERE category='$catogory_value' AND parent='$parent_id' AND id != $edit_category_id";
    }
    $check_catogory_existance = $db->query($check_catogory_existance_q);
    $category_rows_count = mysqli_num_rows($check_catogory_existance);

    if($category_rows_count > 0){
      $errors[] .= "<b>".$catogory_value."</b>"." already exist in selected parent please enter now one!";
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
    }else{

        //insert category
        $add_category_q = "INSERT INTO categories (category, parent ) VALUES('$catogory_value', '$parent_id')";
        if(isset($_GET['edit'])){
          $add_category_q = "UPDATE categories SET category = '$catogory_value', parent = '$parent_id' WHERE id ='$edit_category_id'";
        }
        $db->query($add_category_q);
        header('Location:categories.php');
        echo "category inserted succesfully";
      }
    }

  $catogory_value_on_edit_or_submit = '';
  $parent_value_on_edit_or_submit = 0;

  if(isset($_GET['edit'])){
    $catogory_value_on_edit_or_submit = $edit_catogory_row['category'];
    $parent_value_on_edit_or_submit = $edit_catogory_row['parent'];
  }elseif($_POST){
    $catogory_value_on_edit_or_submit = $catogory_value;
    $parent_value_on_edit_or_submit = $parent_id;
  }



 ?>

 <div class="container">


   <header class=" text-center w3-container w3-blue-grey w3-card">
     <h2>Categories</h2>
   </header><hr>



   <div class="row">
     <div class="col-md-4">
       <div class="w3-panel w3-card w3-light-grey"><br>
       <form class="form" action="categories.php<?=((isset($_GET['edit']))?'?edit='.$edit_category_id:'');?>" method="post">
         <header class="text-center w3-container w3-blue-grey w3-card"><h2><?=((isset($_GET['edit']))?'Edit':'Add')  ;?> Category</h2></header>
         <div id="errors"></div>

           <table class="table table-borderless w3-container w3-white" style="width:100%">
             <tr>
               <div class="form-group">
                 <td>
                   <label for="parent" id="parent">Parent:</label>
                 </td>
                 <td>
                   <select name="parent" id="parent" class="form-control">
                     <option value="0" <?=(($parent_value_on_edit_or_submit == 0)?'selected="selected"':'');?> <?=((isset($_GET['edit']) && $edit_catogory_row['parent'] !=0 )?'disabled':'');?>>Parent</option>
                     <?php while ($parent_category_rows = $parent_category->fetch_assoc() ): ?>
                       <option value="<?=$parent_category_rows['id'];?>" <?=(($parent_value_on_edit_or_submit == $parent_category_rows['id'])?'selected="selected"':'');?> <?=((isset($_GET['edit']) && $edit_catogory_row['parent']==0 )?'disabled':'');?>><?=$parent_category_rows['category'];?></option>
                     <? endwhile; ?>
                   </select>
                 </td>
              </div>
             </tr>
             <tr>
               <div class="form-group">
                 <td>
                   <label for="category">Category: </label>
                 </td>
                 <td>
                   <input type="text" name="category" value="<?=$catogory_value_on_edit_or_submit ;?>" id="category" class="form-control" placeholder="Add category">
                 </td>
               </div>
             </tr>
           </table>
           <div class="form-group text-center">
            <input type="submit" name="submit_cotegory" value="Add category" class="btn btn-success">
            <?=((isset($_GET['edit']))?'  <a href="categories.php" class="btn btn-warning">Cancel</a>':'')  ;?>

          </div>

        </div>
       </form>

     </div>
     <div class="col-md-8">
       <div class="w3-panel w3-card w3-light-grey"><br>
         <header class="text-center w3-container w3-blue-grey w3-cardr"><h2>List of categories</h2></header><br>
         <div class="w3-container w3-white">
           <div class="w3-panel w3-card w3-light-grey"><br>
       <input class="w3-input w3-border w3-padding" type="text" placeholder="Search for category..." id="categorySearchInput" onkeyup="catogorySerach()">
     <br></div>
       <table class="table  w3-card-4  w3-hoverable w3-borderes  table-condensed" id="categoryTable" >
         <thead>
           <tr class="w3-flat-midnight-blue">

            <th><b>Category</b></th>
            <th><b>Parent</th>
            <th><b>Edit</th>
            <th><b>Delete</b></th>
           </tr>
         </thead>
         <tbody>
           <?php
           $parent_categoryq = "SELECT * FROM categories WHERE parent=0 GROUP BY category";
           $parent_category = $db->query($parent_categoryq);
            while ($parent_category_rows = $parent_category->fetch_assoc() ):
            ?>
             <tr class="w3-green">

               <td><b><?=$parent_category_rows['category']?></b></td>
               <td><b>Parent</b></td>
               <td> <b><a href="categories.php?edit=<?=$parent_category_rows['id'];?>"><font color = "blue"> <span class="glyphicon glyphicon-pencil"></span></font></a></b></td>
               <td> <b><a href="categories.php?delete=<?=$parent_category_rows['id'];?>"> <font color = "red"><span class="glyphicon glyphicon-trash"></span></font></a></b></td>
             </tr>
           <?php
            $parent_id = (int)$parent_category_rows['id'];
            $child_category_q = "SELECT * FROM categories WHERE parent='$parent_id' GROUP BY category ";
            $child_category = $db->query($child_category_q);
            while ($child_category_rows = $child_category->fetch_assoc() ): ?>
             <tr>

               <td><?=$child_category_rows['category'];?></td>
               <td><?=$parent_category_rows['category'];?></td>
               <td> <a href="categories.php?edit=<?=$child_category_rows['id'];?>"><font color = "blue"> <span class="glyphicon glyphicon-pencil"></span></font></a></td>
               <td> <a href="categories.php?delete=<?=$child_category_rows['id'];?>" onclick="return confirm('Are you sure to delete catogory permenetly?')"><font color = "red"> <span class="glyphicon glyphicon-trash"></span></font></a></td>
             </tr>
           <?php endwhile; ?>
         <?php endwhile; ?>

         </tbody>
       </table>
     </div>
   </div>
   </div>
   </div>
 </div>

 <script>
 function catogorySerach() {
   var input, filter, table, tr, td, i;
   input = document.getElementById("categorySearchInput");
   filter = input.value.toUpperCase();
   table = document.getElementById("categoryTable");
   tr = table.getElementsByTagName("tr");
   for (i = 0; i < tr.length; i++) {
     td = tr[i].getElementsByTagName("td")[1];
     if (td) {
       if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
         tr[i].style.display = "";
       } else {
         tr[i].style.display = "none";
       }
     }
   }
 }
 </script>


 <?php
 include_once 'includes/footer.php';
 include_once 'includes/scripts.php';


  ?>
