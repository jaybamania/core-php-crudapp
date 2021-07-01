<?php
$my_header = 'Add Form';
include "include/header.php";
include "classes/operations.php";
use Ops as O;
$user = new O\Add();
require "include/connect.php";
// if(isset($_POST['ajax'])){
    if(isset($_POST['name']) || isset($_POST['email']) || isset($_POST['phone']) || isset($_POST['address']) || isset($_POST['education']) || isset($_POST['hobbies']) || isset($_FILES['file']['name'])){
    $user->name = $_POST['name'];
    $user->email = $_POST['email'];
    $user->phone = $_POST['phone'];
    $user->address = $_POST['address'];
    if(isset($_POST['education'])){$user->education = implode(',', $_POST['education']); }
    if(isset($_POST['hobbies'])){$user->hobbies = implode(',', $_POST['hobbies']); }

    //Image Name
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
    $user->image = $NewImageName;
    // $_POST['education'])){$user->education = implode(',', $_POST['education']);
    $validation = new O\Validations();
    $validation->name = $_POST['name'];
    $validation->email = $_POST['email'];
    $validation->phone = $_POST['phone'];
    $validation->address = $_POST['address'];
    if(isset($_POST['education'])){$validation->education = implode(',', $_POST['education']); }
    if(isset($_POST['hobbies'])){$validation->hobbies = implode(',', $_POST['hobbies']);}
    $validation->image = $ImageName ;
    //Variables for Error Messages
    $duplicate = $nameErr = $emailErr = $phoneErr = $addressErr = $hobbiesErr = $educationErr = $imageErr = ""; 
    //Variable for Successful Message
    $created = "";
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
        // if Email Already Msg doesn't get, then insert the data
        if (!$duplicate) {
            
            // header('Location: index.php');
           
            $created = $user->insert($conn);
            if (!$created) {
                echo "Error:" . mysqli_error($conn);
            } else {
                session_start();
                $_SESSION['success'] = $created;
                echo "<script language='javascript'>
                location.replace('index.php')
                
                </script>";
                header('Location: index.php');
            }
        }
    
}

    }
    else{

        $user->name = "";
        $user->email = "";
        $user->phone = "";
        $user->address = "";
        $user->education = "";
        $user->hobbies="";
        $user->image="";
    }
?>
<?php

    // if($nameErr || $emailErr){
    //     $return_arr = array("name_error"=>$nameErr,"email_error"=>$emailErr);
    //     echo json_encode($return_arr); exit();
    // }
    // else{
    //     $return_arr = array("name"=>$name,"email"=>$email);
    //     echo json_encode($return_arr); exit();
    // }
    

// if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['phone']) && isset($_POST['address'])) {

    // $user->name = $_POST['name'];
    // $user->email = $_POST['email'];
    // $user->phone = $_POST['phone'];
    // $user->address = $_POST['address'];
    // if(isset($_POST['education'])){$user->education = implode(',', $_POST['education']); }
    // if(isset($_POST['hobbies'])){$user->hobbies = implode(',', $_POST['hobbies']); }
//     //Inserting Image
//     // $check = getimagesize($_FILES["image"]["tmp_name"]);
//     // if($check !== false){
//     //     $image = $_FILES['image']['tmp_name'];
//     //     $imgContent = addslashes(file_get_contents($image));
//     //     $user = new O\Add();
//     //     $user->image = $imgContent;
        
//     // }
    // $output_dir = "uploads/";/* Path for file upload */
	// $RandomNum   = time();
	// $ImageName      = str_replace(' ','-',strtolower($_FILES['image']['name'][0]));
	// $ImageType      = $_FILES['image']['type'][0];
 
	// $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
	// $ImageExt       = str_replace('.','',$ImageExt);
	// $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
	// $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
    // $ret[$NewImageName]= $output_dir.$NewImageName;
	
	// /* Try to create the directory if it does not exist */
	// if (!file_exists($output_dir))
	// {
	// 	mkdir($output_dir, 0777);
	// }               
	// move_uploaded_file($_FILES["image"]["tmp_name"][0],$output_dir."/".$NewImageName );
//     // $imageVar = new O\UploadImage();
//     // $imageUpload = $imageVar->uploadimage($ImageName,$ImageType,$output_dir);
//     $user->image = $NewImageName; 
    // $validation = new O\Validations();
    // $validation->name = $_POST['name'];
    // $validation->email = $_POST['email'];
    // $validation->phone = $_POST['phone'];
    // $validation->address = $_POST['address'];
    // $validation->image = $ImageName ;
    // if(isset($_POST['education'])){$validation->education = implode(',', $_POST['education']); }
    // if(isset($_POST['hobbies'])){$validation->hobbies = implode(',', $_POST['hobbies']);}
    // //Variables for Error Messages
    // $duplicate = $nameErr = $emailErr = $phoneErr = $addressErr = $hobbiesErr = $educationErr = $imageErr = ""; 
    // //Variable for Successful Message
    // $created = "";
//     //validations of every fields
    // $nameErr = $validation->validate_name();
    // $emailErr = $validation->validate_email();
    // $phoneErr = $validation->validate_phone();
    // $addressErr = $validation->validate_address();
    // $educationErr = $validation->validate_education();
    // $hobbiesErr = $validation->validate_hobbies();
    // $imageErr = $validation->validate_image();
//     if (!$nameErr && !$emailErr && !$phoneErr && !$addressErr && !$hobbiesErr && !$educationErr && !$imageErr) {
//         //Check Email if already exists
//         $check_email = new O\CheckEmail();
//         $check_email->email = $_POST['email'];
//         $duplicate = $check_email->checkEmail($conn);
//         if (!$duplicate) {
//             //if Email Already Mesg doesn't get then insert the data
//             $created = $user->insert($conn);
//             if (!$created) {
//                 echo "Error:" . mysqli_error($conn);
//             } else {
//                 session_start();
//                 $_SESSION['success'] = $created;
//                 header('Location: index.php');
//             }
//         }
//     }
// }else{

//     $user->name = "";
//     $user->email = "";
//     $user->phone = "";
//     $user->address = "";
//     $user->education = "";
//     $user->hobbies="";
//     $user->image="";
// }
?>
<body>
<div class="result"></div>
<div class="mainbody">

<h4 style="color:red; font-size:2vw;"><?php if (isset($duplicate)) {
    echo $duplicate;
} ?></h4>
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
<span class="errors" style='color:red;'></span>
<span class="response" style='color:green;'></span>
<form class="addForm"  method="POST"  enctype="multipart/form-data">
<div class="form-gorup">
<?php echo $user->name." ".$user->email." ".$user->phone." ".$user->address."  ".$user->education." ".$user->hobbies." >> ".$user->image; ?>
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
        <input type="file" class="profile" id="file" name="file" value="<?php echo $user->image; ?>" onChange="previewFile(this)"/>
        
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
            <select name="education[]" class="education" multiple>
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
            <button type="submit" class="btn btn-success submitBtn" name="">Submit</button>
    
</form>

</div>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
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
    // $("#file").change(function() {
    // var file = this.files[0];
    // var fileType = file.type;
    // var match = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'image/jpeg', 'image/png', 'image/jpg'];
    // if(!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[3]) || (fileType == match[4]) || (fileType == match[5]))){
    //     alert('Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.');
    //     $("#file").val('');
    //     return false;
    // }

// $(".addForm").submit(function(e) {

// e.preventDefault(); // avoid to execute the actual submit of the form.

// var form = $(this);


// $.ajax({
//        type: "POST",
//        url: "add.php",
//        data: form.serialize(), // serializes the form's elements.
//        success: function(data)
//        {
//            console.log(data); // show response from the php script.
//        }
//      });


// });
    // $('#imagefile').change(function() {
    //     var filename = $('#imagefile').val();
    //     // $('#select_file').html(filename);
    //     console.log("Your image- " + filename);
    // });
    $(".addForm").submit(function(e){
        e.preventDefault();
        var name = $("#name").val()
        // var file = ('input[type=file]')[0].files[0].name 
        var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '')

        var email = $("#email").val()
        var phone = $("#phone").val()
        var address = $("#address").val()
        var education = [];
        var hobbies = [];
        
        $.each($(".education option:selected"), function(){            
            education.push($(this).val());
        });
        var educationList = education.join(",")
        $.each($("input[name='hobbies[]']:checked"), function(){            
            hobbies.push($(this).val());
        });
        var hobbiesList = hobbies.join(",")

        console.log("Your Name- " + name);
        console.log("Your image- " + filename);
        console.log("Your email- " + email);
        console.log("Your phone- " + phone);
        console.log("Your address- " + address);
        console.log("You have selected the Educations - " + educationList);
        console.log("You have selected the Hobbies - " + hobbiesList);
        $.ajax({
            type: "POST",
            url:"add.php",
            //data: {ajax:1,name: name,email:email,phone: phone,address:address, education:educationList,hobbies:hobbiesList,image:filename}, // serializes the form's elements.
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
               
                $('.result').html(data);
                $('.fupForm').css("opacity","");
                $(".submitBtn").removeAttr("disabled");
                $.ajax({
                    url:"adminpage.php",
                    success:function(response){
                        console.log(response)
                        history.pushState({},'',"index.php");
                        $('.statusMsg').html('<p class="alert alert-success">Member Added Successfully</p>');
                        $('.statusMsg').fadeOut(5000);
                    }
                })
            }
        });
        
    });



</script>
</body>
</html>
