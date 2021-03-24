<div class="w3-container">
  <div class="w3-content" style="max-width:1200px ">

    <?php while( $piamgerow = $pimage->fetch_assoc()): ?>
      <img class="mySlides" src=<?= $piamgerow['image'];?>  alt="product image"  style="width:100%; height:200px;"/>
    <?php endwhile; ?>

    <div class="w3-row-padding w3-section">

      <?php $n=1;
      $pimageq1 = "SELECT * FROM pimage WHERE pid = '$pid' ";
      $pimage1 = $db->query($pimageq1);
       while( $piamgerow1 = $pimage1->fetch_assoc()): ?>
      <div class="w3-col s4">
        <img class="demo w3-opacity w3-hover-opacity-off" src=<?= $piamgerow1['image'];?> style="width:100%;" onmouseover="currentDiv(<?= $n++; ?>)">
      </div>
       <?php endwhile; ?>

    </div>
  </div>
</div>
