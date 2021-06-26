<?php 
require("include/connect.php");
include "classes/operations.php";
use Ops as O;

if(isset($_POST['id']) && isset($_POST['i'])){
    $user_delete = new O\DeleteData();
    $user_delete->id = $_POST['id'];
    $user_delete->serial_id = $_POST['i'];
    $deleted = $user_delete->delete($conn);
    session_start();
    $_SESSION['success'] = $deleted;
    header('Location: index.php');
}

?>