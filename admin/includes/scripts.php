<script>
function myFunction() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function catogorySerach() {
  var input, filter, table, tr, td, i;
  input = document.getElementById("categorySearchInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("categoryTable");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }
  }
}

function updateSizes(){
   var sizeString = '';
   for (var i = 1; i <= 12; i++) {
    if(jQuery('#size'+i).val() !=''){
      sizeString += jQuery('#size'+i).val() + ':' + jQuery('#quantity'+i).val() + ',';
    }
   }

   jQuery('#size_and_quantity_preview').val(sizeString);
}


function viewDetails(id){

  var data = {"id":id};
  jQuery.ajax({
    url :  '/nullTrolley/admin/includes/ordersdetails.php',
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


</script>
