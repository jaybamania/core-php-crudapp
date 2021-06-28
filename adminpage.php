<?php
$my_header = 'Admin Panel';
include "include/header.php";
require "include/connect.php";
?>
<?php
require "include/connect.php";

include "classes/operations.php";
include "include/pagination.php";
use Ops as O;
$getData = new O\GetData();
$userData = $getData->getAllMembers($conn);
if($userData){
$totalRows = count($userData);
$totalPages = ceil($totalRows / $noOfRecordsPerPage);
}
$paginationData = $getData->getAllData($conn,$offset,$noOfRecordsPerPage);

?>
<div id="results"></div>
<div class="mainbody">
<?php
        require_once "components/performsection.php";
    ?>
    <div class="statusMsg"></div>
       
        <?php
        require_once "components/datatable.php";
    ?>
</div>



<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
   
<script type="text/javascript">


    $(document).ready(function(
      e){
     

// Delete 
$('.deleteButton').click(function(e){
  var el = this;
  // Delete id
  var deleteid = $(this).data('id');
  var serialid = $(this).data('i');
  var confirmalert = confirm("Are you sure?");
  if (confirmalert == true) {
     // AJAX Request
     $.ajax({
       url: 'delete.php',
       type: 'POST',
       data: { id:deleteid, i:serialid },
       success: function(response){
        console.log(response)
        if(response !== ""){
          $('.statusMsg').html('<p class="alert alert-success">Deleted Successfully</p>');
       // Remove row from HTML Table
       $(el).closest('tr').css('background','tomato');
       $(el).closest('tr').fadeOut(300,function(){
          $(this).remove();
       });
       $('.statusMsg').fadeOut(3000);
         }else{
       alert('Invalid ID.');
         }

       }
     });
  }

});

//Edit
$('.editButton').click(function(){
  var el = this;
 // Edit id
 var editid = $(this).data('id');
  var serialid = $(this).data('i');
  console.log(editid);
  console.log(serialid);

     $.ajax({
       url: "edit.php?id="+editid,
       success: function(response){
        console.log(response)
        $('.mainbody').hide();
        $('.heading').hide();
        history.pushState({},'',"edit.php?id="+editid);
        $('#results').html(response);
       }
     });

     
});

//Add
$('.addButton').click(function(){

     // AJAX Request
     $.ajax({
       url: 'add.php',
       success: function(response){
        $('.mainbody').hide();
        $('.heading').hide();
        history.pushState({},'',"add.php");
        $('#results').html(response);
        
       }
     });

     
});

});


</script>
</body>
</html>