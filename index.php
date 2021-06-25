<?php
$my_header = 'Admin Panel';
include "include/header.php";
require "include/connect.php";
?>
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script
    src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<title>CRUD APP</title>
<link rel="stylesheet" href="style.css" type="text/css" />
</head>
<body>
    <div id="container">
        <div id="inner-container">
        
    <h4 style="color:green; font-size:2vw;"><?php
        session_start();
        if (isset($_SESSION['success'])) {
            echo $_SESSION['success'];
            unset($_SESSION['success']);
        }
    ?></h4>
            <div id="results"></div>
            <div id="loader"></div>

        </div>
    </div>
</body>

<script type="text/javascript">
    function showRecords(perPageCount, pageNumber) {
        $.ajax({
            type: "GET",
            url: "adminpage.php",
            data: "pageno=" + pageNumber,
            cache: false,
    		
            success: function(html) {
                $("#results").html(html);
                $('#loader').html(''); 
            }
        });
    }
    
    $(document).ready(function() {
        showRecords(1, 1);
    });
</script>
</html>

