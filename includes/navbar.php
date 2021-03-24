<?php
  $sql1 = "SELECT * FROM categories WHERE parent = 0" ; //select main catogoreis like men women etc
  $parentq = $db->query($sql1); //execute the query

?>

<nav class="navbar navbar-inverse navbar-fixed-top" >
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="index.php"> <font color = "#ff3300"><b>nullTrolley <span class="glyphicon glyphicon-home"></span></b></font> </a>
    </div>
    <ul class="nav navbar-nav">
      <?php
      /*fetch main catogories */
        while ($parent = $parentq->fetch_assoc() ):
      ?>
      <?php
        $paarentid = $parent['id'];
        /*fetch main subcatogories*/
        $sql2 = "SELECT * FROM categories WHERE parent = '$paarentid'" ;
        $childq = $db->query($sql2);
      ?>

        <li class="dropdown">
          <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <font color = "#ccffff"> <?php echo $parent['category']; ?></font>
            <span class="caret"></span></a>
            <ul class="dropdown-menu">

              <?php
                while($child = $childq->fetch_assoc()):
              ?>
              <li><a href="category.php?pid=<?=$child['id'];?>">  <font color = "#0000ff"> <?php echo $child['category']; ?></font> </a></li>
              <?php endwhile; ?>

            </ul>
          </li>
        <?php endwhile; ?>

      </ul>

      <ul class="nav navbar-nav navbar-right">
        <?php if(!is_loged_in()): ?>
        <li><a href="signup.php"><font color = "#ccffff"> Sign Up <span class="glyphicon glyphicon-user"></span> </font></a></li>
        <li><a href="login.php"> <font color = "#ccffff"> Login <span class="glyphicon glyphicon-log-in"></span> </font></a></li>
        <?php endif; ?>
        <?php if(is_loged_in()):
          //calculate cart product
          $total_cart_amount = $db->query("SELECT SUM(p.price) FROM cart as c, products as p WHERE p.id=c.p_id AND c.u_id='$user_id'")->fetch_assoc();
          ?>

        <li><a href="cart.php" class="w3-text-white"><span class="glyphicon glyphicon-shopping-cart"><?=$total_cart_amount['SUM(p.price)'];?></span></a></li>

        <li><a href="account.php?profile=1" class="w3-text-white"> Hello <?=$user['fname'];?></a></li>
        <li><a href="logout.php"><font color = "#ccffff">  Log out<span class="glyphicon glyphicon-log-out"></span></font></a></li>

        <?php endif; ?>
      </ul>
    </div>
  </nav>
