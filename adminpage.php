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
    <?php session_start(); if(isset($_SESSION['success'])){  
        echo "<script type='text/javascript'>  history.pushState({},'','index.php'); showRecords(1,".$totalPages.");</script>"; 
    ?>
<div class="alert alert-success"><?= $_SESSION['success']; ?></div>
<?php unset($_SESSION['success']);} ?>
    <div class="statusMsg"></div>
       
        <?php
        require_once "components/datatable.php";
    ?>
</div>




</body>
</html>