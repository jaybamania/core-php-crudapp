<?php
$my_header = 'Admin Panel';
include "include/header.php";
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
<script>
$(document).ready(function() {
    //Hide Loading Image
    function Hide_Load() {
    $("#loading").fadeOut('slow');
    };
    
    
    $("#mainbody").load("index.php?pageno=1", Hide_Load());
    //Pagination Click
    $("#pagination li").click(function(){
    //CSS Styles
    $("#pagination li").css({'border' : 'solid #dddddd 1px'}).css({'color' : '#0063DC'});
    $(this).css({'color' : '#FF0084'}).css({'border' : 'none'});
    //Loading Data
    var pageNum = this.id;
    $("#content").load("pagination_data.php?page=" + pageNum, Hide_Load());
    });
    });
</script>


</body>
</html>