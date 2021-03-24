<nav class="navbar navbar-inverse navbar-fixed-top" >
  <div class="container-fluid">
    <div class="navbar-header">
      <a class="navbar-brand" href="/nullTrolley/admin/index.php"> <font color = "#ff3300"><b>nullTrolley Admin</b></font> </a>
    </div>
    <ul class="nav navbar-nav">
      <li><a href="orders.php"><font color = "#ccffff"><b>Orders</b></font></a></li>
      <li><a href="returns.php"><font color = "#ccffff"><b>Returns</b></font></a></li>
      <li><a href="brands.php"><font color = "#ccffff"><b>Brands</b></font></a></li>
      <li><a href="categories.php"><font color = "#ccffff"><b>Category</b></font></a></li>
      <li><a href="products.php"><font color = "#ccffff"><b>Products</b></font></a></li>
      <li><a href="trash.php"><font color = "#ccffff"><b>Trash</b></font></a></li>


    </ul>
    <ul class="nav navbar-nav navbar-right">
      <li><font color = "#ccffff"> <h4>Hello <?=$user['fname'];?></h4> </font></li>
      <li><a href="http://<?=$host_name;?>/nullTrolley/logout.php"><font color = "#ccffff">Log out<span class="glyphicon glyphicon-log-out"></span></font></a></li>
    </ul>

    </div>
  </nav>
  <!-- these bellow line breakes are because navigation bar two lines are goin bellow the navigation bar -->
  <br><br><br>
