<?php
  require_once '/opt/lampp/htdocs/nullTrolley/core/init.php';
  $parent_category_id = (int)$_POST['parentID'];
  $child_categories = $db->query("SELECT * FROM categories WHERE parent = '$parent_category_id' ORDER BY category");
 ob_start();
 ?>
 
 <?php while($child_categories_row = $child_categories->fetch_assoc()): ?>
    <option value="<?=$child_categories_row['id'];?>" <?=((isset($_POST['child_category']) && $_POST['child_category'] == $child_categories_row['id'] )?' Selected':'') ;?>><?=$child_categories_row['category'];?></option>
 <?php endwhile;?>

 <?php echo ob_get_clean();  ?>
