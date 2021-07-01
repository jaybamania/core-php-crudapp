<?php
$my_header = 'Search Result';
include("include/header.php");
?>
<?php 
require("include/connect.php");
include "classes/operations.php";
include "include/pagination.php";
use Ops as O;
$getData = new O\GetData();

$search_data = new O\SearchData();

$userData = $getData->getAllMembers($conn);

if(isset($_POST['filtervalue'])){

    // $paginationData = $getData->getAllData($conn,$offset,$noOfRecordsPerPage);
    $search_data->string = $_POST['search'];
    switch ($_POST['filtervalue']) {
        case 'Name':
            $search_data->field_name = "name";
            break;
        case 'Email':
            $search_data->field_name = "email";
            break;
        case 'Phone':
            $search_data->field_name = "phone";
            break;
        case 'Address':
            $search_data->field_name = "address";
            break;
        case 'Education':
            $search_data->field_name = "education_id";
            break;
        case 'Hobbies':
            $search_data->field_name = "hobbies_id";
            break;
        default:
            $search_data->field_name = "name";
            break;
    }
}
$paginationData = $search_data->search($conn,$offset, $noOfRecordsPerPage);
if($paginationData){
    $totalRows = count($paginationData);
    $totalPages = ceil($totalRows / $noOfRecordsPerPage);
    }
    

?>
<div id="results"></div>
<div class="mainbody">
<?php
        require_once "components/performsection.php";
    ?>
       
        <?php
        require_once "components/datatable.php";
    ?>
</div>




</body>
</html>