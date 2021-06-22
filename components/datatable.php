<table class="table table-bordered"  style="background-color:white">
            <tr class="indextr">
                <th class="indexth">Sr.No</th>
                <th class="indexth">Photo</th>
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
            if(isset($paginationData)):
            foreach ($paginationData as $row): ?>
                    <tr class="indextr">
                        <td class="indextd"><?php echo ($offset + $i++); ?></td>
                        <td class="indextd"><img class="profileImg" src="upload/<?php echo $row['image'] ?>" width="100px" height="100px" /></td>
                        <td class="indextd"><?php echo $row['name']; ?></td>
                        <td class="indextd"><?php echo $row['email']; ?></td>
                        <td class="indextd"><?php echo $row['phone']; ?></td>
                        <td class="indextd"><?php echo $row['address']; ?></td>
                        
                        <td class="indextd"><?php $getEducationName = $getData->getEducationNamebyId($conn,$row['education_id']); echo $getEducationName;  ?></td>
                        <td class="indextd"><?php $getHobbiesName = $getData->getHobbiesNamebyId($conn,$row['hobbies_id']); echo $getHobbiesName;  ?></td>
                        <td class="operations indextd">
                            <a class="deleteButton btn btn-danger" href="delete.php?id=<?php echo $row['id']; ?>&&i=<?php echo $i - 1; ?>">Delete</a>
                            <a class="editButton btn btn-warning" href="edit.php?id=<?php echo $row['id']; ?>&&i=<?php echo $i - 1; ?>">Edit</a>
                        </td>
                    </tr>
                    <?php endforeach;
                    else : ?> 
                    <tr><td>No Members</td></tr>
                        <?php
                    endif;
            ?>
           
        </table>
        <ul class="pagination ">
            <li><a href="?pageno=1">First</a></li>
            <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
                <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
            </li>
            <li class="<?php if($pageno >= $totalPages){ echo 'disabled'; } ?>">
                <a href="<?php if($pageno >= $totalPages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
            </li>
            <li><a href="?pageno=<?php echo $totalPages; ?>">Last</a></li>
        </ul>