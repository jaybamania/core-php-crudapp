
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
print_r($paginationData);
?>

<div class="mainbody">

       
        <?php
        require_once "components/datatable.php";
    ?>
</div>


<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
   
<script type="text/javascript"> 
//     $(function(){ 
//       $("#getnext").on('click', function(){ 
//         console.log("clicked");
//     //   $.ajax({ 
//     //     method: "GET", 
//     //     url: "pageno=",
//     //   }).done(function( data ) { 
//     //       console.log("hell");
//     //     // var result= $.parseJSON(data); 
//     //     // var string='<table width="100%"><tr> <th>#</th><th>Name</th> <th>Email</th><tr>';
 
//     //    /* from result create a string of data and append to the div */
      
//     // //     $.each( result, function( key, value ) { 
          
//     // //       string += "<tr> <td>"+value['id'] + "</td><td>"+value['first_name']+' '+value['last_name']+'</td>  \
//     // //                 <td>'+value['email']+"</td> </tr>"; 
//     // //           }); 
//     // //          string += '</table>'; 
//     // //       $("#records").html(string); 
//     //    }); 
//     }); 
// }); 

</script> 
</body>
</html>