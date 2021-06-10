<?php
$my_header = 'Admin Panel';
include "include/header.php";
?>
<?php
require "include/connect.php";
include "classes/operations.php";
use Ops as O;
$getData = new O\GetData();
$userData = $getData->getAllData($conn);
?>
<div class="mainbody">
    <div class="performSection">
    <div class="addButton">
        <button ><a href="add.php">+ Add Member</a></button>
    </div>
    <form class="adminSearch" action="search.php" method="post">
        <input type="text" name="search" id="search" placeholder="Search by Names">
        <button type="submit" name="search_data">Search</button>
    </form>
    </div>

    <h4 style="color:green; font-size:2vw;"><?php
    session_start();
    if (isset($_SESSION['success'])) {
        echo $_SESSION['success'];
        unset($_SESSION['success']);
    }
    ?></h4>
    <div class="usertable">
        <table class="indextable"  style="background-color:white">
            <tr class="indextr">
                <th class="indexth">Sr.No</th>
                <th class="indexth">Name</th>
                <th class="indexth">Email</th>
                <th class="indexth">Phone</th>
                <th class="indexth">Address</th>
                <th class="indexth">Educations</th>
                <th class="indexth">Hobbies</th>
                <th class="indexth" colspan="2">Operations</th>
            </tr>
            
            <?php
            $i = 1;
            
            foreach ($userData as $row): ?>
                    <tr class="indextr">
                        <td class="indextd"><?php echo $i++; ?></td>
                        <td class="indextd"><?php echo $row['name']; ?></td>
                        <td class="indextd"><?php echo $row['email']; ?></td>
                        <td class="indextd"><?php echo $row['phone']; ?></td>
                        <td class="indextd"><?php echo $row['address']; ?></td>
                        <td class="indextd"><?php $getEducationName = $getData->getEducationNamebyId($conn,$row['education_id']); echo $getEducationName;  ?></td>
                        <td class="indextd"><?php $getHobbiesName = $getData->getHobbiesNamebyId($conn,$row['hobbies_id']); echo $getHobbiesName;  ?></td>
                        <td class="operations indextd">
                            <a class="deleteButton" href="delete.php?id=<?php echo $row['id']; ?>&&i=<?php echo $i - 1; ?>">Delete</a>
                            <a class="editButton" href="edit.php?id=<?php echo $row['id']; ?>&&i=<?php echo $i - 1; ?>">Edit</a>
                        </td>
                    </tr>
                    <?php endforeach;
            ?>
           
        </table>
    </div>
</div>




</body>
</html>