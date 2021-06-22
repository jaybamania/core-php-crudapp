<div class="performSection">
    <div class="addButton">
        <button ><a href="add.php">+ Add Member</a></button>
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
    <input type="submit" name="filtervalue" value="Get Selected Values" />
    </form>
    <?php
        if(isset($_POST['filtervalue'])){
        $selected_val = $_POST['filterby'];
        }else{
            $selected_val = "Names"; 
        }
    ?>
    <form class="adminSearch" action="search.php" method="post">
        <input type="hidden" name="field_name" value="<?php echo $selected_val; ?>">
        <input type="text" name="search" id="search" placeholder="Search by <?php echo $selected_val; ?>">
        <button type="submit" name="search_data">Search</button>
    </form>
    </div>