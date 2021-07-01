<?php
$my_header = "Edit Form";
include "include/header.php";
?>
<?php
require "include/connect.php";
include "classes/operations.php";
use Ops as O;
if (isset($_GET['id'])) {
    $getData = new O\GetData();
    $getData->id = $_GET['id'];
    $userData = $getData->getUserData($conn);
}
if(isset($_POST['id']) || isset($_POST['name']) || isset($_POST['email']) || isset($_POST['phone']) || isset($_POST['address']) || isset($_POST['education']) || isset($_POST['hobbies']) || isset($_FILES['file']['name'][0])){
    $validation = new O\Validations();
    $validation->name = $_POST['name'];
    $validation->email = $_POST['email'];
    $validation->phone = $_POST['phone'];
    $validation->address = $_POST['address'];
    if(isset($_POST['education'])){$validation->education = implode(',', $_POST['education']); }
    if(isset($_POST['hobbies'])){$validation->hobbies = implode(',', $_POST['hobbies']);}
    //Updating a image
	
    //Variables for Error Messages
    $duplicate = $nameErr = $emailErr = $phoneErr = $addressErr = $hobbiesErr = $educationErr = ""; 
    $updated = "";
    $nameErr = $validation->validate_name();
    $emailErr = $validation->validate_email();
    $phoneErr = $validation->validate_phone();
    $addressErr = $validation->validate_address();
    $educationErr = $validation->validate_education();
    $hobbiesErr = $validation->validate_hobbies();
    if (!$nameErr && !$emailErr && !$phoneErr && !$addressErr && !$hobbiesErr && !$educationErr) {
        $updated_user = new O\EditData();
        if(isset($_FILES['file']['name'][0])){
            $output_dir = "uploads/";/* Path for file upload */
            $RandomNum   = time();
            $ImageName      = str_replace(' ','-',strtolower($_FILES['file']['name'][0]));
            $ImageType      = $_FILES['file']['type'][0];
        
            $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
            $ImageExt       = str_replace('.','',$ImageExt);
            $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
            $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
            $ret[$NewImageName]= $output_dir.$NewImageName;
            
            /* Try to create the directory if it does not exist */
            if (!file_exists($output_dir))
            {
                mkdir($output_dir, 0777);
            }               
            move_uploaded_file($_FILES["file"]["tmp_name"][0],$output_dir."/".$NewImageName );
            $updated_user->image = $NewImageName;
        }else{
            $updated_user->image = $userData['image'];
        }
        // $updated_user->serial_id = $_POST['i'];
        $updated_user->id = $_GET['id'];
        $updated_user->name = $_POST['name'];
        $updated_user->email = $_POST['email'];
        $updated_user->phone = $_POST['phone'];
        $updated_user->address = $_POST['address']; 
        if(isset($_POST['education'])){$updated_user->education = implode(',', $_POST['education']); }
        if(isset($_POST['hobbies'])){$updated_user->hobbies = implode(',', $_POST['hobbies']); }
        //Check Email if already exists
        $check_email = new O\CheckEmail();
        $check_email->id = $_POST['id'];
        $check_email->email = $_POST['email'];
        $email_while_update = $check_email->checkEmailWhileUpdate($conn);
        if($email_while_update){
            
            $updated = $updated_user->update($conn);
            if (!$updated) {
                echo "Error:" . mysqli_error($conn);
            } else {
                
                // echo '<script language="javascript">
                // $(".statusMsg").html("<p class=\"alert alert-success\">"'.$updated.'</p>")
                // $(".statusMsg").fadeOut(5000)
                // </script>';
                header('Location: edit.php?id='.$updated_user->id);
            }
        }else{
            $duplicate="Email Already Exists, try something new";
        }
    }
}
?>
<body>

<div class="result"></div>
<div class="mainbody">
<h4 style="color:green; font-size:2vw;"><?php if (isset($updated)) {
    echo $updated;
} ?></h4>
<h4 style="color:red; font-size:2vw;"><?php if (isset($duplicate)) {
    echo $duplicate;
} ?></h4>

<div class="statusMsg"></div>
<button class="btn btn-info mainpage m-2">Go to Mainpage</button>
<script>
$('.mainpage').click(function(e){
  
    // AJAX Request
    $.ajax({
    url: 'adminpage.php',
    dataType:'html',
    success: function(response){
        $('.mainbody').hide();
        $('.heading').hide();
        history.pushState({},'',"index.php");
        $('#results').html(response);
        
    }
    });
});
</script>
<form class="addForm" method="post" enctype="multipart/form-data">
<input type="hidden" name="id" id="id" value="<?php echo $userData['id']; ?>" >
    <div class="singleform">
        
        <label>Profile : </label>
        <img class="profileImg" id="previewImg" src="uploads/<?php echo $userData['image'] ?>" width="100px" height="100px" />
        <input type="file" name="file[]" id="file" onChange="previewFile(this)" /><?php echo "size (<2 Mb)" ; ?>
        <br />
        <span style="color:red"><?php if (isset($nameErr)) {
            echo $nameErr;
        } ?></span> 
       
    </div>
    <div class="singleform">
        
        <label>Name : </label>
        
        <input type="text" name="name" id="name" value="<?php echo $userData['name']; ?>">
        <br />
        <span style="color:red"><?php if (isset($nameErr)) {
            echo $nameErr;
        } ?></span> 
       
    </div>
    <div  class="singleform">
        <label>Email : </label>
        <input type="email" name="email"  id="email" value="<?php echo $userData['email']; ?>">
        <span style="color:red"><?php if (isset($emailErr)) {
            echo $emailErr;
        } ?></span> 
    </div>
    <div  class="singleform">
        <label>Phone : </label>
        <input type="text" name="phone"  id="phone" value="<?php echo $userData['phone']; ?>">
        <span style="color:red"><?php if (isset($phoneErr)) {
            echo $phoneErr;
        } ?></span> 
    </div>
    <div  class="singleform">
        <label>Address : </label>
        <textarea  name="address" id="address">
        <?php echo $userData['address']; ?>
        </textarea>
        <span style="color:red"><?php if (isset($addressErr)) {
            echo $addressErr;
        } ?></span> 
    </div>
    <?php   
            
            $educationData = $getData->getEducationData($conn);
            $hobbiesData = $getData->getHobbiesData($conn);
            // $string2 = strval($getData['education_id']);
            // preg_match("/(\\d+)([a-zA-Z]+)/", $string2, $matches);
            // echo $matches;
        ?>
      
        <div  class="singleform">
         <label>Education : </label>
            <select name="education[]" id="education" multiple>
            <?php
                foreach ($educationData as $row): 

                    if(strpos($userData['education_id'],$row['education_id'] ) !== false){
                ?>
                <option selected  value="<?php echo $row['education_id'] ?>"><?php echo $row['education_name']?></option>

                <?php
              }else{ ?>
                <option  value="<?php echo $row['education_id'] ?>"><?php echo $row['education_name']?></option>
                   <?php
               }
             endforeach;
            ?>
            </select>
            <span style="color:red"><?php if (isset($educationErr)) {
            echo $educationErr;
        } ?></span> 
        </div>

        <div  class="singleform">
         <label>Hobbies : </label>
            <div class="checkboxClass">
            <?php
                foreach ($hobbiesData as $row):

                    if(strpos($userData['hobbies_id'],$row['hobbies_id'] ) !== false){
                ?>
                <input type="checkbox" name="hobbies[]" checked value="<?php echo $row['hobbies_id'] ?>"><?php echo $row['hobby_name'] ?><br/>
                <?php
              }else{ ?>
                 <input type="checkbox" name="hobbies[]" value="<?php echo $row['hobbies_id'] ?>"><?php echo $row['hobby_name'] ?><br/>
                   <?php
               }
             endforeach;
            ?>
                
            </div>
            <span style="color:red"><?php if (isset($hobbiesErr)) {
            echo $hobbiesErr;
        } ?></span> 
        </div>
        <button type="submit" class="btn btn-success submitBtn" name="">Submit</button>
</form>

</div>
<script>
    function previewFile(input){
        var file=$("input[type=file]").get(0).files[0];
        if(file){
            var fileType = file.type;
            var match = ['image/jpeg', 'image/png', 'image/jpg'];
            if(!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]))){
                alert('Sorry, only JPG, JPEG, & PNG files are allowed to upload.');
                $("#file").val('');
                return false;
            }
            var reader = new FileReader();
            reader.onload = function(){
                $('#previewImg').attr("src", reader.result);
                $('#profile').attr("value", reader.result);
            }
            reader.readAsDataURL(file);
        }
    }

    $(".addForm").submit(function(e){
        e.preventDefault();
        var editid = $('#id').val()
        $.ajax({
            type: "POST",
            url: "edit.php?id="+editid,
            data: new FormData(this),
            dataType: 'html',
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
                $('.submitBtn').attr("disabled","disabled");
                $('.addForm').css("opacity",".5");
            },
            success: function(data)
            {   
                $('.mainbody').hide();
                $('.heading').hide();
                history.pushState({},'',"edit.php?id="+editid);
                $('.result').html(data);
                console.log(data)
                $('.fupForm').css("opacity","");
                $(".submitBtn").removeAttr("disabled");
                
            }
        });
        
    });
</script>
</body>
</html>
