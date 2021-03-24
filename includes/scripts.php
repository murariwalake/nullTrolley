<!--script for offer photos -->
<script>
function detailsmodal(id){

  var data = {"id":id};
  jQuery.ajax({
    url :  '/nullTrolley/includes/models.php',
    method : "post",
    data : data,

    success: function(data){
      jQuery('body').append(data);
      jQuery('#details-modal').modal('toggle');
    },
    error: function(){
      alert("Somthing went wrong!");
    }
  });
}

//order details
function orderDetails(id){

  var data = {"id":id};
  jQuery.ajax({
    url :  '/nullTrolley/includes/orderdetails.php',
    method : "post",
    data : data,

    success: function(data){
      jQuery('body').append(data);
      jQuery('#details-modal').modal('toggle');
    },
    error: function(){
      alert("Somthing went wrong!");
    }
  });
}


function passHideVisible() {
    var x = document.getElementById("myInput");
    if (x.type === "password") {
        x.type = "text";
    } else {
        x.type = "password";
    }
}


$(".toggle-password").click(function() {

  $(this).toggleClass("glyphicon-eye-close glyphicon-eye ");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

$(".toggle-password2").click(function() {

  $(this).toggleClass("glyphicon-eye-close glyphicon-eye ");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

function changeContent(from, to) {
  document.getElementById(to).innerHtml = to//document.getElementById(from).innerHtml
  alert("hey");
}

</script>


<!--script end -->
 </body>
</html>
