<?php
$my_header = 'Add Form';
include "include/header.php";
?>
<?php
include "classes/operations.php";
use Ops as O;
$user = new O\Add();
require "include/connect.php";
if (isset($_POST['adddata'])) {
    
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
    $output_dir = "upload/";/* Path for file upload */
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
		@mkdir($output_dir, 0777);
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
<div class="mainbody">

<h4 style="color:red; font-size:2vw;"><?php if (isset($duplicate)) {
    echo $duplicate;
} ?></h4>
<form class="addForm" method="POST" enctype="multipart/form-data">
<div class="singleform">
        <label>Name : </label>
        
        <input type="text" name="name" id="name" value="<?php echo $user->name; ?>">
        <br />
        <span style="color:red"><?php if (isset($nameErr)) {
            echo $nameErr;
        } ?></span> 
       
    </div>
    <div class="singleform">
        <label>Image Profile : </label>
        
        <input type="file" name="image[]" value="<?php echo $user->image; ?>"/>
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
                    <input type="checkbox" name="hobbies[]"  value="<?php echo $row['hobby_id'] ?>"><?php echo $row['hobby_name'] ?><br/>
                <?php }else{ ?>
                     <input type="checkbox" checked name="hobbies[]"  value="<?php echo $row['hobby_id'] ?>"><?php echo $row['hobby_name'] ?><br/>
                     <?php  
                }endforeach;
            ?>
            </div>
            <span style="color:red"><?php if (isset($hobbiesErr)) {
            echo $hobbiesErr;
        } ?></span> 
        </div>
            <button type="submit" name="adddata">Submit</button>
    
</form>

</div>
</body>
</html>
