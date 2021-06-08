<?php
$my_header = 'Admin Panel';
include "include/header.php";
?>
<?php
require "include/connect.php";
include "classes/operations.php";
use Ops as O;
$userData = new O\GetData();
$getData = $userData->getAllData($conn);
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
        <table  style="background-color:white">
            <tr>
                <th>Sr.No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th colspan="2">Operations</th>
            </tr>
            
            <?php
            $i = 1;
            foreach ($getData as $row): ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['address']; ?></td>
                        <td class="operations">
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