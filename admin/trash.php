<?php
  require_once '/opt/lampp/htdocs/nullTrolley/core/init.php';
  if(!is_admin_loged_in()){
    login_error_redirect($_SERVER['REQUEST_URI']);
  }
  require_once 'includes/head.php';
  include_once 'includes/navbar.php';
  $products_q = "SELECT * FROM products WHERE deleted = 1";
  $products = $db->query($products_q);

  //restore
  if(isset($_GET['restore'])){
    $restore_id =  (int)sanatize($_GET['restore']);
    $restore_q = "UPDATE products SET featured='0', deleted='0' WHERE id = $restore_id";
    if(!$db->query($restore_q)){
      die($db->error);
    }
    header('Location:trash.php');
  }
  //delete product permenetly
  if(isset($_GET['delete'])){
    $delete_id =  (int)sanatize($_GET['delete']);
    $delete_q = "DELETE FROM products WHERE id=$delete_id";
    if(!$db->query($delete_q)){
      die($db->error);
    }
    header('Location:trash.php');
  }

?>

<div class="container">

  <div class="w3-panel w3-card w3-light-grey"><br>
    <header class="text-center w3-container w3-blue-grey w3-cardr"><h2>List of Archived Products</h2></header><br>
    <div class="w3-container w3-white"><br>
      <table class="table  w3-card-4  w3-hoverable w3-borderes  table-condensed">
        <thead class="w3-green">
          <th>Restore</th><th>Delete</th><th>Products</th><th>Price</th><th>Category</th><th>Sold</th>
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

           ?>
          <tr>
            <td><a href="trash.php?restore=<?=$products_row['id'] ;?>"><font color = "blue"> <span class="glyphicon glyphicon-refresh"></span></font></a></td>
            <td><a href="trash.php?delete=<?=$products_row['id'] ;?>" onclick="return confirm('Are you sure to delete product permenently?')"><font color = "red"> <span class="glyphicon glyphicon-trash"></span></font></a></td>
            <td><?=$products_row['title'] ;?></td>
            <td><?=money($products_row['price'] );?></td>
            <td><?=$parent_category_row['category']." ~ ".$child_category_row['category'] ;?></td>
            <td>0</td>

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
