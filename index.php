<?php
include("include/header.php");
?>
<?php
require("include/connect.php");
$users = mysqli_query($conn,'select * from members ');
$fetch_users = mysqli_fetch_all($users, MYSQLI_ASSOC);

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
   
    <div>
        <!-- @if(session('name'))
          <h3 class="successfulMsg">Member {{session('name')}}  has been added</h3>
        @endif

        @if(session('updated_name') && session('id'))
          <h3 class="successfulMsg">Member : {{session('id')}} {{session('updated_name')}}  has been Updated</h3>
        @endif

        @if(session('delete_id'))
          <h3 class="successfulMsg">Member {{session('delete_id')}}  has been Deleted Successfully</h3>
        @endif -->

    </div>

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
                    foreach($fetch_users as $row) :
                    ?>
                    <tr>
                        <td><?php echo $i++;  ?></td>
                        <td><?php echo $row['name'];  ?></td>
                        <td><?php echo $row['email'];  ?></td>
                        <td><?php echo $row['phone'];  ?></td>
                        <td><?php echo $row['address'];  ?></td>
                        <td class="operations">
                            <a class="deleteButton" href="delete/<?php echo $row['id']; ?>">Delete</a>
                            <a class="editButton" href="edit/<?php echo $row['id']; ?>">Edit</a>
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