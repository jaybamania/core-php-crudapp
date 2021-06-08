<?php
$my_header = 'Admin Panel';
include("include/header.php");
?>
<?php
require("include/connect.php");
include "classes/operations.php";
use Ops as O;
$userData = new O\GetData();
$getData = $userData->getAllData($conn);

// while ($row = $users->fetch_assoc()) {
//     echo $row['name']."<br>";
// }


?>
<div class="mainbody">
    <div class="performSection">
    <div class="addButton">
        <button ><a href="add.php">+ Add Member</a></button>
    </div>
    <form class="adminSearch" action="/admin" method="post">
        <input type="text" name="search" id="search" placeholder="Search by Names">
        <button type="submit">Search</button>
        <!-- <span style="color:red">@error('search'){{$message}}@enderror</span> -->
    </form>
    </div>

    <h4 style="color:green; font-size:2vw;"><?php
    session_start();
    if(isset($_SESSION['success'])){   
        echo $_SESSION['success'];
        unset($_SESSION['success']);}
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
            
            <?php $i=1; 
                // while ($row = $users->fetch_assoc()) {
                    foreach($getData as $row) :
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
               // }
                    endforeach;
            ?>
            <!-- @if(session('searched_data'))
                @foreach($searches  as $member)
                    
                        <td>{{$i++}}</td>
                        <td>{{$member->name}}</td>
                        <td>{{$member->email}}</td>
                        <td>{{$member->phone}}</td>
                        <td>{{$member->address}}</td>
                        <td class="operations">
                            <a class="deleteButton" href="delete/{{ $member->id }}">Delete</a>
                            <a class="editButton" href="edit/{{ $member->id }}">Edit</a>
                        </td>
                    </tr>
                @endforeach
            @else
                @foreach($members as $member)
                    <tr>
                        <td>{{$i++}}</td>
                        <td>{{$member->name}}</td>
                        <td>{{$member->email}}</td>
                        <td>{{$member->phone}}</td>
                        <td>{{$member->address}}</td>
                        <td class="operations">
                            <a class="deleteButton" href="delete/{{ $member->id }}">Delete</a>
                            <a class="editButton" href="edit/{{ $member->id }}/{{$i-1}}">Edit</a>
                        </td>
                    </tr>
                @endforeach
            @endif  -->
           
            
        </table>
    </div>
</div>




</body>
</html>