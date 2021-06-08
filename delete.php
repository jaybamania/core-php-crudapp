<?php 
require("include/connect.php");
include "classes/operations.php";
use Ops as O;

if(isset($_GET['id']) && isset($_GET['i'])){
    $user_delete = new O\DeleteData();
    $user_delete->id = $_GET['id'];
    $user_delete->serial_id = $_GET['i'];
    $deleted = $user_delete->delete($conn);
    session_start();
    $_SESSION['success'] = $deleted;
    header('Location: index.php');
}

?>