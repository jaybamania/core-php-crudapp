<?php 

if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$totalPages = 0;
$noOfRecordsPerPage = 4;
$offset = ($pageno-1) * $noOfRecordsPerPage;

// $getData = new O\GetData();
// $userData = $getData->getAllMembers($conn);
// if($userData){
// $totalRows = count($userData);
// $totalPages = ceil($totalRows / $noOfRecordsPerPage);
// }

?>