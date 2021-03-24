<div class="w3-container">
  <div class="w3-content" style="max-width:1200px ">

    <?php while( $piamgerow = $pimage->fetch_assoc()): ?>
      <img class="mySlides" src=<?= "../".$piamgerow['image'];?>  alt="product image"  style="width:100%; ;"/>
    <?php endwhile; ?>

    <div class="w3-row-padding w3-section">

      <?php $n=1;
      $pimageq1 = "SELECT * FROM pimage WHERE pid = '$pid' ";
      $pimage1 = $db->query($pimageq1);
       while( $piamgerow1 = $pimage1->fetch_assoc()): ?>
      <div class="w3-col s4">
        <img class="demo w3-opacity w3-hover-opacity-off" src=<?= "../".$piamgerow1['image'];?> style="width:40%; " onmouseover="currentDiv(<?= $n++; ?>) ">
      </div>
       <?php endwhile; ?>

    </div>
  </div>
</div>

<script type="text/javascript">

var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function currentDiv(n) {
  showDivs(slideIndex = n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  if (n > x.length) {slideIndex = 1}
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
     dots[i].className = dots[i].className.replace(" w3-opacity-off", "");
  }
  x[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " w3-opacity-off";
}

</script>
