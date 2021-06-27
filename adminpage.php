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

<div class="mainbody">
<?php
        require_once "components/performsection.php";
    ?>
    <h4 style="color:green; font-size:2vw;"><?php
        session_start();
        if (isset($_SESSION['success'])) {
            echo $_SESSION['success'];
            unset($_SESSION['success']);
        }
    ?></h4>
       
        <?php
        require_once "components/datatable.php";
    ?>
</div>
<div id="result"></div>


<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
   
<script type="text/javascript">


    $(document).ready(function(){

// Delete 
$('.deleteButton').click(function(){
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
       // Remove row from HTML Table
       $(el).closest('tr').css('background','tomato');
       $(el).closest('tr').fadeOut(800,function(){

          $(this).remove();
       });
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
        $('#result').html(response);
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
        $('#result').html(response);
        
       }
     });

     
});

});


</script>
</body>
</html>