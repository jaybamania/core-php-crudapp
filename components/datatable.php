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
                        <td class="indextd"><img class="profileImg" src="uploads/<?php echo $row['image'] ?>" width="100px" height="100px" /></td>
                        <td class="indextd"><?php echo $row['name']; ?></td>
                        <td class="indextd"><?php echo $row['email']; ?></td>
                        <td class="indextd"><?php echo $row['phone']; ?></td>
                        <td class="indextd"><?php echo $row['address']; ?></td>
                        
                        <td class="indextd"><?php $getEducationName = $getData->getEducationNamebyId($conn,$row['education_id']); echo $getEducationName;  ?></td>
                        <td class="indextd"><?php $getHobbiesName = $getData->getHobbiesNamebyId($conn,$row['hobbies_id']); echo $getHobbiesName;  ?></td>
                        <td class="operations indextd">
                            <a  class="deleteButton btn btn-danger" 
                                data-i = '<?= $i-1 ?>'   
                                data-id='<?= $row['id'];  ?>'
                                >Delete</a>
                            <a  class="editButton btn btn-warning" 
                                data-i = '<?= $i-1 ?>' 
                                data-id='<?= $row['id'];  ?>'
                            >Edit</a>
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
           
            <?php
                for ($i = 1; $i <= $totalPages; $i ++) {
                if ($i == $pageno) {
                    ?> <a href="javascript:void(0);" class=" btn btn-info current">
                            <?php echo $i ?>
                    </a> <?php
                } else {
                    ?> <a href="javascript:void(0);" class="btn btn-info pages"
                        onclick="showRecords('<?php echo $noOfRecordsPerPage;  ?>', '<?php echo $i; ?>');">
                            <?php echo $i ?>
                    </a> <?php
                } // endIf
            } // endFor

            ?>
            <li><a href="?pageno=<?php echo $totalPages; ?>" onclick="showRecords('<?php echo $noOfRecordsPerPage;  ?>', '<?php echo $totalPages; ?>');">Last</a></li>
            Page <?php echo $pageno; ?>
            of <?php echo $totalPages; ?>
        </ul>