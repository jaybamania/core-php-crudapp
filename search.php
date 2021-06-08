<?php
$my_header = 'Search Result';
include("include/header.php");
?>
<?php 
require("include/connect.php");
include "classes/operations.php";
use Ops as O;

if(isset($_POST['search_data'])){
    $search_data = new O\SearchData();
    $search_data->string = $_POST['search'];
    $search_result = $search_data->search($conn);
    
}

?>
<div class="mainbody">
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
            
            <?php $i=1; 
                if(isset($search_result)){
                    foreach($search_result as $row) :
                        ?>
                        <tr>
                            <td><?php echo $i++;  ?></td>
                            <td><?php echo $row['name'];  ?></td>
                            <td><?php echo $row['email'];  ?></td>
                            <td><?php echo $row['phone'];  ?></td>
                            <td><?php echo $row['address'];  ?></td>
                            <td class="operations">
                                <a class="deleteButton" href="delete.php?id=<?php echo $row['id']; ?>&&i=<?php echo $i-1; ?>">Delete</a>
                                <a class="editButton" href="edit.php?id=<?php echo $row['id']; ?>&&i=<?php echo $i-1; ?>">Edit</a>
                            </td>
                        </tr>
                        <?php
                        endforeach;
                }else{
                    echo "<tr><td colspan='6'>No results Found</td></tr>";
                }
            ?>
        </table>
    </div>
</div>




</body>
</html>