<div class="performSection">
    <div class="addButton">
        <button ><a >+ Add Member</a></button>
    </div>
    <form method="post">
    <label for="filterby">Filter By:</label>

    <select name="filterby" id="filterby">
        <option value="">--Please choose an option--</option>
        <option value="Name">Name</option>
        <option value="Email">Email</option>
        <option value="Phone">Phone</option>
        <option value="Address">Address</option>
        <option value="Education">Education</option>
        <option value="Hobbies">Hobbies</option>
    </select>
    <input type="submit" name="filtervalue" id="filtervalue" value="Get Selected Values" />
    </form>
    <?php
        if(isset($_GET['filtervalue'])){
        $selected_val = $_GET['filtervalue'];
        echo $selected_val;
        }else{
            $selected_val = "Names"; 
        }
    ?>
    <form class="adminSearch" action="search.php" method="post">
        <input type="hidden" id="field_name" name="field_name" value="<?php echo $selected_val; ?>">
        <input type="text" name="search" id="search" placeholder="Search by <?php echo $selected_val; ?>">
        <button type="submit" id="search_data">Search</button>
    </form>
    </div>
    <script
    src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script type="text/javascript">    
    $("#filtervalue").click(function(e) {
        e.preventDefault();
        var filter_val = $('#filterby').find(":selected").text();
        $.ajax({
            url:"components/performsection.php",
            data: {filtervalue:filter_val},
            success:function(html){
                $("#field_name").val(filter_val);
                $("#search").attr("placeholder", "Search By "+filter_val);
            }
        })
        
    });

    $("#search_data").click(function(e) {
        e.preventDefault();
        var filter_val = $('#field_name').val();
        var search_str = $("#search").val();
        console.log(filter_val)
        console.log(search_str)
        $.ajax({
            url:"search.php",
            type : "POST",
            data: {filtervalue:filter_val,search:search_str},
            success:function(html){
                $('.mainbody').hide();
                $('.heading').hide();
                console.log(html)
                $("#results").html(html);
                // history.pushState({},"","search.php")
                
                // $("#search").attr("placeholder", "Search By "+filter_val);
            }
        })
        
    });
</script>