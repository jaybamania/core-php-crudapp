
<html>
<head>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script
    src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<title>CRUD APP</title>

</head>
<body>
    <div id="container">
        <div id="inner-container">
       
    
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

        showRecords(1,1);
        $.ajax({
            url:"adminpage.php",
            success:function(html){
                $("#results").html(html);
                $('#loader').html(''); 
            }
        })
        
    });
    
</script>
</html>

