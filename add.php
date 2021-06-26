<?php
$my_header = 'Add Form';
include "include/header.php";
?>
<?php
include "classes/operations.php";
use Ops as O;
$user = new O\Add();
require "include/connect.php";
if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['address'])) {

    $user->name = $_POST['name'];
    $user->email = $_POST['email'];
    $user->phone = $_POST['phone'];
    $user->address = $_POST['address'];
    if(isset($_POST['education'])){$user->education = implode(',', $_POST['education']); }
    if(isset($_POST['hobbies'])){$user->hobbies = implode(',', $_POST['hobbies']); }
    //Inserting Image
    // $check = getimagesize($_FILES["image"]["tmp_name"]);
    // if($check !== false){
    //     $image = $_FILES['image']['tmp_name'];
    //     $imgContent = addslashes(file_get_contents($image));
    //     $user = new O\Add();
    //     $user->image = $imgContent;
        
    // }
    $output_dir = "uploads/";/* Path for file upload */
	$RandomNum   = time();
	$ImageName      = str_replace(' ','-',strtolower($_FILES['image']['name'][0]));
	$ImageType      = $_FILES['image']['type'][0];
 
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
	move_uploaded_file($_FILES["image"]["tmp_name"][0],$output_dir."/".$NewImageName );
    // $imageVar = new O\UploadImage();
    // $imageUpload = $imageVar->uploadimage($ImageName,$ImageType,$output_dir);
    $user->image = $NewImageName; 
    $validation = new O\Validations();
    $validation->name = $_POST['name'];
    $validation->email = $_POST['email'];
    $validation->phone = $_POST['phone'];
    $validation->address = $_POST['address'];
    $validation->image = $ImageName ;
    if(isset($_POST['education'])){$validation->education = implode(',', $_POST['education']); }
    if(isset($_POST['hobbies'])){$validation->hobbies = implode(',', $_POST['hobbies']);}
    //Variables for Error Messages
    $duplicate = $nameErr = $emailErr = $phoneErr = $addressErr = $hobbiesErr = $educationErr = $imageErr = ""; 
    //Variable for Successful Message
    $created = "";
    //validations of every fields
    $nameErr = $validation->validate_name();
    $emailErr = $validation->validate_email();
    $phoneErr = $validation->validate_phone();
    $addressErr = $validation->validate_address();
    $educationErr = $validation->validate_education();
    $hobbiesErr = $validation->validate_hobbies();
    $imageErr = $validation->validate_image();
    if (!$nameErr && !$emailErr && !$phoneErr && !$addressErr && !$hobbiesErr && !$educationErr && !$imageErr) {
        //Check Email if already exists
        $check_email = new O\CheckEmail();
        $check_email->email = $_POST['email'];
        $duplicate = $check_email->checkEmail($conn);
        if (!$duplicate) {
            //if Email Already Mesg doesn't get then insert the data
            $created = $user->insert($conn);
            if (!$created) {
                echo "Error:" . mysqli_error($conn);
            } else {
                session_start();
                $_SESSION['success'] = $created;
                header('Location: index.php');
            }
        }
    }
}else{

    $user->name = "";
    $user->email = "";
    $user->phone = "";
    $user->address = "";
    $user->education = "";
    $user->hobbies="";
    $user->image="";
}
?>
<body>
<div class="result"></div>
<div class="mainbody">

<h4 style="color:red; font-size:2vw;"><?php if (isset($duplicate)) {
    echo $duplicate;
} ?></h4>
<button class="btn btn-info mainpage m-2">Go to Mainpage</button>
<script>$('.mainpage').click(function(){
    // AJAX Request
    $.ajax({
    url: 'adminpage.php',
    success: function(response){
        $('.mainbody').hide();
        $('.heading').hide();
        history.pushState({},'',"index.php");
        $('#results').html(response);
    }
    });
});</script>
<span class="response"></span>
<form class="addForm"  method="POST" action="add.php" enctype="multipart/form-data">
<div class="form-gorup">
        <label>Name : </label>
        
        <input type="text" name="name" id="name" value="<?php echo $user->name; ?>">
        <br />
        <span style="color:red"><?php if (isset($nameErr)) {
            echo $nameErr;
        } ?></span> 
       
    </div>
    <div class="singleform">
        <label>Image Profile : </label>
        <img src="" id="previewImg" alt="Profile Image" style="max-width:130px; max-height:130px;margin-top:20px; border-radius:50%;" />
        <input type="file" name="image[]" value="<?php echo $user->image; ?>" onChange="previewFile(this)"/>
        
        <br />
        <span style="color:red"><?php if (isset($imageErr)) {
            echo $imageErr;
        } ?></span> 
       
    </div>
    <div  class="singleform">
        <label>Email : </label>
        <input type="email" name="email"  id="email" value="<?php echo $user->email; ?>">
        <span style="color:red"><?php if (isset($emailErr)) {
            echo $emailErr;
        } ?></span> 
    </div>
    <div  class="singleform">
        <label>Phone : </label>
        <input type="text" name="phone"  id="phone" value="<?php echo $user->phone; ?>">
        <span style="color:red"><?php if (isset($phoneErr)) {
            echo $phoneErr;
        } ?></span> 
    </div>
    <div  class="singleform">
        <label>Address : </label>
        <textarea  name="address" id="address">
        <?php echo $user->phone; ?>
        </textarea>
        <span style="color:red"><?php if (isset($addressErr)) {
            echo $addressErr;
        } ?></span> 
    </div>
        <?php 
            $getData = new O\GetData();
            $educationData = $getData->getEducationData($conn);
            $hobbiesData = $getData->getHobbiesData($conn);
        ?>
      
        <div  class="singleform">
         <label>Education : </label>
            <select name="education[]" id="education" multiple>
            <?php
                foreach ($educationData as $row): ?>
                <option  value="<?php echo $row['education_id'] ?>"><?php echo $row['education_name']?></option>
                <?php endforeach;
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
                if($user->hobbies == ""){?>
                    <input type="checkbox" name="hobbies[]"  value="<?php echo $row['hobbies_id'] ?>"><?php echo $row['hobby_name'] ?><br/>
                <?php }else{ ?>
                     <input type="checkbox" checked name="hobbies[]"  value="<?php echo $row['hobbies_id'] ?>"><?php echo $row['hobby_name'] ?><br/>
                     <?php  
                }endforeach;
            ?>
            </div>
            <span style="color:red"><?php if (isset($hobbiesErr)) {
            echo $hobbiesErr;
        } ?></span> 
        </div>
            <button type="submit" class="btn btn-success" name="adddata">Submit</button>
    
</form>

</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script>
    function previewFile(input){
        var file=$("input[type=file]").get(0).files[0];
        if(file){
            var reader = new FileReader();
            reader.onload = function(){
                $('#previewImg').attr("src", reader.result);
            }
            reader.readAsDataURL(file);
        }
    }

$(function(){

    var form = $(".addform");

    form.submit(function(e){

        $(this).attr("disabled","disabled");
        e.preventDefault();

        $.ajax({
            type: form.attr("method"),
            url : form.attr('action'),
            data : form.serialize(),
            dataType:"json", //response data type
            success:function(data){
                $(".response").text(data.content);
            }
            error:function(data){
                $(".response").text("Error Occured");
            }
        })
    })

})


// $('.addForm').on('submit', function (e) {

//   e.preventDefault();

//   $.ajax({
//     type: 'post',
//     url: 'add.php',
//     data: $('form').serialize(),
    
//     success: function (response) {
//         console.log(response);
//         $("#show").text($("form").serialize());
//       alert('form was submitted');
//     }
//   });

// });

// });

  $(document).ready(function () {

//     $(".addform").submit(function (event) {
//     var formData = {
//       name: $("#name").val(),
//       email: $("#email").val(),
//       phone: $("#phone").val(),
//       address: $("#address").val(),
//     };

//     $.ajax({
//       type: "POST",
//       url: "add.php",
//       data: formData,
//       dataType: "json",
//       encode: true,
//     }).done(function (data) {
//       console.log(data);
//       if (!data.success) {
//         if (data.errors.name) {
//           $("#name-group").addClass("has-error");
//           $("#name-group").append(
//             '<div class="help-block">' + data.errors.name + "</div>"
//           );
//         }
//     });

//     event.preventDefault();
//   });



})

</script>
</body>
</html>
